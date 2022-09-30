<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Certificate;
use App\Models\Page;
use Inertia\Inertia;
use App\Repositories\Eloquent\GalleryRepository;

class NewsController extends Controller
{
    protected $galleryRepository;

    public function __construct(GalleryRepository $galleryRepository){
        $this->galleryRepository = $galleryRepository;
    }

    public function index()
    {
        $page = Page::where('key', 'blogs')->firstOrFail();

        $images = [];
        foreach ($page->sections as $sections){
            if($sections->file){
                $images[] = asset($sections->file->getFileUrlAttribute());
            } else {
                $images[] = null;
            }

        }

        $files = [];


        $blogs = News::orderBy('created_at','desc')->with(['translation','latestImage'])->paginate(6);
        //dd($blogs);
        //dd($blogs);

        return Inertia::render('News', ["page" => $page, "seo" => [
            "title"=>$page->meta_title,
            "description"=>$page->meta_description,
            "keywords"=>$page->meta_keyword,
            "og_title"=>$page->meta_og_title,
            "og_description"=>$page->meta_og_description,
//            "image" => "imgg",
//            "locale" => App::getLocale()
        ], 'news' => $blogs,'blog_images' => $files, 'images' => $images])->withViewData([
            'meta_title' => $page->meta_title,
            'meta_description' => $page->meta_description,
            'meta_keyword' => $page->meta_keyword,
            "image" => $page->file,
            'og_title' => $page->meta_og_title,
            'og_description' => $page->meta_og_description
        ]);
    }

    public function show(string $locale, string $slug)
    {
        //\Illuminate\Support\Facades\DB::enableQueryLog();


        $blog = News::query()->where('slug',$slug)->with(['translation','latestImage'])->firstOrFail();

        //$related_blogs = News::query()->where('id','!=',$blog->id)->with(['translation','latestImage'])->limit(4)->inRandomOrder()->get();

        /*foreach ($blog->products as $product){
            $prices = [];

            foreach ($product->variants as $variant){
                $prices[] = $variant->special_price ? $variant->special_price : $variant->price;
            }

            $product['min_price'] = !empty($prices) ? min($prices) : 0;
        }*/

        return Inertia::render('NewsSingle',[
            'product' => null,
            'category_path' => null,
            'similar_products' => null,
            'product_images' => null,
            'product_attributes' => null,
            'news' => $blog,
            "seo" => [
                "title"=>$blog->meta_title,
                "description"=>$blog->meta_description,
                "keywords"=>$blog->meta_keyword,
                "og_title"=>$blog->meta_title,
                "og_description"=>$blog->meta_description,
//            "image" => "imgg",
//            "locale" => App::getLocale()
            ]
        ])->withViewData([
            'meta_title' => $blog->meta_title,
            'meta_description' => $blog->meta_description,
            'meta_keyword' => $blog->meta_keyword,
            "image" => null,
            'og_title' => $blog->meta_title,
            'og_description' => $blog->meta_description,
        ]);
    }
}
