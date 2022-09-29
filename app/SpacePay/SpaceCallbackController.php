<?php

namespace App\SpacePay;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SpaceCallbackController extends Controller
{
    //

    public function status(Request $request){


        Storage::put('request.txt',print_r($request->all(),true));
        return response()->json(['Status' => 0, 'Description' => 'test']);
    }

    public function refund(Request $request){
        return response('',200);
    }
}
