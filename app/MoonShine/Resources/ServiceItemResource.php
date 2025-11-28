<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceItem;

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
use MoonShine\UI\Fields\Field;
use MoonShine\UI\Fields\File;
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
 * @extends ModelResource<ServiceItem>
 */
class ServiceItemResource extends ModelResource
{
    protected string $model = ServiceItem::class;

    protected string $title = 'Материал';

    protected string $column = 'title';


    public function search(): array
    {
        return ['title'];
    }

    /*  protected ?ClickAction $clickAction = ClickAction::EDIT;*/


    public function indexFields(): array
    {
        return [
            ID::make()
                ->sortable(),

          /*  Image::make(__('Изображение'), 'img'),*/
            Text::make(__('Название'), 'title'),
            BelongsTo::make('Категория', 'category', 'title', resource: ServiceCategoryResource::class),

            Switcher::make('Открытая', 'show.show_subscription'),
            Switcher::make('Платная статья', 'show.show_article_paid'),
            Text::make('Стоимость (T)', 'show.show_paid'),
            Switcher::make('title', 'metatitle'),
            Switcher::make('description', 'description'),
            Switcher::make('keywords', 'keywords'),
            Switcher::make('Публикация', 'published')->updateOnPreview(),
            Number::make('Сортировка', 'sorting'),
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
                                    Slug::make('Алиас', 'slug')
                                        ->from('title')->unique(),
                                    Text::make('Подзаголовок', 'subtitle')->unescape(),

                                ]),
                                Collapse::make('Анонс', [

                            /*        Image::make(__('Изображение'), 'img')
                                        ->dir('useful')
                                        ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg', 'webp'])
                                        ->removable(),*/
                                    TinyMce::make('Краткое описание', 'short_desc'),

                                ]),

                            ])
                                ->columnSpan(6),
                            Column::make([

                                Collapse::make('Детали вывода', [


                                    Switcher::make('Публикация', 'published')->default(1),
                                    Number::make('Сортировка', 'sorting')->buttons()->default(999),
                                    BelongsTo::make('Категория', 'category', 'title', resource: ServiceCategoryResource::class),
                                    Collapse::make('Показ материала', [

                                        Json::make('Показ', 'show')->fields([
                                            Switcher::make('Открыто', 'show_subscription')->default(0)->hint('Открыть статью всем'),
                                            Switcher::make('Платная статья', 'show_article_paid ')->default(0)->hint('Это поле имеет приоритет!'),
                                            Number::make('Стоимость статьи', 'show_paid')->hint('Только цифры'),
                                        ])->object(),


                                    ]),

                                ]),




                                Collapse::make('Метаданные', [

                                    Text::make('Мета тэг (title) ', 'metatitle')->unescape(),
                                    Text::make('Мета тэг (description) ', 'description')->unescape(),
                                    Text::make('Мета тэг (keywords) ', 'keywords')->unescape(),
                                ]),

                                Collapse::make('Скрипты', [
                                    Switcher::make('Скрипт', 'script_published'),
                                    Textarea::make('Cкрипт ', 'script'),
                                ]),


                            ])
                                ->columnSpan(6)

                        ]),
                        Grid::make([

                            Column::make([
                                Collapse::make('', [
                                    TinyMce::make('Описание', 'desc'),
                                    Image::make(__('Изображение'), 'img2')
                                        ->dir('useful')
                                        ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg', 'webp'])
                                        ->removable()->hint('Во всю ширину'),
                                    TinyMce::make('Описание', 'desc2'),


                                    Json::make('Файлы (Документы)', 'files')->fields([

                                        Text::make('', 'json_file_label')->hint('Название'),
                                        File::make('Документ', 'json_file_file')
                                            ->dir('docs/doc')
                                            ->customName(fn(UploadedFile $file, Field $field) =>  date('d-m-Y--H-i-s').'-'.$file->getClientOriginalName())                                          ->removable()

                                    ])->vertical()->creatable(limit: 30)
                                        ->removable(),
                                ]),

                            ])->columnSpan(12),
                        ]),


                    ]),
                    Tab::make(__('Дополнительно'), [
                        Grid::make([
                            Column::make([
                                Collapse::make('Шаблон с картинкой', [

                                    Text::make('Заголовок', 'temp_title'),

                                    Image::make(__('Изображение'), 'temp_img')
                                  ->dir('service')
                                  ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg', 'webp'])
                                  ->removable()->hint('Размер 389*335'),

                                    TinyMce::make('Описание', 'temp_desc'),

                                    Text::make('Цена', 'temp_price')->hint('Необязательное поле'),
                                ]),


                                ])->columnSpan(6),
                            Column::make([

                                ])->columnSpan(6),
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
