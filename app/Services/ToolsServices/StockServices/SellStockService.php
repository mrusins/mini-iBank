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

class SellStockService
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

    public function sell(string $stock, int $amount, float $actualPrice): void
    {
        $count = DB::table('stocks')
            ->where('name', $stock)
            ->where('uniq_id', '=', $_SESSION['uniqID'])
            ->get()
            ->toArray();

//        var_dump($count[0]->total, $amount);die;

        if (((int)$count[0]->total - $amount) < 0) {
            $this->errorMessage->setText($this->messages->error7());
            $this->redirect();
        } else {
            $update = DB::table('stocks')
                ->where('id', '=', $count[0]->id)
                ->update(['total' => (int)$count[0]->total - $amount]);

            $this->investmentAccountService->accountPlus($amount, (float)$count[0]->actual_price);
        }

    }

    private function redirect()
    {
        return redirect()->route('tools');
    }
}
