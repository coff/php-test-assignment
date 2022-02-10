<?php

namespace Coff\TestAssignment\Bookkeeper;

use Coff\TestAssignment\Country\CountryProviderInterface;
use Coff\TestAssignment\Enum\CurrencyIso4217Enum;
use Coff\TestAssignment\ExchangeRates\ExchangeRatesProviderInterface;

class CommissionBookkeeper implements BookkeeperInterface
{
    use BookkeeperTrait;

    /**
     * @var CountryProviderInterface
     */
    private $countryProvider;

    /**
     * @var ExchangeRatesProviderInterface
     */
    private $ratesProvider;

    /**
     * @var float
     */
    private $euCommission = 0.01;

    /**
     * @var float
     */
    private $nonEuComission = 0.02;

    /** @var float */
    private $amount;

    /** @var CurrencyIso4217Enum */
    private $currency;

    /** @var string */
    private $bin;

    /** @var float */
    private $result;

    /**
     * @param float $euCommission
     * @return CommissionBookkeeper
     */
    public function setEuCommission(float $euCommission): CommissionBookkeeper
    {
        $this->euCommission = $euCommission;
        return $this;
    }

    /**
     * @param float $nonEuComission
     * @return CommissionBookkeeper
     */
    public function setNonEuComission(float $nonEuComission): CommissionBookkeeper
    {
        $this->nonEuComission = $nonEuComission;
        return $this;
    }



    /**
     * @param CountryProviderInterface $countryProvider
     * @return CommissionBookkeeper
     */
    public function setCountryProvider(CountryProviderInterface $countryProvider): CommissionBookkeeper
    {
        $this->countryProvider = $countryProvider;
        return $this;
    }

    /**
     * @param ExchangeRatesProviderInterface $ratesProvider
     * @return CommissionBookkeeper
     */
    public function setRatesProvider(ExchangeRatesProviderInterface $ratesProvider): CommissionBookkeeper
    {
        $this->ratesProvider = $ratesProvider;
        return $this;
    }

    /**
     * @param $inputData
     * @return $this
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function setInputData($inputData): self
    {
        if (
            !isset($inputData->currency)
            || !isset($inputData->bin)
            || !isset($inputData->amount)
        ) {
            throw new \InvalidArgumentException('Invalid data!');
        }

        if (!($inputData->amount > 0)) {
            throw new \InvalidArgumentException('Invalid amount!');
        }

        if (strlen($inputData->bin) < 6) {
            throw new \InvalidArgumentException('BIN too short!');
        }

        try {
            $this->currency = CurrencyIso4217Enum::fromValue($inputData->currency);
        } catch (\UnexpectedValueException $exception) {
            throw new \InvalidArgumentException('Unsupported currency!');
        }

        $this->bin = $inputData->bin;
        $this->amount = $inputData->amount;

        return $this;
    }

    /**
     * @return mixed;
     */
    public function getResult() {
        return $this->result;
    }

    /**
     * @return $this
     */
    public function init() : self
    {
        $this->ratesProvider->fetch();

        return $this;
    }

    /**
     * @return self
     */
    public function commit() : self
    {
        $country = $this->countryProvider
            ->setBin($this->bin)
            ->fetch()
            ->getCountry()
        ;

        $rate = $this->ratesProvider->getRateByCurrency($this->currency);

        // what commission rate to use?
        $commisionRate = $country->isEuCountry() ? $this->euCommission : $this->nonEuComission;

        $amount = $this->amount * $commisionRate;

        // beware division by zero;
        if ($rate === 0) {
            throw new \Exception('Invalid rate!');
        }

        // convert to EUR; rate is '1' for EUR so it won't break it
        $amount = $amount / $rate;

        // ceil to nearest cent
        $this->result = ceil ($amount * 100) / 100;

        return $this;
    }
}