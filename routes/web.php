<?php

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
use App\MoonShine\Controllers\MoonshineCompany;
use App\MoonShine\Controllers\MoonshineContact;
use App\MoonShine\Controllers\MoonshineHome;
use App\MoonShine\Controllers\MoonshineNew;
use App\MoonShine\Controllers\MoonshineServiceModule;
use App\MoonShine\Controllers\MoonshineSetting;
use App\MoonShine\Controllers\MoonshineUsefulModule;
use Illuminate\Support\Facades\Route;

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

Route::controller(FancyBoxController::class)->group(function () {
    Route::post('/fancybox-ajax', 'fancybox');
});

Route::controller(FancyBoxSendingFromFormController::class)->group(function () {
    Route::post('/subscription_me', 'fancyboxSubscriptionMe');
    Route::post('/request_for_training', 'fancyboxRequestForTraining');
    Route::post('/call_me', 'fancyboxCallMe');
    Route::post('/consult_me', 'fancyboxConsultMe');
});

/**
 * ///fancybox-ajax
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
Route::get('/login', [MoonshineHome::class, 'login' ])->name('login');

