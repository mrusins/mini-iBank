<?php

namespace App\Services\ToolsServices\CurrencyServices;

class ShowHideRatesService
{

    public function showRates(): bool
    {
        if (!isset($_SESSION['viewRates'])) {
            $_SESSION['viewRates'] = true;
        }
        return $_SESSION['viewRates'];
    }

    public function seeRates(): void
    {
        $_SESSION['viewRates'] = true;
    }

    public function hideRates(): void
    {
        $_SESSION['viewRates'] = false;

    }
}
