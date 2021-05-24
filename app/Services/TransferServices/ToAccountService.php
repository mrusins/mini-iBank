<?php

namespace App\Services\TransferServices;

use App\Models\Account;

class ToAccountService
{
    private GetAccountCurrencyService $getAccountCurrencyService;

    public function __construct(GetAccountCurrencyService $getAccountCurrencyService)
    {

        $this->getAccountCurrencyService = $getAccountCurrencyService;
    }

    public function toAccount(string $fromAccount, string $toAccount, string $amount): bool
    {
        if (!isset($toAccount)) {
            return false;
        }
        if (Account::where('account', '=', $toAccount)->count() > 0) {
            $id = Account::where('account', $toAccount)->first()['id'];
            $payment = Account::find($id);
            $sumInAccount = Account::where('account', $toAccount)->first()['amount'];
            $paymentCurrencies = $this->getAccountCurrencyService->fromAccount($fromAccount, $toAccount);
            $totalPayment = (float)(($paymentCurrencies['toCurrencyRate'] /
                        $paymentCurrencies['fromCurrencyRate']) * $amount) * 100 + (int)$sumInAccount;

            $payment->amount = round($totalPayment, 0);
            $_SESSION['convertedAmount'] = round($totalPayment, 0) - $sumInAccount;
            return (int)$payment->save();

        } else {
            return false;
        }
    }



}
