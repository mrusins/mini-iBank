<?php

namespace App\Services\ToolsServices\StockServices;


use App\Messages\ErrorMessage;
use App\Messages\Messages;
use App\Models\Stock;
use App\Repositories\StockRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReadStocksService
{

    private StockRepository $stockRepository;
    private ErrorMessage $errorMessage;
    private Messages $messages;

    public function __construct(StockRepository $stockRepository,
                                ErrorMessage $errorMessage,
                                Messages $messages)
    {

        $this->stockRepository = $stockRepository;
        $this->errorMessage = $errorMessage;
        $this->messages = $messages;
    }

    public function get()
    {
$stocks = DB::table('stocks')->get();
return $stocks;
//var_dump($stocks); die;

    }

}
