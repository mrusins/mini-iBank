<?php

namespace App\Services\ToolsServices\StockServices;

use App\Messages\ErrorMessage;
use App\Messages\Messages;
use App\Models\Stock;
use App\Repositories\StockRepository;
use App\Services\GetSummary;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UpdateStocksService
{
    private StockRepository $stockRepository;
    private ErrorMessage $errorMessage;
    private Messages $messages;
    private float $stockPrice;
    private int $buyAmount;
    private GetSummary $getSummary;
    private IsMoneyEnoughService $isMoneyEnoughService;
    private InvestmentAccountService $investmentAccountService;

    public function __construct(StockRepository $stockRepository,
                                ErrorMessage $errorMessage,
                                Messages $messages,
                                GetSummary $getSummary,
                                IsMoneyEnoughService $isMoneyEnoughService,
                                InvestmentAccountService $investmentAccountService
    )
    {

        $this->stockRepository = $stockRepository;
        $this->errorMessage = $errorMessage;
        $this->messages = $messages;
        $this->getSummary = $getSummary;
        $this->isMoneyEnoughService = $isMoneyEnoughService;
        $this->investmentAccountService = $investmentAccountService;
    }


    public function update():void
    {
//        var_dump($this->stockRepository->searchStock('PBR'));die;

        $myStocks = Stock::select('name')->where('uniq_id', $_SESSION['uniqID'])->get()->toArray();
        foreach ($myStocks as $stock){
            $updated = $this->stockRepository->searchStock($stock['name']);

            $upd = Stock::updateOrCreate(
                ['name' => $stock],
                ['actual_price' => $updated['c'], 'updated_at' => Carbon::now()]
            );



        }
    }
}
