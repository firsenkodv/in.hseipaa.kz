<?php

namespace Domain\UserExpert\ViewModels;

use App\Models\User;
use App\Models\UserExpert;
use Illuminate\Database\Eloquent\Collection;
use Support\Traits\Makeable;

class UserExpertViewModel
{
    use Makeable;

    public function Experts(): Collection|null
    {

        return UserExpert::query()
            ->orderBy('sorting', 'DESC')
            ->get();


    }

    public function UserExperts($user_id): Collection|null
    {

        $row = [];
        return $this->Experts()->each(function (UserExpert $expert) use ($user_id) {

            $user = User::find($user_id);
            $user_experts = $user->UserExpert;
            $row[$expert->id] = $expert;
            $row[$expert->id]['checked'] = false;

                  foreach ($user_experts as $user_expert) {
                            if  ($user_expert->id == $expert->id) {
                                $row[$expert->id]['checked'] = true;
                            }
                        }

            return $row;
        });


    }
}
