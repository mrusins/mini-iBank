<?php

namespace App\Services\TransferServices;

use App\Models\Account;

class PaymentConfirmationService
{
    public function confirm(): array
    {

        if (isset($_SESSION['confirmPayment']) && $_SESSION['confirmPayment'] === true) {
            $_SESSION['confirmPayment'] = false;
            return ['fromAccount' => $_SESSION['paymentData']['fromAccount'],
                'toAccount' => $_SESSION['paymentData']['toAccount'],
                'amount' => $_SESSION['paymentData']['amount']
                ];
        }
        $_SESSION['confirmPayment'] = false;
        return [];
    }
}
