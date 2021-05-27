<?php

namespace App\Services\ToolsServices\StockServices;


use App\Messages\ErrorMessage;
use App\Messages\Messages;
use App\Models\Stock;
use App\Repositories\StockRepository;
use App\Services\GetSummary;
use Illuminate\Database\Eloquent\Model;

class IsMoneyEnoughService
{

    private ErrorMessage $errorMessage;
    private Messages $messages;
    private float $stockPrice;
    private int $buyAmount;
    private GetSummary $getSummary;

    public function __construct(
                                ErrorMessage $errorMessage,
                                Messages $messages,
                                GetSummary $getSummary
    )
    {

        $this->errorMessage = $errorMessage;
        $this->messages = $messages;
        $this->getSummary = $getSummary;
    }

    public function isMoneyEnough(int $amount, float $price): bool
    {
        $stockCartSum = ($amount * $price) * 100;
        $accounts = $this->getSummary->total();
        $investmentAccountSum = '1';
        foreach ($accounts as $account) {
            if ($account['is_investment'] === true) {
                $investmentAccountSum = $account['amount'];
            }
        }
        if (strlen($investmentAccountSum) <= 1) {
            $this->errorMessage->setText($this->messages->error5());
            $this->redirect();
        }
        return $stockCartSum > $investmentAccountSum ? false : true;

    }

    private function redirect()
    {
        return redirect()->route('tools');

    }

}
