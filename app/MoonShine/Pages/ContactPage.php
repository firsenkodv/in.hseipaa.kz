<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use Illuminate\Support\Facades\Storage;
use MoonShine\Laravel\Pages\Page;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Support\Enums\FormMethod;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;


class ContactPage extends Page
{
    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            '#' => $this->getTitle()
        ];
    }

    public function setting()
    {

        if (Storage::disk('config')->exists('moonshine/contact.php')) {
            $result = include(storage_path('app/public/config/moonshine/contact.php'));
        } else {
            $result = null;
        }

        return (is_array($result)) ? $result : null;

    }

    public function getTitle(): string
    {
        return $this->title ?: 'ContactPage';
    }

    /**
     * @return list<ComponentContract>
     */
    protected function components(): iterable
    {
        if (!is_null($this->setting())) {
            extract($this->setting());
        }

        return [
            FormBuilder::make('/moonshine/contact', FormMethod::POST)
                ->fields([

                    Tabs::make([

                        Tab::make(__('Настройки'), [


                            Grid::make([


                                Column::make([
                                    Divider::make('Константы'),

                                    Box::make([

                                        Text::make('Название', 'title')->default((isset($title)) ? $title : ''),
                                        TinyMce::make('Описание на странице', 'text')->default((isset($text)) ? $text : ''),


                                    ]),


                                ])->columnSpan(6),


                                Column::make([
                                    Divider::make('Контакты'),

                                    Box::make([
                                        Text::make('Мета тэг (title) ', 'metatitle')->unescape()->default((isset($metatitle)) ? $metatitle : ''),
                                        Text::make('Мета тэг (description) ', 'description')->unescape()->default((isset($description)) ? $description : ''),
                                        Text::make('Мета тэг (keywords) ', 'keywords')->unescape()->default((isset($keywords)) ? $keywords : ''),
                                    ]),

                                ])->columnSpan(6),
                            ]),
                        ]),

                        Tab::make(__('Города'), [

                            Grid::make([
                                Column::make([

                                    Box::make([
                                        Json::make('Города сайта', 'json_cities')->fields([
                                            Text::make('Заголовок города', 'json_title'),
                                            Number::make('Основной телефон', 'json_phone')->placeholder('Только цифры'),
                                            Number::make('Дополнительный телефон', 'json_phone2')->placeholder('Только цифры'),
                                            Number::make('Дополнительный телефон', 'json_phone3')->placeholder('Только цифры'),
                                            Number::make('Дополнительный телефон', 'json_phone4')->placeholder('Только цифры'),
                                            Number::make('Дополнительный телефон', 'json_phone5')->placeholder('Только цифры'),
                                            Text::make('Email', 'json_email'),
                                            Text::make('Email', 'json_email2')->placeholder('Дополнительный email'),
                                            Text::make('Email', 'json_email3')->placeholder('Дополнительный email'),
                                            Text::make('Адрес офиса', 'json_address'),
                                            Textarea::make('Краткое описание', 'json_text'),
                                            Text::make('Координаты', 'json_coordinates'),


                                        ])->vertical()->creatable(limit: 30)
                                            ->removable()->default((isset($json_cities)) ? $json_cities : ''),


                                    ]),
                                ])->columnSpan(6),
                                Column::make([

                                ])->columnSpan(6),

                            ]),
                        ]),

                        Tab::make(__('FAQ'), [

                            Grid::make([
                                Column::make([
                                    Collapse::make('Вопрос/Ответ', [
                                        Text::make('Заголовок', 'faq_title')->unescape()
                                            ->default((isset($faq_title)) ? $faq_title : ''),

                                        Json::make('Вопрос-ответ', 'faq')->fields([
                                            Textarea::make('Вопрос', 'faq_question'),
                                            TinyMce::make('Ответ', 'faq_answer')

                                        ])->vertical()->creatable(limit: 50)
                                            ->removable()
                                            ->default((isset($faq)) ? $faq : ''),

                                    ]),
                                ])->columnSpan(12),
                            ]),

                        ]),


                    ]),


                ])->submit(label: 'Сохранить', attributes: ['class' => 'btn-primary'])
        ];
    }
}
