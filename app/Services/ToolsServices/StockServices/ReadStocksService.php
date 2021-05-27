<?php

namespace App\Services\ToolsServices\StockServices;


use Illuminate\Support\Facades\DB;

class ReadStocksService
{


    public function get()
    {
$stocks = DB::table('stocks')->where('uniq_id', $_SESSION['uniqID'])->get();
return $stocks;
    }
}
