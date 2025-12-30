<?php

namespace Domain\UserLanguage\ViewModels;

use App\Models\User;
use App\Models\UserLanguage;
use Illuminate\Database\Eloquent\Collection;
use Support\Traits\Makeable;

class UserLanguageViewModel
{
    use Makeable;

    public function Languages(): Collection|null
    {

        return UserLanguage::query()
            ->orderBy('sorting', 'DESC')
            ->get();


    }

    public function UserLanguages($user_id): Collection|null
    {

        $row = [];
        return $this->Languages()->each(function (UserLanguage $Language) use ($user_id) {

            $user = User::find($user_id);
            $user_Languages = $user->UserLanguage;
            $row[$Language->id] = $Language;
            $row[$Language->id]['checked'] = false;

            foreach ($user_Languages as $user_Language) {
                if  ($user_Language->id == $Language->id) {
                    $row[$Language->id]['checked'] = true;
                }
            }

            return $row;
        });


    }

}
