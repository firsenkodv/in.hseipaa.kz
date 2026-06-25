<?php

declare(strict_types=1);

namespace App\MoonShine\Controllers;

use App\Exports\UsersExport;
use App\Models\User;
use App\Models\UserExpert;
use App\Models\UserFileQualification;
use App\Models\UserLecturer;
use App\Models\UserSpecialist;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use MoonShine\Laravel\Http\Controllers\MoonShineController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class MoonshineUserExport extends MoonShineController
{
    public function export(Request $request): BinaryFileResponse
    {
        if (!auth('moonshine')->check()) {
            abort(403);
        }

        $cityId           = $request->input('city_id');
        $userHumanId      = $request->input('user_human_id');
        $specialistIds    = array_keys((array) $request->input('specialists', []));
        $expertIds        = array_keys((array) $request->input('experts', []));
        $lecturerIds      = array_keys((array) $request->input('lecturers', []));
        $qualificationIds = array_keys((array) $request->input('qualifications', []));

        $totalSpecialists    = UserSpecialist::count();
        $totalExperts        = UserExpert::count();
        $totalLecturers      = UserLecturer::count();
        $totalQualifications = UserFileQualification::count();

        $query = User::query()->with([
            'UserCity',
            'UserHuman',
            'UserSpecialist',
            'UserExpert',
            'UserLecturer',
            'UserFileQualification',
        ]);

        if ($cityId) {
            $query->where('user_city_id', $cityId);
        }

        if ($userHumanId) {
            $query->where('user_human_id', $userHumanId);
        }

        if (!empty($specialistIds) && count($specialistIds) < $totalSpecialists) {
            $query->whereHas('UserSpecialist', function ($q) use ($specialistIds) {
                $q->whereIn('user_specialists.id', $specialistIds);
            });
        }

        if (!empty($expertIds) && count($expertIds) < $totalExperts) {
            $query->whereHas('UserExpert', function ($q) use ($expertIds) {
                $q->whereIn('user_experts.id', $expertIds);
            });
        }

        if (!empty($lecturerIds) && count($lecturerIds) < $totalLecturers) {
            $query->whereHas('UserLecturer', function ($q) use ($lecturerIds) {
                $q->whereIn('user_lecturers.id', $lecturerIds);
            });
        }

        if (!empty($qualificationIds) && count($qualificationIds) < $totalQualifications) {
            $query->whereHas('UserFileQualification', function ($q) use ($qualificationIds) {
                $q->whereIn('user_file_qualifications.id', $qualificationIds);
            });
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        $rows = $users->map(fn(User $user) => [
            $user->id,
            $user->username ?? $user->company,
            $user->email,
            format_phone($user->phone),
            $user->iin ?? $user->bin,
            $user->UserCity?->title,
            $user->UserHuman?->title,
            $user->UserSpecialist->pluck('title')->implode(', '),
            $user->UserExpert->pluck('title')->implode(', '),
            $user->UserLecturer->pluck('title')->implode(', '),
            $user->UserFileQualification->pluck('title')->implode(', '),
            $user->created_at?->format('d.m.Y'),
        ])->toArray();

        return Excel::download(
            new UsersExport($rows),
            'users-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}
