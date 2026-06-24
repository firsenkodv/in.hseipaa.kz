<?php

declare(strict_types=1);

namespace App\MoonShine\Controllers;

use App\Exports\UsersExport;
use App\Models\User;
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

        if (!empty($specialistIds)) {
            $query->whereHas('UserSpecialist', function ($q) use ($specialistIds) {
                $q->whereIn('id', $specialistIds);
            });
        }

        if (!empty($expertIds)) {
            $query->whereHas('UserExpert', function ($q) use ($expertIds) {
                $q->whereIn('id', $expertIds);
            });
        }

        if (!empty($lecturerIds)) {
            $query->whereHas('UserLecturer', function ($q) use ($lecturerIds) {
                $q->whereIn('id', $lecturerIds);
            });
        }

        if (!empty($qualificationIds)) {
            $query->whereHas('UserFileQualification', function ($q) use ($qualificationIds) {
                $q->whereIn('id', $qualificationIds);
            });
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        $rows = $users->map(fn(User $user) => [
            $user->id,
            $user->username ?? $user->company,
            $user->email,
            $user->phone,
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
