<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderRequest;
use App\Models\City;
use App\Models\PromoCode;
use App\Models\Slider;
use App\Models\Stock;
use App\Repositories\Eloquent\CityRepository;
use App\Repositories\Eloquent\PromoCodeRepository;
use App\Repositories\Eloquent\StockRepository;
use App\Repositories\SliderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PromocodeController extends Controller
{

    private $promoCodeRepository;


    public function __construct(
        PromoCodeRepository $promoCodeRepository
    )
    {
        $this->promoCodeRepository = $promoCodeRepository;

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

        return view('admin.nowa.views.promocode.index', [
            'data' => $this->promoCodeRepository->getData($request)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $slider = $this->promoCodeRepository->model;

        $url = locale_route('promocode.store', [], false);
        $method = 'POST';

        /*return view('admin.pages.slider.form', [
            'slider' => $slider,
            'url' => $url,
            'method' => $method,
        ]);*/

        return view('admin.nowa.views.promocode.form', [
            'model' => $slider,
            'url' => $url,
            'method' => $method,
            'cities' => City::with('translation')->get()
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
            'reward' => 'required'
        ]);

        $saveData = $request->except('_token');
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];
        //dd($saveData);
        if($saveData['type'] == 'cart'){
            if(PromoCode::where('type','cart')->count() > 0){
                return redirect()->back()->with('danger','you can create only one promocode of type cart');
            }
        }
        $slider = $this->promoCodeRepository->create($saveData);

        // Save Files
        if ($request->hasFile('images')) {
            $slider = $this->promoCodeRepository->saveFiles($slider->id, $request);
        }

        return redirect(locale_route('promocode.index', $slider->id))->with('success', __('admin.create_successfully'));

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param string $locale
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(string $locale, PromoCode $promoCode)
    {
        $url = locale_route('promocode.update', $promoCode->id, false);
        $method = 'PUT';

        /*return view('admin.pages.slider.form', [
            'slider' => $slider,
            'url' => $url,
            'method' => $method,
        ]);*/

        return view('admin.nowa.views.promocode.form', [
            'model' => $promoCode,
            'url' => $url,
            'method' => $method,
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
    public function update(Request $request, string $locale, PromoCode $promoCode)
    {
        $request->validate([
            'reward' => 'required'
        ]);
        $saveData = Arr::except($request->except('_token'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];

        /*if($saveData['type'] == 'cart'){
            if(PromoCode::where('type','cart')->count() > 0){
                return redirect()->back()->with('danger','you can create only one promocode of type cart');
            }
        }*/

        $this->promoCodeRepository->update($promoCode->id, $saveData);

        //$this->promoCodeRepository->saveFiles($promoCode->id, $request);


        return redirect(locale_route('promocode.index', $promoCode->id))->with('success', __('admin.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $locale
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(string $locale, PromoCode $promoCode)
    {
        if (!$this->promoCodeRepository->delete($promoCode->id)) {
            return redirect(locale_route('promocode.show', $promoCode->id))->with('danger', __('admin.not_delete_message'));
        }
        return redirect(locale_route('promocode.index'))->with('success', __('admin.delete_message'));
    }
}
