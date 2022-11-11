<?php

namespace App\TbcPay;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class TbcCallbackController extends Controller
{
    //

    public function status(Request $request){

        //dd($request->all());
        Storage::put('request.txt',print_r($request->all(),true));
        $paymentId = $request->input('PaymentId');

        $tbcPayment = new TbcPayment('cVcrsvTG7A3MWSslK62G9jlGqKxEAyCI','7000998','SVcfMh6VPFIJV47l');

        $resp = $tbcPayment->checkStatus($paymentId);

        $resp = \json_decode($resp,true);

        Storage::put('tbc.txt',print_r($resp,true));

        switch ($resp['status']){
            case 'Succeeded':
                Order::where('tbc_pay_id','=',$resp['payId'])->update(['status' => 'success']);
                break;
            case 'Failed':
                Order::where('tbc_pay_id','=',$resp['payId'])->update(['status' => 'error']);
                break;
            case 'Processing':
                Order::where('tbc_pay_id','=',$resp['payId'])->update(['status' => 'in_progress']);
                break;
            default:
                Order::where('tbc_pay_id','=',$resp['payId'])->update(['status' => 'error']);
        }
        return response('',200);
    }

    public function refund(Request $request){
        return response('',200);
    }
}
