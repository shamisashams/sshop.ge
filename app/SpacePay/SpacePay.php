<?php

namespace App\SpacePay;

use GuzzleHttp\Client;

class SpacePay
{

    private $http_client;

    private $apiUrl = 'https://testapi.spacebank.ge/api/v1/';

    private $createQr = 'qr/create';
    private $checkStatus = 'loans/checkstatus';
    private $installmentCancel = 'loans/installments/cance';

    private $secret = '';
    private $merchant = '';


    /**
     * @param $merchant
     * @param $secret
     */

    public function __construct($merchant, $secret)
    {
        $this->secret = $secret;
        $this->merchant = $merchant;
        $this->http_client = new Client();
    }


    /**
     * @param string $PhoneNumber
     * @param float $TotalAmount
     * @param string $OrderId
     * @param float|null $GrandTotalAmount
     * @param float|null $DiscountAmount
     * @param int $Type
     * @param string $returnUrl
     * @param array $Products
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */

    public function createQr(
        float $TotalAmount,
        string $OrderId,
        string $PhoneNumber = null,
        $GrandTotalAmount = 0,
        $DiscountAmount = 0,
        int $Type = 1,
        string $returnUrl = '',
        array $Products = []
    ){

        $json = [];

        $productData = [];

        foreach ($Products as $item){
            $product = [
                'Title' => $item['title'],
                'Model' => $item['model'],
                'Quantity' => $item['quantity'],
                'Amount' => $item['amount'],
                'CashbackAmount' => $item['cashbackAmount'],
                'ImageUrl' => $item['image'],
            ];
            $productData[] = $product;
        }

        $json['Data']['MerchantName'] = $this->merchant;
        $json['Data']['PhoneNumber'] = $PhoneNumber;
        $json['Data']['GrandTotalAmount'] = $GrandTotalAmount;
        $json['Data']['DiscountAmount'] = $DiscountAmount;
        $json['Data']['TotalAmount'] = $TotalAmount;
        $json['Data']['OrderId'] = $OrderId;
        $json['Data']['Type'] = $Type;
        $json['Data']['returnUrl'] = $returnUrl;
        $json['Data']['Products'] = $productData;
        $json['Data']['Secret'] = $this->secret;



        $url = $this->apiUrl.$this->createQr;

        $response = $this->http_client->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/json',
            ],

            'json' => $json
        ]);

        return $response->getBody()->getContents();
    }

    public function checkStatus($orderId){
        $url = $this->apiUrl.$this->checkStatus;

        $response = $this->http_client->request('GET', $url, [

                'query' => [
                    'MerchantName' => $this->merchant,
                    'OrderId' => $orderId,
                    'Secret' => $this->secret
                ]

        ]);

        return $response->getBody()->getContents();
    }

    public function installmentCancel(){

    }

}
