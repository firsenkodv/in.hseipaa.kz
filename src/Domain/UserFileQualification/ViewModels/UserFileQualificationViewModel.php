<?php

namespace Domain\UserFileQualification\ViewModels;

use App\Models\User;
use App\Models\UserFileQualification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class UserFileQualificationViewModel
{
    use Makeable;

    public function Qualifications(): Collection|null
    {
        return Cache::rememberForever('user_file_qualifications', function () {
            return UserFileQualification::query()
                ->orderBy('sorting', 'DESC')
                ->get();
        });
    }

    public function UserFileQualifications($user_id): Collection|null
    {
        $row = [];
        $user              = User::find($user_id);
        $user_qualifications = $user->UserFileQualification;

        return $this->Qualifications()->each(function (UserFileQualification $qualification) use ($user_qualifications, &$row) {

            $row[$qualification->id] = $qualification;
            $row[$qualification->id]['checked']          = false;
            $row[$qualification->id]['custom_documents'] = '';
            $row[$qualification->id]['certificate_date'] = '';

            foreach ($user_qualifications as $user_qualification) {
                if ($user_qualification->id == $qualification->id) {
                    $row[$qualification->id]['checked']          = true;
                    $row[$qualification->id]['custom_documents'] = $user_qualification->pivot->custom_documents ?? '';
                    $row[$qualification->id]['certificate_date'] = $user_qualification->pivot->certificate_date
                        ? \Carbon\Carbon::parse($user_qualification->pivot->certificate_date)->format('d.m.Y')
                        : '';
                }
            }

            return $row;
        });
    }
}
