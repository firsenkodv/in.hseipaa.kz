<?php

namespace App\MoonShine\Fields;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\ComponentAttributeBag;
use MoonShine\UI\Fields\Field;


class Video extends  Field
{
    protected string $view = 'moonshine.fields.video';

    protected function fields():string | bool
    {
        $array = [];

        $id = $this->getData()->getKey();
        if ($id) {
            if($this->getData()->toArray()['video']) {
                return   asset(Storage::url($this->getData()->toArray()['video']));
            }
        }
        return false;

    }


    protected function viewData(): array
    {
        return [
            'video' => $this->fields(),
        ];
    }

}
