<?php

namespace Domain\Menu\ViewModels;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Makeable;

class MenuViewModel
{
    use Makeable;

    public function footerMenu(): Model|null
    {
        return Menu::find(1); // 1 - нижнее меню в админке

    }
    public function hamburgerMenu(): Model|null
    {
        return Menu::find(3); // 3 - верхне меню в админке hamburgerMenu

    }

}
