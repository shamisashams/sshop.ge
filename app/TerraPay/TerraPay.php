<?php

namespace App\TerraPay;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class TerraPay
{

    private $http_client;

    private $apiUrl = 'https://test01.terabank.ge/CustomerOnBoarding.Retail.Api/api/UserSessions/AddStoreProducts';

    private $bankUrl = 'https://test01.terabank.ge/customer-on-boarding/installments/products/';


    private $Culture = ['ka','en'];
    private $selectedCulture;
    private $StoreId = '';

    public function __construct($StoreId, $Culture = 0)
    {
        $this->selectedCulture = isset($this->Culture[$Culture]) ? $this->Culture[$Culture] : $this->Culture[0];
        $this->StoreId = $StoreId;
        $this->http_client = new Client();
    }

    public function makeOrder($OrderId,$StoreProduct = []){

        $json = [];
        $productData = [];

        foreach ($StoreProduct as $item){
            $product = [
                'Code' => $item['code'],
                'Name' => $item['name'],
                'Amount' => $item['amount'],
                'CashAmount' => $item['cashAmount'],
                'Quantity' => $item['quantity'],
            ];
            $productData[] = $product;
        }

        $json['Culture'] = $this->selectedCulture;
        $json['StoreId'] = $this->StoreId;
        $json['OrderId'] = $OrderId;
        $json['Products'] = $productData;


        //dd($json);

        $url = $this->apiUrl;

        try {
            $response = $this->http_client->request('POST', $url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],

                'json' => $json,
                'verify' => false
            ]);

            return $response->getBody()->getContents();
        } catch (\Exception $exception){
            echo($exception->getMessage());
            exit();
        }



    }

    public function redirectUrl($storeSessionId = null){
        if($storeSessionId !== null){
            return $this->bankUrl.$storeSessionId;
        }
    }

}
