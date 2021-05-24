<?php

namespace App\Services;

use App\Models\Account;
use Illuminate\Http\Request;

class GetUserAccounts
{
    public function getUserAccounts():array{
        $total = [];

        $fromDBbyId = Account::where('uniqId', $_SESSION['uniqID'])
            ->where('is_investment', '=', false)
            ->get(['account'])
            ->toArray();

//        var_dump($fromDBbyId);
        $_SESSION['userAccounts'] = $fromDBbyId;
        foreach ($fromDBbyId as $item){
            array_push($total, [
                $item['account']=>$item['account']] );
        }
        return $total;
    }
}
