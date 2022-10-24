<?php

namespace App\Cart;

use App\Models\ProductSet;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use App\Models\Product;


class Cart
{

    public function __construct()
    {
        //\session()->forget('cart');
    }

    public function mergeCart($user){

        $db_cart = $user->cart()->firstOrCreate([
            'user_id' => $user->id
        ]);


        $cart =  $this->getCart();



        //dd($cart);
        if($cart){
            $db_cart->items()->delete();
            foreach ($cart['products'] as $item){
                $db_cart->items()->updateOrCreate([
                    'product_id' => $item['product']->id,
                ],[
                    'qty' => $item['quantity'],
                ]);
            }
        }


        $arr = [];
        if (auth()->user()){
            $db_cart = auth()->user()->cart()->with('items')->first();

            foreach ($db_cart->items as $item){
                $obj = [
                    'product_id' => $item->product_id,
                    'quantity' => $item->qty,
                    'price' => $item->price
                ];
                $arr[] = (object)$obj;
            }
            //dd($arr);
            //\session(['cart' => $arr]);
        }
    }

    public function add($request){


        $products = session('cart') ?? array();



        $bool = true;


        foreach ($products as $item) {
            if ($item->product_id == $request['id']) {

                    $item->quantity += $request['qty'];
                    $bool = false;
                    break;

            }
        }


            $product = Product::findOrFail($request['id']);


            if ($bool) {
                $products[] = (object)[
                    'product_id' => $product->id,
                    'quantity' => $request['qty'],
                    'price' => $product->price,
                ];
                $request->session()->put('cart', $products);

            }



            if($user = auth()->user()){
                $this->mergeCart($user);
            }


    }

    public function addCollection($request){
        $collections = session('cart_collections') ?? array();
        $bool = true;

        //dd($collections);

        foreach ($collections as $item) {
            if ($item->collection_id == $request['collection']) {

                $item->quantity += 1;
                $bool = false;
                break;

            }
        }

        $collection = ProductSet::findOrFail($request['collection']);
        //dd($collections);
        if ($bool) {

            $products[] = (object)[
                'collection_id' => $collection->id,
                'quantity' => 1,
                'color_id' => $request['color'],
                'price' => $collection->price,
            ];
            $request->session()->put('cart_collections', $products);

        }
    }

    public function remove($request){
        $id = $request['id'];



        $cart = session('cart') ?? array();
        if ($cart !== null) {
            foreach ($cart as $key => $item) {
                if ($item->product_id == $id) {
                    unset($cart[$key]);
                    $cart = array_values($cart);
                }
            }
            if(count($cart)){
                session(['cart' => $cart]);
            } else {
                session()->forget('cart');
            }


        }
        if($user = auth()->user()){
            $this->mergeCart($user);
        }
    }

    public function removeCollection($request){
        $id = $request['id'];


        $cart = session('cart_collections') ?? array();
        if ($cart !== null) {
            foreach ($cart as $key => $item) {
                if ($item->collection_id == $id) {
                    unset($cart[$key]);
                    $cart = array_values($cart);
                }
            }
            if(count($cart)){
                session(['cart_collections' => $cart]);
            } else {
                session()->forget('cart_collections');
            }


        }

    }

    public function update($request){
        //dd($request->all());
        $id = $request['id'];
        $cart = session('cart') ?? array();
        if ($cart !== null) {
            foreach ($cart as $key => $item) {
                if ($item->product_id == $id) {
                    $cart[$key]->quantity = $request['qty'];
                }
            }

            //dd($cart);
            session(['cart' => $cart]);

        }
        if($user = auth()->user()){
            $this->mergeCart($user);
        }
    }

    public function updateCollection($request){
        //dd($request->all());
        $id = $request['id'];
        $cart = session('cart_collections') ?? array();
        if ($cart !== null) {
            foreach ($cart as $key => $item) {
                if ($item->collection_id == $id) {
                    $cart[$key]->quantity = $request['qty'];
                }
            }

            //dd($cart);
            session(['cart_collections' => $cart]);

        }
    }

    public function getCart(){






        $products = array();
        $collections = [];
        $cart = session('cart') ?? array();

        //dd($cart,$arr);
        $total = 0;
        $total_c = 0;

        //dd($cart);
        if ($cart !== null) {
            foreach ($cart as $_item) {
                $product = Product::with(['translation','latestImage','attribute_values.attribute.options.translation','parent.latestImage'])->where(['id' => $_item->product_id])->first();
                $result = [];

                if ($product){
                    $product_attributes = $product->attribute_values;



                    foreach ($product_attributes as $key => $item){
                        $options = $item->attribute->options;
                        $value = '';
                        foreach ($options as $option){
                            if($item->attribute->type == 'select'){
                                if($item->integer_value == $option->id) {
                                    $result[$key]['attribute']['code'] = $item->attribute->code;
                                    $result[$key]['attribute']['name'] = $item->attribute->name;


                                    $result[$key]['option']['value'] = $option->value;


                                    $result[$key]['option']['color'] = $option->color;


                                    $result[$key]['option']['label'] = $option->label;

                                }

                            }
                        }

                    }

                    $product['attributes'] = $result;
                }

                if ($product) {
                    $products[] = [

                        'product' => $product,
                        'quantity' => $_item->quantity,
                    ];
                }
            }

            //dd($cart);
            foreach ($products as $item) {

                    $total += intval($item['quantity']) * floatval($item['product']->special_price ? $item['product']->special_price : $item['product']->price);

            }


        }

        $cart_collection = session('cart_collections') ?? array();
        //dd($cart_collection);
        if($cart_collection !== null){
            foreach ($cart_collection as $item_c){
                $collection = ProductSet::with('translation','latestImage','products','products.latestImage','products.translation')->where('id',$item_c->collection_id)->first();

                if ($collection) {
                    $collection['attributes'] = $collection->colors()->first();
                    $collections[] = [

                        'collection' => $collection,
                        'quantity' => $item_c->quantity,
                    ];
                }
            }
        }
        foreach ($collections as $item) {

            $total_c += intval($item['quantity']) * floatval($item['collection']->special_price ? $item['collection']->special_price : $item['collection']->price);

        }
        return array('count' => count($cart) + count($cart_collection), 'products' => $products, 'collections' => $collections, 'total' => $total + $total_c);
    }

    public function count(){
        $cart = session('cart') ?? array();
        $cart_collections = session('cart_collections') ?? array();
        return count($cart) + count($cart_collections);
    }

    public function destroy(){
        \session()->forget(['cart','cart_collections']);
        if($user = auth()->user()){
            $this->mergeCart($user);
        }
    }

}
