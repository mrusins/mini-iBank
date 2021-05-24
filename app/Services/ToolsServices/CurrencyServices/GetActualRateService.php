<?php

namespace App\Services\ToolsServices\CurrencyServices;


use App\Models\Currency;
use App\Repositories\CurrencyRateRepository;
use Carbon\Carbon;

class GetActualRateService
{

    private CurrencyRateRepository $currencyRateRepository;
    private string $updateTime;

    public function __construct(CurrencyRateRepository $currencyRateRepository)
    {

        $this->currencyRateRepository = $currencyRateRepository;
        $this->updateTime = '';
    }

    public function autoUpdate(int $minutes, int $timeZone): void
    {

        $date = Carbon::now()->addMinutes($timeZone * 60 - $minutes);

        $leatestInDB = Currency::orderBy('updated_at', 'desc')
            ->take(1)
            ->first()
            ->updated_at
            ->addHour($timeZone);


        if ($date->gt($leatestInDB)) {
            $this->currencyRateRepository->importCurrencyModel();
        }

        $leatest = Currency::orderBy('updated_at', 'desc')
            ->take(1)
            ->first()
            ->updated_at
            ->addHour($timeZone);


        $this->updateTime = $leatest->toDateTimeString();


    }

    public function getUpdateTime(): string
    {
        return $this->updateTime;
    }
}
