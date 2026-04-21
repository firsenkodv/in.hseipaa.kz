<?php

namespace App\Http\Controllers\HeadHunter\HunterVacancy;

use App\Http\Controllers\Controller;
use App\Http\Requests\HH\Vacancy\StoreVacancyRequest;
use Domain\City\ViewModels\CityViewModel;
use Domain\HH\Vacancy\DTOs\StoreVacancyDto;
use Domain\HH\Vacancy\ViewModel\VacancyViewModel;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserVacancyController extends Controller
{

    public function index(): View
    {
        try {
            $user  = UserViewModel::make()->User();
            $items = VacancyViewModel::make()->userVacancies($user->id);

            return view('hh.hunter_vacancy.user.index', compact('user', 'items'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }

    public function show($id): View
    {
        try {
            $user = UserViewModel::make()->User();
            $item = VacancyViewModel::make()->userVacancy((int) $id, $user->id);

            if (!$item) {
                abort(404);
            }

            return view('hh.hunter_vacancy.user.show', compact('user', 'item'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }


    public function store(): View
    {
        try {
            $user        = UserViewModel::make()->User();
            $categories  = VacancyViewModel::make()->categories()->toArray();
            $cities      = CityViewModel::make()->Cities()->toArray();
            $experiences = VacancyViewModel::make()->experiences()->toArray();

            return view('hh.hunter_vacancy.user.store', compact('user', 'categories', 'cities', 'experiences'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }
    public function update($id)
    {
        try {

            $item     = VacancyViewModel::make()->vacancy($id);
            $user      = UserViewModel::make()->User();
            $category = (isset($item->category))?$item->category:'';

            return view('hh.hunter_vacancy.user.update', compact('item','user', 'category'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }

    }
    public function save(StoreVacancyRequest $request): RedirectResponse
    {
        try {
            $user = UserViewModel::make()->User();
            $dto  = StoreVacancyDto::formRequest($request);
            $logo = $request->hasFile('logo') ? $request->file('logo') : null;

            VacancyViewModel::make()->create($dto, $user->id, $logo);

            flash()->info(config('message_flash.info.vacancy_create_ok'));

            return redirect()->route('my_vacancies');

        } catch (\Throwable $th) {
            logErrors($th);
            flash()->alert(config('message_flash.alert.vacancy_create_error'));

            return redirect()->back()->withInput();
        }
    }

    public function delete()
    {

    }


}
