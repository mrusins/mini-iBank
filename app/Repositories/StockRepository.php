<?php

namespace App\Repositories;





class StockRepository
{
    private string $token ='c1mnur237fkpnsp61f6g'; //TODO add your private token

    public function searchStock(string $apiName): array
    {
        $url = "https://finnhub.io/api/v1/quote?symbol=" . $apiName . "&token=$this->token";

        $json = file_get_contents($url);
        $data = json_decode($json, TRUE);
        $this->temp = [$data];
        return $data;
    }
}
