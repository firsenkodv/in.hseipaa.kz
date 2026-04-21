<?php

namespace App\Http\Controllers\HeadHunter\HunterResume;

use App\Http\Controllers\Controller;
use App\Http\Requests\HH\Resume\StoreResumeRequest;
use Domain\City\ViewModels\CityViewModel;
use Domain\HH\Resume\DTOs\StoreResumeDto;
use Domain\HH\Resume\ViewModel\ResumeViewModel;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserResumeController extends Controller
{

    public function index(): View
    {
        try {
            $user  = UserViewModel::make()->User();
            $items = ResumeViewModel::make()->userResumes($user->id);

            return view('hh.hunter_resume.user.index', compact('user', 'items'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }

    public function show($id): View
    {
        try {
            $user = UserViewModel::make()->User();
            $item = ResumeViewModel::make()->userResume((int) $id, $user->id);

            if (!$item) {
                abort(404);
            }

            return view('hh.hunter_resume.user.show', compact('item', 'user'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }


    public function store(): View
    {
        try {
            $user        = UserViewModel::make()->User();
            $categories  = ResumeViewModel::make()->categories()->toArray();
            $cities      = CityViewModel::make()->Cities()->toArray();
            $experiences = ResumeViewModel::make()->experiences()->toArray();

            return view('hh.hunter_resume.user.store', compact('user', 'categories', 'cities', 'experiences'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }

    public function save(StoreResumeRequest $request): RedirectResponse
    {
        try {
            $user = UserViewModel::make()->User();
            $dto  = StoreResumeDto::formRequest($request);

            ResumeViewModel::make()->create($dto, $user->id);

            flash()->info(config('message_flash.info.resume_create_ok'));

            return redirect()->route('my_resumes');

        } catch (\Throwable $th) {
            logErrors($th);
            flash()->alert(config('message_flash.alert.resume_create_error'));

            return redirect()->back()->withInput();
        }
    }

    public function update()
    {

    }
    public function delete()
    {

    }


}
