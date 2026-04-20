<?php

namespace App\Http\Controllers\HeadHunter\HunterResume;

use App\Http\Controllers\Controller;
use Domain\City\ViewModels\CityViewModel;
use Domain\HH\Resume\ViewModel\ResumeViewModel;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HunterResumeController extends Controller
{

    public function index(): View
    {
        try {
            $cities    = select(CityViewModel::make()->Cities());
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

    public function search(Request $request): View
    {
        try {
            $cityId     = (int) $request->input('city')    ?: null;
            $categoryId = (int) $request->input('category') ?: null;

            $cities    = select(CityViewModel::make()->Cities());
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

    public function show($id): View
    {

        try {

            $item     = ResumeViewModel::make()->resume( $id);
            $user      = UserViewModel::make()->User();
            $category = (isset($item->category))?$item->category:'';

            return view('hh.hunter_resume.resume', compact('item','user', 'category'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }


}
