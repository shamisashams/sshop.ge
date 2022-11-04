<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\Translations\ProductTranslation;
use App\Repositories\Eloquent\AttributeRepository;
use App\Repositories\Eloquent\ProductRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Searchable\Search;

class SearchController extends Controller
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
    public function index(string $locale, Request $request)
    {

        $page = Page::where('key', 'about')->firstOrFail();
//        return 1;

        //dd($category->getAncestors());
        /*$products = Product::where(['status' => 1, 'product_categories.category_id' => $category->id])
            ->leftJoin('product_categories', 'product_categories.product_id', '=', 'products.id')->with(['latestImage'])
            ->orderby('updated_at','desc')
            ->paginate(16);*/

        $products = $this->productRepository->getAll();

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

        /*$subCategories = [];
        foreach (Category::where('parent_id','!=',null)->get()->toArray() as $item){
            $subCategories[] = $item;
        }*/

        //dd($products);

        //dd($products);
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

    private function getAttributes():array{
        $attrs = $this->attributeRepository->model->with(['translation','options.translation'])->orderBy('position')->get();
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

        $res = ProductAttributeValue::query()->selectRaw('COUNT(product_id) as count, integer_value as option_id')->whereIn('integer_value',$opt_id)->groupBy('integer_value')->get();

        $data = [];
        foreach ($res as $item){
            $data[$item->option_id] = $item->count;
        }

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
                $_options[$_key]['color'] = $option->color;
                $_options[$_key]['value'] = $option->value;
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


        $result['price']['max'] = $this->productRepository->getMaxprice();
        $result['price']['min'] = $this->productRepository->getMinprice();
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

        //$query->groupBy('attribute_id');

        $products = $query->get();

        //dd($products);

        $attributes = [];
        $attributes['attributes'] = [];
        foreach ($products as $product){
            foreach ($product->attribute_values as $key => $item){
                //dd($item);
                if($item->attribute->code !== 'color'){
                    $attributes['attributes'][$key]['id'] = $item->attribute_id;
                    $attributes['attributes'][$key]['name'] = $item->attribute->name;
                    $attributes['attributes'][$key]['code'] = $item->attribute->code;
                    $attributes['attributes'][$key]['type'] = $item->attribute->type;
                    $_key = 0;
                    foreach ($item->attribute->options as $option){
                        $_options[$_key]['id'] = $option->id;
                        $_options[$_key]['label'] = $option->label;
                        $_options[$_key]['color'] = $option->color;
                        $_key++;
                    }
                    $attributes['attributes'][$key]['options'] = $_options;
                } else {
                    $attributes['color']['id'] = $item->attribute_id;
                    $attributes['color']['name'] = $item->attribute->name;
                    $attributes['color']['code'] = $item->attribute->code;
                    $attributes['color']['type'] = $item->attribute->type;
                    $_key = 0;
                    foreach ($item->attribute->options as $option){
                        $_options[$_key]['id'] = $option->id;
                        $_options[$_key]['label'] = $option->label;
                        $_options[$_key]['color'] = $option->color;
                        $_key++;
                    }
                    $attributes['color']['options'] = $_options;
                }

            }
        }
        //dd($attributes);

        $attributes['price']['max'] = $this->productRepository->getMaxprice();
        $attributes['price']['min'] = $this->productRepository->getMinprice();
        //dd($result);
        return $attributes;
    }



}
