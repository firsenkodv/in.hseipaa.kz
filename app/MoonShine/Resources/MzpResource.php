<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Mzp;

use MoonShine\Laravel\Enums\Action;
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
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends ModelResource<Mzp>
 */
class MzpResource extends ModelResource
{
    protected string $model = Mzp::class;

    protected string $title = 'МЗП';

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

                                Collapse::make('Заполнение обязательно', [

                                Json::make('TD 1', 'td_1')->fields([
                                    Textarea::make('Описание', 'td_1_text'),
                                    Date::make('Дата', 'td_1_date')

                                ])->vertical()->creatable(limit: 1)
                                    ->removable(),

                                Json::make('TD 2', 'td_2')->fields([
                                    Textarea::make('Описание', 'td_2_text'),
                                    Date::make('Дата', 'td_2_date')

                                ])->vertical()->creatable(limit: 1)
                                    ->removable(),

                                Json::make('TD 3', 'td_3')->fields([
                                    Textarea::make('Описание', 'td_3_text'),
                                    Date::make('Дата', 'td_3_date')

                                ])->vertical()->creatable(limit: 1)
                                    ->removable(),



                                       Json::make('TD 4', 'td_4')->fields([
                                    Textarea::make('Описание', 'td_4_text'),

                                ])->vertical()->creatable(limit: 1)
                                    ->removable(),
                                ]),






                            ])
                                ->columnSpan(6),
                            Column::make([

                                Collapse::make('Детали вывода', [

                                    Switcher::make('Публикация', 'published')->default(1),



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


