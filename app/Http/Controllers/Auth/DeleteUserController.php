<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class DeleteUserController extends Controller
{


    /**
     * Метод удаления  (User)
     * clearFolder  - удаляет фото и папки
     * update  - удаляету всех пользователей у кого был этот менеджер
     */

    public function destroy(Request $request)
    {
        /**
         * Получаем страницу откуда пришли
         * $last =  Это id user-а
         */
        $url = url()->previous();
        $slugs = explode("/", $url);
        $last = $slugs [(count($slugs) - 1)];

        /**
         * Проверим, страницу откуда пришли и id user-a
         */
        if ($last == $request->id) {


           $disk =  $this->checkManager($request);



            /**
             * Удаляем user-а
             */
            User::destroy($request->id);

            /**
             * Удаляем все папки и фото manager-а или user-a (зависит от $disk)
             */
            $info = clearFolder($request->id, $disk);

            /**
             * Подготовимся к redirect
             */
            flash()->info(__('Запись удалена. ' . $info ));

            if ($request->redirect) {
                return redirect('/' . $request->redirect);
            }

        }

        return redirect()->intended(route('cabinet'));

    }

    public function checkManager ($request)
    {

       $manager =  User::query()
            ->where('id', $request->id)
            ->where('manager', 1)
            ->count();
       if($manager) {

           /**
            * Нельзя удалять последнего менеджера
            */
           $count = User::query()->where('manager', 1)->count();
           if ($count == 1) {
               flash()->alert(__('Отмена. Это последний менеджер.'));
               return back();
           }

           /**
            * Проверим, является ли удаляемый менеджер по умолчанию!
            */
           $fixed_users = Manager::query()
               ->where('user_id', '=', $request->id)
               ->where('fixed_users', '=', 1)
               ->first();

           /**
            * Если, да, то назначим любого другого (inRandomOrder)
            */
           if ($fixed_users) {
               Manager::query()
                   ->inRandomOrder()
                   ->first()
                   ->update(
                       ['fixed_users' => 1]
                   );
           }

           /**
            * Открепляем менеджера у всех user-ов
            */
           User::query()
               ->where('fixed', '=', $request->id)
               ->update(
                   ['fixed' => null]
               );
       return 'managers'; // название диска для удаления файлов

       }
       return 'files'; // название диска для удаления файлов

    }

}
