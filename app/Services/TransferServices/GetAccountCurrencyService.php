<?php

namespace App\Services\TransferServices;

use App\Models\Account;
use App\Models\Currency;

class GetAccountCurrencyService
{


    public function fromAccount(string $fromAccount, string $toAccount): array
    {


        $fromCurrency = Account::where('account', $fromAccount)->first()['currency'];
        if($fromCurrency !== 'EUR'){
            $fromCurrencyRate = Currency::where('ID', $fromCurrency)->first()['Rate'];
        } else {
            $fromCurrencyRate = 1 * 100000;
        }


        $toCurrency = Account::where('account', $toAccount)->first()['currency'];


//        var_dump($toCurrency); die;

        if($toCurrency !== 'EUR'){
            $toCurrencyRate = Currency::where('ID', $toCurrency)->first()['Rate'];
        } else {
            $toCurrencyRate = 1 * 100000;
        }

        $this->paymentCurrencies = [
            'fromCurrency'=> $fromCurrency,
            'toCurrency' => $toCurrency
        ];

        return [
            'fromCurrency'=> $fromCurrency,
            'toCurrency' => $toCurrency,
            'fromCurrencyRate' => $fromCurrencyRate,
            'toCurrencyRate' => $toCurrencyRate
        ];
    }


}
