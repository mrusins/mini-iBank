<?php

namespace App\Repositories;


use App\Models\Currency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class CurrencyRateRepository
{

    public function importCurrencyModel()
    {

        $xmlString = file_get_contents('https://www.bank.lv/vk/ecb.xml');
        $xmlObject = simplexml_load_string($xmlString);

        $json = json_encode($xmlObject);
        $phpArray = json_decode($json, true);


        Currency::query()->delete();


        foreach ($phpArray['Currencies'] as $currency) {
            foreach ($currency as $cur) {

                $id = $cur['ID'];
                $rate = (float)$cur['Rate'] * 100000;

                $cur = new Currency(['ID' => $id, 'Rate' => $rate]);
                $cur->save();
            }
        }

    }
}
