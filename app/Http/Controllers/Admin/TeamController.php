<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderRequest;
use App\Models\City;
use App\Models\Slider;
use App\Models\Stock;
use App\Models\Team;
use App\Repositories\Eloquent\CityRepository;
use App\Repositories\Eloquent\StockRepository;
use App\Repositories\Eloquent\TeamRepository;
use App\Repositories\SliderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TeamController extends Controller
{

    private $teamRepository;


    public function __construct(
        TeamRepository $teamRepository
    )
    {
        $this->teamRepository = $teamRepository;

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

        return view('admin.nowa.views.team.index', [
            'data' => $this->teamRepository->getData($request, ['translations'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $slider = $this->teamRepository->model;

        $url = locale_route('team.store', [], false);
        $method = 'POST';

        /*return view('admin.pages.slider.form', [
            'slider' => $slider,
            'url' => $url,
            'method' => $method,
        ]);*/

        return view('admin.nowa.views.team.form', [
            'model' => $slider,
            'url' => $url,
            'method' => $method,
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
        //dd($request->all());
        $request->validate([
            config('translatable.fallback_locale') . '.name' => 'required|string|max:255',
        ]);
        $saveData = Arr::except($request->except('_token'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];
        $slider = $this->teamRepository->create($saveData);

        // Save Files
        if ($request->hasFile('images')) {
            $slider = $this->teamRepository->saveFiles($slider->id, $request);
        }

        return redirect(locale_route('team.index', $slider->id))->with('success', __('admin.create_successfully'));

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param string $locale
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(string $locale, Team $team)
    {
        $url = locale_route('team.update', $team->id, false);
        $method = 'PUT';

        /*return view('admin.pages.slider.form', [
            'slider' => $slider,
            'url' => $url,
            'method' => $method,
        ]);*/

        return view('admin.nowa.views.team.form', [
            'model' => $team,
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
    public function update(Request $request, string $locale, Team $team)
    {
        $request->validate([
            config('translatable.fallback_locale') . '.name' => 'required|string|max:255',

        ]);
        $saveData = Arr::except($request->except('_token'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];

        $this->teamRepository->update($team->id, $saveData);

        $this->teamRepository->saveFiles($team->id, $request);


        return redirect(locale_route('team.index', $team->id))->with('success', __('admin.update_successfully'));
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
        if (!$this->teamRepository->delete($stock->id)) {
            return redirect(locale_route('team.index', $stock->id))->with('danger', __('admin.not_delete_message'));
        }
        return redirect(locale_route('team.index'))->with('success', __('admin.delete_message'));
    }
}
