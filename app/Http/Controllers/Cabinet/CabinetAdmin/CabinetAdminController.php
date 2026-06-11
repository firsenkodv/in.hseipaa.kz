<?php

namespace App\Http\Controllers\Cabinet\CabinetAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CabinetAdmin\AdminUpdateRequest;
use App\Http\Requests\CabinetAdmin\AdminUserCreateRequest;
use App\Mail\Auth\AdminNewUserNotificationMail;
use App\Mail\Auth\UserRegisteredMail;
use App\Models\Contract;
use App\Models\Training;
use Domain\Admin\ViewModels\AdminViewModel;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class CabinetAdminController extends Controller
{
    public function adminLogin(): View
    {
        return view('cabinet.cabinet_admin.auth.login_admin');
    }

    public function adminLoginHandle(Request $request): View|RedirectResponse
    {
        session()->forget('a_email');
        session()->forget('a_password');

        $admin = AdminViewModel::make()->Admin($request);

        if (is_null($admin)) {
            flash()->alert(config('message_flash.alert.__enter_error'));
            session(['a_email' => $request->email, 'a_password' => $request->password]);
            return redirect(route('admin_login'));
        }

        session()->forget('a');
        session(['a' => $request->email]);
        return redirect(route('cabinet_admin'));
    }

    public function cabinetAdmin(): View|RedirectResponse
    {
        $a = AdminViewModel::make()->a(session()->get('a'));

        if (is_null($a)) {
            flash()->alert(config('message_flash.alert.__enter_error'));
            return redirect(route('admin_login'));
        }

        return view('cabinet.cabinet_admin.cabinet_admin', ['a' => $a]);
    }

    public function logoutAdmin(): RedirectResponse
    {
        if (session()->exists('a')) {
            session()->forget('a');
            flash()->info(config('message_flash.info.__good_exit'));
            return redirect(route('admin_login'));
        }

        flash()->alert(config('message_flash.alert.role_error'));
        return redirect(route('admin_login'));
    }

    public function adminUsers(): View|RedirectResponse
    {
        $a = AdminViewModel::make()->a(session()->get('a'));

        if (!$a) {
            abort(404);
        }

        $users = AdminViewModel::make()->adminUserList();

        return view('cabinet.cabinet_admin.users.items', [
            'a'      => $a,
            'users'  => $users,
            'search' => '',
            'roles'  => [],
        ]);
    }

    public function adminUsersSearch(Request $request): View|RedirectResponse
    {
        $a = AdminViewModel::make()->a(session()->get('a'));

        if (!$a) {
            abort(404);
        }

        $search = trim($request->input('search', ''));
        $roles  = $request->input('roles', []);
        $users  = AdminViewModel::make()->adminUserList($search, $roles);

        return view('cabinet.cabinet_admin.users.items', [
            'a'      => $a,
            'users'  => $users,
            'search' => $search,
            'roles'  => $roles,
        ]);
    }

    public function adminUser(int $id): View|RedirectResponse
    {
        $a = AdminViewModel::make()->a(session()->get('a'));

        if (!$a) {
            abort(404);
        }

        $user = AdminViewModel::make()->adminUserId($id);

        if (!$user) {
            abort(404);
        }

        $contracts = Contract::where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('cabinet.cabinet_admin.users.item', [
            'a'         => $a,
            'user'      => $user,
            'contracts' => $contracts,
        ]);
    }

    public function adminUserCreate(): View|RedirectResponse
    {
        $a = AdminViewModel::make()->a(session()->get('a'));

        if (!$a) {
            abort(404);
        }

        return view('cabinet.cabinet_admin.users.create', ['a' => $a]);
    }

    public function adminUserCreateHandle(AdminUserCreateRequest $request): RedirectResponse
    {
        $a = AdminViewModel::make()->a(session()->get('a'));

        if (!$a) {
            abort(404);
        }

        try {
            $plainPassword = $request->input('password');

            $user = UserViewModel::make()->UserCreate($request->all());

            $userData = [
                'username' => $user->username,
                'email'    => $user->email,
                'company'  => $user->company,
                'password' => $plainPassword,
            ];

            Mail::to($user->email)->queue(new UserRegisteredMail($userData));
            Mail::to(config('app.mail_admin'))->queue(new AdminNewUserNotificationMail($userData));

            flash()->info(config('message_flash.info.admin_user_create_ok'));
            return redirect()->route('admin_users');

        } catch (\Throwable $th) {
            logErrors($th);
            flash()->alert(config('message_flash.alert.admin_user_create_error'));
            return redirect()->back();
        }
    }

    public function adminUserContractCreate(int $id): View|RedirectResponse
    {
        $a = AdminViewModel::make()->a(session()->get('a'));

        if (!$a) {
            abort(404);
        }

        $user = AdminViewModel::make()->adminUserId($id);

        if (!$user) {
            abort(404);
        }

        return redirect()->route('admin_user', $id);
    }

    public function adminTrainings(): View|RedirectResponse
    {
        $a = AdminViewModel::make()->a(session()->get('a'));

        if (!$a) {
            abort(404);
        }

        $trainings = Training::orderBy('sorting', 'desc')->orderBy('title')->get();

        return view('cabinet.cabinet_admin.trainings.items', [
            'a'         => $a,
            'trainings' => $trainings,
        ]);
    }

    public function adminContracts(): View|RedirectResponse
    {
        $a = AdminViewModel::make()->a(session()->get('a'));

        if (!$a) {
            abort(404);
        }

        $contracts = Contract::with('user')
            ->orderByRaw('date_start IS NULL, date_start ASC')
            ->paginate(config('site.constants.paginate'));

        return view('cabinet.cabinet_admin.contracts.items', [
            'a'         => $a,
            'contracts' => $contracts,
        ]);
    }

    public function adminAjaxUserContracts(int $id): \Illuminate\Contracts\View\View
    {
        $contracts = Contract::where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('ajax.admin-user-contracts', compact('contracts'));
    }

    public function cabinetUpdatePersonalDataAdmin(): View|RedirectResponse
    {
        $a = AdminViewModel::make()->a(session()->get('a'));

        if (!$a) {
            abort(404);
        }

        return view('cabinet.cabinet_admin.cabinet_admin_update', ['a' => $a]);
    }

    public function cabinetUpdatePostPersonalDataAdmin(AdminUpdateRequest $request): RedirectResponse
    {
        try {
            $a = AdminViewModel::make()->a(session()->get('a'));
            AdminViewModel::make()->updatePersonalDataAdmin($request, $a->id);
            flash()->info(config('message_flash.info.cabinet_user_ok'));
            return redirect()->back();
        } catch (\Throwable $th) {
            logErrors($th);
            flash()->alert(config('message_flash.alert.cabinet_user_error'));
            return redirect()->back();
        }
    }
}
