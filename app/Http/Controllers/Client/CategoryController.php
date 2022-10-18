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

class CategoryController extends Controller
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
    public function show(string $locale, string $slug)
    {

        $page = Page::where('key', 'products')->firstOrFail();
//        return 1;
        $category = Category::where(['status' => 1, 'slug' => $slug])->firstOrFail();
        //dd($category->getAncestors());




        //dd($subCategories);
        $products = $this->productRepository->getAll($category->id);

        //dd($products);

        foreach ($products as $product){
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

            $sale = false;

            foreach ($product->variants as $variant){

                if($variant->special_price){
                    $sale = true;
                }
            }

            $product['sale'] = $sale;

        }

        $subCategories = [];
        foreach (Category::where('parent_id','!=',null)->get()->toArray() as $item){
            $subCategories[] = $item;
        }

        return Inertia::render('Products',[
            'products' => $products,
            'category' => null,
            'images' => $images,
            'filter' => $this->getAttributes(),
            'subcategories' => $subCategories,
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

            $sale = false;

            foreach ($product->variants as $variant){

                if($variant->special_price){
                    $sale = true;
                }
            }

            $product['sale'] = $sale;



        }

        foreach (Category::where('parent_id','!=',null)->get()->toArray() as $item){
            $subCategories[] = $item;
        }


        return Inertia::render('Products',[
            'products' => $products,
            'category' => null,
            'images' => $images,
            'filter' => $this->getAttributes(),
            'subcategories' => $subCategories,
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
