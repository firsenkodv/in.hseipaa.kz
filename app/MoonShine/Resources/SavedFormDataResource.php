<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\MoonShine\Fields\SavesFormData;
use Illuminate\Database\Eloquent\Model;
use App\Models\SavedFormData;

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
 * @extends ModelResource<SavedFormData>
 */
class SavedFormDataResource extends ModelResource
{
    protected string $model = SavedFormData::class;
    protected string $title = 'Форма обратной связи';

    protected string $column = 'created_at';

    protected string $sortColumn = 'created_at';


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
            Date::make('Дата', 'created_at')->format('Y-m-d H:i:s'),
            Text::make('Email', 'email')

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

                                Collapse::make('Название формы', [
                                    Text::make('Заголовок', 'title')->required()->locked(),
                                    Text::make('Email', 'email')->locked()->hint('Адреса эл. почт на которые была отправлена форма'),
                                ]),

                            ])
                                ->columnSpan(6),
                            Column::make([

                                Collapse::make('Детали формы', [

                                    SavesFormData::make(''),

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
