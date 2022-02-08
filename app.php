<?php

namespace Coff\TestAssignment;

use Coff\TestAssignment\Bookkeeper\CommissionBookkeeper;
use Coff\TestAssignment\Country\BinListCountryProvider;
use Coff\TestAssignment\ExchangeRates\ExchangeRatesProvider;

include "vendor/autoload.php";

$fileName = $argv[1];

$bk = new CommissionBookkeeper();

// injecting providers
$bk->setRatesProvider($erProvider = new ExchangeRatesProvider());
$bk->setCountryProvider($cProvider = new BinListCountryProvider());

// inject providers here with all dependencies

$bk->init();

try {
    $handle = fopen($fileName, "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            if (empty(trim($line))) {
                continue;
            }
            $jsonData = json_decode($line);

            $bk
                ->setInputData($jsonData)
                ->commit()
            ;
            echo $bk->getResult() . PHP_EOL;
        }

        fclose($handle);
    }
} catch (\Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
    echo $exception->getTraceAsString() . PHP_EOL;
}





