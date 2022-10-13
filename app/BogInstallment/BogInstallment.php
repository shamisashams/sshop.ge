<?php

namespace App\BogInstallment;

use GuzzleHttp\Client;

class BogInstallment
{

    private $api_url = 'https://installment.bog.ge/v1/';



    private $token;

    private $client_id;

    private $secret_key;

    private $http_client;

    /**
     * @param $client_id
     * @param $secret_key
     * @throws \GuzzleHttp\Exception\GuzzleException
     */

    public function __construct($client_id,$secret_key){
        $this->client_id = $client_id;
        $this->secret_key = $secret_key;
        $this->http_client = new Client();

        $this->token = $this->get_token();
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */

    private function get_token(){

        //dd(base64_encode($this->client_id . ':' . $this->secret_key));
        $response = $this->http_client->request('POST', $this->api_url . '/oauth2/token', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Basic '.base64_encode($this->client_id . ':' . $this->secret_key)
            ],

            'form_params' => [
                'grant_type' => 'client_credentials'
            ]
        ]);

        $body = $response->getBody()->getContents();

        $body = json_decode($body,true);

        return $body['access_token'];

    }

    public function makeOrder($shop_order_id,$selectedType,$cart_items,$success_redirect_url = '',$fail_redirect_url = '',$reject_redirect_url = ''){
        $json = [];



        $json['intent'] = 'LOAN';
        $json['installment_month'] = $selectedType['month'];
        $json['installment_type'] = $selectedType['discount_code'];
        $json['shop_order_id'] = $shop_order_id;
        $json['success_redirect_url'] = $success_redirect_url;
        $json['fail_redirect_url'] = $fail_redirect_url;
        $json['reject_redirect_url'] = $reject_redirect_url;
        $json['validate_items'] = false;
        $json['locale'] = 'ka';
        $json['purchase_units'] = [
            ['amount' => [
                'currency_code' => 'GEL',
                'value' => $selectedType['amount']
            ]]
        ];

        $products = [];

        foreach ($cart_items as $item){
            $cartItem = [
              'total_item_amount' => $item['total_item_amount'],
                'item_description' => $item['item_description'],
                'total_item_qty' => $item['total_item_qty'],
                'item_vendor_code' => $item['item_vendor_code'],
                'product_image_url' => $item['product_image_url'],
                'item_site_detail_url' => $item['item_site_detail_url']
            ];
            $products[] = $cartItem;
        }

        $json['cart_items'] = $products;


        $response = $this->http_client->request('POST', $this->api_url . '/installment/checkout', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$this->token
            ],

            'json' => $json
        ]);

        return $response->getBody()->getContents();
    }
}
