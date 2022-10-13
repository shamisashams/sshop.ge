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

    private $client_id = '16021';

    private $secret_key = '09ae1c2addd6a52df6a5c0c28b1cccba';



    public function __construct(){
        $this->bog_pay = new BogInstallment($this->client_id, $this->secret_key);



        //dd($this->rate);
    }


    public function make_order($order_id,$products,$request){

        //dd($request->json()->all());
        $locale = 'ka';
        if(app()->getLocale() !== 'ge') $locale = 'en';

        $response = $this->bog_pay->makeOrder(
            $order_id,
            $request->json()->all(),
            $products,
            route('order.success'),
            route('order.failure'),
            route('order.failure'),
        );
        $data = $response;

        //dd($data);

        $data = json_decode($data,true);

        //dd($data);
        //Order::where('id', '=', $order_id)->update(['transaction_id' => $data['order_id'],'payment_hash'=> $data['payment_hash']]);
        //dd($data);
        return Inertia::location($data['links'][1]['href']);
    }

    public function test(Request $request){
        dd($request->json()->all());
    }


}
