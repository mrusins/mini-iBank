<?php

namespace App\Services\TransferServices;

use App\Models\Account;

class FromAccountService
{
    public function fromAccount(string $fromAccount, string $amount)
    {
        if (!isset($fromAccount)) {
            return false;
        }
        if (Account::where('account', '=', $fromAccount)->count() > 0) {
            $id = Account::where('account', $fromAccount)->first()['id'];
            $sumInAccount = Account::where('account', $fromAccount)->first()['amount'];
            $payment = Account::find($id);
            $payment->amount = (int)$sumInAccount - (int)($amount * 100);
            return $payment->save();
        } else {
            return false;
        }
    }
}
