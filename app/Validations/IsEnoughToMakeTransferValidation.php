<?php

namespace App\Validations;


use App\Models\Account;

class IsEnoughToMakeTransferValidation
{

    public function validate(string $fromAccount, string $amount): bool
    {

        $sumInAccount = Account::where('account', $fromAccount)->first()['amount'];

        if ($amount * 100 > $sumInAccount) {

            return false;
        }

        return true;

    }
}
