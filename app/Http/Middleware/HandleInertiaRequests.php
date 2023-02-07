<?php

namespace App\Http\Middleware;

use App\Cart\Facade\Cart;
use App\Models\Setting;
use App\Models\Wishlist;
use App\Repositories\Eloquent\CategoryRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'client/base';

    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository){
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function share(Request $request)
    {
        //$this->settings();
        $locales = config("translatable.locales");
        $currentRoute = url()->current();

        $categories = $this->categoryRepository->getVisibleCategoryTree();



        $result = $this->buildTree($categories);

        dd($result);

        $info = [];

        $info = Setting::with(['translations'])->get();

        //dd($result);
        $_result = [];
        foreach ($info as $item){
            $_result[$item->key] = $item->value;
            $_result['active'][$item->key] = $item->active;
        }

        //dd($result);
        //Generates urls for language switcher with each locale
        $locale_urls = $this->locale_urls();
        //Generates link for go back button
        $urlPrev = $this->urlPrev();
        return array_merge(parent::share($request), [
            "locales" => $locales,
            "pathname" => $currentRoute,
            "locale_urls" => $locale_urls,
            'urlPrev'	=> $urlPrev,
            'categories' => $result,
            'info' => $_result,
            'user' => auth()->user(),
            'affiliate_link' => auth()->user() ? url('/registration') . '?ref=' .auth()->user()->affiliate_id : null,
            'cart_count' => Cart::count(),
            'wishlist_count' => Wishlist::query()->where('user_id',auth()->id())->count(),
            'flash' => $this->getFlash()
        ]);
    }

    private function getFlash(){
        $arr = [
          'error' => null,
          'warning' => null,
          'success' => null,
          'danger' => null
        ];
        if(session('error')){
            $arr['error'] = session('error');
        }
        if(session('warning')){
            $arr['warning'] = session('warning');
        }
        if(session('success')){
            $arr['success'] = session('success');
        }
        if(session('danger')){
            $arr['danger'] = session('danger');
        }
        return $arr;
    }

    private function buildTree($data){
        $result = [];

        foreach ($data as $key => $category){
            $result[$key]['title'] = $category->title;
            $result[$key]['id'] = $category->id;
            $result[$key]['slug'] = $category->slug;
            $result[$key]['status'] = $category->status;
            $result[$key]['position'] = $category->position;
            $result[$key]['children'] = [];
            $result[$key]['files'] = $category->files;
            $result[$key]['file'] = $category->file;
            $result[$key]['depth'] = $category->depth;
            $result[$key]['on_page'] = $category->on_page;
            $result[$key]['url_path'] = $category->url_path;
            if(count($category->children)){
                $result[$key]['children'] = $this->buildTree($category->children);
            }
        }

        return $result;
    }

    /**
     * @return string
     */
    protected function urlPrev()
    {
        //Generates link for go back button
        if (url()->previous() !== route('login') && url()->previous() !== '' && url()->previous() !== url()->current()) {
            return url()->previous();
        }else {
            return "/";
        }
    }

    /**
     * @return array
     */
    protected function locale_urls()
    {
        $locales = config("translatable.locales");
        $routes = [];
        foreach ($locales as $key => $val)
        {
         $routes[$key] = get_url($val);
        }
        return $routes;
    }

    protected function settings()
    {
        $gphone = "";
        $gemail = "";
        $gaddress = "";
        $gcity = "";
        $gcountry = "";
        $ginstagram = "";
        $gfacebook = "";

        $settings = Setting::with(['translations'])->get();
        foreach ($settings as $setting) {
            switch ($setting->key) {
                case "phone":
                    $gphone = $setting;
                    break;
                case "email":
                    $gemail = $setting;
                    break;
                case "address":
                    $gaddress = $setting;
                    break;
                case "instagram":
                    $ginstagram = $setting;
                    break;
                case "facebook":
                    $gfacebook = $setting;
                    break;
                case "city":
                    $gcity = $setting;
                    break;
                case "country":
                    $gcountry = $setting;
                    break;
            }
        }

        Inertia::share([
            "gphone" => $gphone,
            "gemail" => $gemail,
            "gaddress" => $gaddress,
            "ginstagram" => $ginstagram,
            "gfacebook" => $gfacebook,
            "gcity" => $gcity,
            "gcountry" => $gcountry
        ]);
    }

}
