<?php
/**
 *  app/Http/Controllers/Admin/ProductController.php
 *
 * Date-Time: 30.07.21
 * Time: 10:37
 * @author Insite LLC <hello@insite.international>
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\Category;
use App\Models\CategoryColor;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\ProductColor;
use App\Models\ProductSet;
use App\Models\PromoCode;
use App\Models\Stock;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\Eloquent\ProductAttributeValueRepository;
use App\Repositories\Eloquent\ProductColorRepository;
use App\Repositories\ProductRepositoryInterface;
use App\Rules\ColorMatch;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use ReflectionException;
use App\Repositories\Eloquent\AttributeRepository;
use function Symfony\Component\Translation\t;
use Illuminate\Database\Eloquent\Builder as Builder_;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProductController extends Controller
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param CategoryRepositoryInterface $categoryRepository
     */

    private $attributeRepository;

    private $productAttributeValueRepository;

    private $productColorRepository;

    private $categories;
    public function __construct(
        ProductRepositoryInterface  $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        AttributeRepository $attributeRepository,
        ProductAttributeValueRepository $productAttributeValueRepository,
        ProductColorRepository $productColorRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->categories = $this->categoryRepository->getCategoryTree();
        $this->attributeRepository = $attributeRepository;
        $this->productAttributeValueRepository = $productAttributeValueRepository;
        $this->productColorRepository = $productColorRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(ProductRequest $request)
    {
        /*return view('admin.pages.product.index', [
            'products' => $this->productRepository->getData($request, ['translations', 'categories'])
        ]);*/

        return view('admin.nowa.views.products.index', [
            'data' => $this->productRepository->getData($request, ['translations', 'categories','stocks','categories.ancestors','categories.colors','latestImage']),
            'stocks' => Stock::with('translation')->get(),
            'categories' => $this->categoryRepository->model->leftJoin('category_translations',function ($join){
                $join->on('category_translations.category_id','categories.id')->where('category_translations.locale',app()->getLocale());
            })->orderBy('title')->select('categories.id','category_translations.title')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $product = $this->productRepository->model;





        $url = locale_route('product.store', [], false);
        $method = 'POST';

        /*return view('admin.pages.product.form', [
            'product' => $product,
            'url' => $url,
            'method' => $method,
            'categories' => $this->categories
        ]);*/

        return view('admin.nowa.views.products.form', [
            'product' => $product,
            'url' => $url,
            'method' => $method,
            'categories' => $this->categories,
            'attributes' => Attribute::with(['options'])->get(),
            'stocks' => Stock::with('translation')->get(),
            'collections' => ProductSet::all(),
            'promocodes' => PromoCode::query()->where('type','product')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     *
     * @return Application|RedirectResponse|Redirector
     * @throws ReflectionException
     */
    public function store(ProductRequest $request)
    {


        //dd($request->all());
        $saveData = Arr::except($request->except('_token'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];
        $saveData['stock'] = isset($saveData['stock']) && (bool)$saveData['stock'];
        $saveData['popular'] = isset($saveData['popular']) && (bool)$saveData['popular'];
        $saveData['new'] = isset($saveData['new']) && (bool)$saveData['new'];
        $saveData['new_collection'] = isset($saveData['new_collection']) && (bool)$saveData['new_collection'];
        $saveData['bunker'] = isset($saveData['bunker']) && (bool)$saveData['bunker'];
        $saveData['day_price'] = isset($saveData['day_price']) && (bool)$saveData['day_price'];
        $saveData['day_product'] = isset($saveData['day_product']) && (bool)$saveData['day_product'];
        $saveData['special_price_tag'] = isset($saveData['special_price_tag']) && (bool)$saveData['special_price_tag'];

        $attributes = isset($saveData['attribute']) ? $saveData['attribute'] : [];
        unset($saveData['attribute']);

        $matras_new = isset($saveData['matras_new']) ? $saveData['matras_new'] : [];
        unset($saveData['matras_new']);

        //dd($matras_new);

        if(isset($saveData['term'])){
            $saveData['group'] = $saveData['term'];
            unset($saveData['term']);
        }

        $product = $this->productRepository->create($saveData);
        $product->categories()->sync($saveData['categories']);

        // Save Files
        if ($request->hasFile('images')) {
            $product = $this->productRepository->saveFiles($product->id, $request,512,512);
        }

        if ($request->post('base64_img')) {

            $product = $this->productRepository->uploadCropped($request, $product->id);
        }

        $this->productRepository->saveVideo($request);

        if(isset($saveData['collection_id'])){
            $product->collections()->sync($saveData['collection_id'] ? [$saveData['collection_id']]:[]);
        }



        //save product attributes
        $attr = [];
        foreach ($attributes as $key => $item){
            if ($item){
                $attr[$key] = $item;
            }
        }

        $attr_ids = array_keys($attr);

        $_attributes = Attribute::whereIn('id',$attr_ids)->get();

        $arr = [];
        foreach ($_attributes as $item){
            $arr[$item->id] = $item;
        }

        $data = [];
        foreach ($attr as $key => $item){
            $data['product_id'] = $product->id;
            $data['attribute_id'] = $arr[$key]->id;
            $data['type'] = $arr[$key]->type;
            if($data['type'] == 'boolean') $data['value'] = (bool)$item;
            else $data['value'] = $item;

            //dd($data);
            $this->productAttributeValueRepository->create($data);
        }


        $n =  1;
        if(!empty($matras_new)){
            foreach ($matras_new['option_id'] as $key => $item){
                if($item){
                    $variant = $product->variants()->create([
                        'title' => $product->title,
                        'slug' => $product->slug .'_'. $n++,
                        'price' => $matras_new['price'][$key] ?? 0,
                        'special_price' => $matras_new['special_price'][$key],
                    ]);
                    $variant->categories()->sync($saveData['categories'] ?? []);

                    $data['product_id'] = $variant->id;
                    $data['attribute_id'] = AttributeOption::query()->where('id',$item)->first()->attribute_id;
                    $data['type'] = 'select';
                    $data['value'] = $item;
                    $this->productAttributeValueRepository->create($data);
                }

            }
        }


        $this->updateMinMaxPrice($product);


        return redirect(locale_route('product.edit', $product->id))->with('success', __('admin.create_successfully'));

    }

    /**
     * Display the specified resource.
     *
     * @param string $locale
     * @param Product $product
     *
     * @return Application|Factory|View
     */
    public function show(string $locale, Product $product)
    {
        return view('admin.pages.product.show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $locale
     * @param Category $category
     *
     * @return Application|Factory|View
     */
    public function edit(string $locale, Product $product)
    {
        $url = locale_route('product.update', $product->id, false);
        $method = 'PUT';

        /*return view('admin.pages.product.form', [
            'product' => $product,
            'url' => $url,
            'method' => $method,
            'categories' => $this->categories
        ]);*/

        return view('admin.nowa.views.products.form', [
            'product' => $product,
            'url' => $url,
            'method' => $method,
            'categories' => $this->categories,
            'attributes' => Attribute::with(['options'])->get(),
            'stocks' => Stock::with('translation')->get(),
            'collections' => ProductSet::all(),
            'promocodes' => PromoCode::query()->where('type','product')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param string $locale
     * @param Product $product
     * @return Application|RedirectResponse|Redirector
     * @throws ReflectionException
     */
    public function update(ProductRequest $request, string $locale, Product $product)
    {
        //dd($request->all());
        $request->validate([
            'collection_id' => ['nullable',new ColorMatch($request)]
        ]);
        //dd($request->all());
        $saveData = Arr::except($request->except('_token'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];
        $saveData['popular'] = isset($saveData['popular']) && (bool)$saveData['popular'];
        $saveData['stock'] = isset($saveData['stock']) && (bool)$saveData['stock'];
        $saveData['new'] = isset($saveData['new']) && (bool)$saveData['new'];
        $saveData['new_collection'] = isset($saveData['new_collection']) && (bool)$saveData['new_collection'];
        $saveData['bunker'] = isset($saveData['bunker']) && (bool)$saveData['bunker'];
        $saveData['day_price'] = isset($saveData['day_price']) && (bool)$saveData['day_price'];
        $saveData['day_product'] = isset($saveData['day_product']) && (bool)$saveData['day_product'];
        $saveData['special_price_tag'] = isset($saveData['special_price_tag']) && (bool)$saveData['special_price_tag'];

        //dd($saveData);
        $attributes = isset($saveData['attribute']) ? $saveData['attribute'] : [];
        unset($saveData['attribute']);

        $matras = isset($saveData['matras']) ? $saveData['matras'] : [];

        unset($saveData['matras']);

        $matras_new = isset($saveData['matras_new']) ? $saveData['matras_new'] : [];
        unset($saveData['matras_new']);

        //dd($matras,$request->matras_price,$request->matras_price);

        foreach ($matras as $var_id => $matras_variant){
            $product_atribute = ProductAttributeValue::where('product_id',$var_id)
                ->where('attribute_id',Attribute::where('code','size')->first()->id)->first();

            if ($product_atribute){
                $data['integer_value'] = $matras_variant['option_id'];
                ProductAttributeValue::where('product_id',$product_atribute->product_id)
                    ->where('attribute_id',$product_atribute->attribute_id)
                    ->update($data);
            }
            Product::where('id',$var_id)->update(['price' => $matras_variant['price'], 'special_price' => $matras_variant['special_price']]);
        }


        //dd($request->file('images'));
        if(isset($saveData['term'])){
           $saveData['group'] = $saveData['term'];
            unset($saveData['term']);
        }


        $this->productRepository->update($product->id, $saveData);

        $this->productRepository->saveFiles($product->id, $request, 512,512);

        $this->productRepository->saveVideo($request);


        $product->categories()->sync($saveData['categories'] ?? []);

        if($product->parent_id === null){
            foreach ($product->variants as $variant){
                $variant->categories()->sync($saveData['categories'] ?? []);
            }
        }

        $product->stocks()->sync($saveData['stock_id'] ?? []);



        $product->collections()->sync(isset($saveData['collection_id']) ? [$saveData['collection_id']]:[]);

        //dd($attributes);


        //update product attributes
        $attr = [];
        $attr_del = [];
        foreach ($attributes as $key => $item){
            if ($item){

                $product_atribute = ProductAttributeValue::where('product_id',$product->id)
                    ->where('attribute_id',$key)->first();
                if ($product_atribute){

                    $data['integer_value'] = $item;
                    ProductAttributeValue::where('product_id',$product_atribute->product_id)
                        ->where('attribute_id',$product_atribute->attribute_id)
                        ->update($data);
                    //$product_atribute->update($data);
                } else {
                    $attr[$key] = $item;
                }
            } else $attr_del[] = $key;
        }

        $attr_ids = array_keys($attr);

        $_attributes = Attribute::whereIn('id',$attr_ids)->get();

        $arr = [];
        foreach ($_attributes as $item){
            $arr[$item->id] = $item;
        }

        $data = [];
        foreach ($attr as $key => $item){
            $data['product_id'] = $product->id;
            $data['attribute_id'] = $arr[$key]->id;
            $data['type'] = $arr[$key]->type;

            if($data['type'] == 'boolean') $data['value'] = (bool)$item;
            else $data['value'] = $item;

            //dd($data);
            $this->productAttributeValueRepository->create($data);
        }


        ProductAttributeValue::where('product_id',$product->id)
            ->whereIn('attribute_id',$attr_del)->delete();

        if(isset($saveData['del_var'])){
            Product::query()->whereIn('id',$saveData['del_var'])->delete();
        }

        $n =  1;
        if(!empty($matras_new)){
            foreach ($matras_new['option_id'] as $key => $item){
                if($item){
                    $variant = $product->variants()->create([
                        'title' => $product->title,
                        'slug' => $product->slug .'_' . uniqid(),
                        'price' => $matras_new['price'][$key] ?? 0,
                        'special_price' => $matras_new['special_price'][$key],
                    ]);
                    $variant->categories()->sync($saveData['categories'] ?? []);

                    $data['product_id'] = $variant->id;
                    $data['attribute_id'] = AttributeOption::query()->where('id',$item)->first()->attribute_id;
                    $data['type'] = 'select';
                    $data['value'] = $item;
                    $this->productAttributeValueRepository->create($data);
                }

            }
        }





        $this->updateMinMaxPrice($product);

        return redirect(locale_route('product.index', $product->id))->with('success', __('admin.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $locale
     * @param Product $product
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(string $locale, Product $product)
    {
        if (!$this->productRepository->delete($product->id)) {
            return redirect(locale_route('product.show', $product->id))->with('danger', __('admin.not_delete_message'));
        }
        return redirect(locale_route('product.index'))->with('success', __('admin.delete_message'));
    }


    public function variantCreate(string $locale, Product $product){
        //dd($product);





        $url = locale_route('product.variant.store', [$product], false);
        $method = 'POST';

        /*return view('admin.pages.product.form', [
            'product' => $product,
            'url' => $url,
            'method' => $method,
            'categories' => $this->categories
        ]);*/
        //$product = new Product();

        return view('admin.nowa.views.products.variant-form', [
            'product' => $product,
            'url' => $url,
            'method' => $method,
            'categories' => $this->categories,
            'attributes' => $this->attributeRepository->all(),
            'stocks' => Stock::with('translation')->get(),
            'promocodes' => PromoCode::query()->where('type','product')->get()
        ]);
    }

    public function variantStore(Request $request, $locale, Product $product){
//dd($request->all());
        $request->validate([
           'slug' => 'required|alpha_dash|unique:products,slug',
            'price' => 'required'
        ]);

        $saveData = Arr::except($request->except('_token'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];
        $saveData['stock'] = isset($saveData['stock']) && (bool)$saveData['stock'];
        $saveData['popular'] = isset($saveData['popular']) && (bool)$saveData['popular'];
        $saveData['new'] = isset($saveData['new']) && (bool)$saveData['new'];
        $saveData['new_collection'] = isset($saveData['new_collection']) && (bool)$saveData['new_collection'];
        $saveData['bunker'] = isset($saveData['bunker']) && (bool)$saveData['bunker'];
        $saveData['day_price'] = isset($saveData['day_price']) && (bool)$saveData['day_price'];
        $saveData['day_product'] = isset($saveData['day_product']) && (bool)$saveData['day_product'];
        $saveData['special_price_tag'] = isset($saveData['special_price_tag']) && (bool)$saveData['special_price_tag'];
        $saveData['parent_id'] = $product->id;

        //dd($saveData);

        $attributes = $saveData['attribute'];
        unset($saveData['attribute']);

        $product_v = $this->productRepository->create($saveData);
        $product_v->categories()->sync($saveData['categories']);

        $product_v->stocks()->sync($saveData['stock_id'] ?? []);

        // Save Files
        if ($request->hasFile('images')) {
            $product_v = $this->productRepository->saveFiles($product_v->id, $request);
        }

        if ($request->post('base64_img')) {

            $product_v = $this->productRepository->uploadCropped($request, $product_v->id);
        }

        $this->productRepository->saveVideo($request, $product_v->id);


        //save product attributes
        $attr = [];
        foreach ($attributes as $key => $item){
            if ($item){
                $attr[$key] = $item;
            }
        }

        $attr_ids = array_keys($attr);

        $_attributes = Attribute::whereIn('id',$attr_ids)->get();

        $arr = [];
        foreach ($_attributes as $item){
            $arr[$item->id] = $item;
        }

        $data = [];
        foreach ($attr as $key => $item){
            $data['product_id'] = $product_v->id;
            $data['attribute_id'] = $arr[$key]->id;
            $data['type'] = $arr[$key]->type;
            if($data['type'] == 'boolean') $data['value'] = (bool)$item;
            else $data['value'] = $item;

            //dd($data);
            $this->productAttributeValueRepository->create($data);
        }

        if($saveData['term']){
            $attribute = Attribute::query()->where('code','size')->first();
            $option = $attribute->options()->create([
                'value' => $saveData['term']
            ]);
            $data = [];

            $data['product_id'] = $product_v->id;
            $data['attribute_id'] = $attribute->id;
            $data['type'] = $attribute->type;

            $data['value'] = $option->id;

            //dd($data);
            $this->productAttributeValueRepository->create($data);

        }


        $this->updateMinMaxPrice($product);

        return redirect(locale_route('product.edit', $product->id))->with('success', __('admin.update_successfully'));

    }

    public function updateMinMaxPrice($product){
        $prices = [];
        if($product->parent_id === null){
            foreach ($product->variants as $variant){
                $prices[] = $variant->special_price ? $variant->special_price : $variant->price;
            }
            //dd($prices);
            if(!empty($prices)){
                $min_price = min($prices);
                $max_price = max($prices);
                $product->update([
                    'min_price' => $min_price,
                    'max_price' => $max_price
                ]);
            }
        } else {
            foreach ($product->parent->variants as $variant){
                $prices[] = $variant->special_price ? $variant->special_price : $variant->price;
            }
            //dd($prices);
            if(!empty($prices)){
                $min_price = min($prices);
                $max_price = max($prices);
                $product->parent()->update([
                    'min_price' => $min_price,
                    'max_price' => $max_price
                ]);
            }
        }


    }

    public function uploadCropped(Request $request, $locale, Product $product){
        $this->productRepository->uploadCropped($request, $product->id);
    }


    public function addColor($locale,Product $product){

        //dd($category);


        //dd($categories);

        $url = locale_route('product.store_color', [$product], false);
        $method = 'POST';

        return view('admin.nowa.views.categories.colors-form', [
            'category' => $product,
            'url' => $url,
            'method' => $method,
            'category_color' => new ProductColor()
        ]);
    }

    public function storeColor(Request $request, $locale, Product $product){
        $saveData = $request->except(['_token']);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];
        $saveData['product_id'] = $product->id;
        //dd($saveData);
        $categoryColor = $this->productColorRepository->create($saveData);

        // Save Files


        $this->productColorRepository->saveFiles($categoryColor->id, $request);



        return redirect(locale_route('product.edit', $product->id))->with('success', __('admin.create_successfully'));


    }

    public function editColor($locate,Product $product,ProductColor $productColor){
        $url = locale_route('product.update_color', [$product->id,$productColor->id], false);
        $method = 'PUT';





        return view('admin.nowa.views.categories.colors-form', [
            'category' => $product,
            'url' => $url,
            'method' => $method,
            'category_color' => $productColor
        ]);
    }

    public function updateColor(Request $request,$locale,Product $product,ProductColor $productColor){
        $saveData = $request->except('_token','_method');
        //$saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];


        //dd($saveData);
        $this->productColorRepository->update($productColor->id, $saveData);


        // Save Files

        $this->productColorRepository->saveFiles($productColor->id, $request);

        //dd(count($data));


        return redirect(locale_route('product.edit', $product->id))->with('success', __('admin.update_successfully'));
    }

    public function deleteColor($locale, Product $product, ProductColor $productColor){

        if (!$this->productColorRepository->delete($productColor->id)) {
            return redirect(locale_route('product.edit', $product->id))->with('danger', __('admin.not_delete_message'));
        }
        return redirect(locale_route('product.edit', $product->id))->with('success', __('admin.delete_message'));
    }

    public function getGroups(Request $request){
        $params = $request->all();
        if(isset($params['term'])){
            $query = Product::query()
                ->select('group')
            ->where('group','like', '%' . $params['term'] . '%');

        }

        $query->groupBy('group');

        $data = $query->limit(10)->get();

        $li = '';
        foreach ($data as $item){
            $li .= '<li>';
            $li .= '<a href="javascript:void(0)" data-sel_product="'. $item->group .'">';
            $li .= $item->group;
            $li .= '</a>';
            $li .= '</li>';
        }

        return $li;
    }

    public function import(Request $request){

        $request->validate([
           'file' => 'required',
            'skip_rows' => 'numeric'
        ]);
        $f = $request->file('file')->getRealPath();

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($f);

        $worksheet = $spreadsheet->getActiveSheet();

        $rowIterator = $worksheet->getRowIterator();

        $chars = [
          'A',
          'B',
          'C',
          'D',
          'E',
          'F',
          'G',
            'H',
            'I',
            'J',
            'K',
            'L',
            'M',
            'N',
            'O',
            'P',
            'R',
            'S',
            'T'
        ];



        $result = [];
        foreach ($rowIterator as $key => $row){
            if($key <= $request->post('skip_rows')) continue;
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);
            $data = [];
            foreach ($cellIterator as $cell) { $data[] = $cell->getValue(); }

            //echo '<pre>';
            if(isset($data[array_search($request->post('model'),$chars)])){
                $result[] = [
                    'model' => $data[array_search($request->post('model'),$chars)],
                    'price' => $data[array_search($request->post('price'),$chars)],
                    'quantity' => preg_replace('/[^0-9]/','',$data[array_search($request->post('quantity'),$chars)]),
                    'title' => $data[array_search($request->post('name'),$chars)],
                    'description' => $data[array_search($request->post('description'),$chars)],
                    'slug' => str_replace(' ','-',$data[array_search($request->post('model'),$chars)])
                ];
            }

            //print_r($data);

        }

        $n = 0;
        foreach ($result as $item){


            $product = Product::where('slug',$item['slug'])->first();
            //dd($product);
            if($product) {
                $product->update($item);

            } else {
                $product = Product::create($item);
            }
        }
        return redirect()->back()->with('success','imported products');
    }
}
