<?php

namespace App\Http\Controllers\HeadHunter\HunterVacancy;

use App\Enums\HH\VacancyArchiveEnum;
use App\Http\Controllers\Controller;
use Domain\HH\Vacancy\ViewModel\VacancyViewModel;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HunterVacancyController extends Controller
{

    /**
     * Публичный список всех опубликованных вакансий.
     * Данные: все опубликованные и не архивные вакансии из БД, список городов и категорий для фильтров.
     * Результат: шаблон hh/hunter_vacancy/vacancies с пагинацией.
     */
    public function index(): View
    {
        try {
            $cities    = VacancyViewModel::make()->cities();
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

    /**
     * Поиск по публичным вакансиям с фильтрацией по городу и категории.
     * Данные: параметры city и category берутся из GET-запроса формы поиска.
     * Результат: тот же шаблон vacancies, но с отфильтрованными результатами и сохранёнными значениями фильтров.
     */
    public function search(Request $request): View
    {
        try {
            $cityId     = (int) $request->input('city')    ?: null;
            $categoryId = (int) $request->input('category') ?: null;

            $cities    = VacancyViewModel::make()->cities();
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

    /**
     * Публичная страница одной вакансии.
     * Данные: вакансия берётся по ID из БД (только опубликованные).
     * Архивную вакансию может видеть только её владелец — остальным возвращается 404.
     * Результат: шаблон hh/hunter_vacancy/vacancy.
     */
    public function show($id): View
    {
        try {
            $item = VacancyViewModel::make()->vacancy($id);
            $user = UserViewModel::make()->User();

            if (!$item) {
                abort(404);
            }

            if ($item->archive === VacancyArchiveEnum::ARCHIVE->value && $item->user_id !== $user?->id) {
                abort(404);
            }

            $category = $item->category ?? '';

            return view('hh.hunter_vacancy.vacancy', compact('item', 'user', 'category'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }


}
