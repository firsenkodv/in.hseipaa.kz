<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserExpert;

use MoonShine\Laravel\Enums\Action;
use MoonShine\Laravel\Http\Responses\MoonShineJsonResponse;
use MoonShine\Laravel\MoonShineRequest;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ToastType;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<UserExpert>
 */
class UserExpertResource extends ModelResource
{
    protected string $model = UserExpert::class;

    protected string $title = 'Эксперты';
    protected string $sortColumn = 'sorting';
    protected string $column = 'title';

    public function search(): array
    {
        return ['title'];
    }

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make(__('Название'), 'title'),
            Number::make('Сортировка', 'sorting'),
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
                Text::make(__('Название'), 'title'),
                Text::make(__('Подзаголовок'), 'subtitle')->hint('Не используется'),
                Number::make('Сортировка', 'sorting')->buttons()->default(999),
            ])
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

    /**
     * @param UserExpert $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }

    protected function activeActions(): ListOf
    {
        return parent::activeActions()
            ->except(Action::VIEW /*Action::MASS_DELETE, Action::DELETE, Action::CREATE*/)// ->only(Action::VIEW)
            ;
    }

    /** ** Дублирование записи ** **/
    protected function indexButtons(): ListOf
    {
        return parent::indexButtons()
            ->add(
                ActionButton::make('Clone')
                    ->icon('document-duplicate')
                    ->method('duplicateRow')
                    ->info()
            //  ->withConfirm()
            );
    }
    public static function duplicateRow(MoonShineRequest $request)
    {
        $resource = $request->getResource();

        /** @var Model $newItem */
        $newItem = $resource?->getItem()->replicate();

        $newItem->save();

        $url = $resource?->getFormPageUrl($newItem->id);

        //  return MoonShineJsonResponse::make()->redirect($url);
        return MoonShineJsonResponse::make()
            ->toast(
                __('Запись успешно дублирована'), // Тут текст "Запись успешно дублирована"
                ToastType::SUCCESS
            )->redirect($url);
    }
    /** ** Дублирование записи ** **/
}
