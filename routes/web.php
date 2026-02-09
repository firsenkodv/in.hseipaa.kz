<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Axios\AxiosController;
use App\Http\Controllers\Axios\AxiosCounterPartyController;
use App\Http\Controllers\Axios\AxiosSendingFromFormController;
use App\Http\Controllers\Axios\AxiosUploadFilesController;
use App\Http\Controllers\Axios\AxiosUploadPhotoController;
use App\Http\Controllers\Cabinet\CabinetRop\CabinetROPController;
use App\Http\Controllers\Cabinet\CabinetUser\CabinetUserController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FancyBox\FancyBoxController;
use App\Http\Controllers\FancyBox\FancyBoxSendingFromFormController;
use App\Http\Controllers\Fetch\FetchCityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Mzp\MzpController;
use App\Http\Controllers\Registry\RegistryController;
use App\Http\Controllers\Search\SearchController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\SiteNew\SiteNewController;
use App\Http\Controllers\Tax\TaxController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UseFul\UseFulController;
use App\Http\Middleware\IsROPAssignedManagerMiddleware;
use App\Http\Middleware\IsROPMiddleware;
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
    Route::post('/select_tarif', 'fancyboxSelectTarif');

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
/** Проверка контрагента */
Route::controller(AxiosCounterPartyController::class)->group(function () {
    Route::post('/check.counter.party', 'checkCounterParty');

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

/** Реестр **/

Route::controller(RegistryController::class)->group(function () {

    Route::get('/registry', 'registry')->name('registry');

    Route::get('/registry/specialists', 'registrySpecialists')->name('registry_specialists');
    Route::get('/registry/specialists/specialist/{id}', 'registrySpecialist')->name('registry_specialist');

    Route::get('/registry/experts', 'registryExperts')->name('registry_experts');
    Route::get('/registry/experts/expert/{id}', 'registryExpert')->name('registry_expert');

    Route::get('/registry/legal-entities', 'registryLegalEntities')->name('registry_legal_entities');
    Route::get('/registry/legal-entities/legal-entity/{id}', 'registryLegalEntity')->name('registry_legal_entity');

    Route::get('/registry/specialists/search', 'registrySpecialistsSearch')->name('registry_specialists_search');
    Route::get('/registry/experts/search', 'registryExpertsSearch')->name('registry_experts_search');
    Route::get('/registry/legal-entities/search', 'registryLegalEntitiesSearch')->name('registry_legal_entities_search');

});

/** ///Реестр **/

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

    /** услуги  */
    Route::get('/cabinet/service', 'cabinetService')
        ->name('cabinet_service')
        ->middleware(UserMiddleware::class);

});


/** ** аватар  **   **/
Route::controller(AxiosUploadPhotoController::class)->group(function () {
    Route::post('/cabinet.upload.photo', 'uploadPhoto')
        ->middleware(UserMiddleware::class);
/** РОП меняет свой автар */
    Route::post('/cabinet.upload.photo.rop', 'uploadROPPhoto')
        ->name('upload_rop_photo')
        ->middleware(IsROPMiddleware::class);

    /** РОП меняет автар менеджера */
    Route::post('/cabinet.upload.photo.rop-manager', 'uploadROPManagerPhoto')
        ->name('upload_rop-manager_photo')
        ->middleware(IsROPMiddleware::class);

    /** РОП меняет автар пользователя */
    Route::post('/cabinet.upload.photo.rop-user', 'uploadROPUserPhoto')
        ->name('upload_rop-user_photo')
        ->middleware(IsROPMiddleware::class);

});
/** ** аватар  **   **/
/** ** загрузка файлов  **   **/
Route::controller(AxiosUploadFilesController::class)->group(function () {
    Route::post('/cabinet.upload.files', 'uploadFiles')
        ->middleware(UserMiddleware::class);
    Route::post('/cabinet.delete.files', 'deleteFiles')
        ->middleware(UserMiddleware::class);
});
/** ** загрузка файлов  **   **/
/** ** новый токен ** **/
Route::get('/refresh-csrf', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});
/** ** новый токен ** **/
/** ///Cabinet_user */

/**
 * РОП
 */
Route::controller(CabinetROPController::class)->group(function () {

    /** вход  */
    Route::get('/rop', 'ropLogin')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_login');

    Route::post('/rop_login_handle', 'ropLoginHandle')
        ->name('rop_login_handle');

    /** кабинет  */
    Route::get('/cabinet-rop', 'cabinetRop')
        ->middleware(IsROPMiddleware::class)
        ->name('cabinet_rop');

    Route::post('/logout_rop', 'logoutRop')
        ->middleware(IsROPMiddleware::class)
        ->name('logout_rop');

    /** update  */
    Route::get('/cabinet-rop/update/personal-data', 'cabinetUpdatePersonalDataRop')
        ->middleware(IsROPMiddleware::class)
        ->name('cabinet_update_personal_data_rop');

    Route::put('/cabinet_update_post_personal_data_rop', 'cabinetUpdatePostPersonalDataRop')
        ->middleware(IsROPMiddleware::class)
        ->name('cabinet_update_post_personal_data_rop');
    /** ///update  */

    /** Управление менеджерами  */
    /** список */
    Route::get('/cabinet-rop/managers', 'ropManagers')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_managers');
    /** добавить */
    Route::get('/cabinet-rop/managers/add-manager', 'rop_add_manager')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_add_manager');

    Route::post('/rop_add_post_manager', 'rop_add_post_manager')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_add_post_manager');

    /** редактировать */
    Route::get('/cabinet-rop/managers/update-manager/{id}', 'ropUpdateManager')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_update_manager');

    Route::post('/rop_update_post_manager', 'ropUpdatePostManager')
        ->middleware(IsROPMiddleware::class)
        ->middleware(IsROPAssignedManagerMiddleware::class)
        ->name('rop_update_post_manager');

    /** Управление пользователями  */
    /** список */
    Route::get('/cabinet-rop/users', 'ropUsers')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_users');

    /** редактировать */
    Route::get('/cabinet-rop/users/user/{id}', 'ropUpdateUser')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_update_user');

    Route::put('/rop_update_post_user', 'ropUpdatePostUser')
        ->middleware(IsROPMiddleware::class)
         ->name('rop_update_post_user');
    //rop_update_post_user
});

/**
 * ////РОП
 */

