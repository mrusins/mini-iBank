<?php

namespace App\Validations;


use App\Http\Controllers\Controller;
use App\Models\Account;

class TransferFormValidation extends Controller
{

    public function valid( $request): bool
    {
        $this->validate($request, [
            'fromAccount' => 'required',
            'toAccount' => 'required',
            'amount' => 'required',
        ]);
return true;

    }
}
