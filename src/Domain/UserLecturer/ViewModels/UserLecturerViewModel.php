<?php

namespace Domain\UserLecturer\ViewModels;

use App\Models\User;
use App\Models\UserExpert;
use App\Models\UserLecturer;
use Illuminate\Database\Eloquent\Collection;
use Support\Traits\Makeable;

class UserLecturerViewModel
{
use Makeable;
    public function Lecturers(): Collection|null
    {

        return UserLecturer::query()
            ->orderBy('sorting', 'DESC')
            ->get();


    }

    public function UserLecturers($user_id): Collection|null
    {

        $row = [];
        return $this->Lecturers()->each(function (UserLecturer $lecturer) use ($user_id) {

            $user = User::find($user_id);
            $user_lecturers = $user->UserLecturer;
            $row[$lecturer->id] = $lecturer;
            $row[$lecturer->id]['checked'] = false;

            foreach ($user_lecturers as $user_lecturer) {
                if  ($user_lecturer->id == $lecturer->id) {
                    $row[$lecturer->id]['checked'] = true;
                }
            }

            return $row;
        });


    }
}
