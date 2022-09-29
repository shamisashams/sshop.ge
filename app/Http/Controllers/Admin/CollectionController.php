<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderRequest;
use App\Models\Attribute;
use App\Models\City;
use App\Models\Product;
use App\Models\ProductProductSet;
use App\Models\ProductSet;
use App\Models\Slider;
use App\Models\Stock;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\CityRepository;
use App\Repositories\Eloquent\CollectionRepository;
use App\Repositories\Eloquent\StockRepository;
use App\Repositories\SliderRepositoryInterface;
use App\Rules\ColorMatchCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class CollectionController extends Controller
{

    private $collectionRepository;
    private $categoryRepository;
    private $categories;


    public function __construct(
        CollectionRepository $collectionRepository,
        CategoryRepository $categoryRepository
    )
    {
        $this->collectionRepository = $collectionRepository;
        $this->categoryRepository = $categoryRepository;
        $this->categories = $this->categoryRepository->getCategoryTree();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(SliderRequest $request)
    {
        /*return view('admin.pages.slider.index', [
            'sliders' => $this->slideRepository->getData($request, ['translations'])
        ]);*/

        return view('admin.nowa.views.collection.index', [
            'data' => $this->collectionRepository->getData($request, ['translations','colors'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $slider = $this->collectionRepository->model;

        $url = locale_route('collection.store', [], false);
        $method = 'POST';



        /*return view('admin.pages.slider.form', [
            'slider' => $slider,
            'url' => $url,
            'method' => $method,
        ]);*/

        return view('admin.nowa.views.collection.form', [
            'categories' => $this->categories,
            'model' => $slider,
            'url' => $url,
            'method' => $method,
            'color' => Attribute::with('options')->where('code','color')->first()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Admin\ProductRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \ReflectionException
     */
    public function store(Request $request)
    {
        $request->validate([
            config('translatable.fallback_locale') . '.title' => 'required|string|max:255',
            'slug' => ['required', 'alpha_dash', Rule::unique('product_sets', 'slug')],
        ]);
        $saveData = Arr::except($request->except('_token'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];
        $slider = $this->collectionRepository->create($saveData);

        // Save Files
        if ($request->hasFile('images')) {
            $slider = $this->collectionRepository->saveFiles($slider->id, $request);
        }

        if ($request->hasFile('set_image')) {

            $this->collectionRepository->saveSetImage($slider->id, $request);
        }

        if ($request->has('base64_img')) {

            $this->collectionRepository->uploadCropped($request, $slider->id);
        }

        $this->collectionRepository->model->colors()->sync($request->post('color') ?? []);

        $this->collectionRepository->saveVideo($request);
        $this->collectionRepository->model->categories()->sync($saveData['categories'] ?? []);

        return redirect(locale_route('collection.index', $slider->id))->with('success', __('admin.create_successfully'));

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param string $locale
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(string $locale, ProductSet $productSet)
    {
        $url = locale_route('collection.update', $productSet->id, false);
        $method = 'PUT';

        /*return view('admin.pages.slider.form', [
            'slider' => $slider,
            'url' => $url,
            'method' => $method,
        ]);*/

        return view('admin.nowa.views.collection.form', [
            'categories' => $this->categories,
            'model' => $productSet,
            'url' => $url,
            'method' => $method,
            'color' => Attribute::with('options')->where('code','color')->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Admin\CategoryRequest $request
     * @param string $locale
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, string $locale, ProductSet $productSet)
    {

        //dd($request->all());
        $request->validate([
            config('translatable.fallback_locale') . '.title' => 'required|string|max:255',
            'color.*' => new ColorMatchCollection($productSet,$request)
        ]);
        $saveData = Arr::except($request->except('_token'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];

        $this->collectionRepository->update($productSet->id, $saveData);

        $this->collectionRepository->saveFiles($productSet->id, $request);

        if ($request->hasFile('set_image')) {

            $this->collectionRepository->saveSetImage($productSet->id, $request);
        }

        $this->collectionRepository->saveVideo($request);


            $this->collectionRepository->model->colors()->sync($request->post('color') ?? []);


        $this->collectionRepository->model->categories()->sync($saveData['categories'] ?? []);


        return redirect(locale_route('collection.index', $productSet->id))->with('success', __('admin.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $locale
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(string $locale, ProductSet $productSet)
    {
        if (!$this->collectionRepository->delete($productSet->id)) {
            return redirect(locale_route('collection.show', $productSet->id))->with('danger', __('admin.not_delete_message'));
        }
        return redirect(locale_route('collection.index'))->with('success', __('admin.delete_message'));
    }

    public function coordinatesUpdate(Request $request){

        //dd($request->all());
        ProductProductSet::query()->where('id',$request->post('id'))->update(['coordinates' => $request->post('val')]);
        return ['msg' => 'success','status' => 'ok'];

    }

    public function removeProduct($locale,$id){
        ProductProductSet::query()->where('id',$id)->delete();
        return redirect()->back()->with('success', __('admin.delete_message'));
    }

    public function uploadCropped(Request $request, $locale, ProductSet $productSet){
        $this->collectionRepository->uploadCropped($request, $productSet->id);
    }


    public function getProducts(Request $request){
        $params = $request->all();
        if(isset($params['term'])){
            $query = Product::where(function ($tQ) use ($params){
                $tQ->whereTranslationLike('title', '%'.$params['term'].'%')
                    ->orWhereTranslationLike('description', '%'.$params['term'].'%');
                $tQ->orWhere('slug','like','%'.$params['term'].'%');
                $tQ->orWhere('id','like','%'.$params['term'].'%');
            });

        }
        $query->whereHas('attribute_values',function (Builder $aq) use ($params){
            $aq->where('integer_value',$params['color']);
        });
        $query->where('parent_id','!=',null);

        $data = $query->limit(10)->get();

        $li = '';
        foreach ($data as $item){
            $li .= '<li>';
            $li .= '<a href="javascript:void(0)" data-sel_product="'. $item->id .'">';
            $li .= '#'.$item->id .' <b>title</b>:'.$item->title .' <b>slug:</b> '.$item->slug.' <b>code:</b> '. $item->code;
            $li .= ' | ';
            $li .= $item->attribute_values()->where('integer_value',$params['color'])->first()->attribute->code;
            $li .= ' : ';
            $li .= $item->attribute_values()->where('integer_value',$params['color'])->first()->attribute->options()->where('id',$params['color'])->first()->label;
            $li .= '</a>';
            $li .= '</li>';
        }

        return $li;
    }

    public function addProducts($locale,ProductSet $productSet,Request $request){

        $saveData = $request->input();
        //dd($saveData);

        $productSet->products()->sync(isset($saveData['product_id']) ? $saveData['product_id']:[]);

        return redirect()->back();
    }
}
