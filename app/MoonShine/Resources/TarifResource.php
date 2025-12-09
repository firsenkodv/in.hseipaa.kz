<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tarif;

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

class TarifResource extends ModelResource
{
    protected string $model = Tarif::class;


    protected string $title = 'Тарифы';

    protected string $column = 'title';
    protected string $sortColumn = 'sorting';


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

            Text::make(__('Название'), 'title'),
            Text::make(__('Тип'), 'subtitle'),

            Text::make('Стоимость (T)', 'price'),
            Text::make('МРП', 'mpr'),
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

                                Collapse::make('Главные опции', [
                                    Text::make('Заголовок', 'title')->required(),
                                    Slug::make('Алиас', 'slug')
                                        ->from('title')->unique()->hint('Не выводится'),
                                    Text::make(__('Тип'), 'subtitle'),
                                    Number::make('Стоимость (T)', 'price')->hint('Только цифры, без пробелов'),
                                    Text::make('МРП', 'mpr'),

                                ]),
                                Collapse::make('Тариф', [

                                    Json::make('Описание тарифа', 'tarif')->fields([

                                        Text::make('', 'json_tarif_label')->hint('Опция'),

                                    ])->vertical()->creatable(limit: 100)
                                        ->removable(),

                                ]),

                            ])
                                ->columnSpan(6),
                            Column::make([

                                Collapse::make('Детали вывода', [


                                    Switcher::make('Публикация', 'published')->default(1),
                                    Number::make('Сортировка', 'sorting')->buttons()->default(999),

                                    ]),


                            ])
                                ->columnSpan(6)

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
            'price' => [

                'integer',
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
