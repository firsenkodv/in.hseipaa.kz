<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use Illuminate\Support\Facades\Storage;
use MoonShine\Laravel\Fields\Slug;
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
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;


class CompanyPage extends Page
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

        if (Storage::disk('config')->exists('moonshine/company.php')) {
            $result = include(storage_path('app/public/config/moonshine/company.php'));
        } else {
            $result = null;
        }

        return (is_array($result)) ? $result : null;

    }

    public function getTitle(): string
    {
        return $this->title ?: 'Раздел О нас';
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
            FormBuilder::make('/moonshine/company', FormMethod::POST)
                ->fields([

                    Tabs::make([

                        Tab::make(__('Раздел о нас'), [


                            Grid::make([


                                Column::make([
                                    Divider::make('Заголовок/Алиас'),

                                    Box::make([
                                        Text::make('Заголовок', 'title')->unescape()->default((isset($title)) ? $title : ''),
                                        Slug::make('Алиас', 'slug')->default((isset($slug)) ? $slug : ''),
                                        Text::make('Подзаголовок', 'subtitle')->unescape()->default((isset($subtitle)) ? $subtitle : ''),


                                    ]),


                                ])->columnSpan(6),


                                Column::make([
                                    Divider::make('Метаданные'),

                                    Box::make([
                                        Text::make('Мета тэг (title) ', 'metatitle')->unescape()->default((isset($metatitle)) ? $metatitle : ''),
                                        Text::make('Мета тэг (description) ', 'description')->unescape()->default((isset($description)) ? $description : ''),
                                        Text::make('Мета тэг (keywords) ', 'keywords')->unescape()->default((isset($keywords)) ? $keywords : ''),
                                    ]),

                                ])->columnSpan(6),
                            ]),
                            Grid::make([


                                Column::make([
                                    Divider::make('Описание раздела о нас (о компании)'),

                                    Box::make([
                                        TinyMce::make('Описание', 'desc')->default((isset($desc)) ? $desc : ''),
                                    ]),


                                ])->columnSpan(12),
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
