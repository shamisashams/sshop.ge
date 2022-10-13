<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Product;
use App\Models\ProductSet;
use App\Models\Slider;
use Illuminate\Support\Facades\App;
use Inertia\Inertia;
use App\Repositories\Eloquent\ProductRepository;


class HomeController extends Controller
{
    public function index()
    {


        $page = Page::where('key', 'home')->firstOrFail();

        $images = [];
        foreach ($page->sections as $sections){
            if($sections->file){
                $images[] = asset($sections->file->getFileUrlAttribute());
            } else {
                $images[] = null;
            }

        }

        $sliders = Slider::query()->where("status", 1)->with(['file', 'translations'])->get();
//        dd($page->file);
//        dd(App::getLocale());
        $_products = app(ProductRepository::class)->getHomePageProducts();

        $products = [];
        $products['new'] = [];
        $products['bunker'] = [];
        $products['day_product'] = [];
        $products['day_price'] = [];
        $products['special_price_tag'] = [];
        $products['popular'] = [];
        $products['rand_products'] = [];
        foreach ($_products as $product){
            $product_attributes = $product->attribute_values;

            $_result = [];

            foreach ($product_attributes as $item){
                $options = $item->attribute->options;
                $value = '';
                foreach ($options as $option){
                    if($item->attribute->type == 'select'){
                        if($item->integer_value == $option->id) {
                            $_result[$item->attribute->code] = $option->label;
                        }

                    }
                }

            }
            $product['attributes'] = $_result;

            if($product->new) $products['new'][] = $product;
            if($product->bunker) $products['bunker'][] = $product;
            if($product->day_product) $products['day_product'][] = $product;
            if($product->day_price) $products['day_price'][] = $product;
            if($product->special_price_tag) $products['special_price_tag'][] = $product;
            if($product->popular) $products['popular'][] = $product;
        }

        $rand_products =  Product::with(['latestImage','variants','attribute_values.attribute.options.translation'])->whereHas('categories',function ($query){
            $query->where('status',1);
        })->inRandomOrder()->limit(18)->get();

        foreach ($rand_products as $product){
            $product_attributes = $product->attribute_values;

            $_result = [];

            foreach ($product_attributes as $item){
                $options = $item->attribute->options;
                $value = '';
                foreach ($options as $option){
                    if($item->attribute->type == 'select'){
                        if($item->integer_value == $option->id) {
                            $_result[$item->attribute->code] = $option->label;
                        }

                    }
                }

            }
            $product['attributes'] = $_result;
        }

        $products['rand_products'] = $rand_products;
        //dd($products);

        return Inertia::render('Home', ["sliders" => $sliders,
            "partners" => Partner::query()->orderBy('company_name')->get(),
            "page" => $page, "seo" => [
            "title"=>$page->meta_title,
            "description"=>$page->meta_description,
            "keywords"=>$page->meta_keyword,
            "og_title"=>$page->meta_og_title,
            "og_description"=>$page->meta_og_description,

//            "image" => "imgg",
//            "locale" => App::getLocale()
        ],
            'products' => $products,
            'images' => $images,
            'collections' => ProductSet::with(['translation','latestImage'])->where('status',1)->get(),
            'collection' => ProductSet::with(['translation','latestImage','products','products.stocks'])->where('status',1)->inRandomOrder()->first(),
            'blogs' => News::with(['translation','latestImage'])->limit(4)->inRandomOrder()->get()
        ])->withViewData([
            'meta_title' => $page->meta_title,
            'meta_description' => $page->meta_description,
            'meta_keyword' => $page->meta_keyword,
            "image" => $page->file,
            'og_title' => $page->meta_og_title,
            'og_description' => $page->meta_og_description
        ]);

    }


}