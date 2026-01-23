<?php

namespace Domain\User\ViewModels;

use App\Enums\User\RegistryStatus;
use App\Enums\User\Status;
use App\Models\User;
use Domain\User\DTOs\UserUpdateDto;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Makeable;

class UserViewModel
{
    use Makeable;

    /**
     * @param $request
     * @return Model|null
     * Сохранение пользователя, create
     */
    public function UserCreate($request): Model|null
    {
        return User::Create($request);

    }

    /**
     * @param $request
     * @param $id
     * @return bool
     * @throws \Exception|\Throwable
     * Редактирование пользователя
     */
    public function UserUpdate($request, $id): bool
    {

        $data = UserUpdateDto::formRequest($request);

        /** Сначала получаем пользователя по указанному ID **/
        $user = User::query()->where('id', $id)->first();

        if (!$user) {
            throw new \Exception("Пользователь с указанным ID не найден.");
        }


        /** Получаем выбранные IDs языков **/
        $languageIds = $request->input('languages', []);
        /** Чекбоксы передают именно IDs **/

        /** Получаем выбранные IDs направлений эксперта **/
        $specialistIds = $request->input('specialists', []);
        /** Чекбоксы передают именно IDs **/

        /** Получаем выбранные IDs направлений эксперта **/
        $expertIds = $request->input('experts', []);
        /** Чекбоксы передают именно IDs **/

        /** Получаем выбранные IDs направлений лектора **/
        $lecturerIds = $request->input('lecturers', []);
        /** Чекбоксы передают именно IDs **/

        /** Получаем выбранные IDs направлений видов деятельности **/
        $productionIds = $request->input('productions', []);
        /** Чекбоксы передают именно IDs **/

        /** метод для публикации в зависимости от выбранных направлений */
        $data->published = $this->publishedUser($request, $user);

        // dump($data->published); // тут видно 1


        \DB::beginTransaction(); // Начинаем транзакцию

        try {
            /** Обновляем основного пользователя **/
            $user->update($data->toArray());

            /** Синхронизируем связи с направлениями языков **/
            $user->UserLanguage()->sync($languageIds);

            /** Синхронизируем связи с направлениями cпециалистов **/
            $user->UserSpecialist()->sync($specialistIds);

            /** Синхронизируем связи с направлениями экспертов **/
            $user->UserExpert()->sync($expertIds);

            /** Синхронизируем связи с направлениями лекторов **/
            $user->UserLecturer()->sync($lecturerIds);

            /** Синхронизируем связи с направлениями видов деятельности **/
            $user->UserProduction()->sync($productionIds);

            \DB::commit(); // Подтверждение успешной транзакции
        } catch (\Throwable $exception) {
            \DB::rollBack(); // Откат транзакции в случае ошибки
            logErrors($exception);
            throw $exception; // Повторно выбрасываем исключение вверх по стеку

        }


        return true;

    }

    public function User(): Model|null
    {
        if (auth()->check()) {
            return auth()->user()->load(['UserHuman', 'UserLecturer', 'UserCity', 'UserExpert', 'UserSex', 'UserProduction', 'UserSpecialist', 'UserLanguage']);
        }
        return null;
    }

    public function userId($id): Model|null
    {
        return User::query()
            ->where('published', 1)
            ->where('id', $id)
            ->firstOrFail();
    }

    public function publishedUser($request, $user): bool
    {

        if ($user->individual) {
            // Получаем нужные массивы из объекта $request
            $specialistIds = $request->input('specialists', []);
            $expertIds = $request->input('experts', []);

            // Проверяем, что хотя бы один из массивов не пуст
            if (!empty($specialistIds) || !empty($expertIds)) {
                return false;
            }
        }


        if ($user->legal_entity) {
            return false;
        }

        return true;

    }

    /**
     * @param $relation
     * @return LengthAwarePaginator | array
     * Получение пользователей по статусу
     */
    public function registryUsers($relation): LengthAwarePaginator|array
    {
        $users = User::whereHas($relation)
            ->where('published', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(config('site.constants.paginate'));
        if (!$users || $users->isEmpty()) { // Проверяем, есть ли вообще элементы
            $users = [];
        }
        return $users;

    }

    /**
     * @return LengthAwarePaginator | array
     * Получение юр. лиц пользователей
     */
    public function registryLegalEntityUsers(): LengthAwarePaginator|array
    {
        $users = User::where('user_human_id', Status::LEGALENTITY->value)
            ->where('published', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(config('site.constants.paginate'));
        if (!$users || $users->isEmpty()) { // Проверяем, есть ли вообще элементы
            $users = [];
        }
        return $users;
    }

    /**
     * @param $search
     * @param $cityId
     * @return LengthAwarePaginator|null
     * Поиск пользователей юрид. лиц
     */
    public function UserLegalEntitiesSearch($search, $cityId): LengthAwarePaginator|null
    {
        // Основной запрос на выборку пользователей
        $usersQuery = User::query();

        // Поиск по частичному совпадению имени, компании или e-mail
        if (!empty($search)) {
            $usersQuery->where(function ($query) use ($search) {
                $query->where('username', 'LIKE', "%{$search}%")
                    ->orWhere('company', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Фильтр по выбранному городу
        if (!empty($cityId)) {
            $usersQuery->whereHas('UserCity', function ($query) use ($cityId) {
                $query->where('user_cities.id', $cityId); // Уточнили таблицу user_cities
            });
        }

        $usersQuery->where('user_human_id', Status::LEGALENTITY->value);
        $usersQuery->where('published', 1);


        // Выполнение запроса и получение результата
        return $usersQuery
            ->orderBy('created_at', 'desc')
            ->paginate(config('site.constants.paginate'));


    }
}
