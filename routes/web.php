<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Axios\AxiosController;
use App\Http\Controllers\Axios\AxiosSendingFromFormController;
use App\Http\Controllers\Axios\AxiosUploadPhotoController;
use App\Http\Controllers\Cabinet\CabinetUser\CabinetUserController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FancyBox\FancyBoxController;
use App\Http\Controllers\FancyBox\FancyBoxSendingFromFormController;
use App\Http\Controllers\Fetch\FetchCityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Mzp\MzpController;
use App\Http\Controllers\Search\SearchController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\SiteNew\SiteNewController;
use App\Http\Controllers\Tax\TaxController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UseFul\UseFulController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\UserMiddleware;
use App\MoonShine\Controllers\MoonshineCompany;
use App\MoonShine\Controllers\MoonshineContact;
use App\MoonShine\Controllers\MoonshineHome;
use App\MoonShine\Controllers\MoonshineNew;
use App\MoonShine\Controllers\MoonshineServiceModule;
use App\MoonShine\Controllers\MoonshineSetting;
use App\MoonShine\Controllers\MoonshineUsefulModule;
use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

/**
 * админка
 */
Route::post('/moonshine/home', [MoonshineHome::class, 'home' ]);
Route::post('/moonshine/setting', [MoonshineSetting::class, 'setting' ]);
Route::post('/moonshine/contact', [MoonshineContact::class, 'contact' ]);
Route::post('/moonshine/new', [MoonshineNew::class, 'new' ]);
Route::post('/moonshine/company', [MoonshineCompany::class, 'company' ]);
Route::post('/moonshine/useful_module', [MoonshineUsefulModule::class, 'useful_module' ]);
Route::post('/moonshine/service_module', [MoonshineServiceModule::class, 'service_module' ]);
/**
 * админка
 */

/**
 * fancybox-ajax
 */
/** получение самой формы */
Route::controller(FancyBoxController::class)->group(function () {
    Route::post('/fancybox-ajax', 'fancybox');
});
/** Отправка самой формы */
Route::controller(FancyBoxSendingFromFormController::class)->group(function () {
    Route::post('/subscription_me', 'fancyboxSubscriptionMe');
    Route::post('/request_for_training', 'fancyboxRequestForTraining');
    Route::post('/call_me', 'fancyboxCallMe');
    Route::post('/consult_me', 'fancyboxConsultMe');

});

/**
 * ///fancybox-ajax
 *//**
 *
 *
 * axios
 */
 /** получение самой формы */
Route::controller(AxiosController::class)->group(function () {
    Route::post('/upload-form-async', 'async');
});
/** Отправка самой формы */
Route::controller(AxiosSendingFromFormController::class)->group(function () {
    Route::post('/call_me_blue', 'axiosCallMeBlue');

});


/**
 * ///axios
 */

Route::controller(TestController::class)->group(function () {
    Route::get('/test', 'test')->name("test");
});

/** Контакты **/

Route::controller(ContactController::class)->group(function () {
    Route::get('/contacts', 'contacts')->name("contacts");
});

/** ///Контакты **/

/** Главная **/

Route::get('/', [HomeController::class, 'index' ])->name('home');

/** ///Главная **/

/**  запросы fetch **/
Route::controller(FetchCityController::class)->group(function () {
    Route::post('/set.city.default', 'setCityDefault');
});

/** Страницы сайта
 *********************************
 *********************************/

/** О нас **/

Route::controller(CompanyController::class)->group(function () {

    Route::get(config2('moonshine.company.slug'), 'categories')->name('company_categories');
    Route::get(config2('moonshine.company.slug') . '/{category_slug}', 'category')->name('company_category');
    Route::get(config2('moonshine.company.slug') . '/{category_slug}/{item_slug}', 'item')->name('company_item');

});

/** ///О нас **/

/** Новости **/

Route::controller(SiteNewController::class)->group(function () {
    Route::get(config2('moonshine.new.slug'), 'categories')->name('site_new_categories');
    Route::get(config2('moonshine.new.slug') . '/{category_slug}', 'category')->name('site_new_category');
    Route::get(config2('moonshine.new.slug') . '/{category_slug}/{item_slug}', 'item')->name('site_new_item');
});

/** ///Новости **/

/** Полезное **/

Route::controller(UseFulController::class)->group(function () {

 Route::get('section-{useful:slug}', 'section')->name('useful_section');
 Route::get('section-{useful:slug}/{category_slug}', 'category')->name('useful_category');
 Route::get('section-{useful:slug}/{category_slug}/{subcategory_slug}', 'subcategory')->name('useful_subcategory');
 Route::get('section-{useful:slug}/{category_slug}/{subcategory_slug}/{item_slug}', 'item')->name('useful_item');

});

/** ///Полезное **/

/** Услуги **/

Route::controller(ServiceController::class)->group(function () {

 Route::get('service-{service:slug}', 'section')->name('service_section');
 Route::get('service-{service:slug}/{category_slug}', 'category')->name('service_category');
 Route::get('service-{service:slug}/{category_slug}/{item_slug}', 'item')->name('service_item');

});

/** ///Услуги **/

/** Налоговый календарь **/

Route::controller(TaxController::class)->group(function () {

    Route::get('/tax-calendar/{item_slug}', 'taxCalendar')->name('tax_calendar');

});

/** ///Налоговый календарь **/

/** МЗП  **/

Route::controller(MzpController::class)->group(function () {

    Route::get('/mzp', 'items')->name('mzp_items');
    Route::get('/mzp/{item_slug}', 'item')->name('mzp_item');

});

/** ///МЗП **/

/** Поиск **/

Route::controller(SearchController::class)->group(function () {

    Route::match(['get', 'post'],'search', 'search')->name('search');


});

/** ///Поиск **/


/** Login */
/**
 * Auth
 */

Route::controller(SignInController::class)->group(function () {

    Route::get('/login', 'login')
        ->middleware(RedirectIfAuthenticated::class)
        ->name('login');

    Route::post('/login', 'handleLogin')
        ->middleware(RedirectIfAuthenticated::class)
        ->name('handle_login');

});

Route::controller(SignUpController::class)->group(function () {

       Route::get('/sign-up', 'signUp')
            ->middleware(RedirectIfAuthenticated::class)
           ->name('sign_up');

        Route::post('/sign-up', 'handleSignUp')->middleware(ProtectAgainstSpam::class)
            ->name('handle_sign_up');

});

Route::controller(ForgotPasswordController::class)->group(function () {

        Route::get('/forgot-password', 'forgot')
            ->name('forgot')
            ->middleware(RedirectIfAuthenticated::class);

        Route::post('/forgot-password', 'handleForgot')
            ->name('handel_forgot')
            ->middleware(RedirectIfAuthenticated::class);

});

Route::controller(ResetPasswordController::class)->group(function () {

    /*    Route::get('/reset-password/{token}','page')
            ->name('password.reset')
            ->middleware(RedirectIfAuthenticated::class);

        Route::post('/reset-password', 'handle')
            ->name('password.handle')
            ->middleware(RedirectIfAuthenticated::class);*/

});

Route::controller(LogoutController::class)->group(function () {

    Route::post('/logout', 'logout')->name('logout');

});

/**
 *  ///Auth
 */
/** Cabinet_user */
Route::controller(CabinetUserController::class)->group(function () {

     /** кабинет  */
    Route::get('/cabinet', 'cabinetUser')
        ->name('cabinet_user')
        ->middleware(UserMiddleware::class);

    /** кабинет страница обновления  */
    Route::get('/cabinet/setting/update', 'cabinetUserUpdate')
        ->name('cabinet_user_update')
        ->middleware(UserMiddleware::class);

    /** кабинет метод обновления  */
    Route::put('/cabinet/setting/update', 'cabinetUserUpdateHandel')
        ->name('cabinet_user_update_handel')
        ->middleware(UserMiddleware::class);

    /** тариф  */
    Route::get('/cabinet/pricing', 'cabinetPricing')
        ->name('cabinet_pricing')
        ->middleware(UserMiddleware::class);

});


/** ** аватар  **   **/
Route::controller(AxiosUploadPhotoController::class)->group(function () {

    Route::post('/cabinet.upload.photo', 'uploadPhoto')
        ->middleware(UserMiddleware::class);

});

/** ** аватар  **   **/
/** ///Cabinet_user */


