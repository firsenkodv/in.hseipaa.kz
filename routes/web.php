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
use App\Http\Controllers\Cabinet\CabinetManager\CabinetManagerController;
use App\Http\Controllers\Cabinet\CabinetRop\CabinetROPController;
use App\Http\Controllers\Cabinet\CabinetUser\CabinetUserController;
use App\Http\Controllers\Cabinet\Message\ToManager;
use App\Http\Controllers\Cabinet\Message\ToUser;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FancyBox\FancyBoxController;
use App\Http\Controllers\FancyBox\FancyBoxSendingFromFormController;
use App\Http\Controllers\Fetch\FetchCityController;
use App\Http\Controllers\HeadHunter\HunterResume\HunterResumeController;
use App\Http\Controllers\HeadHunter\HunterResume\UserResumeController;
use App\Http\Controllers\HeadHunter\HunterVacancy\HunterVacancyController;
use App\Http\Controllers\HeadHunter\HunterVacancy\UserVacancyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Mzp\MzpController;
use App\Http\Controllers\Registry\RegistryController;
use App\Http\Controllers\Search\SearchController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\SiteNew\SiteNewController;
use App\Http\Controllers\Tax\TaxController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UseFul\UseFulController;
use App\Http\Middleware\IsManagerMiddleware;
use App\Http\Middleware\IsROPAssignedManagerMiddleware;
use App\Http\Middleware\IsROPIsManagerMiddleware;
use App\Http\Middleware\IsROPMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\AuthAnyMiddleware;
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

        Route::post('/sign-up', 'handleSignUp')
            ->middleware(ProtectAgainstSpam::class)
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

    Route::get('/reset-password/{token}', 'page')
        ->name('password.reset')
        ->middleware(RedirectIfAuthenticated::class);

    Route::post('/reset-password', 'handle')
        ->name('password_handle')
        ->middleware(RedirectIfAuthenticated::class);

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

    /** кабинет страница с сообщениями */
    Route::get('/cabinet/setting/messages', 'cabinetUserMessages')
        ->name('cabinet_user_messages')
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

    /** Manager меняет автар пользователя */
    Route::post('/cabinet.upload.photo.manager-user', 'uploadManagerUserPhoto')
        ->name('upload_manager-user_photo')
        ->middleware(IsManagerMiddleware::class);

    /** Manager меняет свой автар */
    Route::post('/cabinet.upload.photo.manager', 'uploadManagerPhoto')
        ->name('upload_manager_photo')
        ->middleware(IsROPMiddleware::class);

});
/** ** аватар  **   **/
/** ** загрузка файлов  **   **/
Route::controller(AxiosUploadFilesController::class)->group(function () {
    Route::post('/cabinet.upload.files', 'uploadFiles')
        ->middleware(AuthAnyMiddleware::class);
    Route::post('/cabinet.delete.files', 'deleteFiles')
        ->middleware(AuthAnyMiddleware::class);
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

    /** добавить - создать */
    Route::get('/cabinet-rop/managers/add-manager', 'ropAddManager')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_add_manager');

    Route::post('/rop_add_post_manager', 'ropAddPostManager')
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

    /** список на модерации*/
    Route::get('/cabinet-rop/users/locked', 'ropNoPublishedUsers')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_no_published_users');

    /** список на удаление */
    Route::get('/cabinet-rop/users/deleted', 'ropDeletedUsers')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_deleted_users');

    /** отметить пользователя на удаление */
    Route::post('/cabinet-rop/users/{id}/mark-delete', 'ropMarkUserForDelete')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_mark_user_delete');

    /** поиск пользователей */
    Route::any('/cabinet-rop/users/search', 'ropUsersSearch')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_users_search');

    /** назначить, закрепить за менеджером  */
    Route::post('/cabinet-rop/users/assign', 'ropUsersAssign')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_users_assign');

    /** редактировать */
    Route::get('/cabinet-rop/users/user/{id}', 'ropUpdateUser')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_update_user');

    /** HH — вакансии */
    Route::get('/cabinet-rop/hh/vacancies', 'ropHhVacancies')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_hh_vacancies');

    Route::get('/cabinet-rop/hh/vacancies/{id}', 'ropHhVacancy')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_hh_vacancy');

    /** HH — публикация / блокировка вакансии */
    Route::post('/cabinet-rop/hh/vacancy/{id}/publish', 'ropHhVacancyPublish')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_hh_vacancy_publish');

    Route::post('/cabinet-rop/hh/vacancy/{id}/unpublish', 'ropHhVacancyUnpublish')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_hh_vacancy_unpublish');

    /** HH — вакансии на модерации */
    Route::get('/cabinet-rop/hh/vacancy-moderation', 'ropHhVacanciesModer')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_hh_vacancies_moder');

    Route::get('/cabinet-rop/hh/vacancy-moderation/{id}', 'ropHhVacancyModer')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_hh_vacancy_moder');

    /** HH — резюме */
    Route::get('/cabinet-rop/hh/resumes', 'ropHhResumes')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_hh_resumes');

    Route::get('/cabinet-rop/hh/resumes/{id}', 'ropHhResume')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_hh_resume');

    /** HH — публикация / блокировка резюме */
    Route::post('/cabinet-rop/hh/resume/{id}/publish', 'ropHhResumePublish')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_hh_resume_publish');

    Route::post('/cabinet-rop/hh/resume/{id}/unpublish', 'ropHhResumeUnpublish')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_hh_resume_unpublish');

    /** HH — резюме на модерации */
    Route::get('/cabinet-rop/hh/resume-moderation', 'ropHhResumesModer')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_hh_resumes_moder');

    Route::get('/cabinet-rop/hh/resume-moderation/{id}', 'ropHhResumeModer')
        ->middleware(IsROPMiddleware::class)
        ->name('rop_hh_resume_moder');

    Route::put('/rop_update_post_user', 'ropUpdatePostUser')
        ->middleware(IsROPMiddleware::class)
         ->name('rop_update_post_user');
    //rop_update_post_user
});

/**
 * ////РОП
 */


/**
 * Manager
 */
Route::controller(CabinetManagerController::class)->group(function () {
    /** вход  */
    Route::get('/manager', 'managerLogin')
        ->middleware(IsManagerMiddleware::class)
        ->name('manager_login');

    Route::post('/manager_login_handle', 'managerLoginHandle')
        ->name('manager_login_handle');

    /** кабинет  */
    Route::get('/cabinet-manager', 'cabinetManager')
        ->middleware(IsManagerMiddleware::class)
        ->name('cabinet_manager');

    /** update  */
    Route::get('/cabinet-manager/update/personal-data', 'cabinetUpdatePersonalDataManager')
        ->middleware(IsManagerMiddleware::class)
        ->name('cabinet_update_personal_data_manager');

    Route::put('/cabinet_update_post_personal_data_manager', 'cabinetUpdatePostPersonalDataManager')
        ->middleware(IsManagerMiddleware::class)
        ->name('cabinet_update_post_personal_data_manager');
    /** ///update  */

    /** Управление пользователями  */
    /** список */
    Route::get('/cabinet-manager/users', 'managerUsers')
        ->middleware(IsManagerMiddleware::class)
        ->name('manager_users');

    /** список на модерации*/
    Route::get('/cabinet-manager/users/locked', 'managerNoPublishedUsers')
        ->middleware(IsManagerMiddleware::class)
        ->name('manager_no_published_users');

    /** список на удаление */
    Route::get('/cabinet-manager/users/deleted', 'managerDeletedUsers')
        ->middleware(IsManagerMiddleware::class)
        ->name('manager_deleted_users');

    /** отметить пользователя на удаление */
    Route::post('/cabinet-manager/users/{id}/mark-delete', 'managerMarkUserForDelete')
        ->middleware(IsManagerMiddleware::class)
        ->name('manager_mark_user_delete');

    /** поиск пользователей */
    Route::get('/cabinet-manager/users/search', 'managerUsersSearch')
        ->middleware(IsManagerMiddleware::class)
        ->name('manager_users_search');

    /** установить тариф пользователю */
    Route::post('/cabinet-manager/set-tarif', 'managerSetUserTarif')
        ->middleware(IsManagerMiddleware::class)
        ->name('manager_set_user_tarif');


    /** редактировать */
    Route::get('/cabinet-manager/users/user/{id}', 'managerUpdateUser')
        ->middleware(IsManagerMiddleware::class)
        ->name('manager_update_user');

    Route::put('/manager_update_post_user', 'managerUpdatePostUser')
        ->middleware(IsManagerMiddleware::class)
        ->name('manager_update_post_user');



    /** logout */
    Route::post('/logout_manager', 'logoutManager')
        ->middleware(IsManagerMiddleware::class)
        ->name('logout_manager');

});

/**
 * ////Manager
 */

/**
 * Общий для РОМ м менеджером
 */

Route::controller(ToUser::class)->group(function () {
    Route::post('/cabinet/to_user_message', 'toUser')
      /*  ->middleware(IsROPIsManagerMiddleware::class)*/
        ->name('to_user_message');
    Route::post('/cabinet/cabinet-message/delete', 'cabinetMessageDelete')
        ->name('cabinet_message_delete');
});

//

/**
 * ////Общий для РОМ м менеджером
 */

/**
 * Общий для РОМ м менеджером
 */

Route::controller(ToManager::class)->group(function () {
    Route::post('/cabinet/to_manager_message', 'toManager')
        ->middleware(UserMiddleware::class)
    ->name('to_manager_message');

    Route::post('/cabinet/cabinet-user-message/delete', 'cabinetMessageDelete')
        ->middleware(UserMiddleware::class)
    ->name('cabinet_user_message_delete');
});


/**
 * ////Общий для РОМ м менеджером
 */


/**
 * HunterVacancy
 */
Route::controller(HunterVacancyController::class)->group(function () {

    Route::get('/hh/vacancies', 'index')
        ->middleware(UserMiddleware::class)
        ->name('vacancies');

    Route::get('/hh/vacancies/vacancy/{id}', 'show')
        ->middleware(UserMiddleware::class)
        ->name('vacancy');

    Route::get('/hh/vacancies/search', 'search')
        ->middleware(UserMiddleware::class)
        ->name('vacancy_search');

});

Route::controller(UserVacancyController::class)->group(function () {

    Route::get('/hh/my-vacancies', 'index')
        ->middleware(UserMiddleware::class)
        ->name('my_vacancies');

    Route::get('/hh/my-vacancies/vacancy/{id}', 'show')
        ->middleware(UserMiddleware::class)
        ->name('my_vacancy');

    Route::get('/hh/my-vacancies/create', 'store')
        ->middleware(UserMiddleware::class)
        ->name('my_vacancy_create');

    Route::post('/hh/my-vacancies/create', 'save')
        ->middleware(UserMiddleware::class)
        ->name('my_vacancy_store');

    Route::get('/hh/my-vacancies/archive', 'archive')
        ->middleware(UserMiddleware::class)
        ->name('my_vacancy_archive');

    Route::get('/hh/my-vacancies/archive/vacancy/{id}', 'archiveShow')
        ->middleware(UserMiddleware::class)
        ->name('my_vacancy_archive_show');

    Route::get('/hh/my-vacancies/vacancy/{id}/edit', 'update')
        ->middleware(UserMiddleware::class)
        ->name('my_vacancy_edit');

    Route::put('/hh/my-vacancies/vacancy/{id}/edit', 'updateSave')
        ->middleware(UserMiddleware::class)
        ->name('my_vacancy_update');

    Route::post('/hh/my-vacancies/vacancy/{id}/archive', 'archive_move')
        ->middleware(UserMiddleware::class)
        ->name('my_vacancy_archive_move');

    Route::post('/hh/my-vacancies/archive/vacancy/{id}/restore', 'restore')
        ->middleware(UserMiddleware::class)
        ->name('my_vacancy_restore');

    Route::delete('/hh/my-vacancies/vacancy/{id}', 'destroy')
        ->middleware(UserMiddleware::class)
        ->name('my_vacancy_delete');

});

/**
 * ///HunterVacancy
 *//**
 * HunterResume
 */
Route::controller(HunterResumeController::class)->group(function () {

    Route::get('/hh/resumes', 'index')
        ->middleware(UserMiddleware::class)
        ->name('resumes');

    Route::get('/hh/resumes/resume/{id}', 'show')
        ->middleware(UserMiddleware::class)
        ->name('resume');

    Route::get('/hh/resumes/search', 'search')
        ->middleware(UserMiddleware::class)
        ->name('resume_search');

});


Route::controller(UserResumeController::class)->group(function () {

    Route::get('/hh/my-resumes', 'index')
        ->middleware(UserMiddleware::class)
        ->name('my_resumes');

    Route::get('/hh/my-resumes/resume/{id}', 'show')
        ->middleware(UserMiddleware::class)
        ->name('my_resume');

    Route::get('/hh/my-resumes/create', 'store')
        ->middleware(UserMiddleware::class)
        ->name('my_resume_create');

    Route::post('/hh/my-resumes/create', 'save')
        ->middleware(UserMiddleware::class)
        ->name('my_resume_store');

    Route::get('/hh/my-resumes/archive', 'archive')
        ->middleware(UserMiddleware::class)
        ->name('my_resume_archive');

    Route::get('/hh/my-resumes/archive/resume/{id}', 'archiveShow')
        ->middleware(UserMiddleware::class)
        ->name('my_resume_archive_show');

    Route::get('/hh/my-resumes/resume/{id}/edit', 'update')
        ->middleware(UserMiddleware::class)
        ->name('my_resume_edit');

    Route::put('/hh/my-resumes/resume/{id}/edit', 'updateSave')
        ->middleware(UserMiddleware::class)
        ->name('my_resume_update');

    Route::post('/hh/my-resumes/resume/{id}/archive', 'archive_move')
        ->middleware(UserMiddleware::class)
        ->name('my_resume_archive_move');

    Route::post('/hh/my-resumes/archive/resume/{id}/restore', 'restore')
        ->middleware(UserMiddleware::class)
        ->name('my_resume_restore');

    Route::delete('/hh/my-resumes/resume/{id}', 'destroy')
        ->middleware(UserMiddleware::class)
        ->name('my_resume_delete');

});

/**
 * ///HunterResume
 */
