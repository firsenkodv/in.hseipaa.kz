<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Poll;
use App\Models\UserCity;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

class PollResource extends ModelResource
{
    protected string $model = Poll::class;
    protected string $title = 'Голосования';
    protected string $column = 'title';

    public function search(): array
    {
        return ['title'];
    }

    public function indexFields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'title'),
            Switcher::make('Для всех', 'for_all')->updateOnPreview(),
            Switcher::make('Активно', 'is_active')->updateOnPreview(),
        ];
    }

    public function formFields(): array
    {
        $cityOptions = UserCity::orderBy('title')->pluck('title', 'id')->toArray();

        return [
            Box::make([
                Tabs::make([

                    Tab::make('Основное', [
                        Grid::make([
                            Column::make([
                                Collapse::make('Голосование', [
                                    Text::make('Название', 'title')->required(),
                                    Switcher::make('Активно', 'is_active')->default(1),
                                ]),
                                Collapse::make('Вопросы', [
                                    Json::make('Вопросы', 'questions')
                                        ->fields([
                                            Textarea::make('Вопрос', 'question')->required(),
                                        ])
                                        ->vertical()
                                        ->creatable(limit: 50)
                                        ->removable(),
                                ]),
                            ])->columnSpan(12),
                        ]),
                    ]),

                    Tab::make('Аудитория', [
                        Grid::make([
                            Column::make([
                                Collapse::make('Для кого', [
                                    Switcher::make('Для всех', 'for_all')
                                        ->default(1)
                                        ->hint('Если включено — остальные критерии игнорируются'),

                                    Select::make('Города', 'city_ids')
                                        ->multiple()
                                        ->options($cityOptions)
                                        ->nullable()
                                        ->hint('Пользователи из выбранных городов'),

                                    Select::make('Тип лица', 'person_type')
                                        ->nullable()
                                        ->options([
                                            'individual' => 'Физическое лицо',
                                            'legal'      => 'Юридическое лицо',
                                        ])
                                        ->hint('Оставьте пустым, чтобы не фильтровать по типу'),

                                    Switcher::make('Только с тарифом', 'has_tariff')
                                        ->hint('Пользователи с активным тарифом'),

                                    Switcher::make('Специалисты', 'is_specialist'),
                                    Switcher::make('Эксперты', 'is_expert'),
                                    Switcher::make('Лекторы', 'is_lecturer'),
                                ]),
                            ])->columnSpan(12),
                        ]),
                    ]),

                ]),
            ]),
        ];
    }

    protected function rules(mixed $item): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
        ];
    }

    protected function detailFields(): iterable
    {
        return [ID::make()];
    }
}
