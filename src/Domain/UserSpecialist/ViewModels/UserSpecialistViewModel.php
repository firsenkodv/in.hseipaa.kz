<?php

namespace Domain\UserSpecialist\ViewModels;

use App\Models\User;
use App\Models\UserSpecialist;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class UserSpecialistViewModel
{
    use Makeable;

    public function Specialists(): Collection|null
    {
        return Cache::rememberForever('user_specialists', function () {

            return UserSpecialist::query()
                ->orderBy('sorting', 'DESC')
                ->get();

        });
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

    public function UserSpecialistsSearch($search, $cityId, $specialistId): LengthAwarePaginator|null
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
        if (!empty($specialistId)) {
            $usersQuery->whereHas('UserSpecialist', function ($query) use ($specialistId) {
                $query->where('user_specialists.id', $specialistId); // Уточнили таблицу user_specialists
            });
        }

        if ($cityId === null && $specialistId === null) {
            $usersQuery->whereHas('UserSpecialist');
        }

        $usersQuery->where('published', 1);


        // Выполнение запроса и получение результата
        return $usersQuery
            ->orderBy('created_at', 'desc')
            ->paginate(config('site.constants.paginate'));



    }

}
