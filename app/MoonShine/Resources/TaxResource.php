<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tax;

use Illuminate\Http\UploadedFile;
use MoonShine\Laravel\Enums\Action;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\ListOf;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Field;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends ModelResource<Tax>
 */
class TaxResource extends ModelResource
{
    protected string $model = Tax::class;

    protected string $title = 'Налоговый календарь';

    protected string $column = 'y';

    protected string $sortColumn = 'y';


    public function search(): array
    {
        return ['title'];
    }

    /*    protected ?ClickAction $clickAction = ClickAction::EDIT;*/


    public function indexFields(): array
    {
        return [
            ID::make()
                ->sortable(),

            Text::make(__('Название'), 'title'),
            Text::make(__('Год'), 'y'),
            Switcher::make('title', 'metatitle'),
            Switcher::make('description', 'description'),
            Switcher::make('keywords', 'keywords'),
            Switcher::make('Публикация', 'published')->updateOnPreview(),
            Switcher::make('Начало', 'presently')->updateOnPreview(),


        ];
    }


    public function formFields(): array
    {
        return [
            Box::make([
                Tabs::make([

                    Tab::make(__('Общие настройки'), [
                        Grid::make([
                            Column::make([

                                Collapse::make('Заголовок/Алиас', [
                                    Text::make('Заголовок', 'title')->required(),
                                    Text::make('Заголовок в меню', 'menu')->hint('Если не заполнить, выведется заголовок')->unescape(),
                                    Slug::make('Алиас', 'slug')
                                        ->from('title')->unique(),
                                    Select::make('Выбрать год', 'y')->options($this->y())->default(date("Y")),
                                    Text::make('Подзаголовок', 'subtitle')->unescape(),

                                ]),


                            ])
                                ->columnSpan(6),
                            Column::make([

                                Collapse::make('Детали вывода', [

                                    Switcher::make('Публикация', 'published')->default(1),
                                    Switcher::make('Начало отчета', 'presently')->default(1)->hint('Данный переключатель показывает, что нужно учитывать текущий месяц на календаре. Если отключить его, будет начала с января.'),


                                ]),


                                Collapse::make('Метаданные', [

                                    Text::make('Мета тэг (title) ', 'metatitle')->unescape(),
                                    Text::make('Мета тэг (description) ', 'description')->unescape(),
                                    Text::make('Мета тэг (keywords) ', 'keywords')->unescape(),
                                ]),


                            ])
                                ->columnSpan(6)

                        ]),

                        Grid::make([

                            Column::make([
                                Collapse::make('', [
                                    TinyMce::make('Общее описание', 'desc'),

                                ]),

                            ])->columnSpan(12),
                        ]),
                    ]),


                    Tab::make(__('Январь'), [
                        Grid::make([

                            Column::make([

                                Json::make('Январь', 'jan')->fields([

                                    Date::make('Дата', 'json_date')->format('d.m.Y')->hint('Дата события'),
                                    TinyMce::make('Описание', 'json_text')->hint('HTML'),
                                ])->vertical()->creatable(limit: 31)
                                    ->removable(),
                            ])->columnSpan(6),
                            Column::make([])->columnSpan(6),
                        ]),


                    ]),
                    Tab::make(__('Февраль'), [
                        Grid::make([

                            Column::make([

                                Json::make('Февраль', 'feb')->fields([

                                    Date::make('Дата', 'json_date')->format('d.m.Y')->hint('Дата события'),
                                    TinyMce::make('Описание', 'json_text')->hint('HTML'),
                                ])->vertical()->creatable(limit: 31)
                                    ->removable(),
                            ])->columnSpan(6),
                            Column::make([])->columnSpan(6),
                        ]),


                    ]),
                    Tab::make(__('Март'), [
                        Grid::make([

                            Column::make([

                                Json::make('Март', 'mar')->fields([

                                    Date::make('Дата', 'json_date')->format('d.m.Y')->hint('Дата события'),
                                    TinyMce::make('Описание', 'json_text')->hint('HTML'),
                                ])->vertical()->creatable(limit: 31)
                                    ->removable(),
                            ])->columnSpan(6),
                            Column::make([])->columnSpan(6),
                        ]),


                    ]),
                    Tab::make(__('Апрель'), [
                        Grid::make([

                            Column::make([

                                Json::make('Апрель', 'apr')->fields([

                                    Date::make('Дата', 'json_date')->format('d.m.Y')->hint('Дата события'),
                                    TinyMce::make('Описание', 'json_text')->hint('HTML'),
                                ])->vertical()->creatable(limit: 31)
                                    ->removable(),
                            ])->columnSpan(6),
                            Column::make([])->columnSpan(6),
                        ]),


                    ]),
                    Tab::make(__('Май'), [
                        Grid::make([

                            Column::make([

                                Json::make('Май', 'mai')->fields([

                                    Date::make('Дата', 'json_date')->format('d.m.Y')->hint('Дата события'),
                                    TinyMce::make('Описание', 'json_text')->hint('HTML'),
                                ])->vertical()->creatable(limit: 31)
                                    ->removable(),
                            ])->columnSpan(6),
                            Column::make([])->columnSpan(6),
                        ]),


                    ]),
                    Tab::make(__('Июнь'), [
                        Grid::make([

                            Column::make([

                                Json::make('Июнь', 'jun')->fields([

                                    Date::make('Дата', 'json_date')->format('d.m.Y')->hint('Дата события'),
                                    TinyMce::make('Описание', 'json_text')->hint('HTML'),
                                ])->vertical()->creatable(limit: 31)
                                    ->removable(),
                            ])->columnSpan(6),
                            Column::make([])->columnSpan(6),
                        ]),


                    ]),
                    Tab::make(__('Июль'), [
                        Grid::make([

                            Column::make([

                                Json::make('Июль', 'jul')->fields([

                                    Date::make('Дата', 'json_date')->format('d.m.Y')->hint('Дата события'),
                                    TinyMce::make('Описание', 'json_text')->hint('HTML'),
                                ])->vertical()->creatable(limit: 31)
                                    ->removable(),
                            ])->columnSpan(6),
                            Column::make([])->columnSpan(6),
                        ]),


                    ]),
                    Tab::make(__('Август'), [
                        Grid::make([

                            Column::make([

                                Json::make('Август', 'aug')->fields([

                                    Date::make('Дата', 'json_date')->format('d.m.Y')->hint('Дата события'),
                                    TinyMce::make('Описание', 'json_text')->hint('HTML'),
                                ])->vertical()->creatable(limit: 31)
                                    ->removable(),
                            ])->columnSpan(6),
                            Column::make([])->columnSpan(6),
                        ]),


                    ]),
                    Tab::make(__('Сентябрь'), [
                        Grid::make([

                            Column::make([

                                Json::make('Сентябрь', 'sept')->fields([

                                    Date::make('Дата', 'json_date')->format('d.m.Y')->hint('Дата события'),
                                    TinyMce::make('Описание', 'json_text')->hint('HTML'),
                                ])->vertical()->creatable(limit: 31)
                                    ->removable(),
                            ])->columnSpan(6),
                            Column::make([])->columnSpan(6),
                        ]),


                    ]),
                    Tab::make(__('Октябрь'), [
                        Grid::make([

                            Column::make([

                                Json::make('Октябрь', 'oct')->fields([

                                    Date::make('Дата', 'json_date')->format('d.m.Y')->hint('Дата события'),
                                    TinyMce::make('Описание', 'json_text')->hint('HTML'),
                                ])->vertical()->creatable(limit: 31)
                                    ->removable(),
                            ])->columnSpan(6),
                            Column::make([])->columnSpan(6),
                        ]),


                    ]),
                    Tab::make(__('Ноябрь'), [
                        Grid::make([

                            Column::make([

                                Json::make('Ноябрь', 'nov')->fields([

                                    Date::make('Дата', 'json_date')->format('d.m.Y')->hint('Дата события'),
                                    TinyMce::make('Описание', 'json_text')->hint('HTML'),
                                ])->vertical()->creatable(limit: 31)
                                    ->removable(),
                            ])->columnSpan(6),
                            Column::make([])->columnSpan(6),
                        ]),


                    ]),
                    Tab::make(__('Декабрь'), [
                        Grid::make([

                            Column::make([

                                Json::make('Декабрь', 'dec ')->fields([

                                    Date::make('Дата', 'json_date')->format('d.m.Y')->hint('Дата события'),
                                    TinyMce::make('Описание', 'json_text')->hint('HTML'),
                                ])->vertical()->creatable(limit: 31)
                                    ->removable(),
                            ])->columnSpan(6),
                            Column::make([])->columnSpan(6),
                        ]),


                    ]),
                    Tab::make(__('FAQ'), [

                        Grid::make([
                            Column::make([
                                Collapse::make('Вопрос/Ответ', [
                                    Text::make('Заголовок', 'faq_title')->unescape(),

                                    Json::make('Вопрос-ответ', 'faq')->fields([
                                        Textarea::make('Вопрос', 'faq_question'),
                                        TinyMce::make('Ответ', 'faq_answer')

                                    ])->vertical()->creatable(limit: 50)
                                        ->removable(),

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
            'title' => [
                'required',
            ],


        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
        ];
    }

    protected function activeActions(): ListOf
    {
        return parent::activeActions()
            ->except(Action::VIEW /*Action::MASS_DELETE, Action::DELETE, Action::CREATE*/)// ->only(Action::VIEW)
            ;
    }


    protected function y(): array
    {
        for ($i = 2020; $i < 2040; $i++) {

            $a[$i] = $i;
        }
        return $a;

    }
}

