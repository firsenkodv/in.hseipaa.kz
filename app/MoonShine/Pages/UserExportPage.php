<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Models\UserCity;
use App\Models\UserExpert;
use App\Models\UserFileQualification;
use App\Models\UserHuman;
use App\Models\UserLecturer;
use App\Models\UserSpecialist;
use MoonShine\Laravel\Pages\Page;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Support\Enums\FormMethod;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\Checkbox;
use MoonShine\UI\Fields\Select;

class UserExportPage extends Page
{
    public function getBreadcrumbs(): array
    {
        return ['#' => $this->getTitle()];
    }

    public function getTitle(): string
    {
        return $this->title ?: 'Экспорт пользователей';
    }

    /**
     * @return list<ComponentContract>
     */
    protected function components(): iterable
    {
        $cities      = UserCity::orderBy('sorting', 'DESC')->pluck('title', 'id')->toArray();
        $humans      = UserHuman::orderBy('sorting', 'DESC')->pluck('title', 'id')->toArray();
        $qualifications = UserFileQualification::orderBy('sorting', 'DESC')->get();
        $specialists    = UserSpecialist::orderBy('sorting', 'DESC')->get();
        $experts        = UserExpert::orderBy('sorting', 'DESC')->get();
        $lecturers      = UserLecturer::orderBy('sorting', 'DESC')->get();

        // Checkboxes for each group
        $qualificationCheckboxes = $this->buildCheckboxes($qualifications, 'qualifications');
        $specialistCheckboxes    = $this->buildCheckboxes($specialists, 'specialists');
        $expertCheckboxes        = $this->buildCheckboxes($experts, 'experts');
        $lecturerCheckboxes      = $this->buildCheckboxes($lecturers, 'lecturers');

        return [
            Box::make([
                FormBuilder::make('/moonshine/users-export', FormMethod::GET)
                    ->fields([
                        Divider::make('Основные фильтры'),

                        Grid::make([
                            Column::make([
                                Select::make('Город', 'city_id')
                                    ->options($cities)
                                    ->nullable()
                                    ->placeholder('Все города'),
                            ])->columnSpan(6),

                            Column::make([
                                Select::make('Физ. лицо / Юр. лицо', 'user_human_id')
                                    ->options($humans)
                                    ->nullable()
                                    ->placeholder('Все типы'),
                            ])->columnSpan(6),
                        ]),

                        Divider::make('Квалификации'),
                        Grid::make($qualificationCheckboxes),

                        Divider::make('Специалист'),
                        Grid::make($specialistCheckboxes),

                        Divider::make('Эксперт'),
                        Grid::make($expertCheckboxes),

                        Divider::make('Лектор'),
                        Grid::make($lecturerCheckboxes),
                    ])
                    ->submit('⬇ Скачать Excel-файл', ['class' => 'btn-primary']),
            ]),
        ];
    }

    private function buildCheckboxes(\Illuminate\Database\Eloquent\Collection $items, string $group): array
    {
        if ($items->isEmpty()) {
            return [Column::make([])->columnSpan(12)];
        }

        $columns = [];
        foreach ($items as $item) {
            $columns[] = Column::make([
                Checkbox::make($item->title, $group . '[' . $item->id . ']'),
            ])->columnSpan(3);
        }
        return $columns;
    }
}
