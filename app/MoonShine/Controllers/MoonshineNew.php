<?php

declare(strict_types=1);

namespace App\MoonShine\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use MoonShine\Laravel\MoonShineRequest;
use MoonShine\Laravel\Http\Controllers\MoonShineController;
use Symfony\Component\HttpFoundation\Response;

final class MoonshineNew extends MoonShineController
{
    public function new(Request $request): Response
    {
        $data = $request->all();
        Storage::disk('config')->put("moonshine/new.php", "<?php\n\n" . 'return ' . var_export($data, true) . ";\n");

        return back();
    }
}
