<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\HunterExperience;
use MoonShine\Laravel\Enums\Action;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<HunterExperience>
 */
class HunterExperienceResource extends ModelResource
{
    protected string $model = HunterExperience::class;

    protected string $title = 'Опыт работы';

    protected string $column = 'title';

    protected string $sortColumn = 'sorting';


    public function search(): array
    {
        return ['title'];
    }


    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make(__('Название'), 'title'),
            Number::make('Сортировка', 'sorting'),
        ];
    }


    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make(__('Название'), 'title')->required(),
                Number::make('Сортировка', 'sorting')->buttons()->default(999),
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
