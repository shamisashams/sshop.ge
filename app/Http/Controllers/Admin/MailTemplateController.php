<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderRequest;
use App\Models\City;
use App\Models\MailTemplate;
use App\Models\PromoCode;
use App\Models\Slider;
use App\Models\Stock;
use App\Repositories\Eloquent\CityRepository;
use App\Repositories\Eloquent\PromoCodeRepository;
use App\Repositories\Eloquent\StockRepository;
use App\Repositories\SliderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MailTemplateController extends Controller
{




    public function __construct(

    )
    {


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $slider = MailTemplate::where('id',1)->first();

        $url = locale_route('mail-template.update', [], false);
        $method = 'PUT';

        return view('admin.nowa.views.mail_template.index', [
            'model' => $slider,
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
    public function update(Request $request, string $locale)
    {

        $saveData = $request->except(['_token','_method']);


        $model = MailTemplate::first();
        $model->update($saveData);

        //$this->promoCodeRepository->saveFiles($promoCode->id, $request);


        return redirect(locale_route('mail-template.index'))->with('success', __('admin.update_successfully'));
    }


}
