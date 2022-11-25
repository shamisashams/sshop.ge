<?php

namespace App\TbcPay;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class TbcInstallment
{

    //{base-url}/{api-version}/{product}/{sub-product}

    private $baseUrl = 'https://test-api.tbcbank.ge';

    private $apiVersion = 'v1';


    private $client_id;

    private $client_secret;

    private $http_client;

    private $token;


    public function __construct($client_id, $client_secret)
    {

        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->http_client = new Client();
        $this->token = $this->getAccessToken();
    }

    private function getAccessToken(){
        $url = $this->baseUrl . '/' . 'oauth/token';

        $response = $this->http_client->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Basic '.base64_encode($this->client_id . ':' . $this->client_secret)
            ],

            'form_params' => [
                'grant_type' => 'client_credentials',
                'scope' => 'online_installments'
            ]
        ]);

        $body = $response->getBody()->getContents();

        $body = json_decode($body,true);

        //dd($body);
        return $body['access_token'];
    }


    public function initiateInstallment($merchantKey,$campaignId,$priceTotal,$installmentProducts = [],$invoiceId = ''){
        $url = $this->baseUrl . '/' . $this->apiVersion . '/' . 'online-installments/applications';

        $json = [
            'merchantKey ' => $merchantKey,
            'campaignId' => $campaignId,
            'invoiceId' => $invoiceId,
            'priceTotal' => $priceTotal,
            'products' => $installmentProducts,
        ];

        //dd($json);
        try {
            $response = $this->http_client->request('POST', $url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$this->token
                ],

                'json' => $json
            ]);

            dd($response);

            return $response->getBody()->getContents();
        } catch (ClientException $exception){
            dd($exception->getResponse()->getBody()->getContents());
        }


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
