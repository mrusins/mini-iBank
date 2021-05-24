<?php

namespace App\Services\TransferServices;

use App\Messages\ErrorMessage;
use App\Messages\InfoMessage;
use App\Messages\Messages;
use App\Validations\IsEnoughToMakeTransferValidation;


class TransferService
{

    private IsEnoughToMakeTransferValidation $isEnoughToMakeTransferValidation;
    private ErrorMessage $errorMessage;
    private InfoMessage $infoMessage;
    private Messages $messages;
    private ToAccountService $toAccountService;
    private FromAccountService $fromAccountService;


    public function __construct(IsEnoughToMakeTransferValidation $isEnoughToMakeTransferValidation,
                                ErrorMessage $errorMessage,
                                InfoMessage $infoMessage,
                                Messages $messages,
                                ToAccountService $toAccountService,
                                FromAccountService $fromAccountService)
    {

        $this->isEnoughToMakeTransferValidation = $isEnoughToMakeTransferValidation;
        $this->errorMessage = $errorMessage;
        $this->infoMessage = $infoMessage;
        $this->messages = $messages;
        $this->toAccountService = $toAccountService;
        $this->fromAccountService = $fromAccountService;}

    public function transfer(string $toAccount, string $fromAccount, string $amount): void
    {

        if ($this->isEnoughToMakeTransferValidation->validate($fromAccount, $amount)) {

            if ($this->toAccountService->toAccount($fromAccount,$toAccount, $amount) === true &&
                $this->fromAccountService->fromAccount($fromAccount, $amount) === true) {

                $this->infoMessage->setText($this->messages->success1());
                $_SESSION['isPaymentValid'] = true;
            } else {
                $this->errorMessage->setText($this->messages->error1());
                $_SESSION['isPaymentValid'] = false;

            }
        } else {
            $this->errorMessage->setText($this->messages->error2());
            $_SESSION['isPaymentValid'] = false;

        }

    }

}
