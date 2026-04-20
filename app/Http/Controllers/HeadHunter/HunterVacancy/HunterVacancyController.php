<?php

namespace App\Http\Controllers\HeadHunter\HunterVacancy;

use App\Http\Controllers\Controller;
use Domain\City\ViewModels\CityViewModel;
use Domain\HH\Vacancy\ViewModel\VacancyViewModel;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HunterVacancyController extends Controller
{

    public function index(): View
    {
        try {
            $cities    = select(CityViewModel::make()->Cities());
            $categories = select(VacancyViewModel::make()->categories());
            $items     = VacancyViewModel::make()->vacancies();
            $user      = UserViewModel::make()->User();
            $route     = route('vacancies');
            $fields = [];
            return view('hh.hunter_vacancy.vacancies', compact('user','items', 'cities', 'route','categories','fields'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }

    public function search(Request $request): View
    {
        try {
            $cityId     = (int) $request->input('city')    ?: null;
            $categoryId = (int) $request->input('category') ?: null;

            $cities    = select(CityViewModel::make()->Cities());
            $categories = select(VacancyViewModel::make()->categories());
            $items     = VacancyViewModel::make()->search($cityId, $categoryId)->appends($request->query());
            $user      = UserViewModel::make()->User();
            $route     = route('vacancies');
            $fields = [
                'city'    => $cityId    ? ['id' => $cityId,     'title' => collect($cities)->firstWhere('id', $cityId)['title']     ?? ''] : null,
                'vacancy' => $categoryId ? ['id' => $categoryId, 'title' => collect($categories)->firstWhere('id', $categoryId)['title'] ?? ''] : null,
            ];

            return view('hh.hunter_vacancy.vacancies', compact('user','items', 'cities', 'route','categories','fields'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }

    public function show($id): View
    {

        try {

            $item     = VacancyViewModel::make()->vacancy($id);
            $user      = UserViewModel::make()->User();
            $category = (isset($item->category))?$item->category:'';

            return view('hh.hunter_vacancy.vacancy', compact('item','user', 'category'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }


}
