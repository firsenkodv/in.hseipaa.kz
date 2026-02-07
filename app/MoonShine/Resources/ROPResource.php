<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Enums\Moonshine\StatusManagerEnum;
use App\Models\Manager;
use Illuminate\Database\Eloquent\Model;
use App\Models\ROP;

use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use MoonShine\Laravel\Enums\Action;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Enum;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<ROP>
 */
class ROPResource extends ModelResource
{
    protected string $model = ROP::class;

    protected string $title = 'Руководители отделов продаж';

    protected string $column = 'username';

    protected string $sortColumn = 'created_at';

    //protected ?ClickAction $clickAction = ClickAction::EDIT;

    public function search(): array
    {
        return ['username', 'email'];
    }
    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Image::make(__('Аватар'), 'avatar'),
            Text::make('ФИО', 'username')->updateOnPreview(),
            Number::make('Телефон', 'phone')->updateOnPreview(),
            Text::make('Email', 'email')->updateOnPreview(),
            Date::make(__('Дата создания'), 'created_at')
                ->format("d.m.Y")
                ->default(now()->toDateTimeString())
                ->sortable(),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Divider::make('РОП'),
                Grid::make([
                    Column::make([

                        Collapse::make('Имя/Пароль', [
                            Text::make('Email', 'email'),
                            Text::make('Пароль', 'password'),

                        ]),

                        Collapse::make('Личные данные', [

                            Text::make('ФИО', 'username'),
                            Text::make('Телефон', 'phone')->nullable(),

                        ]),
                        Collapse::make('Изображение', [

                            Image::make(__('Аватар'), 'avatar')
                                ->disk('public')
                                ->onAfterApply(function (Model $data, $file, Image $field) {
                                    if ($file !== false) {
                                        $destinationPath = 'rops/' . $data->id . '/avatar';
                                        $file->storeAs($destinationPath, $data->avatar);
                                        Storage::disk('public')->delete($data->avatar);
                                        ROP::query()
                                            ->where('id', $data->id)
                                            ->update(['avatar' => $destinationPath . '/' . $data->avatar]);

                                    }

                                })
                                ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg', 'webp', 'gif'])
                                ->removable(),

                        ]),

                    ])->columnSpan(6),
                    Column::make([

                        Collapse::make('Настройки', [


                            Date::make(__('Дата создания'), 'created_at')
                                ->format("d.m.Y")
                                ->default(now()->toDateTimeString())
                                ->sortable(),


                        ]),
                    ])->columnSpan(6),


                ]),


            ]),
        ];
    }





    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
        ];
    }


    protected function rules(mixed $item): array
    {
        return [
            'username' => 'max:50',
            'email' => [
                'sometimes',
                'bail',
                'required',
                'email',
                Rule::unique('r_o_p_s')->ignore($item->email, 'email'),
            ],
        ];
    }

    protected function activeActions(): ListOf
    {
        return parent::activeActions()
            ->except(Action::VIEW, /*Action::MASS_DELETE, Action::DELETE, Action::CREATE*/)// ->only(Action::VIEW)
            ;
    }
}
