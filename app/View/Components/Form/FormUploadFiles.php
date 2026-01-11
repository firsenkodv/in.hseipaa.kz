<?php

namespace App\View\Components\Form;

use Closure;
use Domain\User\ViewModels\UserFilesViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormUploadFiles extends Component
{
    public array|null $value = [];

    public function __construct($value)
    {

        $fileExtensions  =  UserFilesViewModel::make()->fileExtensions($value);
        $this->value = $fileExtensions;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.form-upload-files');
    }
}
