<?php

namespace App\View\Components\Avatar;

use App\Enums\User\Status;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AvatarUser extends Component
{
    public object | null $user;
    public bool  $woman = false;
    public bool  $man = false;
    public function __construct($user = null)
    {
        $this->user = $user;
        if($user->UserHuman) {
            $this->man = $this->user->man == 1;
            $this->woman = $this->user->woman == 2;
        }

    }



    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.avatar.avatar-user');
    }
}
