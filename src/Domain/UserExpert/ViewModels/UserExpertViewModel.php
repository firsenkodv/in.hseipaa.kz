<?php

namespace Domain\UserExpert\ViewModels;

use App\Models\User;
use App\Models\UserExpert;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class UserExpertViewModel
{
    use Makeable;

    public function Experts(): Collection|null
    {
        return Cache::rememberForever('user_experts', function () {

            return UserExpert::query()
                ->orderBy('sorting', 'DESC')
                ->get();
        });

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


    public function UserExpertsSearch($search, $cityId, $expertId): LengthAwarePaginator|null
    {
        // Основной запрос на выборку пользователей
        $usersQuery = User::query();

        // Поиск по частичному совпадению имени или e-mail
        if (!empty($search)) {
            $usersQuery->where(function ($query) use ($search) {
                $query->where('username', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Фильтр по выбранному городу
        if (!empty($cityId)) {
            $usersQuery->whereHas('UserCity', function ($query) use ($cityId) {
                $query->where('user_cities.id', $cityId); // Уточнили таблицу user_cities
            });
        }

        // Фильтр по выбранной специальности
        if (!empty($expertId)) {
            $usersQuery->whereHas('UserExpert', function ($query) use ($expertId) {
                $query->where('user_experts.id', $expertId); // Уточнили таблицу user_experts
            });
        }

        if ($cityId === null && $expertId === null) {
            $usersQuery->whereHas('UserExpert');
        }

        $usersQuery->where('published', 1);


        // Выполнение запроса и получение результата
        return $usersQuery
            ->orderBy('created_at', 'desc')
            ->paginate(config('site.constants.paginate'));



    }
}
