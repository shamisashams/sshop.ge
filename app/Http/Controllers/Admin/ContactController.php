<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderRequest;
use App\Models\City;
use App\Models\Contact;
use App\Models\Slider;
use App\Models\Stock;
use App\Repositories\Eloquent\CityRepository;
use App\Repositories\Eloquent\ContactRepository;
use App\Repositories\Eloquent\StockRepository;
use App\Repositories\SliderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ContactController extends Controller
{

    private $contactRepository;


    public function __construct(
        ContactRepository $contactRepository
    )
    {
        $this->contactRepository = $contactRepository;

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

        return view('admin.nowa.views.contact.index', [
            'data' => $this->contactRepository->getData($request, ['translations'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $slider = $this->contactRepository->model;

        $url = locale_route('contact.store', [], false);
        $method = 'POST';

        /*return view('admin.pages.slider.form', [
            'slider' => $slider,
            'url' => $url,
            'method' => $method,
        ]);*/

        return view('admin.nowa.views.contact.form', [
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
            'city_id' => 'required'
        ]);
        $saveData = $request->except('_token');
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];

        $options = [
            'coordinates' => [
                'lat' => $saveData['lat'],
                'lng' => $saveData['lng'],
            ]
        ];
        $saveData['options'] = json_encode($options);

        unset($saveData['lat'],$saveData['lng']);


        $slider = $this->contactRepository->create($saveData);

        // Save Files
        if ($request->hasFile('images')) {
            $slider = $this->contactRepository->saveFiles($slider->id, $request);
        }

        return redirect(locale_route('contact.index', $slider->id))->with('success', __('admin.create_successfully'));

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param string $locale
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(string $locale, Contact $contact)
    {
        $url = locale_route('contact.update', $contact->id, false);
        $method = 'PUT';

        /*return view('admin.pages.slider.form', [
            'slider' => $slider,
            'url' => $url,
            'method' => $method,
        ]);*/

        return view('admin.nowa.views.contact.form', [
            'model' => $contact,
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
    public function update(Request $request, string $locale, Contact $contact)
    {
        $request->validate([
            'city_id' => 'required'
        ]);
        $saveData = $request->except('_token');
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];

        $options = [
            'coordinates' => [
                'lat' => $saveData['lat'],
                'lng' => $saveData['lng'],
            ]
        ];
        $saveData['options'] = json_encode($options);

        unset($saveData['lat'],$saveData['lng']);

        $this->contactRepository->update($contact->id, $saveData);

        $this->contactRepository->saveFiles($contact->id, $request);


        return redirect(locale_route('contact.index', $contact->id))->with('success', __('admin.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $locale
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(string $locale, Contact $contact)
    {
        if (!$this->contactRepository->delete($contact->id)) {
            return redirect(locale_route('contact.index', $contact->id))->with('danger', __('admin.not_delete_message'));
        }
        return redirect(locale_route('contact.index'))->with('success', __('admin.delete_message'));
    }
}
