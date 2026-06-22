<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Seo;
use App\MoonShine\Pages\SeoIndexPage;
use Illuminate\Contracts\Database\Eloquent\Builder;
use MoonShine\Laravel\Enums\Action;
use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends ModelResource<Seo>
 */
class SeoResource extends ModelResource
{
    protected string $model = Seo::class;

    protected string $title = 'SEO';

    protected string $column = 'label';

    protected function pages(): array
    {
        return [
            SeoIndexPage::class,
            FormPage::class,
            DetailPage::class,
        ];
    }

    public function search(): array
    {
        return ['label', 'key', 'title'];
    }

    public function indexFields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Страница / Материал', 'label')->disabled(),
            Text::make('Title', 'title'),
            Text::make('Description', 'description'),
            Text::make('Keywords', 'keywords'),
        ];
    }

    public function formFields(): array
    {
        return [
            Text::make('Страница / Материал', 'label')->disabled()->readonly(),
            Text::make('Ключ', 'key')->disabled()->readonly(),
            Text::make('Title', 'title'),
            Textarea::make('Description', 'description'),
            Textarea::make('Keywords', 'keywords'),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Страница / Материал', 'label'),
            Text::make('Title', 'title'),
            Textarea::make('Description', 'description'),
            Textarea::make('Keywords', 'keywords'),
        ];
    }

    protected function activeActions(): ListOf
    {
        return parent::activeActions()
            ->except(Action::CREATE, Action::VIEW, Action::DELETE);
    }

    protected function modifyQueryBuilder(Builder $builder): Builder
    {
        return $builder->incomplete()->orderByRaw('
            (CASE WHEN title IS NULL OR title = \'\' THEN 1 ELSE 0 END +
             CASE WHEN description IS NULL OR description = \'\' THEN 1 ELSE 0 END +
             CASE WHEN keywords IS NULL OR keywords = \'\' THEN 1 ELSE 0 END) DESC
        ')->orderBy('id');
    }

    protected function afterUpdated(mixed $item): mixed
    {
        if (! empty($item->model_class)) {
            $id = last(explode(':', $item->key));
            $modelClass = $item->model_class;
            $model = $modelClass::find($id);

            if ($model) {
                $modelClass::withoutEvents(function () use ($model, $item) {
                    $model->update([
                        'metatitle'   => $item->title,
                        'description' => $item->description,
                        'keywords'    => $item->keywords,
                    ]);
                });
            }
        }

        return $item;
    }
}
