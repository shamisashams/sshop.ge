<?php
/**
 *  routes/web.php
 *
 * Date-Time: 03.06.21
 * Time: 15:41
 * @author Insite LLC <hello@insite.international>
 */

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TranslationController;
use App\Http\Controllers\CKEditorController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\AboutUsController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::post('ckeditor/image_upload', [CKEditorController::class, 'upload'])->withoutMiddleware('web')->name('upload');

Route::any('bog/callback/status', [\App\BogPay\BogCallbackController::class, 'status'])->withoutMiddleware('web')->name('bogCallbackStatus');
Route::any('bog/callback/refund',[\App\BogPay\BogCallbackController::class, 'refund'])->withoutMiddleware('web')->name('bogCallbackRefund');

Route::any('space/callback/status', [\App\SpacePay\SpaceCallbackController::class, 'status'])->withoutMiddleware('web')->name('spaceCallbackStatus');




Route::redirect('', config('translatable.fallback_locale'));
Route::prefix('{locale?}')
    ->group(function () {
        Route::prefix('adminpanel')->group(function () {
            Route::get('login', [LoginController::class, 'loginView'])->name('loginView');
            Route::post('login', [LoginController::class, 'login'])->name('login');


            Route::middleware(['auth','is_admin'])->group(function () {
                Route::get('logout', [LoginController::class, 'logout'])->name('logout');

                Route::redirect('', 'adminpanel/category');

                // Language
                Route::resource('language', LanguageController::class);
                Route::get('language/{language}/destroy', [LanguageController::class, 'destroy'])->name('language.destroy');

                // Translation
                Route::resource('translation', TranslationController::class);

                // Category
                Route::resource('category', \App\Http\Controllers\Admin\CategoryController::class);
                Route::get('category/{category}/destroy', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('category.destroy');
                Route::get('category/{category}/add_color',[\App\Http\Controllers\Admin\CategoryController::class,'addColor'])->name('category.add-color');
                Route::post('category/{category}/store_color',[\App\Http\Controllers\Admin\CategoryController::class,'storeColor'])->name('category.store_color');
                Route::get('category/{category}/{category_color}/edit_color',[\App\Http\Controllers\Admin\CategoryController::class,'editColor'])->name('category.edit_color');
                Route::put('category/{category}/{category_color}/update_color',[\App\Http\Controllers\Admin\CategoryController::class,'updateColor'])->name('category.update_color');
                Route::get('category/{category}/{category_color}/delete_color',[\App\Http\Controllers\Admin\CategoryController::class,'deleteColor'])->name('category.delete_color');
//
                // Product
                Route::resource('product', \App\Http\Controllers\Admin\ProductController::class);
                Route::get('product/{product}/destroy', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('product.destroy');
                Route::post('product/{product?}/upload-cropped',[\App\Http\Controllers\Admin\ProductController::class, 'uploadCropped'])->name('product.crop-upload');
                Route::get('product/{product}/add_color',[\App\Http\Controllers\Admin\ProductController::class,'addColor'])->name('product.add-color');
                Route::post('product/{product}/store_color',[\App\Http\Controllers\Admin\ProductController::class,'storeColor'])->name('product.store_color');
                Route::get('product/{product}/{product_color}/edit_color',[\App\Http\Controllers\Admin\ProductController::class,'editColor'])->name('product.edit_color');
                Route::put('product/{product}/{product_color}/update_color',[\App\Http\Controllers\Admin\ProductController::class,'updateColor'])->name('product.update_color');
                Route::get('product/{product}/{product_color}/delete_color',[\App\Http\Controllers\Admin\ProductController::class,'deleteColor'])->name('product.delete_color');
                Route::post('product/import',[\App\Http\Controllers\Admin\ProductController::class,'import'])->name('product.import');
//

                Route::post('product/search',[\App\Http\Controllers\Admin\NewsController::class,'getProducts'])->name('product.search.ajax');


                Route::post('group-search',[\App\Http\Controllers\Admin\ProductController::class,'getGroups'])->name('search.group');

                Route::get('product/variant/{product}/create',[\App\Http\Controllers\Admin\ProductController::class, 'variantCreate'])->name('product.variant.create');
                Route::post('product/variant/{product}/store',[\App\Http\Controllers\Admin\ProductController::class, 'variantStore'])->name('product.variant.store');

//                // Gallery
                Route::resource('gallery', GalleryController::class);
                Route::get('gallery/{gallery}/destroy', [GalleryController::class, 'destroy'])->name('gallery.destroy');



                // Slider
                Route::resource('slider', SliderController::class);
                Route::get('slider/{slider}/destroy', [SliderController::class, 'destroy'])->name('slider.destroy');

                // Page
                Route::resource('page', PageController::class);
                Route::get('page/{page}/destroy', [PageController::class, 'destroy'])->name('page.destroy');


                Route::get('setting/active',[SettingController::class,'setActive'])->name('setting.active');
                // Setting
                Route::resource('setting', SettingController::class);
                Route::get('setting/{setting}/destroy', [SettingController::class, 'destroy'])->name('setting.destroy');

                Route::get('order/export', [\App\Http\Controllers\Admin\OrderController::class, 'export'])->name('order.export');
                Route::resource('order', \App\Http\Controllers\Admin\OrderController::class);
                //Route::get('order/{order}/destroy', [\App\Http\Controllers\Admin\OrderController::class, 'destroy'])->name('order.destroy');


                // Password
                Route::get('password', [\App\Http\Controllers\Admin\PasswordController::class, 'index'])->name('password.index');
                Route::post('password', [\App\Http\Controllers\Admin\PasswordController::class, 'update'])->name('password.update');

                Route::resource('attribute', \App\Http\Controllers\Admin\AttributeController::class);
                Route::get('attribute/{attribute}/destroy', [\App\Http\Controllers\Admin\AttributeController::class, 'destroy'])->name('attribute.destroy');

                Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);
                Route::get('news/{news}/destroy', [\App\Http\Controllers\Admin\NewsController::class, 'destroy'])->name('news.destroy');




                //Partners
                Route::get('partner', [\App\Http\Controllers\Admin\PartnerController::class,'index'])->name('partner.index');
                Route::put('partner', [\App\Http\Controllers\Admin\PartnerController::class,'update'])->name('partner.update');

                Route::resource('user', \App\Http\Controllers\Admin\UserController::class);
                Route::get('user/{user}/destroy', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('user.destroy');


                Route::resource('city', \App\Http\Controllers\Admin\CityController::class);
                Route::get('city/{city}/destroy', [\App\Http\Controllers\Admin\CityController::class, 'destroy'])->name('city.destroy');

                Route::resource('stock', \App\Http\Controllers\Admin\StockController::class);
                Route::get('stock/{stock}/destroy', [\App\Http\Controllers\Admin\StockController::class, 'destroy'])->name('stock.destroy');

                Route::resource('team', \App\Http\Controllers\Admin\TeamController::class);
                Route::get('team/{team}/destroy', [\App\Http\Controllers\Admin\TeamController::class, 'destroy'])->name('team.destroy');

                Route::resource('contact', \App\Http\Controllers\Admin\ContactController::class);
                Route::get('contact/{contact}/destroy', [\App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('contact.destroy');

                Route::resource('promocode', \App\Http\Controllers\Admin\PromocodeController::class)->parameters(['promocode' => 'promo_code']);
                Route::get('promocode/{promo_code}/destroy', [\App\Http\Controllers\Admin\PromocodeController::class, 'destroy'])->name('promocode.destroy');

                Route::get('mail-templates',[\App\Http\Controllers\Admin\MailTemplateController::class,'index'])->name('mail-template.index');
                Route::put('mail-templates/update',[\App\Http\Controllers\Admin\MailTemplateController::class,'update'])->name('mail-template.update');

                Route::resource('collection', \App\Http\Controllers\Admin\CollectionController::class)->parameters(['collection' => 'product_set']);
                Route::get('collection/{product_set}/destroy', [\App\Http\Controllers\Admin\CollectionController::class, 'destroy'])->name('collection.destroy');
                Route::post('collection/{product_set?}/upload-cropped',[\App\Http\Controllers\Admin\CollectionController::class, 'uploadCropped'])->name('collection.crop-upload');
                Route::put('collection/coordinates/update',[\App\Http\Controllers\Admin\CollectionController::class,'coordinatesUpdate'])->name('collection.update.coordinates');
                Route::get('collection/product/{product}/remove',[\App\Http\Controllers\Admin\CollectionController::class,'removeProduct'])->name('collection.destroy.product');

                Route::post('collection/product/search',[\App\Http\Controllers\Admin\CollectionController::class,'getProducts'])->name('collection.product.search.ajax');
                Route::post('collection/{product_set}/product/add',[\App\Http\Controllers\Admin\CollectionController::class,'addProducts'])->name('product.add-to-set');
            });
        });


        Route::get('login',[\App\Http\Controllers\Client\AuthController::class,'loginView'])->name('client.login.index')->middleware('guest_client');
        Route::post('login',[\App\Http\Controllers\Client\AuthController::class,'login'])->name('client.login');
        Route::get('registration',[\App\Http\Controllers\Client\AuthController::class,'registrationView'])->name('client.registration.index');
        Route::post('registration',[\App\Http\Controllers\Client\AuthController::class,'createAccount'])->name('client.register');

        Route::get('logout',[\App\Http\Controllers\Client\AuthController::class,'logout'])->name('logout');


        Route::get('partner-signin',[\App\Http\Controllers\Client\AuthController::class,'partnerLoginView'])->name('partner.login.index')->middleware('guest_p');
        Route::post('partner-signin',[\App\Http\Controllers\Client\AuthController::class,'partnerLogin'])->name('partner.login');

        Route::middleware(['auth_partner','is_partner'])->group(function (){
            Route::get('partner/settings',[\App\Http\Controllers\Client\PartnerController::class,'cabinet'])->name('partner.settings');
            Route::get('partner/bank-account',[\App\Http\Controllers\Client\PartnerController::class,'bankAccount'])->name('partner.bank-account');
            Route::get('partner/withdraw-funds',[\App\Http\Controllers\Client\PartnerController::class,'withdraw'])->name('partner.withdraw');
            Route::get('partner/referrals',[\App\Http\Controllers\Client\PartnerController::class,'referrals'])->name('partner.referrals');
            Route::get('partner/orders',[\App\Http\Controllers\Client\PartnerController::class,'orders'])->name('partner.orders');
            Route::get('partner/order/{order}/details',[\App\Http\Controllers\Client\PartnerController::class,'orderDetails'])->name('partner.order-details');
            Route::post('partner/settings',[\App\Http\Controllers\Client\PartnerController::class,'updateInfo'])->name('partner.update-info');
            Route::post('partner/bak-account',[\App\Http\Controllers\Client\PartnerController::class,'saveBankAccount'])->name('partner.save-bank-account');
            Route::post('partner/withdraw',[\App\Http\Controllers\Client\PartnerController::class,'withdrawCreate'])->name('partner.withdraw-create');
            Route::get('partner/{referral}/remove',[\App\Http\Controllers\Client\PartnerController::class,'referralRemove'])->name('partner.referral-remove');
            Route::get('invoice/{order}',[\App\Http\Controllers\Client\UserController::class,'invoice'])->name('client.invoice');
        });

        Route::middleware(['auth_client'])->group(function (){
            Route::get('account',[\App\Http\Controllers\Client\UserController::class,'index'])->name('client.cabinet');
            Route::get('account/orders',[\App\Http\Controllers\Client\UserController::class,'orders'])->name('client.orders');
            Route::get('account/order/{order}/details',[\App\Http\Controllers\Client\UserController::class,'orderDetails'])->name('client.order-details');
            Route::get('favorites',[\App\Http\Controllers\Client\FavoriteController::class,'index'])->name('client.favorite.index');
            Route::post('favorites',[\App\Http\Controllers\Client\FavoriteController::class,'addToWishlist'])->name('client.favorite.add');
            Route::post('favorites-set',[\App\Http\Controllers\Client\FavoriteController::class,'addToWishlistCollection'])->name('client.favorite.add-set');
            Route::get('favorites/remove',[\App\Http\Controllers\Client\FavoriteController::class,'removeFromWishlist'])->name('client.favorite.remove');
            Route::post('apply-promocode',[\App\Http\Controllers\Client\CartController::class,'applyPromocode'])->name('apply-promocode');
            Route::post('shipping-submit',[\App\Http\Controllers\Client\ShippingController::class,'submitShipping'])->name('shipping-submit');
            Route::post('checkout',[\App\Http\Controllers\Client\OrderController::class,'order'])->name('client.checkout.order');
            Route::post('settings',[\App\Http\Controllers\Client\UserController::class,'saveSettings'])->name('client.save-settings');
            Route::get('invoice/{order}',[\App\Http\Controllers\Client\UserController::class,'invoice'])->name('client.invoice');
        });

        Route::post('add-to-cart',[\App\Http\Controllers\Client\CartController::class,'addToCart'])->name('add-to-cart');
        Route::post('add-to-cart-collection',[\App\Http\Controllers\Client\CartController::class,'addToCartCollection'])->name('add-to-cart-collection');
        Route::get('remove_from_cart',[\App\Http\Controllers\Client\CartController::class,'removeFromCart'])->name('remove-from-cart');
        Route::get('remove_from_cart_collection',[\App\Http\Controllers\Client\CartController::class,'removeFromCartCollection'])->name('remove-from-cart-collection');
        Route::get('get_cart',[\App\Http\Controllers\Client\CartController::class,'getCart'])->name('get_cart');
        Route::get('update_cart',[\App\Http\Controllers\Client\CartController::class,'updateCart'])->name('update_cart');
        Route::get('update_cart_collection',[\App\Http\Controllers\Client\CartController::class,'updateCartCollection'])->name('update_cart_collection');

        Route::get('sipping',[\App\Http\Controllers\Client\ShippingController::class,'index'])->name('client.shipping.index');

        Route::get('payment',[\App\Http\Controllers\Client\PaymentController::class,'index'])->name('client.payment.index');



        Route::middleware(['active'])->group(function () {

            // Home Page
            Route::get('', [HomeController::class, 'index'])->name('client.home.index');



            // Contact Page
            Route::get('/contact', [ContactController::class, 'index'])->name('client.contact.index');
            Route::post('/contact-us', [ContactController::class, 'mail'])->name('client.contact.mail');


            // About Page
            Route::get('about', [AboutUsController::class, 'index'])->name('client.about.index');

            Route::get('terms-conditions', [\App\Http\Controllers\Client\TermController::class, 'index'])->name('client.terms');

            Route::get('partner-join', [\App\Http\Controllers\Client\PartnerController::class, 'index'])->name('partner.join');
            Route::post('partner-join', [\App\Http\Controllers\Client\PartnerController::class, 'store'])->name('partner.store');

            Route::get('news', [\App\Http\Controllers\Client\NewsController::class, 'index'])->name('client.news.index');
            Route::get('news/{news}', [\App\Http\Controllers\Client\NewsController::class, 'show'])->name('client.news.show');

            Route::get('furniture-set/{slug}',[\App\Http\Controllers\Client\CollectionController::class,'show'])->name('client.collection.show');

            // Product Page
            Route::get('products', [\App\Http\Controllers\Client\ProductController::class, 'index'])->name('client.product.index');
           Route::get('product/{product}', [\App\Http\Controllers\Client\ProductController::class, 'show'])->name('client.product.show');

           Route::get('category/{category}',[\App\Http\Controllers\Client\CategoryController::class,'show'])->name('client.category.show');
            Route::get('popular',[\App\Http\Controllers\Client\CategoryController::class,'popular'])->name('client.category.popular');
            Route::get('special',[\App\Http\Controllers\Client\CategoryController::class,'special'])->name('client.category.special');
            Route::get('new',[\App\Http\Controllers\Client\CategoryController::class,'new'])->name('client.category.new');
            Route::get('sale',[\App\Http\Controllers\Client\CategoryController::class,'special'])->name('client.category.sale');

            //checkout
            Route::get('cart',[\App\Http\Controllers\Client\CartController::class,'index'])->name('client.cart.index');
            Route::get('checkout',[\App\Http\Controllers\Client\OrderController::class,'index'])->name('client.checkout.index');

            Route::get('order/success',[\App\Http\Controllers\Client\OrderController::class,'statusSuccess'])->name('order.success');
            Route::get('order/failure',[\App\Http\Controllers\Client\OrderController::class,'statusFail'])->name('order.failure');

            Route::get('search', [\App\Http\Controllers\Client\SearchController::class, 'index'])->name('search.index');

            Route::any('payments/bog/status',[\App\Http\Controllers\Client\OrderController::class, 'bogResponse'])->name('bogResponse');

            /*Route::get('test/{method}',function ($locale,$method,\App\Http\Controllers\TestController $testController){

                return $testController->{$method}();
            });

            Route::post('test/filter',[\App\Http\Controllers\TestController::class,'filter']);*/
            Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
                $request->fulfill();

                return redirect(route('client.cabinet'));
            })->middleware(['auth', 'signed'])->name('verification.verify');

            Route::post('/email/verification-notification', function (Request $request) {
                $request->user()->sendEmailVerificationNotification();

                return back()->with('message', 'Verification link sent!');
            })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
        });



        //Social-------------------------------------------------------
        Route::get('/auth/facebook/redirect', function () {
            return Socialite::driver('facebook')->redirect();
        })->name('fb-redirect');

        Route::get('/auth/facebook/callback', function () {
            //dd('jdfhgjdhjf urkl');
            $facebookUser = Socialite::driver('facebook')->stateless()->user();

            //dd($facebookUser);
            $email = uniqid();
            if ($facebookUser->email !== null) $email = $facebookUser->email;
            $user = User::updateOrCreate([
                'facebook_id' => $facebookUser->id,

            ], [
                'email' => $email,
                'name' => $facebookUser->name,
                'facebook_id' => $facebookUser->id,
                'facebook_token' => $facebookUser->token,
                'facebook_refresh_token' => $facebookUser->refreshToken,
                'avatar' => $facebookUser->avatar,
            ]);



            //dd($user);

            Auth::login($user);

            return redirect(route('profile'));
        })->name('fb-callback');

        Route::get('/auth/google/redirect', function () {
            return Socialite::driver('google')->redirect();
        })->name('google-redirect');

        Route::get('/auth/google/callback', function () {
            $googleUser = Socialite::driver('google')->user();

            //dd($googleUser);
            $user = User::updateOrCreate([
                //'facebook_id' => $facebookUser->id,
                'email' => $googleUser->email,
            ], [
                'name' => $googleUser->name,
                'google_id' => $googleUser->id,
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
                'avatar' => $googleUser->avatar,
            ]);


            //dd($user);

            Auth::login($user);

            return redirect(route('profile'));
        })->name('google-callback');
        //--------------------------------------------------------------------------
    });


