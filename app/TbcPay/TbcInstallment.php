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

        //echo json_encode($json);
        //exit();
        //dd(json_encode($json));
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

    public function confirmApplication($sessionId, $merchantKey){
        $url = $this->baseUrl . '/' . $this->apiVersion . '/' . 'online-installments/applications/'. $sessionId .'/confirm';

        $json = [
            'merchantKey' => $merchantKey
        ];
        $response = $this->http_client->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Bearer '.$this->token
            ],
            'json' => $json
        ]);

        return $response->getBody()->getContents();
    }

    public function cancelApplication($sessionId, $merchantKey){
        $url = $this->baseUrl . '/' . $this->apiVersion . '/' . 'online-installments/applications/'. $sessionId .'/cancel';

        $json = [
            'merchantKey' => $merchantKey
        ];
        $response = $this->http_client->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Bearer '.$this->token
            ],
            'json' => $json
        ]);

        return $response->getBody()->getContents();
    }

    public function getApplicationStatus($sessionId, $merchantKey){
        $url = $this->baseUrl . '/' . $this->apiVersion . '/' . 'online-installments/applications/'. $sessionId .'/status';

        $json = [
            'merchantKey' => $merchantKey
        ];
        $response = $this->http_client->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Bearer '.$this->token
            ],
            'json' => $json
        ]);

        return $response->getBody()->getContents();
    }

    public function merchantApplicationStatuses($merchantKey,$take = 10){
        $url = $this->baseUrl . '/' . $this->apiVersion . '/' . 'online-installments/merchant/applications/status-changes';

        $json = [
            'merchantKey' => $merchantKey,
            'take' => $take
        ];
        $response = $this->http_client->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Bearer '.$this->token
            ],
            'json' => $json
        ]);

        return $response->getBody()->getContents();
    }

    public function merchantApplicationStatusSync($merchantKey,$synchronizationRequestId){
        $url = $this->baseUrl . '/' . $this->apiVersion . '/' . 'online-installments/merchant/applications/status-changes-sync';

        $json = [
            'merchantKey' => $merchantKey,
            'synchronizationRequestId' => $synchronizationRequestId
        ];
        $response = $this->http_client->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Bearer '.$this->token
            ],
            'json' => $json
        ]);

        return $response->getBody()->getContents();
    }

}
