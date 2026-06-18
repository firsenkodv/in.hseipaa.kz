<?php

namespace App\Http\Controllers\Axios;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Domain\User\ViewModels\UserFilesViewModel;
use Domain\User\ViewModels\UserViewModel;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Support\Traits\Upload;

class AxiosUploadFilesController extends Controller
{

    use Upload;
    public function uploadFiles(Request $request) {

        $request->validate([
            'files' => ['required','array'],                     //  Обязательное поле массива
            'files.*' => ['mimes:jpg,jpeg,png,gif,pdf,doc,docx', //  Форматы разрешённых файлов
                'max:15360'],                                     //  Максимальный размер ~15MB (15360KB)
            'field_name' => ['required', 'string']               // Имя поля для обновления
        ]);


        /** Получаем имя поля для обновления **/
        $fieldName = $request->input('field_name');
        /** должен быть $request->id */
        $user = UserViewModel::make()->UserId($request->id);
        $filesInfo = [];
        $filesCollections = [];
        foreach ($request->file('files') as $file) {
            // Определим путь до целевой папки
            $directory = 'users/' . $user->id . '/'. $fieldName .'/';

            // Проверяем, существует ли папка, и создаём её, если её нет
            if (!Storage::exists($directory)) {

             Storage::makeDirectory($directory, 0755, true); // Третий аргумент разрешает рекурсивное создание вложенных папок

            }

            // Разбираем имя файла на составляющие
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Название файла без расширения
            $fileExt = $file->getClientOriginalExtension();    // Расширение файла
            $fullPath = $directory . $originalFilename . '.' . $fileExt;

            // Сохраняем файл с указанным путём и именем
            $file->storePubliclyAs('', $fullPath);

            // Определяем иконку по типу файла
            $iconClass = match ($fileExt) {
                'jpg', 'jpeg', 'png', 'gif' => 'fa fa-file-image-o',
                'pdf' => 'fa fa-file-pdf-o',
                'doc', 'docx' => 'fa fa-file-word-o',
                default => 'fa fa-file-o'
            };

            $filesInfo[] = [
                'url' => asset(Storage::url($fullPath)),      // Преобразуем относительный путь в абсолютный
                'extension' => $fileExt,
                'icon_class' => $iconClass,
                'json_file' => $fullPath
            ];

            $filesCollections[] = [
                'url'        => asset(Storage::url($fullPath)),
                'extension'  => $fileExt,
                'icon_class' => $iconClass,
                'json_file'  => $fullPath,
            ];

        }




        /** Получаем текущие файлы из базы данных **/
        $existingFiles = ($user->$fieldName ? $user->$fieldName->toArray() : []);

       // Объединяем старые и новые файлы
        $updatedFiles = array_merge($existingFiles, $filesCollections);


        // Обновляем модель пользователя
        $user->update([$fieldName => $updatedFiles]);


        return [
            'success' => true,
            'message' => 'Файлы успешно загружены',
            'files'   => $filesInfo                           // Возвращаем готовый массив
        ];
    }



    public function uploadReportFiles(Request $request): JsonResponse
    {
        $request->validate([
            'files'     => ['required', 'array'],
            'files.*'   => ['mimes:pdf', 'max:15360'],
            'report_id' => ['nullable', 'integer'],
        ]);

        $user     = auth()->user();
        $reportId = $request->integer('report_id');

        $directory = $reportId
            ? 'reports/' . $user->id . '/' . $reportId . '/'
            : 'reports/temp/' . $user->id . '/';

        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory, 0755, true);
        }

        $filesInfo = [];
        foreach ($request->file('files') as $file) {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fileExt          = $file->getClientOriginalExtension();
            $fullPath         = $directory . $originalFilename . '.' . $fileExt;

            $file->storePubliclyAs('', $fullPath);

            $filesInfo[] = [
                'url'        => asset(Storage::url($fullPath)),
                'extension'  => $fileExt,
                'icon_class' => 'fa-file-pdf-o',
                'json_file'  => $fullPath,
            ];
        }

        return response()->json([
            'success' => true,
            'files'   => $filesInfo,
        ]);
    }

    public function deleteReportFiles(Request $request): JsonResponse
    {
        $request->validate([
            'json_file'  => ['required', 'string'],
            'report_id'  => ['nullable', 'integer'],
        ]);

        $user     = auth()->user();
        $strFile  = $request->input('json_file');
        $reportId = $request->integer('report_id');

        // Проверяем, что файл принадлежит текущему пользователю
        $belongsToUser = str_starts_with($strFile, 'reports/' . $user->id . '/')
            || str_starts_with($strFile, 'reports/temp/' . $user->id . '/');

        if (!$belongsToUser) {
            return response()->json(['success' => false, 'message' => 'Access denied'], 403);
        }

        if (Storage::disk('public')->exists($strFile)) {
            Storage::disk('public')->delete($strFile);
        }

        // Если редактируем существующий отчёт — немедленно убираем файл из БД
        if ($reportId) {
            $report = Report::where('id', $reportId)->where('user_id', $user->id)->first();
            if ($report && $report->certificates) {
                $certs = array_values(
                    array_filter($report->certificates->toArray(), fn($c) => $c['json_file'] !== $strFile)
                );
                $report->update(['certificates' => $certs ?: null]);
            }
        }

        return response()->json(['success' => true]);
    }

    public function deleteFiles(Request $request) {

      try {
                /** Получаем необходимые данные из формы **/
                $fieldName = $request->input('field_name'); // Имя поля (например, 'file_id_card')
                $strFile = $request->input('field_value'); // Название удаляемого файла

                /** Проверяем существование пользователя **/
                $user = UserViewModel::make()->UserId($request->id);

                /** Приводим файл к массиву (если это коллекция) **/
                $filesArray = $user->$fieldName ?? []; // Если поле undefined, получаем пустой массив

                /** Удаляем указанный файл из массива **/
                foreach ($filesArray as $key => $file) {

                    if ($file['json_file'] === $strFile) { // Простое сравнение строки файла
                        unset($filesArray[$key]);
                        break;
                    }
                }


                /** Обновляем поле пользователя **/
                $user->$fieldName = $filesArray;
                $user->save();

          /** Удаляем файл физически с диска **/
          if (Storage::disk('public')->exists($strFile)) {
              $this->deleteFile($strFile);
          }

          $fileExtensions  =  UserFilesViewModel::make()->fileExtensions($filesArray);

          return response()->json([
                    'success' => true,
                    'message' => 'Файл успешно удалён.',
                    'files' => $fileExtensions
                ]);

            } catch (\Exception $ex) {

          /** Обрабатываем исключение **/
          logErrors($ex);
                return response()->json([
                    'success' => false,
                    'message' => 'Ошибка при удалении файла: ' . $ex->getMessage(),
                ], 500);
            }
        }

}
