<?php

namespace App\View\Components\HH\Vacancy;

use Closure;
use Domain\HH\Vacancy\ViewModel\VacancyViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserVacancySelectionComponent extends Component
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

        $vacancyCount = $this->user
            ? VacancyViewModel::make()->countByUser($this->user->id)
            : 0;

        $archiveCount = $this->user
            ? VacancyViewModel::make()->countArchiveByUser($this->user->id)
            : 0;

        return view('components.h-h.vacancy.user-vacancy-selection-component', [
            'hasTarif'     => $hasTarif,
            'vacancyCount' => $vacancyCount,
            'archiveCount' => $archiveCount,
        ]);
    }

}
