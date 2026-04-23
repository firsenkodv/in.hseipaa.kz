<?php

namespace App\Http\Controllers\HeadHunter\HunterResume;

use App\Enums\HH\ResumeArchiveEnum;
use App\Http\Controllers\Controller;
use Domain\HH\Resume\ViewModel\ResumeViewModel;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HunterResumeController extends Controller
{

    /**
     * Публичный список всех опубликованных резюме.
     * Данные: все опубликованные и не архивные резюме из БД, список городов и категорий для фильтров.
     * Результат: шаблон hh/hunter_resume/resumes с пагинацией.
     */
    public function index(): View
    {
        try {
            $cities    = ResumeViewModel::make()->cities();
            $categories = select(ResumeViewModel::make()->categories());
            $items     = ResumeViewModel::make()->resumes();
            $user      = UserViewModel::make()->User();
            $route     = route('resumes');
            $fields = [];
            return view('hh.hunter_resume.resumes', compact('user','items', 'cities', 'route','categories','fields'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }

    /**
     * Поиск по публичным резюме с фильтрацией по городу и категории.
     * Данные: параметры city и category берутся из GET-запроса формы поиска.
     * Результат: тот же шаблон resumes, но с отфильтрованными результатами и сохранёнными значениями фильтров.
     */
    public function search(Request $request): View
    {
        try {
            $cityId     = (int) $request->input('city')    ?: null;
            $categoryId = (int) $request->input('category') ?: null;

            $cities    = ResumeViewModel::make()->cities();
            $categories = select(ResumeViewModel::make()->categories());
            $items     = ResumeViewModel::make()->search($cityId, $categoryId)->appends($request->query());
            $user      = UserViewModel::make()->User();
            $route     = route('resumes');
            $fields = [
                'city'    => $cityId    ? ['id' => $cityId,     'title' => collect($cities)->firstWhere('id', $cityId)['title']     ?? ''] : null,
                'resume' => $categoryId ? ['id' => $categoryId, 'title' => collect($categories)->firstWhere('id', $categoryId)['title'] ?? ''] : null,
            ];

            return view('hh.hunter_resume.resumes', compact('user','items', 'cities', 'route','categories','fields'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }

    /**
     * Публичная страница одного резюме.
     * Данные: резюме берётся по ID из БД (только опубликованные).
     * Архивное резюме может видеть только его владелец — остальным возвращается 404.
     * Результат: шаблон hh/hunter_resume/resume.
     */
    public function show($id): View
    {
        try {
            $item = ResumeViewModel::make()->resume($id);
            $user = UserViewModel::make()->User();

            if (!$item) {
                abort(404);
            }

            if ($item->archive === ResumeArchiveEnum::ARCHIVE->value && $item->user_id !== $user?->id) {
                abort(404);
            }

            $category = $item->category ?? '';

            return view('hh.hunter_resume.resume', compact('item', 'user', 'category'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }


}
