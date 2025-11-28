<?php

namespace App\View\Components\Content;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DownloadFileComponent extends Component
{

    public $files;
    public function __construct($files = null)
    {
        $this->files = $files;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.content.download-file-component');
    }
}
