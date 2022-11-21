<?php

namespace App\TbcPay;

use GuzzleHttp\Client;

class TbcPayment
{

    //{base-url}/{api-version}/{product}/{sub-product}

    private $baseUrl = 'https://api.tbcbank.ge';

    private $apiVersion = 'v1';

    private $apiKey;

    private $client_id;

    private $client_secret;

    private $http_client;

    private $token;


    public function __construct($apiKey, $client_id, $client_secret)
    {

        $this->apiKey = $apiKey;
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->http_client = new Client();
        $this->token = $this->getAccessToken();
    }

    private function getAccessToken(){
        $url = $this->baseUrl . '/' . $this->apiVersion . '/' . 'tpay/access-token';

        $response = $this->http_client->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'apikey' => $this->apiKey
            ],

            'form_params' => [
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret
            ]
        ]);

        $body = $response->getBody()->getContents();

        $body = json_decode($body,true);

        //dd($body);
        return $body['access_token'];
    }


    public function createPayment($total,$returnUrl,$merchantPaymentId,$installmentProducts = [],$callbackUrl = '',$preAuth = false,$language = 'KA'){
        $url = $this->baseUrl . '/' . $this->apiVersion . '/' . 'tpay/payments';

        $currency = 'GEL';
        $extra = '';
        $extra2 = '';

        $userIpAddress = request()->ip();

        $expirationMinutes = 5;

        $methods = [5,7,8];

        //$installmentProducts = [];
        //$callbackUrl = '';

        $amount = [
            'currency' => $currency,
            'total' => $total,
            'subTotal' => 0,
            'tax' => 0,
            'shipping' => 0
        ];

        $json = [
            'amount' => $amount,
            'returnurl' => $returnUrl,
            //'extra' => $extra,
            'userIpAddress' => $userIpAddress,
            'expirationMinutes' => $expirationMinutes,
            'methods' => $methods,
            'installmentProducts' => $installmentProducts,
            'callbackUrl' => $callbackUrl,
            'preAuth' => $preAuth,
            'language' => $language,
            'merchantPaymentId' => $merchantPaymentId,
            'saveCard' => false,
            'saveCardToDate' => ''
        ];

        //dd($json);

        $response = $this->http_client->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'apikey' => $this->apiKey,
                'Authorization' => 'Bearer '.$this->token
            ],

            'json' => $json
        ]);

        return $response->getBody()->getContents();
    }

    public function checkStatus($paymentId){
        $url = $this->baseUrl . '/' . $this->apiVersion . '/' . 'payments/' . $paymentId;

        $response = $this->http_client->request('GET', $url, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'apikey' => $this->apiKey,
                'Authorization' => 'Bearer '.$this->token
            ]
        ]);

        return $response->getBody()->getContents();
    }

}
