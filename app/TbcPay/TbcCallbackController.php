<?php

namespace App\TbcPay;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Http\Controllers\Controller;

class TbcCallbackController extends Controller
{
    //

    public function status(Request $request){

        //dd($request->all());

        $paymentId = $request->input('PaymentId');

        $tbcPayment = new TbcPayment('cVcrsvTG7A3MWSslK62G9jlGqKxEAyCI','324234','2345354');

        $resp = $tbcPayment->checkStatus($paymentId);

        dd($resp);

        switch ($request->status){
            case 'success':
                Order::where('id','=',$request->shop_order_id)->update(['status' => 'success']);
                break;
            case 'error':
                Order::where('id','=',$request->shop_order_id)->update(['status' => 'error']);
                break;
            case 'in_progress':
                Order::where('id','=',$request->shop_order_id)->update(['status' => 'in_progress']);
                break;
        }
        return response('',200);
    }

    public function refund(Request $request){
        return response('',200);
    }
}
