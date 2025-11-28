<?php

namespace App\View\Components\Social;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeaderSocialnetworkComponent extends Component
{

    public string | null $telegram;
    public string | null $facebook;
    public string | null $youtube;
    public string | null $instagram;

    public function __construct()
    {
        $this->telegram = (config2('moonshine.setting.telegram')) ? trim(config2('moonshine.setting.telegram')) : null;
        $this->facebook = (config2('moonshine.setting.facebook')) ? trim(config2('moonshine.setting.facebook')) : null;
        $this->youtube = (config2('moonshine.setting.youtube')) ? trim(config2('moonshine.setting.youtube')) : null;
        $this->instagram = (config2('moonshine.setting.instagram')) ? trim(config2('moonshine.setting.instagram')) : null;

    }

    public function render(): View|Closure|string
    {
        return view('components.social.header-socialnetwork-component');
    }
}
