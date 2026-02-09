<?php

namespace App\Http\Controllers\Axios;

use App\Http\Controllers\Controller;
use App\Http\Requests\AvatarRequest;
use Domain\Manager\ViewModels\ManagerViewModel;
use Domain\ROP\ViewModels\ROPViewModel;
use Domain\User\ViewModels\UserViewModel;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AxiosUploadPhotoController extends Controller
{



    public function uploadFile($destinationPath, $request)
    {
        // Если директория не существует, создадим её
        if (!is_dir(storage_path('app/public/' . $destinationPath))) {
            /** Создадим папку **/
            mkdir(storage_path('app/public/' . $destinationPath), 0755, true);
        } else {
            /** Очистка всей папки 'avatar' перед сохранением нового файла **/
            File::deleteDirectory(storage_path('app/public/' . $destinationPath));
            /** Создадим папку **/
            mkdir(storage_path('app/public/' . $destinationPath), 0755, true);
        }

        /** Записываем  */
        $avatarPath  = Storage::disk('public')->put($destinationPath, $request->file('avatar'));
        return [
            'avatar' => $avatarPath ,
            'intervention' => asset(intervention('160x160', $avatarPath, $destinationPath. '/intervention')),
        ];

    }


    /** загрузка аватара для user-ов */
    public function uploadPhoto(AvatarRequest $request)
    {
        try {
            // Сохранение файла в хранилище
            $user = UserViewModel::make()->User();
            $destinationPath = 'users/'.$user->id.'/avatar';

            $result = $this->uploadFile($destinationPath, $request);
            /** Сохраняем  */
            $user->avatar = $result['avatar'];
            $user->save();

        } catch (\Throwable $th) {
            // Обрабатываем исключение
            logErrors($th);
        }

        return response()->json([
            'response' => $request->all(),
            'avatar' => (isset($result['avatar'])) ? $result['avatar'] : null,
            'intervention' => (isset($result['intervention'])) ? $result['intervention'] : null,
        ], 200);

    }


    /** загрузка аватара для ROP-ов */
    public function uploadROPPhoto(AvatarRequest $request)
    {

        try {

            // Сохранение файла в хранилище
            $user = ROPViewModel::make()->r(session()->get('r'));
            $destinationPath = 'rops/'.$user->id.'/avatar';
            $result = $this->uploadFile($destinationPath, $request);

            /** Сохраняем  */
            $user->avatar = $result['avatar'];
            $user->save();

        } catch (\Throwable $th) {
            // Обрабатываем исключение
            logErrors($th);
        }

        return response()->json([
            'response' => $request->all(),
            'avatar' => (isset($result['avatar'])) ? $result['avatar'] : null,
            'intervention' => (isset($result['intervention'])) ? $result['intervention'] : null,
        ], 200);

    }

    /** загрузка аватара ROP-ом для менеджеров */
    public function uploadROPManagerPhoto(AvatarRequest $request)
    {
        try {

            // Сохранение файла в хранилище
            $manager = ManagerViewModel::make()->managerId($request->manager_id);
            $destinationPath = 'managers/'.$manager->id.'/avatar';
            $result = $this->uploadFile($destinationPath, $request);

            /** Сохраняем  */
            $manager->avatar = $result['avatar'];
            $manager->save();

        } catch (\Throwable $th) {
            // Обрабатываем исключение
            logErrors($th);
        }

        return response()->json([
            'response' => $request->all(),
            'avatar' => (isset($result['avatar'])) ? $result['avatar'] : null,
            'intervention' => (isset($result['intervention'])) ? $result['intervention'] : null,
        ], 200);

    }

    /** загрузка аватара ROP-ом для пользователей */
    public function uploadROPUserPhoto(AvatarRequest $request)
    {
        try {
            // Сохранение файла в хранилище
            $users = UserViewModel::make()->UserId($request->user_id);
            $destinationPath = 'users/'.$users->id.'/avatar';
            $result = $this->uploadFile($destinationPath, $request);

            /** Сохраняем  */
            $users->avatar = $result['avatar'];
            $users->save();

        } catch (\Throwable $th) {
            // Обрабатываем исключение
            logErrors($th);
        }

        return response()->json([
            'response' => $request->all(),
            'avatar' => (isset($result['avatar'])) ? $result['avatar'] : null,
            'intervention' => (isset($result['intervention'])) ? $result['intervention'] : null,
        ], 200);

    }



}
