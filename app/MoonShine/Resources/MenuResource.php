<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\UserSex;
use Illuminate\Database\Eloquent\Model;
use App\Models\Menu;

use MoonShine\Laravel\Enums\Action;
use MoonShine\Laravel\Http\Responses\MoonShineJsonResponse;
use MoonShine\Laravel\MoonShineRequest;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ToastType;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Menu>
 */
class MenuResource extends ModelResource
{
    protected string $model = Menu::class;

    protected string $title = 'Меню';


    public function search(): array
    {
        return ['title'];
    }

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make(__('Название'), 'title'),
            Date::make('Дата', 'created_at')->format('d.m.Y'),

        ];
    }


    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make(__('Название'), 'title'),

                Grid::make([
                    Column::make([
                        Collapse::make('Первая колонка', [
                            Json::make('', 'col1')->fields([

                                Text::make('Пункт меню', 'json_text'),
                                Text::make('Страница перехода', 'json_url'),

                            ])->vertical()->creatable(limit: 100)
                                ->removable(),

                            ]),
                    ])->columnSpan(3),
                    Column::make([
                        Collapse::make('Вторая колонка', [
                            Json::make('', 'col2')->fields([

                                Text::make('Пункт меню', 'json_text'),
                                Text::make('Страница перехода', 'json_url'),

                            ])->vertical()->creatable(limit: 100)
                                ->removable(),
                        ]),
                    ])->columnSpan(3),
                    Column::make([
                        Collapse::make('Третья колонка', [
                            Json::make('', 'col3')->fields([

                                Text::make('Пункт меню', 'json_text'),
                                Text::make('Страница перехода', 'json_url'),

                            ])->vertical()->creatable(limit: 100)
                                ->removable(),
                        ]),
                    ])->columnSpan(3),
                    Column::make([
                        Collapse::make('Четвертая колонка', [
                            Json::make('', 'col4')->fields([

                                Text::make('Пункт меню', 'json_text'),
                                Text::make('Страница перехода', 'json_url'),

                            ])->vertical()->creatable(limit: 100)
                                ->removable(),
                        ]),
                    ])->columnSpan(3),
                ])
            ])
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
        return [];
    }

    protected function activeActions(): ListOf
    {
        return parent::activeActions()
            ->except(Action::VIEW, Action::MASS_DELETE, Action::DELETE, Action::CREATE)// ->only(Action::VIEW)
            ;
    }

}
