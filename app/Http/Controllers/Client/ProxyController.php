<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Repositories\Eloquent\AttributeRepository;
use App\Repositories\Eloquent\ProductRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProxyController extends Controller
{
    private $attributeRepository;
    private $productRepository;

    public function __construct(AttributeRepository $attributeRepository,ProductRepository $productRepository){
        $this->attributeRepository = $attributeRepository;
        $this->productRepository = $productRepository;
    }


    /**
     * @param string $locale
     * @param string $slug
     * @return Application|Factory|View
     */
    public function index($locale,$url_path)
    {


        //dd($url_path);

        $url_path = explode('/',$url_path);
        $slug = end($url_path);

        //dd($slug);
//        return 1;

        if ($category = Category::where(['status' => 1, 'slug' => $slug])->first()){
            $page = Page::where('key', 'products')->firstOrFail();
            //dd($category);
            $products = $this->productRepository->getAll($category->id);

            //dd($products);

            foreach ($products as $product){
                $product_attributes = $product->attribute_values;

                $_result = [];

                foreach ($product_attributes as $item){
                    //$options = $item->attribute->options;
                    $value = '';
                    /*foreach ($options as $option){
                        if($item->attribute->type == 'select'){
                            if($item->integer_value == $option->id) {
                                $_result[$item->attribute->code] = $option->label;
                            }

                        }
                    }*/

                    if($item->attribute->type == 'select'){

                        $_result[$item->attribute->code] = $item->option->label;


                    }
                }

                $product['attributes'] = $_result;


            }


            $images = [];
            foreach ($page->sections as $sections){
                if($sections->file){
                    $images[] = asset($sections->file->getFileUrlAttribute());
                } else {
                    $images[] = null;
                }

            }




            //dd($products);

            //dd($products);
            return Inertia::render('Products',[
                'products' => $products,
                'category' => $category,
                'images' => $images,
                'filter' => $this->getAttributes($category),
                "seo" => [
                    "title"=>$category->title,
                    "description"=>$category->title,
                    "keywords"=>$category->title,
                    "og_title"=>$category->title,
                    "og_description"=>$category->title,
//            "image" => "imgg",
//            "locale" => App::getLocale()
                ]
            ])->withViewData([
                'meta_title' => $category->title,
                'meta_description' => $category->title,
                'meta_keyword' => $category->title,
                "image" => $category->title,
                'og_title' => $category->title,
                'og_description' => $category->title,
            ]);
        }


        if ($product = Product::query()->where(['status' => true, 'slug' => $slug])->whereHas('categories', function (Builder $query) {
            $query->where('status', 1);

        })->with(['translation','latestImage','video','attribute_values.attribute.translation','attribute_values.option.translation'])->first()){


            $productImages = $product->files()->orderBy('id','desc')->get();

            $gpouped = $product->grouped()->with(['attribute_values.attribute.translation','attribute_values.attribute.translation','attribute_values.option.translation'])->get();

            $arr = [];
            $d =[];
            foreach ($gpouped as $v_product){
                foreach ($v_product->attribute_values as $attr_value){
                    /*foreach ($attr_value->attribute->options as $option){
                        if($attr_value->integer_value == $option->id) {
                            if($attr_value->attribute->code == 'color'){
                                $arr[$attr_value->attribute->code]['attribute'] = $attr_value->attribute->name;
                                $arr[$attr_value->attribute->code]['option'] = $option->color;
                            }
                        }
                    }*/

                    if($attr_value->attribute->code == 'color'){
                        $arr[$attr_value->attribute->code]['attribute'] = $attr_value->attribute->name;
                        $arr[$attr_value->attribute->code]['option'] = $attr_value->option->color;
                    }

                }

                $d[$v_product->slug] = $arr;
            }
            //dd($d);

            $product_attributes = $product->attribute_values;

            $result = [];

            foreach ($product_attributes as $item){
                //$options = $item->attribute->options;
                $value = '';
                /*foreach ($options as $option){
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
                }*/
                if($item->attribute->type == 'select'){
                    if($item->attribute->code == 'size'){
                        $result[$item->attribute->code]['attribute'] = $item->attribute->name;
                        $result[$item->attribute->code]['option'] = $item->option->value;
                    }
                    else {
                        $result[$item->attribute->code]['option'] = $item->option->label;
                        $result[$item->attribute->code]['attribute'] = $item->attribute->name;
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
                ->with(['latestImage','translation','attribute_values.attribute.translation','attribute_values.option.translation'])->limit(25)->get();

            foreach ($similar_products as $_product){
                $product_attributes = $_product->attribute_values;

                $_result = [];

                foreach ($product_attributes as $item){
                    //$options = $item->attribute->options;
                    $value = '';
                    /*foreach ($options as $option){
                        if($item->attribute->type == 'select'){
                            if($item->integer_value == $option->id) {
                                $_result[$item->attribute->code] = $option->label;
                            }

                        }
                    }*/
                    if($item->attribute->type == 'select'){

                        $_result[$item->attribute->code] = $item->option->label;


                    }
                }
                $_product['attributes'] = $_result;



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


        abort(404);
    }

    private function getAttributes($category = null):array{
        $result = [];
        if($category !== null){
            $attrs = $category->attributes()->with('options')->orderBy('position')->get();
        } else
        $attrs = $this->attributeRepository->model->with('options')->orderBy('position')->get();
        $result['attributes'] = [];
        $key = 0;

        $attr_id = [];
        foreach ($attrs as $attr){
            $attr_id[$attr->id] = $attr->options->pluck('id')->toArray();
        }
        $opt_id = [];
        foreach ($attr_id as $item){
            foreach ($item as $o){
                $opt_id[] = $o;
            }

        }

        $res_q = ProductAttributeValue::query()->selectRaw('COUNT(product_attribute_values.product_id) as count, integer_value as option_id');


        if($category){
            $res_q->join('product_categories','product_categories.product_id','product_attribute_values.product_id');
            $res_q->where('product_categories.category_id',$category->id);
        }
        $res_q->whereIn('integer_value',$opt_id)->groupBy('integer_value')->get();
        //$res_q->groupBy('product_categories.product_id');

        $res = $res_q->get();

        $data = [];
        foreach ($res as $item){
            $data[$item->option_id] = $item->count;
        }
        //dd($data);
        $result['color']['options'] = [];
        foreach ($attrs as $item){
            /*$result['attributes'][$key]['id'] = $item->id;
            $result['attributes'][$key]['name'] = $item->name;
            $result['attributes'][$key]['code'] = $item->code;
            $result['attributes'][$key]['type'] = $item->type;
            $_options = [];
            $_key = 0;
            foreach ($item->options as $option){
                $_options[$_key]['id'] = $option->id;
                $_options[$_key]['label'] = $option->label;
                $_key++;
            }
            $result['attributes'][$key]['options'] = $_options;*/

            if($item->code !== 'color'){
                $result['attributes'][$key]['id'] = $item->id;
                $result['attributes'][$key]['name'] = $item->name;
                $result['attributes'][$key]['code'] = $item->code;
                $result['attributes'][$key]['type'] = $item->type;
                $_key = 0;
                $_options = [];
                foreach ($item->options as $option){
                    $_options[$_key]['id'] = $option->id;
                    $_options[$_key]['label'] = $option->label;
                    $_options[$_key]['color'] = $option->color;
                    $_options[$_key]['value'] = $option->value;
                    $_options[$_key]['count'] = isset($data[$option->id]) ? $data[$option->id] : 0;
                    $_key++;
                }
                $result['attributes'][$key]['options'] = $_options;
                $key++;
            } else {
                $result['color']['id'] = $item->id;
                $result['color']['name'] = $item->name;
                $result['color']['code'] = $item->code;
                $result['color']['type'] = $item->type;
                $_key = 0;
                $_options = [];
                foreach ($item->options as $option){
                    $_options[$_key]['id'] = $option->id;
                    $_options[$_key]['label'] = $option->label;
                    $_options[$_key]['color'] = $option->color;
                    $_options[$_key]['value'] = $option->value;
                    $_options[$_key]['count'] = isset($data[$option->id]) ? $data[$option->id] : 0;
                    $_key++;
                }
                $result['color']['options'] = $_options;
            }


        }
        $result['price']['max'] = $this->productRepository->getMaxprice($category);
        $result['price']['min'] = $this->productRepository->getMinprice($category);
        //dd($result);
        return $result;
    }

    private function getAttributes2($categoryId = null):array{
        $query =  Product::query()->select('products.*')
            ->leftJoin('product_categories', 'product_categories.product_id', '=', 'products.id')
            ->leftJoin('product_attribute_values','product_attribute_values.product_id','products.id');

        if ($categoryId) {
            $query->whereIn('product_categories.category_id', explode(',', $categoryId));
        }
        $query->groupBy('attribute_id');

        $products = $query->get();

        $attributes = [];
        $attributes['attributes'] = [];
        foreach ($products as $product){
            foreach ($product->attribute_values as $key => $item){
                //dd($item);
                $attributes['attributes'][$key]['id'] = $item->attribute_id;
                $attributes['attributes'][$key]['name'] = $item->attribute->name;
                $attributes['attributes'][$key]['code'] = $item->attribute->code;
                $attributes['attributes'][$key]['type'] = $item->attribute->type;
                $_key = 0;
                foreach ($item->attribute->options as $option){
                    $_options[$_key]['id'] = $option->id;
                    $_options[$_key]['label'] = $option->label;
                    $_key++;
                }
                $attributes['attributes'][$key]['options'] = $_options;
            }
        }
        //dd($attributes);

        $attributes['price']['max'] = $this->productRepository->getMaxprice();
        $attributes['price']['min'] = $this->productRepository->getMinprice();
        //dd($result);
        return $attributes;
    }

    public function popular(){
        $page = Page::where('key', 'products')->firstOrFail();

        $images = [];
        foreach ($page->sections as $sections){
            if($sections->file){
                $images[] = asset($sections->file->getFileUrlAttribute());
            } else {
                $images[] = null;
            }

        }

        $products = $this->productRepository->getAll(null,1);

        foreach ($products as $product){
            $product_attributes = $product->attribute_values;

            $_result = [];

            foreach ($product_attributes as $item){
                //$options = $item->attribute->options;
                $value = '';
                /*foreach ($options as $option){
                    if($item->attribute->type == 'select'){
                        if($item->integer_value == $option->id) {
                            $_result[$item->attribute->code] = $option->label;
                        }

                    }
                }*/

                if($item->attribute->type == 'select'){

                    $_result[$item->attribute->code] = $item->option->label;


                }
            }
            $product['attributes'] = $_result;

        }

        return Inertia::render('Products',[
            'products' => $products,
            'category' => null,
            'images' => $images,
            'filter' => $this->getAttributes(),
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

    public function special(){
        $page = Page::where('key', 'products')->firstOrFail();

        $images = [];
        foreach ($page->sections as $sections){
            if($sections->file){
                $images[] = asset($sections->file->getFileUrlAttribute());
            } else {
                $images[] = null;
            }

        }

        $products = $this->productRepository->getAll(null,null,1);

        foreach ($products as $product){
            $product_attributes = $product->attribute_values;

            $_result = [];

            foreach ($product_attributes as $item){
                //$options = $item->attribute->options;
                $value = '';
                /*foreach ($options as $option){
                    if($item->attribute->type == 'select'){
                        if($item->integer_value == $option->id) {
                            $_result[$item->attribute->code] = $option->label;
                        }

                    }
                }*/
                if($item->attribute->type == 'select'){

                    $_result[$item->attribute->code] = $item->option->label;


                }
            }
            $product['attributes'] = $_result;



        }



        return Inertia::render('Products',[
            'products' => $products,
            'category' => null,
            'images' => $images,
            'filter' => $this->getAttributes(),
            'collections' => [],
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

    public function new(){
        $page = Page::where('key', 'products')->firstOrFail();

        $images = [];
        foreach ($page->sections as $sections){
            if($sections->file){
                $images[] = asset($sections->file->getFileUrlAttribute());
            } else {
                $images[] = null;
            }

        }

        $products = $this->productRepository->getAll(null,null,null,1);

        $subCategories = [];
        foreach ($products as $product){
            $product_attributes = $product->attribute_values;

            $_result = [];

            foreach ($product_attributes as $item){
                //$options = $item->attribute->options;
                $value = '';
                /*foreach ($options as $option){
                    if($item->attribute->type == 'select'){
                        if($item->integer_value == $option->id) {
                            $_result[$item->attribute->code] = $option->label;
                        }

                    }
                }*/
                if($item->attribute->type == 'select'){

                    $_result[$item->attribute->code] = $item->option->label;


                }
            }
            $product['attributes'] = $_result;





        }




        return Inertia::render('Products',[
            'products' => $products,
            'category' => null,
            'images' => $images,
            'filter' => $this->getAttributes(),

            'collections' => [],
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


    public function youMayLike(){
        $page = Page::where('key', 'products')->firstOrFail();

        $images = [];
        foreach ($page->sections as $sections){
            if($sections->file){
                $images[] = asset($sections->file->getFileUrlAttribute());
            } else {
                $images[] = null;
            }

        }

        $products = $this->productRepository->getAll();

        foreach ($products as $product){
            $product_attributes = $product->attribute_values;

            $_result = [];

            foreach ($product_attributes as $item){
                //$options = $item->attribute->options;
                $value = '';
                /*foreach ($options as $option){
                    if($item->attribute->type == 'select'){
                        if($item->integer_value == $option->id) {
                            $_result[$item->attribute->code] = $option->label;
                        }

                    }
                }*/
                if($item->attribute->type == 'select'){

                    $_result[$item->attribute->code] = $item->option->label;


                }
            }
            $product['attributes'] = $_result;

        }

        return Inertia::render('Products',[
            'products' => $products,
            'category' => null,
            'images' => $images,
            'filter' => $this->getAttributes(),
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
}
