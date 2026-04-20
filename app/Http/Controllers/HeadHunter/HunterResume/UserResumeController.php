<?php

namespace App\Http\Controllers\HeadHunter\HunterResume;

use App\Http\Controllers\Controller;
use Domain\City\ViewModels\CityViewModel;
use Domain\HH\Vacancy\ViewModel\VacancyViewModel;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UserResumeController extends Controller
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


    public function store()
    {

    }
    public function update()
    {

    }
    public function delete()
    {

    }


}
