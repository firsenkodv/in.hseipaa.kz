<?php

namespace App\View\Components\HH\Vacancy;

use Closure;
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

        return view('components.h-h.vacancy.user-vacancy-selection-component', [
            'hasTarif' => $hasTarif,
        ]);
    }

}
