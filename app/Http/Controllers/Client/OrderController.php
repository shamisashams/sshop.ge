<?php

namespace App\Http\Controllers\Client;

use App\BogInstallment\BogInstallmentController;
use App\BogPay\BogPay;
use App\BogPay\BogPaymentController;
use App\Cart\Facade\Cart;
use App\Http\Controllers\Controller;
use App\Mail\PromocodeProduct;
use App\Models\Category;
use App\Models\City;
use App\Models\MailTemplate;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductSet;
use App\Models\Setting;
use App\Promocode\Promocode;
use App\SpacePay\SpacePay;
use App\TbcPay\TbcInstallment;
use App\TbcPay\TbcPayment;
use App\TerraPay\TerraPay;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use App\Repositories\Eloquent\ProductRepository;
use Spatie\TranslationLoader\TranslationLoaders\Db;
use Illuminate\Support\Facades\DB as DataBase;
use function Symfony\Component\String\s;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{

    protected $productRepository;



    public function __construct(ProductRepository $productRepository){
        $this->productRepository = $productRepository;
    }

    /**
     * @param string $locale
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(string $locale, Request $request)
    {
        $page = Page::where('key', 'products')->firstOrFail();
        $products = Product::with(['files'])->whereHas('categories',function (Builder $query){
            $query->where('status', 1);
        })->paginate(16);

        $images = [];
        foreach ($page->sections as $sections){
            if($sections->file){
                $images[] = asset($sections->file->getFileUrlAttribute());
            } else {
                $images[] = null;
            }

        }

        //dd($products);
        return Inertia::render('OrderForm/OrderForm',[
            'products' => $products,
            'images' => $images,
            'page' => $page,
            "seo" => [
                "title"=>$page->meta_title,
                "description"=>$page->meta_description,
                "keywords"=>$page->meta_keyword,
                "og_title"=>$page->meta_og_title,
                "og_description"=>$page->meta_og_description,
//            "image" => "imgg",
//            "locale" => App::getLocale()
            ]
        ])->withViewData([
            'meta_title' => $page->meta_title,
            'meta_description' => $page->meta_description,
            'meta_keyword' => $page->meta_keyword,
            "image" => $page->file,
            'og_title' => $page->meta_og_title,
            'og_description' => $page->meta_og_description
        ]);
    }


    /**
     * @param string $locale
     * @param string $slug
     * @return Application|Factory|View
     */
    public function show(string $locale, string $slug)
    {
        //\Illuminate\Support\Facades\DB::enableQueryLog();

        $product = Product::where(['status' => true, 'slug' => $slug])->whereHas('categories', function (Builder $query) {
            $query->where('status', 1);

        })->with(['latestImage'])->firstOrFail();

        $productImages = $product->files()->orderBy('id','desc')->get();

        $product_attributes = $product->attribute_values;

        $result = [];

        foreach ($product_attributes as $item){
            $options = $item->attribute->options;
            $value = '';
            foreach ($options as $option){
                if($item->attribute->type == 'select'){
                    if($item->integer_value == $option->id) {
                        $result[$item->attribute->code] = $option->label;
                    }

                }
            }

        }


        //dd(last($product->categories));
        $categories = $product->categories;


        $path = [];
        $arr = [];
        foreach ($categories as $key =>$item){


            $ancestors = $item->ancestors;
            if(count($ancestors)){
                foreach ($ancestors as $ancestor){
                    $arr[count($ancestors)]['ancestors'][] = $ancestor;
                    $arr[count($ancestors)]['current'] = $item;
                }
            } else {
                $arr[0]['ancestors'] = [];
                $arr[0]['current'] = $item;
            }



            /*if($item->isLeaf()){

                $ancestors = $item->ancestors;

                $k = 0;
                foreach ($ancestors as $ancestor){
                    $path[$k]['id'] = $ancestor->id;
                    $path[$k]['slug'] = $ancestor->slug;
                    $path[$k]['title'] = $ancestor->title;
                    $k++;
                }

                $path[$k]['id'] = $item->id;
                $path[$k]['slug'] = $item->slug;
                $path[$k]['title'] = $item->title;
                break;
            } else {

            }*/

        }

        $max = max(array_keys($arr));

        $k = 0;
        foreach ($arr[$max]['ancestors'] as $ancestor){
            $path[$k]['id'] = $ancestor->id;
            $path[$k]['slug'] = $ancestor->slug;
            $path[$k]['title'] = $ancestor->title;
            $k++;
        }

        $path[$k]['id'] = $arr[$max]['current']->id;
        $path[$k]['slug'] = $arr[$max]['current']->slug;
        $path[$k]['title'] = $arr[$max]['current']->title;
        //dd($path);


        $similar_products = Product::where(['status' => 1, 'product_categories.category_id' => $path[0]['id']])
            ->where('products.id','!=',$product->id)
            ->leftJoin('product_categories', 'product_categories.product_id', '=', 'products.id')
            ->inRandomOrder()
            ->with('latestImage')->get();
        //dd($category);
        //$result = [];
        //$result['id'] = $category[0]['id'];
        //$result['title'] = $category[0]['title'];
        //dd(\Illuminate\Support\Facades\DB::getQueryLog());

        /*return view('client.pages.product.show', [
            'product' => $product
        ]);*/
        return Inertia::render('ProductDetails/ProductDetails',[
            'product' => $product,
            'category_path' => $path,
            'similar_products' => $similar_products,
            'product_images' => $productImages,
            'product_attributes' => $result,
            "seo" => [
                "title"=>$product->meta_title,
                "description"=>$product->meta_description,
                "keywords"=>$product->meta_keyword,
                "og_title"=>$product->meta_og_title,
                "og_description"=>$product->meta_og_description,
//            "image" => "imgg",
//            "locale" => App::getLocale()
            ]
        ])->withViewData([
            'meta_title' => $product->meta_title,
            'meta_description' => $product->meta_description,
            'meta_keyword' => $product->meta_keyword,
            "image" => $product->file,
            'og_title' => $product->meta_og_title,
            'og_description' => $product->meta_og_description
        ]);
    }

    public function order(Request $request,$locale){
        //dd($request->all());
        /*$request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'city' => 'required',
            'address' => 'required',
            'payment_method' => 'required',
            'payment_type' => 'required_if:payment_method,1'
        ]);*/

        if (!session('shipping')){
            return redirect()->back();
        }


        $data = $request->all();
        //if ($bogInstallment) $data['payment_type'] = 'bog_installment';
        $cart = Arr::pull($data,'cart');
        $cart = Cart::getCart();
        $data['locale'] = app()->getLocale();
        $data['grand_total'] = $cart['total'];

        $user = auth()->user();

        $data['first_name'] = $user->name;
        $data['last_name'] = $user->surname;
        $data['email'] = $user->email;
        $data['city'] = City::query()->where('id',session('shipping.city_id'))->first()->title;
        $data['address'] = session('shipping.address');
        $data['info'] = session('shipping.comment');
        $data['payment_method'] = 1;
        $data['user_id'] = $user->id;
        $data['ship_price'] = session('shipping.ship_price');

        $data['phone'] = session('shipping.phone');


        $grand_t = $data['grand_total'];

        //dd($data);

        $delete_promocode = false;
        $product_promocode = false;
        if($promocode = session('promocode')){


            if($promocode->type == 'product'){
                $promocode_products = $promocode->products()->select('id')->get()->pluck('id')->toArray();
                foreach ($cart['products'] as $item){

                    if(in_array($item['product']->parent->id,$promocode_products)){
                        $item['product']['discount'] = $item['product']->parent->promocode->reward;
                        $delete_promocode = true;
                        $product_promocode = true;
                    }
                }
            }

            if($promocode->type == 'cart'){
                $data['discount'] = $promocode->reward;
                $delete_promocode = true;
            }

        }




        //dd($cart);


        if($cart['count'] > 0){


            try {
                DataBase::beginTransaction();
                $order = Order::create($data);

                $data = [];
                $insert = [];
                $product_images = [];
                $product_models = [];
                foreach ($cart['products'] as $item){

                    $data['order_id'] = $order->id;
                    $data['product_id'] = $item['product']['id'];
                    $data['name'] = $item['product']['title'];
                    $data['qty_ordered'] = $item['quantity'];
                    $data['price'] = $item['product']->special_price ? $item['product']->special_price : $item['product']['price'] ;
                    $data['total'] = $data['price'] * $item['quantity'];
                    $data['attributes'] = json_encode($item['product']['attributes']);
                    if ($item['product']->discount){
                        $data['promocode_discount'] = $item['product']->discount;
                    }
                    $insert[] = $data;
                    $product_images[$item['product']->id] = $item['product']->latestImage ? $item['product']->latestImage->file_full_url : '';
                    $product_models[$item['product']->id] = $item['product']->model;
                }
                //dd($insert);
                OrderItem::insert($insert);

                $total = 0;
                foreach ($cart['collections'] as $item){
                    $collection = $order->collections()->create([
                        'product_set_id' => $item['collection']->id,
                        'title' => $item['collection']->title,
                        'total_price' => $item['collection']->special_price ? $item['collection']->special_price : $item['collection']->price
                    ]);
                    foreach ($item['collection']->products as $_item){

                        $product_attributes = $_item->attribute_values;

                        $result = [];

                        foreach ($product_attributes as $_item_){
                            $options = $_item_->attribute->options;
                            $value = '';
                            foreach ($options as $option){
                                if($_item_->attribute->type == 'select'){
                                    if($_item_->integer_value == $option->id) {
                                        if($_item_->attribute->code == 'size'){
                                            $result[$_item_->attribute->code] = $option->value;
                                        }
                                        elseif ($_item_->attribute->code == 'color'){
                                            $result[$_item_->attribute->code] = $option->color;
                                        }
                                        else {
                                            $result[$_item_->attribute->code] = $option->label;
                                        }
                                    }

                                }
                            }

                        }


                        $collection->items()->create([
                            'product_id' => $_item->id,
                            'title' => $_item->title,
                            'price' => $_item->price,
                            'attributes' => json_encode($result)
                        ]);
                    }

                }









                DataBase::commit();

                /*$pdf = Pdf::loadView('client.order.order',compact('order'),[],'UTF-8');

                $pdf->save('order_'. $order->id .'.pdf');

                Mail::to($request->user())->send(new \App\Mail\Order($order));
                unlink('order_'. $order->id .'.pdf');

                foreach ($order->items as $item){

                    $file = 'warranty_'. $item->id .'.pdf';

                    unlink($file);
                }*/

                $_promocode = \App\Models\PromoCode::query()->where('type','cart')->first();
                //dd($promocode);
                if ($_promocode){
                    if($_promocode->status){
                        $promo_gen = new Promocode();
                        $gen = $promo_gen->generateCode();

                        $request->user()->promocode()->create(['promocode_id' => $_promocode->id, 'promocode' => $gen]);
                        $data['product'] = null;
                        $data['text'] = 'cart promocode';
                        $data['code'] = $gen;
                        //Mail::to($request->user())->send(new PromocodeProduct($data));
                    }

                }

                $partner_reward = Setting::query()->where('key','partner_reward')->first();

                if($user->referrer && $partner_reward->integer_value){
                    $user->referrer()->update(['balance' => \Illuminate\Support\Facades\DB::raw('balance + '. ($grand_t * $partner_reward->integer_value) / 100)]);
                }

                //Cart::destroy();
                if(($promo_code = session('promocode')) && $delete_promocode){
                    //dd($promo_code->userPromocode->promocode, $request->user()->promocode()->where('promocode',$promo_code->userPromocode->promocode)->first());
                    $request->user()->promocode()->where('promocode',$promo_code->userPromocode->promocode)->delete();
                }

                session()->forget('promocode');

                if($order->payment_method == 1 && $order->payment_type == 'bog'){
                    return app(BogPaymentController::class)->make_order($order->id,$order->grand_total);
                } elseif($order->payment_method == 1 && $order->payment_type == 'tbc'){
                    $tbcPay = new TbcPayment('cVcrsvTG7A3MWSslK62G9jlGqKxEAyCI','7000998','SVcfMh6VPFIJV47l');
                    $returnUrl = 'https://sshop.ge/' . app()->getLocale() . '/payments/tbc/status?order_id='.$order->id;

                    $installmentProducts = [];
                    foreach ($order->items as $key => $item){
                        $installmentProducts[] = [
                            'Name' => $item->name,
                            'Price' => $item->price,
                            'Quantity' => $item->qty_ordered
                        ];
                    }

                    $resp = $tbcPay->createPayment($order->grand_total,$returnUrl,$order->id,$installmentProducts,route('tbcCallbackStatus'));
                    $resp = \json_decode($resp,true);
                    if(isset($resp['status'])){
                        if ($resp['status'] == 'Created'){
                            $order->update(['tbc_pay_id' => $resp['payId']]);
                            return Inertia::location($resp['links'][1]['uri']);
                        }
                    }

                    //return redirect(locale_route('order.failure',$order->id));
                }
                elseif($order->payment_method == 1 && $order->payment_type == 'terra'){

                    $terra = new TerraPay('0J04');

                    $terra_products = [];

                    //dd($order->items);
                    foreach ($order->items as $key => $item){
                        $terra_products[$key]['name'] = $item->name;
                        $terra_products[$key]['code'] = '';
                        $terra_products[$key]['quantity'] = $item->qty_ordered;
                        $terra_products[$key]['amount'] = $item->qty_ordered * $item->price;
                        $terra_products[$key]['cashAmount'] = $item->qty_ordered * $item->price;
                    }
                    //dd($terra_products);

                    $data = $terra->makeOrder($order->id,$terra_products);



                    $data = json_decode($data,true);
                    if($data['success']){
                        //dd($data);
                        return Inertia::location($terra->redirectUrl($data['storeSessionId']));
                    }
                }
                elseif($order->payment_method == 1 && $order->payment_type == 'bog_installment'){

                    $bog_products = [];

                    //dd($order->items);
                    foreach ($order->items as $key => $item){
                        $bog_products[$key]['item_description'] = $item->name;
                        $bog_products[$key]['item_vendor_code'] = $product_models[$item->product_id];
                        $bog_products[$key]['total_item_qty'] = $item->qty_ordered;
                        $bog_products[$key]['total_item_amount'] = $item->qty_ordered * $item->price;
                        $bog_products[$key]['product_image_url'] = $product_images[$item->product_id];
                        $bog_products[$key]['item_site_detail_url'] = route('client.product.show',$item->product_id);
                    }
                    //dd($order->payment_type);


                    return app(BogInstallmentController::class)->make_order($order->id,$bog_products,$request);

                }
                elseif($order->payment_method == 1 && $order->payment_type == 'tbc_installment'){
                    $tbcPay = new TbcInstallment('VzlcvfDPoQhAMAMsLmkGKfyfcEXO4LcG','o3F9HKvmDlk4X7pt');
                    $returnUrl = 'https://sshop.ge/' . app()->getLocale() . '/payments/tbc/status?order_id='.$order->id;

                    $installmentProducts = [];
                    foreach ($order->items as $key => $item){
                        $installmentProducts[] = [
                            'Name' => $item->name,
                            'Price' => $item->price,
                            'Quantity' => $item->qty_ordered
                        ];
                    }

                    $resp = $tbcPay->initiateInstallment('000000000-ce21da5e-da92-48f3-8009-4d438cbcc137',204,$order->grand_total,$installmentProducts,$order->id);
                    $resp = \json_decode($resp,true);
                    if(isset($resp['status'])){
                        if ($resp['status'] == 'Created'){
                            $order->update(['tbc_pay_id' => $resp['payId']]);
                            return Inertia::location($resp['links'][1]['uri']);
                        }
                    }
                }
                 else {
                    return redirect(locale_route('order.success',$order->id));
                }

            } catch (QueryException $exception){
                dd($exception->getMessage());
                DataBase::rollBack();
            }


        }


        return redirect()->route('client.home.index');
    }

    public function bogResponse(Request $request){
        //dump($request->order_id);
        $order = Order::query()->where('id',$request->get('order_id'))->first();

        //dd($order);
        if($order->status == 'success') return redirect(locale_route('order.success',$order->id));
        else if($order->status == 'error') return redirect(route('order.failure'));
        else {
            sleep(3);
            return redirect('https://sshop.ge/' . app()->getLocale() . '/payments/bog/status?order_id='.$order->id);
        }
    }

    public function tbcResponse(Request $request){
        //dump($request->order_id);
        $order = Order::query()->where('id',$request->get('order_id'))->first();

        //dd($order);
        if($order->status == 'success') return redirect(locale_route('order.success',$order->id));
        else if($order->status == 'error') return redirect(route('order.failure'));
        else {
            sleep(3);
            return redirect('https://sshop.ge/' . app()->getLocale() . '/payments/tbc/status?order_id='.$order->id);
        }
    }

    public function statusSuccess($order_id){
        $order = Order::query()->where('id',$order_id)->with('items')->first();
        return Inertia::render('PaymentSuccess',['order' => $order])->withViewData([
            'meta_title' => 'success',
            'meta_description' => 'success',
            'meta_keyword' => 'success',
            "image" => '',
            'og_title' => 'success',
            'og_description' => 'success',
        ]);
    }

    public function statusFail($order_id){
        return Inertia::render('PaymentFail',[])->withViewData([
            'meta_title' => 'success',
            'meta_description' => 'success',
            'meta_keyword' => 'success',
            "image" => '',
            'og_title' => 'success',
            'og_description' => 'success',
        ]);
    }

}
