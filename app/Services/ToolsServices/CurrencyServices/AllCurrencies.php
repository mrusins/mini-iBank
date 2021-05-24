<?php

namespace App\Services\ToolsServices\CurrencyServices;

use Illuminate\Support\Facades\DB;

class AllCurrencies
{

    public function getAll():array
    {
        $results = [];
                $data =  DB::table('currencies')->get();
                foreach ($data as $value){
                    array_push($results, [
                        "ID"=>$value->ID,
                        'Rate'=>$value->Rate / 100000
                    ]);
                }
                return $results;
    }

}
