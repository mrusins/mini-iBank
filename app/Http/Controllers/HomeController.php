<?php

namespace App\Http\Controllers;

use App\Messages\ErrorMessage;
use App\Messages\InfoMessage;
use App\Messages\Messages;
use App\Models\Transaction;
use App\Services\GetSummary;
use App\Services\GetUserAccounts;
use App\Services\HistoryServices\ReadHistoryService;
use App\Services\HistoryServices\WriteHistoryService;
use App\Services\TransferServices\PaymentConfirmationService;
use App\Services\TransferServices\TransferService;
use App\Validations\TransferFormValidation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Throwable;


class HomeController extends Controller
{
    const HISTORY_RECORDS_PER_PAGE = 10;



    private GetSummary $getSummary;
    private GetUserAccounts $getUserAccounts;
    private TransferService $transferService;
    private ErrorMessage $errorMessage;
    private InfoMessage $infoMessage;
    private TransferFormValidation $transferFormValidation;
    private WriteHistoryService $writeHistoryService;
    private ReadHistoryService $readHistoryService;
    private PaymentConfirmationService $paymentConfirmationService;
    private Messages $messages;

    public function __construct(GetSummary $getSummary,
                                Messages $messages,
                                GetUserAccounts $getUserAccounts,
                                TransferService $transferService,
                                PaymentConfirmationService $paymentConfirmationService,
                                ErrorMessage $errorMessage,
                                InfoMessage $infoMessage,
                                TransferFormValidation $transferFormValidation,
                                WriteHistoryService $writeHistoryService,
                                ReadHistoryService $readHistoryService)
    {

        $this->getSummary = $getSummary;
        $this->getUserAccounts = $getUserAccounts;
        $this->transferService = $transferService;
        $this->errorMessage = $errorMessage;
        $this->infoMessage = $infoMessage;
        $this->transferFormValidation = $transferFormValidation;
        $this->writeHistoryService = $writeHistoryService;
        $this->readHistoryService = $readHistoryService;
        $this->paymentConfirmationService = $paymentConfirmationService;
        $this->messages = $messages;
    }

    public function index(Request $request)
    {
//        var_dump($_SESSION);
//        $_SESSION['confirmPayment'] = false;

        $user = auth()->user();
        $_SESSION['uniqID'] = $user->uniqId;
        $_SESSION['viewRates'] = true;

//var_dump($this->paymentConfirmationService->confirm());


        echo view('head', [

            'total' => $this->getSummary->total(),
            'userAccounts' => $this->getUserAccounts->getUserAccounts(),
            'errorMessages' => $this->errorMessage->getText(),
            'infoMessages' => $this->infoMessage->getText(),
            'history' => $this->readHistoryService->out(self::HISTORY_RECORDS_PER_PAGE),
            'paymentConfirmation' => $this->paymentConfirmationService->confirm()

        ]);
        unset($_SESSION['errorMsg'],
            $_SESSION['infoMsg'],
            $_SESSION['paymentData']
        );
        session_destroy(); //todo

    }

    public function indexRedirect(Request $request)
    {

        if (isset($_POST['toAccount'])) {
            $this->transferService->transfer($_POST['toAccount'], $_POST['fromAccount'], $_POST['amount']);
            if ($_SESSION['isPaymentValid'] === true) {
                $this->writeHistoryService->save($_POST['fromAccount'], $_POST['toAccount'], $_POST['amount']);
            }
        }

        return redirect()->route('index');
    }

    public function confirmPayment(Request $request)
    {
        if (isset($_POST['toAccount'])) {
            $this->transferFormValidation->valid($request);
            if (count($_SESSION['errorMsg']) === 0) {
                $_SESSION['confirmPayment'] = true;
                $_SESSION['paymentData'] = ['fromAccount' => $_POST['fromAccount'], 'toAccount' => $_POST['toAccount'], 'amount' => $_POST['amount']];
            }
        }

        return redirect()->route('index');
    }

    public function cancelPayment()
    {
        $this->errorMessage->setText($this->messages->error3());

        return redirect()->route('index');

    }

    public function confirmPassword()
    {
        return redirect()->route('confirmPayment');
    }

}
