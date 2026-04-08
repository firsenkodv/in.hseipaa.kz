<?php

namespace App\View\Components\CabinetUser\Menu;

use Closure;
use Domain\CabinetMessage\ViewModels\CabinetMessageViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CabinetUserTopMenu extends Component
{
    public object | null $user;
    public int $unread;

    public function __construct($user = null)
    {
        $this->user   = $user;
        $this->unread = CabinetMessageViewModel::make()->unreadCountForUser(auth()->id());
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.menu.cabinet-user-top-menu');
    }
}
