<?php

namespace App\Services\ToolsServices\StockServices;


use App\Messages\ErrorMessage;
use App\Messages\Messages;
use App\Models\Stock;
use App\Repositories\StockRepository;

class AddStockService
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

    public function add(string $stock, int $amount)
    {
        $api = $this->stockRepository->searchStock($stock);
//        var_dump($stock['c']); die;
        if ($api['c'] === 0) {
            $this->errorMessage->setText($this->messages->error4());
//            session_destroy(); //todo
            return redirect()->route('tools');
        }
        $newStock = new Stock();
        $newStock->name = $stock;
        $newStock->actual_price = $api['c'];
        $newStock->starting_price = $api['c'];
        $newStock->total = $amount;
        $newStock->save();

        return redirect()->route('tools');

    }

}
