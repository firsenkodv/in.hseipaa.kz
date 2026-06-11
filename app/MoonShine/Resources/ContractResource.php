<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Contract;
use App\Models\Training;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use App\Enums\OrganizationEnum;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Contract>
 */
class ContractResource extends ModelResource
{
    protected string $model = Contract::class;
    protected string $title = 'Договоры';
    protected array $with = ['user'];

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('№ договора', 'contract_number'),
            Text::make('ФИО', 'full_name'),
            Text::make('Email', 'email'),
            Text::make('Телефон', 'phone'),
            Text::make('Дисциплина', 'discipline'),
            Number::make('Цена', 'price'),
            Select::make('Валюта', 'currency')
                ->options(['KZT' => 'KZT', 'USD' => 'USD', 'EUR' => 'EUR', 'RUB' => 'RUB']),
            Number::make('Часов', 'hours'),
            Date::make('Период от', 'date_start')->format('d.m.Y'),
            Date::make('Период до', 'date_end')->format('d.m.Y'),
            Switcher::make('Подписан', 'is_signed')->updateOnPreview(),
            BelongsTo::make('Пользователь', 'user', fn($user) => $user->username . ' (' . $user->email . ')', resource: UserResource::class),
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

                Grid::make([
                    Column::make([
                        Collapse::make('Данные договора', [
                            Text::make('Номер договора', 'contract_number')
                                ->readonly()
                                ->hint('Присваивается автоматически при создании')
                                ->canSee(fn() => $this->isUpdateFormPage()),
                            Text::make('ФИО', 'full_name'),
                            Text::make('Email', 'email')->nullable(),
                            Text::make('Телефон', 'phone')->nullable(),
                            Select::make('Дисциплина', 'discipline')
                                ->options(Training::orderBy('sorting')->pluck('title', 'title')->all())
                                ->searchable()
                                ->nullable(),

                            Divider::make('Финансы и часы'),
                            Number::make('Цена', 'price')->nullable(),
                            Select::make('Валюта', 'currency')
                                ->options(['KZT' => 'KZT — Тенге', 'USD' => 'USD — Доллар', 'EUR' => 'EUR — Евро', 'RUB' => 'RUB — Рубль'])
                                ->default('KZT')
                                ->nullable(),
                            Number::make('Количество часов', 'hours')->min(0)->nullable(),

                            Divider::make('Период'),
                            Date::make('Дата начала', 'date_start')->format('d.m.Y')->nullable(),
                            Date::make('Дата окончания', 'date_end')->format('d.m.Y')->nullable(),

                            Divider::make('Организации'),
                            Select::make('Организации обучения', 'organizations')
                                ->options(OrganizationEnum::options())
                                ->nullable(),
                        ]),
                    ])->columnSpan(6),

                    Column::make([
                        Collapse::make('Связь и статус', [
                            BelongsTo::make(
                                'Пользователь',
                                'user',
                                fn($user) => $user->username . ' (' . $user->email . ')',
                                resource: UserResource::class
                            )->searchable()->nullable(),

                            Divider::make('Статус'),
                            Switcher::make('Подписан', 'is_signed')->default(0),
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
            Text::make('Номер договора', 'contract_number'),
            Text::make('ФИО', 'full_name'),
            Text::make('Email', 'email'),
            Text::make('Телефон', 'phone'),
            Text::make('Дисциплина', 'discipline'),
            Number::make('Цена', 'price'),
            Select::make('Валюта', 'currency')
                ->options(['KZT' => 'KZT — Тенге', 'USD' => 'USD — Доллар', 'EUR' => 'EUR — Евро', 'RUB' => 'RUB — Рубль']),
            Number::make('Количество часов', 'hours'),
            Date::make('Дата начала', 'date_start')->format('d.m.Y'),
            Date::make('Дата окончания', 'date_end')->format('d.m.Y'),
            Switcher::make('Подписан', 'is_signed'),
            Select::make('Организации обучения', 'organizations')
                ->options(OrganizationEnum::options())
                ->nullable(),
            BelongsTo::make('Пользователь', 'user', fn($user) => $user->username . ' (' . $user->email . ')', resource: UserResource::class),
        ];
    }

    protected function rules(mixed $item): array
    {
        return [
            'full_name'  => 'required|string|max:255',
            'user_id'    => 'required|exists:users,id',
            'email'      => 'nullable|email|max:255',
            'price'      => 'nullable|numeric|min:0',
            'hours'      => 'nullable|integer|min:0',
            'date_end'   => 'nullable|date|after_or_equal:date_start',
        ];
    }

    protected function search(): array
    {
        return ['full_name', 'email', 'phone', 'discipline'];
    }
}
