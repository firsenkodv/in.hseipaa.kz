<?php

namespace App\View\Components\CabinetRop;

use Closure;
use Domain\ROP\ViewModels\ROPViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HhRelation extends Component
{
    public int $vacancyCount          = 0;
    public int $vacancyModerationCount = 0;
    public int $resumeCount           = 0;
    public int $resumeModerationCount  = 0;

    public function __construct()
    {
        $r = ROPViewModel::make()->r(session()->get('r'));

        if ($r) {
            $vm = ROPViewModel::make();
            $this->vacancyCount           = $vm->ropVacancyCount($r);
            $this->vacancyModerationCount = $vm->ropVacancyUnpublishedCount($r);
            $this->resumeCount            = $vm->ropResumeCount($r);
            $this->resumeModerationCount  = $vm->ropResumeUnpublishedCount($r);
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.cabinet-rop.hh-relation');
    }
}
