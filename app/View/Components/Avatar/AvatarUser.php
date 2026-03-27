<?php

namespace App\View\Components\Avatar;

use App\Enums\User\Status;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AvatarUser extends Component
{
    public ?object $user;
    public bool  $woman = false;
    public bool  $man = false;
    public string $intervention;
    public string $managerid='';
    public string $userid='';

    public string $route = '';
    public bool $readonly = false;
    public function __construct($user, $route = '', $folder  = 'users', $managerid = '', $userid = '', $readonly = false)
    {
        $this->user = $user;
        if($user->UserHuman) {
            $this->man = $this->user->man == 1;
            $this->woman = $this->user->woman == 2;
        } else {
            $this->man = true;
        }

        $this->intervention = $folder . '/' .  $this->user->id . '/avatar/intervention';
        $this->managerid = $managerid;
        $this->userid = $userid;
        $this->route = $route;
        $this->readonly = $readonly;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.avatar.avatar-user');
    }
}
