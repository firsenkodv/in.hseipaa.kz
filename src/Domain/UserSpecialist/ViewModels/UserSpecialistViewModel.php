<?php

namespace Domain\UserSpecialist\ViewModels;

use App\Models\User;
use App\Models\UserSpecialist;
use Illuminate\Database\Eloquent\Collection;
use Support\Traits\Makeable;

class UserSpecialistViewModel
{
    use Makeable;

    public function Specialists(): Collection|null
    {

        return UserSpecialist::query()
            ->orderBy('sorting', 'DESC')
            ->get();


    }

    public function UserSpecialists($user_id): Collection|null
    {

        $row = [];
        return $this->Specialists()->each(function (UserSpecialist $specialist) use ($user_id) {

            $user = User::find($user_id);
            $user_specialists = $user->UserSpecialist;
            $row[$specialist->id] = $specialist;
            $row[$specialist->id]['checked'] = false;

            foreach ($user_specialists as $user_specialist) {
                if  ($user_specialist->id == $specialist->id) {
                    $row[$specialist->id]['checked'] = true;
                }
            }

            return $row;
        });


    }

}
