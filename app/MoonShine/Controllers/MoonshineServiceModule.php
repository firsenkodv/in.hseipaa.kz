<?php

declare(strict_types=1);

namespace App\MoonShine\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use MoonShine\Laravel\MoonShineRequest;
use MoonShine\Laravel\Http\Controllers\MoonShineController;
use Support\Traits\Upload;
use Symfony\Component\HttpFoundation\Response;

final class MoonshineServiceModule extends MoonShineController
{
    use Upload;
    //useful_module
    public function service_module(Request $request): Response
    {
        $data = $request->all();

        /**  Сохраняем файл **/
        $destinationPath = 'service/module';
        if(isset($data['temp_img'])) {
            /**  Перезаписываем **/
            $data['temp_img']  = $this->UploadFile($request->file('temp_img'), $destinationPath);
        } else {
            /**  Сохраним, что было **/
            if(config2('moonshine.service_module.temp_img')) {
               $data['temp_img'] = config2('moonshine.service_module.temp_img');
           }
        }
        Storage::disk('config')->put("moonshine/service_module.php", "<?php\n\n" . 'return ' . var_export($data, true) . ";\n");

        return back();
    }
}
