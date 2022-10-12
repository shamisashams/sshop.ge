<?php

namespace App\BogInstallment;


use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Inertia\Inertia;



class BogInstallmentController extends Controller
{
    //
    private $bog_pay;

    private $client_id = '28642';

    private $secret_key = '5e6daf50f65a575e873c6abf085c23f1';



    public function __construct(){
        $this->bog_pay = new BogInstallment($this->client_id, $this->secret_key);



        //dd($this->rate);
    }


    public function make_order(Request $request){

        //dd($request->json()->all());
        $order_id = 1;
        $locale = 'ka';
        if(app()->getLocale() !== 'ge') $locale = 'en';

        $response = $this->bog_pay->makeOrder(
            $order_id,
            $request->json()->all(),
            []
        );
        $data = $response;

        //dd($data);

        $data = json_decode($data,true);

        //Order::where('id', '=', $order_id)->update(['transaction_id' => $data['order_id'],'payment_hash'=> $data['payment_hash']]);
        //dd($data);
        return Inertia::location($data['links'][1]['href']);
    }

    public function test(Request $request){
        dd($request->json()->all());
    }


}
