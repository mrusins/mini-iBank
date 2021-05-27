<?php

namespace App\Http\Controllers;


use App\Messages\ErrorMessage;
use App\Messages\InfoMessage;
use App\Repositories\CurrencyRateRepository;
use App\Repositories\StockRepository;
use App\Services\GetSummary;
use App\Services\ToolsServices\CurrencyServices\AllCurrencies;
use App\Services\ToolsServices\CurrencyServices\GetActualRateService;
use App\Services\ToolsServices\CurrencyServices\ShowHideRatesService;
use App\Services\ToolsServices\StockServices\AddStockService;
use App\Services\ToolsServices\StockServices\ReadStocksService;
use App\Services\ToolsServices\StockServices\SellStockService;
use App\Services\ToolsServices\StockServices\UpdateStocksService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinToolsController extends Controller
{
    const TIME_ZONE = 3;
    const CURRENCY_REFRESH_TIME = 20;

    private GetActualRateService $getActualRateService;
    private AllCurrencies $allCurrencies;
    private AddStockService $addStockService;
    private ErrorMessage $errorMessage;
    private InfoMessage $infoMessage;
    private ReadStocksService $readStocksService;
    private ShowHideRatesService $showHideRatesService;
    private GetSummary $getSummary;
    private SellStockService $sellStockService;
    private UpdateStocksService $updateStocksService;

    public function __construct(GetActualRateService $getActualRateService,
                                AllCurrencies $allCurrencies,
                                AddStockService $addStockService,
                                ErrorMessage $errorMessage,
                                InfoMessage $infoMessage,
                                ReadStocksService $readStocksService,
                                ShowHideRatesService $showHideRatesService,
                                GetSummary $getSummary,
                                SellStockService $sellStockService,
                                UpdateStocksService $updateStocksService
    )
    {
        $this->getActualRateService = $getActualRateService;
        $this->allCurrencies = $allCurrencies;
        $this->addStockService = $addStockService;
        $this->errorMessage = $errorMessage;
        $this->infoMessage = $infoMessage;
        $this->readStocksService = $readStocksService;
        $this->showHideRatesService = $showHideRatesService;
        $this->getSummary = $getSummary;
        $this->sellStockService = $sellStockService;
        $this->updateStocksService = $updateStocksService;
    }


    public function index()
    {
        $user = auth()->user();
        $_SESSION['uniqID'] = $user->uniqId;
        $this->getActualRateService->autoUpdate(self::CURRENCY_REFRESH_TIME, self::TIME_ZONE);

        $this->readStocksService->get();

        echo view('tools', [
            'currencyUpdateTime' => $this->getActualRateService->getUpdateTime(),
            'allCurrencies' => $this->allCurrencies->getAll(),
            'viewRates' => $this->showHideRatesService->showRates(),
            'errorMessages' => $this->errorMessage->getText(),
            'infoMessages' => $this->infoMessage->getText(),
            'myStocks' => $this->readStocksService->get(),
            'total' => $this->getSummary->total(),

        ]);
        unset($_SESSION['errorMsg'],
            $_SESSION['infoMsg']
        );
    }

    public function showRates()
    {
        $this->showHideRatesService->hideRates();

        return redirect()->route('tools');
    }

    public function hideRates()
    {
        $this->showHideRatesService->seeRates();
//        var_dump('aaa'); die;
        return redirect()->route('tools');
    }

    public function addStock()
    {
//        var_dump($_POST); die;
        $this->addStockService->add($_POST['stock'], (int)$_POST['stockAmount']);
        return redirect()->route('tools');

    }

    public function sellStock()
    {
//        var_dump($_POST);
//        die;
        $this->sellStockService->sell($_POST['name'], (int)$_POST['amount'], (float)$_POST['actualPrice']);
        return redirect()->route('tools');
    }

    public function updateStocks()
    {
        $this->updateStocksService->update();
        return redirect()->route('tools');

//        var_dump('updating');
//        die;
    }
}
