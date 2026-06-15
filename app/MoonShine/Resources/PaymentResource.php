<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Payment;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Enums\Action;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Payment>
 */
class PaymentResource extends ModelResource
{
    protected string $model = Payment::class;
    protected string $title = 'Платежи';
    protected array  $with  = ['user', 'tarif'];

    protected function activeActions(): ListOf
    {
        return parent::activeActions()->except(Action::CREATE, Action::UPDATE);
    }

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('№ заказа', 'order_number'),
            Number::make('Оплачено (тг)', 'paid_amount'),
            Switcher::make('Оплачено', 'is_paid'),
            Text::make('Статус банка', 'order_status'),
            BelongsTo::make(
                'Пользователь',
                'user',
                fn($user) => $user->username . ' (' . $user->email . ')',
                resource: UserResource::class
            ),
            BelongsTo::make(
                'Тариф',
                'tarif',
                fn($tarif) => $tarif->title,
                resource: TarifResource::class
            )->nullable(),
            Date::make('Дата', 'created_at')->format('d.m.Y H:i')->sortable(),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return $this->detailFields();
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('№ заказа', 'order_number'),
            Text::make('ID заказа банка', 'order_id'),
            Number::make('Запрошено (тиын)', 'amount'),
            Number::make('Оплачено (тенге)', 'paid_amount'),
            Text::make('Статус банка', 'order_status'),
            Switcher::make('Оплачено', 'is_paid'),
            Text::make('Описание', 'desc'),
            Text::make('Валюта', 'currency'),
            Text::make('Язык', 'lang'),
            BelongsTo::make(
                'Пользователь',
                'user',
                fn($user) => $user->username . ' (' . $user->email . ')',
                resource: UserResource::class
            ),
            BelongsTo::make(
                'Тариф',
                'tarif',
                fn($tarif) => $tarif->title,
                resource: TarifResource::class
            )->nullable(),
            Date::make('Создан', 'created_at')->format('d.m.Y H:i'),
        ];
    }

    protected function rules(mixed $item): array
    {
        return [];
    }

    protected function search(): array
    {
        return ['order_number', 'order_id'];
    }
}
