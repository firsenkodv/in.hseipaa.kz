<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Training;
use MoonShine\Laravel\Enums\Action;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Training>
 */
class TrainingResource extends ModelResource
{
    protected string $model = Training::class;

    protected string $title = 'Дисциплины';

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
            Text::make('Название', 'title'),
            Number::make('Сортировка', 'sorting')->sortable(),
        ];
    }

    public function formFields(): array
    {
        return [
            Box::make([
                Text::make('Название', 'title')->required(),
                Number::make('Сортировка', 'sorting')->default(999),
            ]),
        ];
    }

    protected function rules(mixed $item): array
    {
        return [
            'title'   => ['required', 'string', 'max:255'],
            'sorting' => ['required', 'integer'],
        ];
    }

    protected function detailFields(): iterable
    {
        return [ID::make()];
    }

    protected function activeActions(): ListOf
    {
        return parent::activeActions()->except(Action::VIEW);
    }
}
