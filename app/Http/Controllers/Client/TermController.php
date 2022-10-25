<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\Team;
use Inertia\Inertia;
use App\Repositories\Eloquent\GalleryRepository;

class TermController extends Controller
{
    protected $galleryRepository;

    public function __construct(GalleryRepository $galleryRepository){
        $this->galleryRepository = $galleryRepository;
    }

    public function index()
    {
        $page = Page::where('key', 'term_condition')->firstOrFail();

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

        $gallery = Gallery::with('files')->where('status',1)->first();


        if(!$gallery){
            $gallery = [];
        } else {
            $gallery = $gallery->files;
        }
        //dd($gallery);
        //dd($files);

        return Inertia::render('TermConditions', [
            "team" => Team::with(['translation','file'])->where('status',1)->get(),
            "gallery" => $gallery,
            "page" => $page,
            "seo" => [
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
