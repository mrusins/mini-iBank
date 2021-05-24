<?php

namespace App\Services\HistoryServices;

use App\Models\Transaction;
use App\Services\TransferServices\GetAccountCurrencyService;
use App\Services\TransferServices\ToAccountService;
use Throwable;

class WriteHistoryService
{
    private GetAccountCurrencyService $getAccountCurrencyService;

    public function __construct(GetAccountCurrencyService $getAccountCurrencyService)
    {

        $this->getAccountCurrencyService = $getAccountCurrencyService;
    }

    public function save(string $fromAccount, string $toAccount, float $amount)
    {

        $fromAccountCurrency = $this->getAccountCurrencyService->fromAccount($fromAccount, $toAccount)['fromCurrency'];
        $toAccountCurrency = $this->getAccountCurrencyService->fromAccount($fromAccount, $toAccount)['toCurrency'];


        try {
            $transaction = new Transaction();

            $transaction->from_account = $fromAccount;
            $transaction->to_account = $toAccount;
            $transaction->amount = $amount * 100;
            $transaction->currency = $fromAccountCurrency;
            $transaction->converted_to = $toAccountCurrency;
            $transaction->converted_amount = $_SESSION['convertedAmount'];


            $transaction->save();

        } catch (Throwable $e) {
            report($e);

            return false;
        }
    }
}
