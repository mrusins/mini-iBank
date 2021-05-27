<?php

namespace App\Services;

use App\Models\Account;
use Illuminate\Http\Request;

class GetSummary
{
    public function total(){
        $total = [];

        $fromDBbyId = Account::where('uniqId', $_SESSION['uniqID'])->get(['id','currency','amount', 'account', 'is_investment'])->toArray();
        foreach ($fromDBbyId as $item){
            array_push($total, [
                'id'=> $item['id'],
                'currency'=>$item['currency'],
                'amount'=>$item['amount'],
                'is_investment'=>(bool)$item['is_investment'],
                'account'=>$item['account']] );
        }
        return $total;
    }
}
