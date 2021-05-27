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

class AddStockService
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

    public function add(string $stock, int $amount)
    {
        $api = $this->stockRepository->searchStock($stock);
        $this->stockPrice = $api['c'];
        $this->buyAmount = $amount;

        if ($api['c'] === 0) {
            $this->errorMessage->setText($this->messages->error4());
            return redirect()->route('tools');
        } elseif ($this->isMoneyEnoughService->isMoneyEnough($amount, $this->stockPrice) === false) {
            $this->errorMessage->setText($this->messages->error6());
            return redirect()->route('tools');
        }


        if (Stock::where('name', '=', $stock)->where('uniq_id', '=', $_SESSION['uniqID'])->count() > 0) {
            $count = DB::table('stocks')
                ->where('name', $stock)
                ->where('uniq_id', '=', $_SESSION['uniqID'])
                ->get()
                ->toArray();

            $update = DB::table('stocks')
                ->where('id', '=', $count[0]->id)
                ->where('uniq_id', '=', $_SESSION['uniqID'])
                ->update(['total' => (int)$count[0]->total + $amount, 'updated_at' => Carbon::now()]);

            $this->investmentAccountService->accountMinus($amount, $this->stockPrice);


        } else {
            $newStock = new Stock();
            $newStock->name = $stock;
            $newStock->actual_price = $api['c'];
            $newStock->starting_price = $api['c'];
            $newStock->total = $amount;
            $newStock->uniq_id = $_SESSION['uniqID'];
            $newStock->save();
            $this->investmentAccountService->accountMinus($amount, $this->stockPrice);

        }
    }


}
