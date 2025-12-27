<?php

namespace Domain\User\ViewModels;

use App\Models\User;
use Domain\User\DTOs\UserUpdateDto;
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
    public function UserCreate($request):Model | null
    {
        return User::Create($request);

    }

    /**
     * @param $request
     * @param $id
     * @return bool
     * @throws \Exception
     * Редактирование пользователя
     */
    public function  UserUpdate($request, $id):bool
    {

        $data =  UserUpdateDto::formRequest($request);

        /** Сначала получаем пользователя по указанному ID **/
        $user = User::query()->where('id', $id)->first();

        if (!$user) {
            throw new \Exception("Пользователь с указанным ID не найден.");
        }


        /** Получаем выбранные IDs направлений эксперта **/
        $expertIds = $request->input('experts', []); /** Чекбоксы передают именно IDs **/

        /** Получаем выбранные IDs направлений лектора **/
        $lecturerIds = $request->input('lecturers', []); /** Чекбоксы передают именно IDs **/



        \DB::beginTransaction(); // Начинаем транзакцию

        try {
            /** Обновляем основного пользователя **/
            $user->update($data->toArray());

            /** Синхронизируем связи с направлениями экспертов **/
            $user->UserExpert()->sync($expertIds);

            /** Синхронизируем связи с направлениями лекторов **/
            $user->UserLecturer()->sync($lecturerIds);

            \DB::commit(); // Подтверждение успешной транзакции
        } catch (\Throwable $exception) {
            \DB::rollBack(); // Откат транзакции в случае ошибки
            logErrors($exception);
            throw $exception; // Повторно выбрасываем исключение вверх по стеку

        }




        return true;

    }

    public function User():Model | null
    {
        if(auth()->check()) {
            return auth()->user()->load(['UserHuman','UserLecturer', 'UserCity', 'UserExpert', 'UserSex']);
        }
        return null;
    }
}
