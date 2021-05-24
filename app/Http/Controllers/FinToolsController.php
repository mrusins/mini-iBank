<?php

namespace App\Http\Controllers;


use App\Messages\ErrorMessage;
use App\Messages\InfoMessage;
use App\Repositories\CurrencyRateRepository;
use App\Repositories\StockRepository;
use App\Services\ToolsServices\CurrencyServices\AllCurrencies;
use App\Services\ToolsServices\CurrencyServices\GetActualRateService;
use App\Services\ToolsServices\CurrencyServices\ShowHideRatesService;
use App\Services\ToolsServices\StockServices\AddStockService;
use App\Services\ToolsServices\StockServices\ReadStocksService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinToolsController extends Controller
{
    private GetActualRateService $getActualRateService;
    private AllCurrencies $allCurrencies;
    private StockRepository $stockRepository;
    private AddStockService $addStockService;
    private ErrorMessage $errorMessage;
    private InfoMessage $infoMessage;
    private ReadStocksService $readStocksService;
    private ShowHideRatesService $showHideRatesService;

    public function __construct(GetActualRateService $getActualRateService,
                                AllCurrencies $allCurrencies,
                                StockRepository $stockRepository,
                                AddStockService $addStockService,
                                ErrorMessage $errorMessage,
                                InfoMessage $infoMessage,
                                ReadStocksService $readStocksService,
                                ShowHideRatesService $showHideRatesService
    )
    {
        $this->getActualRateService = $getActualRateService;
        $this->allCurrencies = $allCurrencies;
        $this->stockRepository = $stockRepository;
        $this->addStockService = $addStockService;
        $this->errorMessage = $errorMessage;
        $this->infoMessage = $infoMessage;
        $this->readStocksService = $readStocksService;
        $this->showHideRatesService = $showHideRatesService;
    }


    public function index()
    {
        $this->getActualRateService->autoUpdate(20, 3);

        $this->readStocksService->get();
//        $this->addStockService->add('F');


        echo view('tools', [
            'currencyUpdateTime' => $this->getActualRateService->getUpdateTime(),
            'allCurrencies' => $this->allCurrencies->getAll(),
            'viewRates' => $this->showHideRatesService->showRates(),
            'errorMessages' => $this->errorMessage->getText(),
            'infoMessages' => $this->infoMessage->getText(),
            'myStocks' => $this->readStocksService->get(),

        ]);
        unset($_SESSION['errorMsg'],
            $_SESSION['infoMsg']
        );
    }

    public function showRates()
    {
        return redirect()->route('tools');
    }

    public function addStock()
    {
//        var_dump($_POST); die;
        $this->addStockService->add($_POST['stock'], (int)$_POST['stockAmount']);
        return redirect()->route('tools');

    }
}
