<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\HunterCategory;
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
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<HunterCategory>
 */
class HunterCategoryResource extends ModelResource
{
    protected string $model = HunterCategory::class;

    protected string $title = 'Категории хантинга';

    protected string $column = 'title';

    protected string $sortColumn = 'sorting';

    public function search(): array
    {
        return ['title'];
    }


    public function indexFields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make(__('Название'), 'title'),
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

                                Collapse::make('Изображение', [
                                    Image::make(__('Изображение'), 'img')
                                        ->dir('hunter/categories')
                                        ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg', 'webp'])
                                        ->removable(),
                                ]),

                            ])->columnSpan(6),

                            Column::make([

                                Collapse::make('Детали вывода', [
                                    Switcher::make('Публикация', 'published')->default(1),
                                    Number::make('Сортировка', 'sorting')->buttons()->default(999),
                                ]),

                            ])->columnSpan(6),
                        ]),

                        Grid::make([
                            Column::make([
                                Collapse::make('Описание', [
                                    TinyMce::make('Описание', 'desc'),
                                ]),
                            ])->columnSpan(12),
                        ]),
                    ]),

                ]),
            ]),
        ];
    }


    protected function detailFields(): iterable
    {
        return [
            ID::make(),
        ];
    }

    protected function rules(mixed $item): array
    {
        return [
            'title' => ['required'],
        ];
    }

    protected function activeActions(): ListOf
    {
        return parent::activeActions()
            ->except(Action::VIEW);
    }
}
