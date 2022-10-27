<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Repositories\Eloquent\ProductRepository;
use Spatie\TranslationLoader\TranslationLoaders\Db;

class ProductController extends Controller
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
        return Inertia::render('Products/Products',[
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

        $product = Product::query()->where(['status' => true, 'slug' => $slug])->whereHas('categories', function (Builder $query) {
            $query->where('status', 1);

        })->with(['translation','latestImage','video','attribute_values.attribute.translation','attribute_values.attribute.options.translation'])->firstOrFail();

        $productImages = $product->files()->orderBy('id','desc')->get();

        $gpouped = $product->grouped()->with(['attribute_values.attribute.translation','attribute_values.attribute.options'])->get();

        $arr = [];
        $d =[];
        foreach ($gpouped as $v_product){
            foreach ($v_product->attribute_values as $attr_value){
                foreach ($attr_value->attribute->options as $option){
                    if($attr_value->integer_value == $option->id) {
                        if($attr_value->attribute->code == 'color'){
                            $arr[$attr_value->attribute->code]['attribute'] = $attr_value->attribute->name;
                            $arr[$attr_value->attribute->code]['option'] = $option->color;
                        }
                    }
                }

            }

            $d[$v_product->slug] = $arr;
        }
        //dd($d);

        $product_attributes = $product->attribute_values;

        $result = [];

        foreach ($product_attributes as $item){
            $options = $item->attribute->options;
            $value = '';
            foreach ($options as $option){
                if($item->attribute->type == 'select'){
                    if($item->integer_value == $option->id) {
                        if($item->attribute->code == 'size'){
                            $result[$item->attribute->code]['attribute'] = $item->attribute->name;
                            $result[$item->attribute->code]['option'] = $option->value;
                        }
                        else {
                            $result[$item->attribute->code]['option'] = $option->label;
                            $result[$item->attribute->code]['attribute'] = $item->attribute->name;
                        }
                    }

                }
            }

        }

        $product['attributes'] = $result;

        $stocks = [];

        $config = [];
        $prices = [];
        $v_c = 0;
        foreach ($product->variants()->with(['video','attribute_values.attribute.options','latestImage','files','stocks','stocks.translation'])->get() as $variant){
            $product_attributes = $variant->attribute_values;

            $result = [];

            foreach ($product_attributes as $item){
                $options = $item->attribute->options;
                $value = '';
                foreach ($options as $option){
                    if($item->attribute->type == 'select'){
                        if($item->integer_value == $option->id) {
                            $result[$item->attribute->code]['label'] = $option->label;
                            $result[$item->attribute->code]['id'] = $option->id;
                            $result[$item->attribute->code]['code'] = $option->code;
                            $result[$item->attribute->code]['color'] = $option->color;
                            $result[$item->attribute->code]['value'] = $option->value;
                        }

                    }
                }

            }

            //dd($result);
            foreach ($result as $key => $item){
                $config[$key][$item['id']]['label'] = $item['label'];
                $config[$key][$item['id']]['code'] = $item['code'];
                $config[$key][$item['id']]['color'] = $item['color'];
                $config[$key][$item['id']]['value'] = $item['value'];
                $config[$key][$item['id']]['variants'][] = $variant->id;
            }
            $config['variants'][$variant->id]['prices'] = $variant->price;
            $config['variants'][$variant->id]['images'] = $variant->files;
            $config['variants'][$variant->id]['variant'] = $variant;
            $config['variant_count'] = ++$v_c;
            $config['last_variant'] =  $variant;
            $config['last_variant']['attributes'] =  $result;
            $prices[] = $variant->special_price ? $variant->special_price : $variant->price;



            if(count($variant->stocks)){
                foreach ($variant->stocks as $stock){
                    $stocks[$stock->city_id][$stock->id] = $stock;
                    $config['variants'][$variant->id]['stocks'][$stock->city_id][$stock->id] = $stock;
                }

            }



        }



        //dd($config);

        $product['min_price']= !empty($prices) ? min($prices) : 0;
        //dd($config);

        //dd($prices);
        //dd($product);


        //dd(last($product->categories));
        $categories = $product->categories()->with(['ancestors'])->get();


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
            ->where('parent_id',null)
            ->leftJoin('product_categories', 'product_categories.product_id', '=', 'products.id')
            ->inRandomOrder()
            ->groupBy('products.id')
            ->with(['latestImage','translation','attribute_values.attribute.translation','attribute_values.attribute.options.translation'])->limit(20)->get();

        foreach ($similar_products as $_product){
            $product_attributes = $_product->attribute_values;

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
            $_product['attributes'] = $_result;
            $prices = [];

            foreach ($_product->variants as $variant){
                $prices[] = $variant->special_price ? $variant->special_price : $variant->price;
            }

            $_product['min_price'] = !empty($prices) ? min($prices) : 0;


        }




        //dd($product);
        //dd($category);
        //$result = [];
        //$result['id'] = $category[0]['id'];
        //$result['title'] = $category[0]['title'];
        //dd(\Illuminate\Support\Facades\DB::getQueryLog());

        /*return view('client.pages.product.show', [
            'product' => $product
        ]);*/
        return Inertia::render('SingleProduct',[
            'category_last' => end($path),
            'variants' => $d,
            'product' => $product,
            'category_path' => $path,
            'similar_products' => $similar_products,
            'product_images' => $productImages,
            'product_attributes' => $result,
            'product_config' => $config,
            'stocks' => $stocks,
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

}
