<?php

namespace Domain\User\ViewModels;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Makeable;

class UserFilesViewModel
{
    use Makeable;


    public function fileExtensions($filesArray): array
    {
        if ($filesArray !== null || is_array($filesArray)) {
            $fileExtensions = [];
            foreach ($filesArray as $fileItem) {
                $fullPath = \Storage::url($fileItem['json_file']);
                $fileName = basename($fullPath);               // example.pdf
                $fileExt = pathinfo($fileName)['extension'];  // pdf | png

                // Определяем иконку по типу файла
                $iconClass = match ($fileExt) {
                    'jpg', 'jpeg', 'png', 'gif' => 'fa fa-file-image-o',
                    'pdf' => 'fa fa-file-pdf-o',
                    'doc', 'docx' => 'fa fa-file-word-o',
                    default => 'fa fa-file-o'
                };

                // Формируем новый массив
                $fileExtensions[] = [
                    'url' => asset($fullPath),    // Преобразуем относительный путь в абсолютный
                    'extension' => $fileExt,
                    'icon_class' => $iconClass,
                    'json_file' => $fileItem['json_file']

                ];
            }

            return $fileExtensions;
        }
        return [];


    }

}
