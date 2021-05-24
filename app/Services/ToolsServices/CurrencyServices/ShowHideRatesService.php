<?php

namespace App\Services\ToolsServices\CurrencyServices;

use Illuminate\Support\Facades\DB;

class ShowHideRatesService
{

    public function showRates(): bool
    {
        if(!isset($_SESSION['viewRates'])){
            $_SESSION['viewRates'] = true;
            return true;
        }
        elseif ($_SESSION['viewRates'] === true) {
            $_SESSION['viewRates'] = false;
            return false;

        } elseif ($_SESSION['viewRates'] === false) {
            $_SESSION['viewRates'] = true;
            return true;

        }
    }

}
