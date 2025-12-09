<?php

namespace Domain\SavedFormData\ViewModel;

use App\Models\SavedFormData;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\EmailAddressCollector;
use Support\Traits\Makeable;

class SavedFormDataViewModel
{
    use Makeable;
use EmailAddressCollector;
    public function save($request):Model | null
    {
       return SavedFormData::query()->create(
       [
           'title' => $request->url,
           'params' => $request->all(),
           'email' => (count($this->emails()))? implode(", ", $this->emails()) : 'Ошибка!!! Не найти email для отправки'
       ]
       );

    }

}
