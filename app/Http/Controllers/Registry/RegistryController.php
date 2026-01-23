<?php

namespace App\Http\Controllers\Registry;

use App\Enums\User\RegistryStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserCity;
use App\Models\UserExpert;
use App\Models\UserSpecialist;
use Domain\City\ViewModels\CityViewModel;
use Domain\User\ViewModels\UserViewModel;
use Domain\UserExpert\ViewModels\UserExpertViewModel;
use Domain\UserSpecialist\ViewModels\UserSpecialistViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RegistryController extends Controller
{


    public function registry(): RedirectResponse
    {
        return redirect()->route('registry_specialists');
    }

    /** СПЕЦИАЛИСТЫ */
    /** Список специалистов */
    public function registrySpecialists(): View
    {

        /**     Получаем текущего пользователя */
        $user = UserViewModel::make()->User();

        /**     Получаем всех специалистов для select-а */
        $specialists = $this->select(UserSpecialistViewModel::make()->Specialists());

        /**     Получаем все города для select-а */
        $cities = $this->select(CityViewModel::make()->Cities());

        /**     Получаем все пользователей которое являются специалистами */
        $items = UserViewModel::make()->registryUsers(RegistryStatus::SPECIALIST->relation());

        return view('pages.registry.specialists.items', [
            'items' => $items,
            'route' => \Route::currentRouteName(),
            'specialists' => $specialists,
            'cities' => $cities,
            'user' => $user,
        ]);
    }

    /** Подробная информация о специалисте */
    public function registrySpecialist($id): View
    {
        /**     Получаем текущего пользователя */
        $user = UserViewModel::make()->User();

        $item =  UserViewModel::make()->UserId($id);

        return view('pages.registry.specialists.item', [
            'item' => $item,
            'user' => $user,


        ]);

    }

    /** ЭКСПЕРТЫ */
    /** Список экспертов */
    public function registryExperts(): View
    {

        /**     Получаем текущего пользователя */
        $user = UserViewModel::make()->User();

        /**     Получаем всех экспертов для select-а */
        $experts = $this->select(UserExpertViewModel::make()->Experts());

        /**     Получаем все города для select-а */
        $cities = $this->select(CityViewModel::make()->Cities());

        /**     Получаем все пользователей которое являются экспертами */
        $items = UserViewModel::make()->registryUsers(RegistryStatus::EXPERT->relation());

        return view('pages.registry.experts.items', [
            'items' => $items,
            'route' => \Route::currentRouteName(),
            'experts' => $experts,
            'cities' => $cities,
            'user' => $user,
        ]);
    }

    /** Подробная информация об эксперте */
    public function registryExpert($id): View
    {

        /**     Получаем текущего пользователя */
        $user = UserViewModel::make()->User();

        $item =  UserViewModel::make()->UserId($id);

        return view('pages.registry.experts.item', [
            'item' => $item,
            'user' => $user,

        ]);

    }

    /** ЮРЛИЦА */
    /** Список юр.лиц */
    public function registryLegalEntities(): View
    {

        /**     Получаем текущего пользователя */
        $user = UserViewModel::make()->User();

        /**     Получаем все города для select-а */
        $cities = $this->select(CityViewModel::make()->Cities());

        /**     Получаем все пользователей которое являются экспертами */
        $items = UserViewModel::make()->registryLegalEntityUsers();

        return view('pages.registry.legal_entities.items', [
            'items' => $items,
            'route' => \Route::currentRouteName(),
            'cities' => $cities,
            'user' => $user,

        ]);
    }

    /** Подробная информация о юр.лице */
    public function registryLegalEntity($id): View
    {
        /**     Получаем текущего пользователя */
        $user = UserViewModel::make()->User();

        $item =  UserViewModel::make()->UserId($id);

        return view('pages.registry.legal_entities.item', [
            'item' => $item,
            'user' => $user,

        ]);

    }


    /** ПОИСК  */
    /** поиск специалистов */
    public function registrySpecialistsSearch(Request $request)
    {
        /**     Получаем текущего пользователя */
        $user = UserViewModel::make()->User();

        /**     Получаем всех специалистов для select-а */
        $specialists = $this->select(UserSpecialistViewModel::make()->Specialists());

        /**     Получаем все города для select-а */
        $cities = $this->select(CityViewModel::make()->Cities());

        $cityId = ($request->city == 0) ? null : $request->city;
        $specialistId = ($request->specialist == 0) ? null : $request->specialist;
        $search = $request->search;
        $route = $request->route;

        /** Соберем все поля в массив $fields */
        $fields = $this->fields($request);

        $items = UserSpecialistViewModel::make()->UserSpecialistsSearch($search, $cityId, $specialistId);

        return view('pages.registry.specialists.items', [
            'items' => $items,
            'fields' => $fields,
            'specialists' => $specialists,
            'cities' => $cities,
            'route' => $route,
            'user' => $user,

        ]);

    }

    /** поиск экспертов */
    public function registryExpertsSearch(Request $request)
    {

        /**     Получаем текущего пользователя */
        $user = UserViewModel::make()->User();

        /**     Получаем всех специалистов для select-а */
        $experts = $this->select(UserExpertViewModel::make()->Experts());

        /**     Получаем все города для select-а */
        $cities = $this->select(CityViewModel::make()->Cities());

        $cityId = ($request->city == 0) ? null : $request->city;
        $expertId = ($request->expert == 0) ? null : $request->expert;
        $search = $request->search;
        $route = $request->route;

        /** Соберем все поля в массив $fields */
        $fields = $this->fields($request);

        $items = UserExpertViewModel::make()->UserExpertsSearch($search, $cityId, $expertId);

        return view('pages.registry.experts.items', [
            'items' => $items,
            'fields' => $fields,
            'experts' => $experts,
            'cities' => $cities,
            'route' => $route,
            'user' => $user,

        ]);

    }

    /** поиск по компаниям */
    public function registryLegalEntitiesSearch(Request $request)
    {

        /**     Получаем текущего пользователя */
        $user = UserViewModel::make()->User();

        /**     Получаем все города для select-а */
        $cities = $this->select(CityViewModel::make()->Cities());

        $cityId = ($request->city == 0) ? null : $request->city;
        $search = $request->search;
        $route = $request->route;

        /** Соберем все поля в массив $fields */
        $fields = $this->fields($request);

        $items = UserViewModel::make()->UserLegalEntitiesSearch($search, $cityId);

        return view('pages.registry.legal_entities.items', [
            'items' => $items,
            'fields' => $fields,
            'cities' => $cities,
            'route' => $route,
            'user' => $user,

        ]);

    }

    /** получаем select-ы */
    public function select($items)
    {
        $arrItems = [];
        /**     Получаем всех специалистов для select-а */
        if (!$items->isEmpty()) { // Проверяем, пуста ли коллекция
            // Преобразуем коллекцию в массив
            $arrItems = $items->toArray();

            // Добавляем элемент в начало массива
            array_unshift($arrItems, ['id' => '0', 'title' => 'Все']);
        }
        return $arrItems;

    }

    public function fields($request): array
    {
        $cityId = ($request->city == 0) ? null : $request->city;
        $specialistId = ($request->specialist == 0) ? null : $request->specialist;
        $expertId = ($request->expert == 0) ? null : $request->expert;
        $search = $request->search;
        $route = $request->route;


        $c = UserCity::find($cityId) ?: null;
        $s = UserSpecialist::find($specialistId) ?: null;
        $e = UserExpert::find($expertId) ?: null;

        $fields['specialist']['id'] = (!is_null($s)) ? $s->id : null;
        $fields['specialist']['title'] = (!is_null($s)) ? $s->title : null;
        $fields['expert']['id'] = (!is_null($e)) ? $e->id : null;
        $fields['expert']['title'] = (!is_null($e)) ? $e->title : null;
        $fields['city']['id'] = (!is_null($c)) ? $c->id : null;
        $fields['city']['title'] = (!is_null($c)) ? $c->title : null;
        $fields['search'] = $search;
        $fields['route'] = $route;
        return $fields;

    }
    /** /////ПОИСК */


}
