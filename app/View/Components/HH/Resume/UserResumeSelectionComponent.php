<?php

namespace App\View\Components\HH\Resume;

use Closure;
use Domain\HH\Resume\ViewModel\ResumeViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserResumeSelectionComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public readonly mixed $user,
    ) {}

    public function render(): View|Closure|string
    {
        $hasTarif = $this->user && $this->user->hasTarif;

        $resumeCount = $this->user
            ? ResumeViewModel::make()->countByUser($this->user->id)
            : 0;

        $archiveCount = $this->user
            ? ResumeViewModel::make()->countArchiveByUser($this->user->id)
            : 0;

        return view('components.h-h.resume.user-resume-selection-component', [
            'hasTarif'    => $hasTarif,
            'resumeCount' => $resumeCount,
            'archiveCount' => $archiveCount,
        ]);
    }

}
