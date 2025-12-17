<?php

namespace App\Http\Controllers\Axios;

use App\Http\Controllers\Controller;
use App\Http\Requests\AvatarRequest;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AxiosUploadPhotoController extends Controller
{
    public function uploadPhoto(AvatarRequest $request)

    {

        try {

            // Сохранение файла в хранилище
            $user = UserViewModel::make()->User();
            $destinationPath = 'users/'.$user->id.'/avatar';
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
            $avatar = Storage::disk('public')->put($destinationPath, $request->file('avatar'));

            /** Создаем новый файл intervention **/
            $intervention =  asset(intervention('160x160', $avatar, 'users/' . $user->id . '/avatar/intervention'));

            /** Сохраняем  */
            $user->avatar = $avatar;
            $user->save();

            return response()->json([
                'response' => $request->all(),
                'avatar' => $avatar,
                'intervention' => $intervention,
            ], 200);

        } catch (\Throwable $th) {

            // Обрабатываем исключение
            logErrors($th);


        }

    }

}
