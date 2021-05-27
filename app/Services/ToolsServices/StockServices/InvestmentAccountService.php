<?php

namespace App\Services\ToolsServices\StockServices;


use App\Services\GetSummary;
use Illuminate\Support\Facades\DB;

class InvestmentAccountService
{
    private GetSummary $getSummary;

    public function __construct(GetSummary $getSummary){

        $this->getSummary = $getSummary;
    }

    public function accountMinus(int $amount, float $price):void
    {

        $accounts = $this->getSummary->total();
        $investmentAccountId = '1';
        foreach ($accounts as $account) {
            if ($account['is_investment'] === true) {
                $investmentAccountId = $account['id'];
            }
        }
        $actualSum = DB::table('accounts')
            ->where('id', $investmentAccountId)
            ->get()
            ->toArray();

        $update = DB::table('accounts')
            ->where('id', $investmentAccountId)
            ->update(['amount' => (int)$actualSum[0]->amount - (($amount * $price)*100)]);

    }
    public function accountPlus(int $amount, float $price):void
    {
        $accounts = $this->getSummary->total();
        $investmentAccountId = '1';
        foreach ($accounts as $account) {
            if ($account['is_investment'] === true) {
                $investmentAccountId = $account['id'];
            }
        }
        $actualSum = DB::table('accounts')
            ->where('id', $investmentAccountId)
            ->get()
            ->toArray();

        $update = DB::table('accounts')
            ->where('id', $investmentAccountId)
            ->update(['amount' => (int)$actualSum[0]->amount + (($amount * $price)*100)]);
    }
}
