<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\MoonShine\Fields\PreviewImage;
use App\MoonShine\Fields\UploadFile;
use Domain\Service\ViewModels\ServiceViewModel;
use Domain\UseFul\ViewModels\UseFulViewModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Preview;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;


class ServiceModulePage extends Page
{

    public function getBreadcrumbs(): array
    {
        return [
            '#' => $this->getTitle()
        ];
    }

    public function setting()
    {

        if (Storage::disk('config')->exists('moonshine/service_module.php')) {
            $result = include(storage_path('app/public/config/moonshine/service_module.php'));
        } else {
            $result = null;
        }

        return (is_array($result)) ? $result : null;

    }


    public function getTitle(): string
    {
        return $this->title ?: 'Модуль';
    }


    public function categories(): array
    {

        $categories = ServiceViewModel::make()->categories();
        if ($categories) {
            foreach ($categories as $category) {
                $array[$category->id] = $category->title;
            }
            return $array;
        }
        return [];
    }

    protected function components(): iterable
    {
        if (!is_null($this->setting())) {
            extract($this->setting());
        }

        return [
            FormBuilder::make('/moonshine/service_module', FormMethod::POST)
                ->fields([

                    Tabs::make([

                        Tab::make(__('Модуль вывода двух услуг на главной'), [


                            Grid::make([


                                Column::make([
                                    Divider::make('По центру'),
                                    Box::make([

                                        Text::make('Заголовок', 'title')->unescape()->default((isset($title)) ? $title : ''),
                                    ]),
                                ])->columnSpan(12),

                                Column::make([
                                    Divider::make('Левая часть'),

                                    Box::make([
                                        Select::make('Выбрать', 'category_left')->options($this->categories())->default((isset($category_left)) ? $category_left : '')->nullable()
                                    ]),
                                    Box::make([
                                        Text::make('Заголовок', 'temp_title_left')->unescape()->default((isset($temp_title_left)) ? $temp_title_left : ''),
                                        TinyMce::make('Описание', 'temp_desc_left')->unescape()->default((isset($temp_desc_left)) ? $temp_desc_left : ''),
                                        Text::make('Цена', 'temp_price_left')->unescape()->default((isset($temp_price_left)) ? $temp_price_left : '')->hint('Не обязательное поле'),
                                        Text::make('Url', 'temp_url_left')->unescape()->default((isset($temp_url_left)) ? $temp_url_left : '')->hint('Не обязательное поле'),

                                        Text::make('Кнопка', 'temp_button_left')->unescape()->default((isset($temp_button_left)) ? $temp_button_left : '')->hint('Не обязательное поле'),
                                    ]),


                                ])->columnSpan(4),


                                Column::make([
                                    Divider::make('Центральная  часть'),

                                    Box::make([
                                        Image::make(__('Изображение'), 'temp_img')->hint('Размер 389*335'),
                                        PreviewImage::make()->default((isset($temp_img)) ? $temp_img : ''),
                                    ]),

                                ])->columnSpan(4),
                                Column::make([
                                    Divider::make('Правая часть'),
                                    Box::make([
                                        Select::make('Выбрать', 'category_right')->options($this->categories())->default((isset($category_right)) ? $category_right : '')->nullable()
                                    ]),
                                    Box::make([
                                        Text::make('Заголовок', 'temp_title_right')->unescape()->default((isset($temp_title_right)) ? $temp_title_right : ''),
                                        TinyMce::make('Описание', 'temp_desc_right')->unescape()->default((isset($temp_desc_right)) ? $temp_desc_right : ''),
                                        Text::make('Цена', 'temp_price_right')->unescape()->default((isset($temp_price_right)) ? $temp_price_right : '')->hint('Не обязательное поле'),
                                        Text::make('Url', 'temp_url_right')->unescape()->default((isset($temp_url_right)) ? $temp_url_right : '')->hint('Не обязательное поле'),

                                        Text::make('Кнопка', 'temp_button_right')->unescape()->default((isset($temp_button_right)) ? $temp_button_right : '')->hint('Не обязательное поле'),


                                    ]),

                                ])->columnSpan(4),
                            ]),


                        ]),


                    ]),


                ])->submit(label: 'Сохранить', attributes: ['class' => 'btn-primary'])
        ];
    }
}
