<?php

namespace Domain\User\ViewModels;

use App\Models\User;
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
        /**  Укажите список нужных полей **/
        $data = $request->only(['username', 'phone', 'email', 'date_birthday', 'user_city_id',  'user_sex_id', 'iin', 'address','bin', 'company', 'position_boss', 'accountant_work', 'accountant_position', 'accountant_ticket', 'accountant_ticket_date', 'telegram', 'whatsapp', 'instagram', 'website']);

        /** Сначала получаем пользователя по указанному ID **/
        $user = User::query()->where('id', $id)->first();

        if (!$user) {
            throw new \Exception("Пользователь с указанным ID не найден.");
        }

        /** Далее выполняем обновление **/
        $rowsAffected = $user->update($data);

        if ($rowsAffected <= 0) {
            throw new \Exception("Данные пользователя не были обновлены.");
        }

        /** Получаем выбранные IDs направлений эксперта **/
        $expertIds = $request->input('experts', []); /** Чекбоксы передают именно IDs **/
        /** Синхронизируем связи с направлениями экспертов **/
        $user->UserExpert()->sync($expertIds);

        /** Получаем выбранные IDs направлений лектора **/
        $lecturerIds = $request->input('lecturers', []); /** Чекбоксы передают именно IDs **/
        /** Синхронизируем связи с направлениями лекторов **/
        $user->UserLecturer()->sync($lecturerIds);

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
