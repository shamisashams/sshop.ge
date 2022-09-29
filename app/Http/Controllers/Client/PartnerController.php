<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\CredentialChanged;
use App\Mail\PartnerJoined;
use App\Models\Certificate;
use App\Models\Page;
use App\Models\User;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Repositories\Eloquent\GalleryRepository;
use function PHPUnit\Framework\at;

class PartnerController extends Controller
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

        return Inertia::render('PartnerJoin', ["page" => $page, "seo" => [
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

    public function store(Request $request){
        $attributes = $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'cv' => 'nullable'
        ]);

        $attributes['is_partner'] = 1;

        $attributes['affiliate_id'] = (string) Str::uuid();

        //$password =  Str::random(8);

        $attributes['status'] = 'pending';
        //$attributes['password'] = Hash::make($password);
        //dd($attributes);
        $model = $this->userRepository->create(Arr::except($attributes,['cv']));

        $username = $attributes['name'] . '_' . uniqid();
        $this->userRepository->model->partner()->create(['username' => $username]);
        //dd($model);
        $this->userRepository->uploadCv($model, $request);

        /*$data = [
            'username' => $username,
            'password' => $password
        ];*/
        //Mail::to($model)->send(new PartnerJoined($data));

        return redirect()->back()->with('success',__('client.success_partner_register'));
    }

    public function cabinet(){
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

        return Inertia::render('AccountSettings', ["page" => $page, "seo" => [
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


    public function bankAccount(){
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

        return Inertia::render('BankAccount', [
            "bank_account" => auth()->user()->bankAccount,
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

    public function saveBankAccount(Request $request){
        $data = $request->validate([
            'bank_id' => 'required',
            'account_number' => 'required'
        ]);

        auth()->user()->bankAccount()->updateOrCreate(['user_id' => auth()->id()],$data);

        return redirect()->back()->with('success',__('client.success_save'));
    }

    public function withdraw(){
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

        return Inertia::render('WithdrawFunds', [
            "bank_accounts" => auth()->user()->bankAccounts,
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

    public function withdrawCreate(Request $request){

        $bankAccount = auth()->user()->bankAccount()->where('id',$request->post('bank_account'))->first();
        dd($bankAccount);
    }

    public function referrals(){
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

        return Inertia::render('AffiliationsList', ["page" => $page, "seo" => [
            "title"=>$page->meta_title,
            "description"=>$page->meta_description,
            "keywords"=>$page->meta_keyword,
            "og_title"=>$page->meta_og_title,
            "og_description"=>$page->meta_og_description,
//            "image" => "imgg",
//            "locale" => App::getLocale()
        ], 'gallery_img' => $files,
            'images' => $images,
            'referrals' => auth()->user()->referrals()->orderBy('created_at','desc')->paginate(1)
        ])->withViewData([
            'meta_title' => $page->meta_title,
            'meta_description' => $page->meta_description,
            'meta_keyword' => $page->meta_keyword,
            "image" => $page->file,
            'og_title' => $page->meta_og_title,
            'og_description' => $page->meta_og_description
        ]);
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

        return Inertia::render('OrderHistory', [
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

        return Inertia::render('OrderDetails', [
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

    public function updateInfo(Request $request){
        //dd($request->all());
        if(count(auth()->user()->files) > 0){
            $data = $request->validate([
                'address' => 'required',
                'phone' => 'required',
                'email' => 'required|email|unique:users,email,' . auth()->id(),
                'id_number' => 'required',
                'name' => 'required',
                'surname' => 'required'
            ]);
        } else {
            $data = $request->validate([
                'address' => 'required',
                'phone' => 'required',
                'email' => 'required|email|unique:users,email,' . auth()->id(),
                'avatar' => 'required',
                'id_number' => 'required',
                'name' => 'required',
                'surname' => 'required'
            ]);
        }


        $data = Arr::except($data,'avatar');

        //dd($data);

        $this->userRepository->update(auth()->id(),$data);

        $this->userRepository->uploadId($request);

        return redirect()->back()->with('success',__('client.success_save'));
    }

    public function referralRemove(Request $request){
        User::query()->where('referred_by',auth()->user()->affiliate_id)->where('id',$request->get('id'))->update(['referred_by' => null]);
        return redirect()->back()->with('success',__('client.success_referral_remove'));
    }
}
