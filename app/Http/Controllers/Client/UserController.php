<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Order;
use App\Models\Page;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Repositories\Eloquent\GalleryRepository;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $page = Page::where('key', 'about')->firstOrFail();

        $images = [];
        foreach ($page->sections as $sections){
            if($sections->file){
                $images[] = asset($sections->file->getFileUrlAttribute());
            } else {
                $images[] = null;
            }

        }

        $files = [];
        if($page->images) $files = $page->files;

        //dd($files);

        return Inertia::render('RegularCabinet', ["page" => $page, "seo" => [
            "title"=>$page->meta_title,
            "description"=>$page->meta_description,
            "keywords"=>$page->meta_keyword,
            "og_title"=>$page->meta_og_title,
            "og_description"=>$page->meta_og_description,
//            "image" => "imgg",
//            "locale" => App::getLocale()
        ], 'gallery_img' => $files,'images' => $images])->withViewData([
            'meta_title' => $page->meta_title,
            'meta_description' => $page->meta_description,
            'meta_keyword' => $page->meta_keyword,
            "image" => $page->file,
            'og_title' => $page->meta_og_title,
            'og_description' => $page->meta_og_description
        ]);
    }

    public function saveSettings(Request $request){

        $data = $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'id_number' => 'required'
        ]);

        auth()->user()->update($data);
        return redirect()->back()->with('success',__('client.success_saved'));
    }



    public function orders(){
        $page = Page::where('key', 'about')->firstOrFail();

        $images = [];
        foreach ($page->sections as $sections){
            if($sections->file){
                $images[] = asset($sections->file->getFileUrlAttribute());
            } else {
                $images[] = null;
            }

        }

        $files = [];
        if($page->images) $files = $page->files;

        //dd($files);

        return Inertia::render('RegularOrderHistory', [
            "orders" => auth()->user()->orders()->orderBy('created_at','desc')->paginate(3),
            "page" => $page, "seo" => [
            "title"=>$page->meta_title,
            "description"=>$page->meta_description,
            "keywords"=>$page->meta_keyword,
            "og_title"=>$page->meta_og_title,
            "og_description"=>$page->meta_og_description,
//            "image" => "imgg",
//            "locale" => App::getLocale()
        ], 'gallery_img' => $files,'images' => $images])->withViewData([
            'meta_title' => $page->meta_title,
            'meta_description' => $page->meta_description,
            'meta_keyword' => $page->meta_keyword,
            "image" => $page->file,
            'og_title' => $page->meta_og_title,
            'og_description' => $page->meta_og_description
        ]);
    }
    public function orderDetails($locale, $order_id){
        //dd($order);
        $page = Page::where('key', 'about')->firstOrFail();

        $images = [];
        foreach ($page->sections as $sections){
            if($sections->file){
                $images[] = asset($sections->file->getFileUrlAttribute());
            } else {
                $images[] = null;
            }

        }

        $files = [];
        if($page->images) $files = $page->files;


        $order = auth()->user()->orders()->where('id',$order_id)->with(['items','collections','collections.items'])->firstOrFail();

        //dd($order);

        return Inertia::render('RegularOrderDetails', [
            "order" => $order,
            "page" => $page, "seo" => [
            "title"=>$page->meta_title,
            "description"=>$page->meta_description,
            "keywords"=>$page->meta_keyword,
            "og_title"=>$page->meta_og_title,
            "og_description"=>$page->meta_og_description,
//            "image" => "imgg",
//            "locale" => App::getLocale()
        ], 'gallery_img' => $files,'images' => $images])->withViewData([
            'meta_title' => $page->meta_title,
            'meta_description' => $page->meta_description,
            'meta_keyword' => $page->meta_keyword,
            "image" => $page->file,
            'og_title' => $page->meta_og_title,
            'og_description' => $page->meta_og_description
        ]);
    }

    public function invoice($locale, $order_id){
        //dd($order);
        $page = Page::where('key', 'about')->firstOrFail();

        $images = [];
        foreach ($page->sections as $sections){
            if($sections->file){
                $images[] = asset($sections->file->getFileUrlAttribute());
            } else {
                $images[] = null;
            }

        }

        $files = [];
        if($page->images) $files = $page->files;


        $order = auth()->user()->orders()->where('id',$order_id)->with(['items','collections','collections.items'])->firstOrFail();

        //dd($order);

        return Inertia::render('Invoice', [
            "order" => $order,
            "page" => $page, "seo" => [
                "title"=>$page->meta_title,
                "description"=>$page->meta_description,
                "keywords"=>$page->meta_keyword,
                "og_title"=>$page->meta_og_title,
                "og_description"=>$page->meta_og_description,
//            "image" => "imgg",
//            "locale" => App::getLocale()
            ], 'gallery_img' => $files,'images' => $images])->withViewData([
            'meta_title' => $page->meta_title,
            'meta_description' => $page->meta_description,
            'meta_keyword' => $page->meta_keyword,
            "image" => $page->file,
            'og_title' => $page->meta_og_title,
            'og_description' => $page->meta_og_description
        ]);
    }
}
