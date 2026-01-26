<?php

namespace App\View\Components\Content;

use Closure;
use Domain\Tarif\ViewModels\Tarif;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ContentTarifComponent extends Component
{
    public array $tarifs;
    public int $tarif_id;
    public object | null $user;

    public function __construct($content = null)
    {
        if (is_null($content)) {

            $tarifs = Tarif::make()->tarifs();
            $this->tarifs = $tarifs->toArray();

        } else {
            // Если коллекция пустая (отношение не имеет активных тарифов)
            if ($content->tarif->isEmpty()) {
                // Обработка случая отсутствия тарифов
                $this->tarifs = [];
            } else {
                $this->tarifs = $content->tarif->toArray();
            }
        }
        $user = UserViewModel::make()->User();
        if (!is_null($user)) {
            $this->tarif_id = (is_null($user->tarif_id))? 0 : $user->tarif_id;
            $this->user = $user;
        } else {
            $this->tarif_id = 0;
            $this->user = null;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.content.content-tarif-component');
    }
}
