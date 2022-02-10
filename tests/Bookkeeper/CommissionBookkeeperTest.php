<?php

use Coff\TestAssignment\Bookkeeper\CommissionBookkeeper;
use Coff\TestAssignment\Country\BinListCountryProvider;
use Coff\TestAssignment\Enum\CountryIso3166Aplha2Enum;
use Coff\TestAssignment\ExchangeRates\ExchangeRatesProvider;
use PHPUnit\Framework\MockObject\Stub;

final class CommissionBookkeeperTest extends \PHPUnit\Framework\TestCase
{
    /** @var CommissionBookkeeper */
    protected $object;

    /** @var Stub */
    protected $ratesProvider;

    /** @var Stub */
    protected $countryProvider;

    public function setUp(): void
    {
        $this->countryProviderStub = $this
            ->createStub(BinListCountryProvider::class);
        $this->countryProviderStub->method('setBin')
            ->willReturnSelf();
        $this->countryProviderStub->method('fetch')
            ->willReturnSelf();

        $this->ratesProviderStub = $this->createStub(ExchangeRatesProvider::class);

        $this->object = new CommissionBookkeeper();
        $this->object
            ->setCountryProvider($this->countryProviderStub)
            ->setRatesProvider($this->ratesProviderStub)
            ;
    }

    public function edgeCasesProvider() {
        //  country, currency, amount, rate, expected
        return [
            ["DE", "EUR", 100.00, 1.00, 1.00], // EU country with EUR currency
            ["PL", "PLN", 100.00, 4.00, 0.25], // EU country with non-EUR currency
            ["US", "USD", 100.00, 0.50, 4.00], // non-EU country with non-EUR currency
            ["MC", "EUR", 100.00, 1.00, 2.00], // non-EU country with EUR currency
            ["DE", "EUR", 100.01, 1.00, 1.01], // ceiling to 1 eurocent
        ];
    }

    /**
     * @dataProvider edgeCasesProvider
     */
    public function testEdgeCases($country, $currency, $amount, $rate,  $expected)
    {
        $data = new class {
            public  $bin = "000000", $amount, $currency;
        };

        $data->amount = $amount;
        $data->currency = $currency;

        $this->countryProviderStub->method('getCountry')
            ->willReturn(CountryIso3166Aplha2Enum::fromValue($country));

        $this->ratesProviderStub->method('getRateByCurrency')
            ->willReturn($rate);

        $res = $this->object
            ->setInputData( $data)
            ->commit()
            ->getResult();

        $this->assertEquals($expected, $res);
    }

    public function invalidDataProvider()
    {
        return [
            [null, "Invalid data!"],
            [new class { }, 'Invalid data!'],
            [new class { public $bin="234234"; }, 'Invalid data!'],
            [new class { public $bin="234234", $amount = 1; }, 'Invalid data!'],
            [new class { public $bin="234234", $currency = "PLN"; }, 'Invalid data!'],
            [new class { public $bin="353455", $amount = 0, $currency = "PLN"; }, 'Invalid amount!'],
            [new class { public $bin="3453456", $amount = 10, $currency = "pl"; }, 'Unsupported currency!'],
            [new class { public $bin="34456", $amount = 10, $currency = "PLN"; }, 'BIN too short!'],
        ];
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function testSetInvalidInputData($data, $expectedMessage)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedMessage);

        $res = $this->object
            ->setInputData( $data);

    }
}