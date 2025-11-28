<?php

namespace App\MoonShine\Fields;

use Illuminate\Support\Facades\Storage;
use MoonShine\UI\Fields\Field;

class PreviewImage extends Field
{
    protected string $view = 'moonshine.fields.preview_image';

    public string $img;

    public function default($img): self
    {
        $this->img = $img;
        return $this;
    }




    protected function viewData(): array
    {
        return [
            'img' => $this->img,
        ];
    }

}
