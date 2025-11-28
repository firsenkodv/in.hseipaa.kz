<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use Domain\UseFul\ViewModels\UseFulViewModel;
use Illuminate\Support\Facades\Storage;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Page;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Support\Enums\FormMethod;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;


class UsefulModulePage extends Page
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

        if (Storage::disk('config')->exists('moonshine/useful_module.php')) {
            $result = include(storage_path('app/public/config/moonshine/useful_module.php'));
        } else {
            $result = null;
        }

        return (is_array($result)) ? $result : null;

    }

    public function Useful():array
    {

        $categories = UseFulViewModel::make()->categories();
        if ($categories) {
            foreach ($categories as $category) {
                $array[$category->id] = $category->title;
            }
            return $array;
        }
        return [];
    }

    public function getTitle(): string
    {
        return $this->title ?: 'Модуль';
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
            FormBuilder::make('/moonshine/useful_module', FormMethod::POST)
                ->fields([

                    Tabs::make([

                        Tab::make(__('Модуль вывода материалов'), [


                            Grid::make([


                                Column::make([
                                    Divider::make('Левая часть'),

                                    Box::make([
                                        Text::make('Заголовок', 'title_left')->unescape()->default((isset($title_left)) ? $title_left : ''),

                                        Select::make('Выбрать', 'category_left')->options($this->Useful())->default((isset($category_left)) ? $category_left  : '')


                                    ]),


                                ])->columnSpan(6),


                                Column::make([
                                    Divider::make('Правая часть'),

                                    Box::make([
                                        Text::make('Заголовок', 'title_right')->unescape()->default((isset($title_right)) ? $title_right : ''),

                                        Select::make('Выбрать', 'category_right')->options($this->Useful())->default((isset($category_right)) ? $category_right  : '')


                                    ]),

                                ])->columnSpan(6),
                            ]),


                        ]),


                    ]),


                ])->submit(label: 'Сохранить', attributes: ['class' => 'btn-primary'])
        ];
    }
}
