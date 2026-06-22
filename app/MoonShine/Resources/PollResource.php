<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Poll;
use App\Models\UserCity;
use MoonShine\Laravel\Enums\Action;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use Illuminate\Support\Facades\Storage;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Preview;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

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
            Date::make('Действует до', 'expires_at')->format('d.m.Y'),
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
                                    Date::make('Действует до', 'expires_at')
                                        ->nullable()
                                        ->hint('Дата окончания опроса. После этой даты пользователи не смогут голосовать, но опрос остаётся видимым.'),
                                ]),
                                Collapse::make('Вопросы и варианты ответов', [
                                    Json::make('Вопросы', 'questions')
                                        ->fields([
                                            Text::make('Вопрос', 'question')->required(),
                                            Json::make('Варианты ответа', 'options')
                                                ->fields([
                                                    Text::make('Вариант', 'option')->required(),
                                                ])
                                                ->creatable(limit: 10)
                                                ->removable(),
                                        ])
                                        ->vertical()
                                        ->creatable(limit: 50)
                                        ->removable(),
                                ]),
                            ])->columnSpan(12),
                        ]),
                    ]),

                    Tab::make('Результаты', [
                        Grid::make([
                            Column::make([
                                Collapse::make('Файл с результатами', [
                                    Preview::make(
                                        'Скачать Excel',
                                        'results_file',
                                        static function (Poll $item): string {
                                            $value = $item->results_file;
                                            if (!$value) {
                                                return '<span style="color:#667085;font-size:14px;">
                                                    Файл будет сформирован автоматически после даты окончания опроса.<br>
                                                    Команда запуска вручную: <code>php artisan poll:export-results</code>
                                                </span>';
                                            }
                                            $url = Storage::disk('public')->url($value);
                                            return '<a href="' . e($url) . '" target="_blank" download
                                                style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;
                                                       background:#2dac6a;color:#fff;border-radius:6px;font-weight:600;
                                                       text-decoration:none;font-size:15px;">
                                                ⬇ Скачать Excel-файл
                                            </a>';
                                        }
                                    ),
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

    protected function activeActions(): ListOf
    {
        return parent::activeActions()
            ->except(Action::VIEW /*Action::MASS_DELETE, Action::DELETE, Action::CREATE*/)// ->only(Action::VIEW)
            ;
    }


    protected function detailFields(): iterable
    {
        return [ID::make()];
    }
}
