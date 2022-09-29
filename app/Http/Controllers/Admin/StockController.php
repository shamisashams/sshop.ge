<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderRequest;
use App\Models\City;
use App\Models\Slider;
use App\Models\Stock;
use App\Repositories\Eloquent\CityRepository;
use App\Repositories\Eloquent\StockRepository;
use App\Repositories\SliderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class StockController extends Controller
{

    private $stockRepository;


    public function __construct(
        StockRepository $stockRepository
    )
    {
        $this->stockRepository = $stockRepository;

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

        return view('admin.nowa.views.stock.index', [
            'data' => $this->stockRepository->getData($request, ['translations'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $slider = $this->stockRepository->model;

        $url = locale_route('stock.store', [], false);
        $method = 'POST';

        /*return view('admin.pages.slider.form', [
            'slider' => $slider,
            'url' => $url,
            'method' => $method,
        ]);*/

        return view('admin.nowa.views.stock.form', [
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
            config('translatable.fallback_locale') . '.title' => 'required|string|max:255',
            'city_id' => 'required'
        ]);
        $saveData = Arr::except($request->except('_token'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];
        $slider = $this->stockRepository->create($saveData);

        // Save Files
        if ($request->hasFile('images')) {
            $slider = $this->stockRepository->saveFiles($slider->id, $request);
        }

        return redirect(locale_route('stock.index', $slider->id))->with('success', __('admin.create_successfully'));

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param string $locale
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(string $locale, Stock $stock)
    {
        $url = locale_route('stock.update', $stock->id, false);
        $method = 'PUT';

        /*return view('admin.pages.slider.form', [
            'slider' => $slider,
            'url' => $url,
            'method' => $method,
        ]);*/

        return view('admin.nowa.views.stock.form', [
            'model' => $stock,
            'url' => $url,
            'method' => $method,
            'cities' => City::with('translation')->get()
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
    public function update(Request $request, string $locale, Stock $stock)
    {
        $request->validate([
            config('translatable.fallback_locale') . '.title' => 'required|string|max:255',
            'city_id' => 'required'
        ]);
        $saveData = Arr::except($request->except('_token'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];

        $this->stockRepository->update($stock->id, $saveData);

        $this->stockRepository->saveFiles($stock->id, $request);


        return redirect(locale_route('stock.index', $stock->id))->with('success', __('admin.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $locale
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(string $locale, Stock $stock)
    {
        if (!$this->stockRepository->delete($stock->id)) {
            return redirect(locale_route('stock.show', $stock->id))->with('danger', __('admin.not_delete_message'));
        }
        return redirect(locale_route('stock.index'))->with('success', __('admin.delete_message'));
    }
}
