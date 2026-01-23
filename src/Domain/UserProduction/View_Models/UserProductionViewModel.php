<?php

namespace Domain\UserProduction\View_Models;

use App\Models\User;
use App\Models\UserProduction;
use Illuminate\Database\Eloquent\Collection;
use Support\Traits\Makeable;

class UserProductionViewModel
{
    use Makeable;

    public function Productions(): Collection|null
    {
        return UserProduction::query()
            ->orderBy('sorting', 'DESC')
            ->get();
    }

    public function UserProductions($user_id): Collection|null
    {

        $row = [];
        return $this->Productions()->each(function (UserProduction $production) use ($user_id) {

            $user = User::find($user_id);
            $user_productions = $user->UserProduction;
            $row[$production->id] = $production;
            $row[$production->id]['checked'] = false;

            foreach ($user_productions as $user_production) {
                if  ($user_production->id == $production->id) {
                    $row[$production->id]['checked'] = true;
                }
            }

            return $row;
        });


    }

}
