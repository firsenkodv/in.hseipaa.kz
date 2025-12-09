<?php

namespace App\MoonShine\Fields;

use Illuminate\Support\Facades\Storage;
use MoonShine\UI\Fields\Field;

class SavesFormData extends Field
{
    protected string $view = 'moonshine.fields.saved_form_data';

    public string $params;
    protected function fields():array | bool
    {
        $array = [];

        $id = $this->getData()->getKey();
        if ($id) {
           return  (isset($this->getData()->toArray()['params']))? $this->getData()->toArray()['params'] : [];
        }
        return false;

    }


    protected function viewData(): array
    {
        return [
            'params' => $this->fields(),
        ];
    }
}
