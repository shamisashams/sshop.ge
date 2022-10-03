<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GalleryRequest;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\File;
use App\Models\Gallery;
use App\Models\Partner;
use App\Models\Product;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\GalleryRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{



    public function __construct(

    )
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(GalleryRequest $request)
    {
        $url = locale_route('partner.update', false);
        $method = 'PUT';

        return view('admin.nowa.views.partner.form', [
            'partners' => Partner::query()->orderBy('company_name')->get(),
            'url' => $url,
            'method' => $method
        ]);
    }







    public function update(Request $request, string $locale)
    {

        //dd($request->all());

        $partners = Partner::all();
        //dd($request->all());
        if (count($partners)) {

            foreach ($partners as $file) {
                if (!$request->old_images) {
                    if (Storage::exists('public/partners/' . $file->title)) {
                        Storage::delete('public/partners/' . $file->title);
                    }
                    $file->delete();

                    continue;
                }
                if (!in_array((string)$file->id, $request->old_images, true)) {
                    if (Storage::exists('public/partners/' . $file->title)) {
                        Storage::delete('public/partners/' . $file->title);
                    }
                    $file->delete();
                }

                $file->update(['company_name' => isset($request->post('company_name')[$file->id]) ? $request->post('company_name')[$file->id] : null]);
            }
        }


        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $key => $file) {
                $imagename = date('Ymhs') . str_replace(' ', '', $file->getClientOriginalName());
                $destination = base_path() . '/storage/app/public/partners';
                $request->file('images')[$key]->move($destination, $imagename);
                Partner::query()->create([
                    'title' => $imagename,
                    'path' => 'storage/partners',
                    'format' => $file->getClientOriginalExtension(),
                ]);
            }
        }


        return redirect(locale_route('partner.index'))->with('success', __('admin.update_successfully'));
    }

}
