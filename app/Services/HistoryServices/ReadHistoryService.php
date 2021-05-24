<?php

namespace App\Services\HistoryServices;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Throwable;

class ReadHistoryService
{
    public function out(int $recordCount)
    {

        $accounts = $_SESSION['userAccounts'];

        return Transaction::where(function ($q) use ($accounts) {
            foreach ($accounts as $account) {
                $a = implode('',$account);
                $q->orWhere('from_account', 'like', "%{$a}%")
                ->orWhere('to_account', 'like', "%{$a}%");
            }
        })->orderBy('created_at', 'DESC')->paginate($recordCount);

    }

    public function in():array
    {

    }



}
