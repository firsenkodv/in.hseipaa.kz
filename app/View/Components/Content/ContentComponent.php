<?php

namespace App\View\Components\Content;

use Closure;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ContentComponent extends Component
{
    public ?object $content;
    public bool $tariff_has_been_paid;
    public function __construct($content)
    {
        $this->content = $content;
        $user = UserViewModel::make()->User();

        $this->content = $content;
        $user = UserViewModel::make()->user(); // Получаем текущего пользователя

        //tarif_id - проверяем на false
        $this->tariff_has_been_paid = !is_null($user) && $user->tarif_id;


    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.content.content-component');
    }
}
