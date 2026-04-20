<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\HunterVacancyItem;
use MoonShine\Laravel\Enums\Action;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
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
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends ModelResource<HunterVacancyItem>
 */
class HunterVacancyItemResource extends ModelResource
{
    protected string $model = HunterVacancyItem::class;

    protected string $title = 'Вакансии';

    protected string $column = 'title';


    public function search(): array
    {
        return ['title', 'company'];
    }


    public function indexFields(): array
    {
        return [
            ID::make()->sortable(),
            Image::make(__('Изображение'), 'img'),
            Text::make(__('Название'), 'title'),
            BelongsTo::make('Пользователь', 'user', fn($user) => $user->username . ($user->UserHuman?->title ? ' (' . $user->UserHuman->title . ')' : ''), resource: UserResource::class),
            BelongsTo::make('Категория', 'category', 'title', resource: HunterCategoryResource::class),
            BelongsTo::make('Город', 'city', 'title', resource: UserCityResource::class),
            Text::make('Компания', 'company'),
            Number::make('Зарплата', 'price'),
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
                                        ->dir('hunter/vacancies')
                                        ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg', 'webp'])
                                        ->removable(),
                                ]),

                            ])->columnSpan(6),

                            Column::make([

                                Collapse::make('Детали вывода', [
                                    Switcher::make('Публикация', 'published')->default(1),
                                    Number::make('Сортировка', 'sorting')->buttons()->default(999),
                                    BelongsTo::make('Пользователь', 'user', fn($user) => $user->username . ($user->UserHuman?->title ? ' (' . $user->UserHuman->title . ')' : ''), resource: UserResource::class)->searchable(),
                                    BelongsTo::make('Категория', 'category', 'title', resource: HunterCategoryResource::class)->searchable(),
                                    BelongsTo::make('Город', 'city', 'title', resource: UserCityResource::class)->searchable(),
                                    BelongsTo::make('Опыт работы', 'experience', 'title', resource: HunterExperienceResource::class),
                                    Number::make('Зарплата', 'price')->hint('Только цифры'),
                                ]),

                            ])->columnSpan(6),
                        ]),
                    ]),

                    Tab::make(__('О компании'), [
                        Grid::make([
                            Column::make([

                                Collapse::make('Компания', [
                                    Text::make('Название компании', 'company'),
                                    Text::make('Должность', 'post'),
                                    Image::make(__('Логотип'), 'logo')
                                        ->dir('hunter/logos')
                                        ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg', 'webp'])
                                        ->removable(),
                                ]),

                                Collapse::make('Контакты', [
                                    Text::make('Email', 'email'),
                                    Number::make('Телефон', 'phone')->hint('Указывайте только номер, без + и пробелов - 77075594060'),                                    Text::make('Телеграм', 'telegram')->hint('Заполняйте правильно - t.me/hseipaa или @hseipaa'),
                                    Number::make('WhatsApp', 'whatsapp')->hint('Заполняйте правильно  - (только цифры) - 77075594059'),
                                    Textarea::make('Адрес', 'address'),
                                ]),

                            ])->columnSpan(12),
                        ]),
                    ]),

                    Tab::make(__('Детали вакансии'), [
                        Grid::make([
                            Column::make([

                                Collapse::make('Описание', [
                                    TinyMce::make('Описание вакансии', 'desc'),
                                ]),

                                Collapse::make('Требования', [
                                    TinyMce::make('Требования', 'must'),
                                ]),

                                Collapse::make('Условия', [
                                    TinyMce::make('Условия работы', 'conditions'),
                                ]),

                            ])->columnSpan(12),
                        ]),
                    ]),

                    Tab::make(__('Доп. параметры'), [
                        Grid::make([
                            Column::make([

                                Collapse::make('Параметры', [
                                    Json::make('Параметры', 'params')->fields([
                                        Text::make('Ключ', 'key'),
                                        Text::make('Значение', 'value'),
                                    ])->vertical()->creatable(limit: 30)->removable(),
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
