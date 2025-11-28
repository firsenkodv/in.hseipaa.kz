<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\SiteNewModule;

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
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends ModelResource<SiteNewModule>
 */
class SiteNewModuleResource extends ModelResource
{
    protected string $model = SiteNewModule::class;


    protected string $title = 'Вывод изображений в слайдер новостей';

    protected string $column = 'title';

    protected string $sortColumn = 'sorting';


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

            Image::make('Изображение', 'img'),

            Text::make('Сортировка', 'sorting'),

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

                                Collapse::make('Заголовок', [
                                    Text::make('Заголовок', 'title')->required(),
                                    Text::make('Url адрес', 'link')->hint('Адрес перехода')->unescape(),


                                ]),
                                Collapse::make('Слайдер', [

                                    Image::make(__('Изображение'), 'img')
                                        ->dir('images/news')
                                        ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg', 'webp'])
                                        ->removable(),



                                ]),

                               Collapse::make('Расширенные настройки', [

                                   BelongsTo::make('(Новости) Выбрать категорию', 'category', 'title', resource: SiteNewResource::class)->nullable(),
                                   BelongsTo::make('(Новости) Выбрать материал категории', 'item', 'title', resource: SiteNewResource::class)->nullable(),
                               ]),


                                ])
                                ->columnSpan(6),
                            Column::make([

                                Collapse::make('Детали вывода', [
                                    Number::make('Сортировка', 'sorting')->buttons()->default(999),

                                ]),


                            ])
                                ->columnSpan(6)

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

}
