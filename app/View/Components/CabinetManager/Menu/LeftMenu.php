<?php

namespace App\View\Components\CabinetManager\Menu;

use App\Enums\User\MarkedDeleteEnum;
use Closure;
use Domain\Manager\ViewModels\ManagerViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LeftMenu extends Component
{
    public ?object $users;
    public  int $countUsers = 0;
    public  int $countLockedUsers = 0;
    public  int $countDeletedUsers = 0;
    public function __construct()
    {
        $m = ManagerViewModel::make()->m(session()->get('m'));
        $this->users = ManagerViewModel::make()->managerUserList($m);
        $this->countUsers        = (!is_null($this->users)) ? $this->users->count() : 0;
        $this->countLockedUsers  = (!is_null($this->users)) ? $this->users->where('published', 0)->where('marked_delete', MarkedDeleteEnum::NONE->value)->count() : 0;
        $this->countDeletedUsers = (!is_null($this->users)) ? $this->users->where('marked_delete', MarkedDeleteEnum::MARKED->value)->count() : 0;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cabinet-manager.menu.left-menu');
    }
}
