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

        $resp = \json_decode($resp,true);
        file_put_contents('tbc.txt',print_r($resp,true));

        switch ($resp['Succeeded']){
            case 'success':
                Order::where('tbc_pay_id','=',$resp['payId'])->update(['status' => 'success']);
                break;
            case 'Failed':
                Order::where('tbc_pay_id','=',$resp['payId'])->update(['status' => 'error']);
                break;
            case 'Processing':
                Order::where('tbc_pay_id','=',$resp['payId'])->update(['status' => 'in_progress']);
                break;
            default:

        }
        return response('',200);
    }

    public function refund(Request $request){
        return response('',200);
    }
}
