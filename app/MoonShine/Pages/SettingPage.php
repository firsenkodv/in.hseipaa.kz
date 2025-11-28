<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use Illuminate\Support\Facades\Storage;
use MoonShine\Laravel\Pages\Page;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Support\Enums\FormMethod;
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


class SettingPage extends Page
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

        if (Storage::disk('config')->exists('moonshine/setting.php')) {
            $result = include(storage_path('app/public/config/moonshine/setting.php'));
        } else {
            $result = null;
        }

        return (is_array($result)) ? $result : null;

    }
    public function getTitle(): string
    {
        return $this->title ?: 'Настройки сайта';
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
            FormBuilder::make('/moonshine/setting', FormMethod::POST)
                ->fields([

                    Tabs::make([

                        Tab::make(__('Настройки'), [

                            Grid::make([

                                Column::make([
                                    Divider::make('Константы'),

                                    Box::make([
                                        Text::make('Название', 'title')->default((isset($title)) ? $title : ''),

                                        Text::make('Название в логотипе', 'title_logo')->default((isset($title_logo)) ? $title_logo : ''),
                                        Textarea::make('Слоган', 'slogan')->default((isset($slogan)) ? $slogan : ''),

                                    ]),
                                    Divider::make('Соц.сети'),

                                    Box::make([
                                        Text::make('Telegram', 'telegram')->default((isset($telegram)) ? $telegram : ''),
                                        Text::make('FaceBook', 'facebook')->default((isset($facebook)) ? $facebook : ''),
                                        Text::make('YouTube', 'youtube')->default((isset($youtube)) ? $youtube : ''),
                                        Text::make('Instagram', 'instagram')->default((isset($instagram)) ? $instagram : ''),
                                    ]),

                                    Divider::make('Блок "Получите консультацию"'),

                                    Box::make([
                                        Text::make('Заголовок', 'consult_title')->default((isset($consult_title)) ? $consult_title : ''),
                                        Text::make('Шаг1', 'consult_step1')->default((isset($consult_step1)) ? $consult_step1 : ''),
                                        Text::make('Шаг2', 'consult_step2')->default((isset($consult_step2)) ? $consult_step2 : ''),
                                        Text::make('Шаг3', 'consult_step3')->default((isset($consult_step3)) ? $consult_step3 : ''),

                                        Text::make('Кнопка 1', 'consult_button1')->default((isset($consult_button1)) ? $consult_button1 : ''),

                                        Text::make('Кнопка 2', 'consult_button2')->default((isset($consult_button2)) ? $consult_button2 : ''),

                                    ]),
                                    Divider::make('Блок "Всё в личном кабинете"'),

                                    Box::make([
                                        Text::make('Заголовок', 'personal_account_title')->default((isset($personal_account_title)) ? $personal_account_title : ''),
                                        Textarea::make('Описание', 'personal_account_desc')->default((isset($personal_account_desc)) ? $personal_account_desc : ''),


                                        Text::make('Кнопка 1', 'personal_account_button1')->default((isset($personal_account_button1)) ? $personal_account_button1 : ''),

                                        Text::make('Кнопка 2', 'personal_account_button2')->default((isset($personal_account_button2)) ? $personal_account_button2 : ''),

                                    ]),


                                ])->columnSpan(6),


                                Column::make([
                                    Divider::make('Контакты'),

                                    Box::make([

                                        Text::make('Copyright', 'contact_copy')->default((isset($contact_copy)) ? $contact_copy : ''),

                                        Number::make(__('Телефон'), 'phone1')->default((isset($phone1)) ? $phone1 : '')->hint('Только цифры'),
                                        Number::make(__('Телефон 2'), 'phone2')->default((isset($phone2)) ? $phone2 : '')->hint('Только цифры'),
                                        Text::make(__('Email'), 'email')->default((isset($email)) ? $email : ''),
                                    ]),


                                ])->columnSpan(6),
                            ]),
                        ]),

                        Tab::make(__('Заявки'), [

                            Grid::make([
                                Column::make([
                                    Divider::make('На всех страницах'),
                                    Box::make([
                                        Text::make('Заголовок', 'title_c_1')->default((isset($title_c_1)) ? $title_c_1 : '')
                                            ->hint('Синяя горизонтальная форма'),
                                       /* Textarea::make('Описание', 'text_c')->default((isset($text_c)) ? $text_c : ''),*/
                                    ]),
                                    Box::make([
                                        Text::make('Заголовок', 'title_c_2')->default((isset($title_c_2)) ? $title_c_2 : '')
                                            ->hint('В разработке'),
                                        Textarea::make('Описание', 'text_c_2')->default((isset($text_c_2)) ? $text_c_2 : ''),
                                    ]),
                                ])->columnSpan(12),
                            ])

                        ]),

                        Tab::make(__('МЗП'), [

                            Grid::make([
                                Column::make([
                                    Divider::make('Вывод данных'),
                                    Box::make([
                                        Text::make('Заголовок над поиском', 'mzp_title')->default((isset($mzp_title)) ? $mzp_title : '')
                                            ->hint('Только цифры'),
                                        Number::make('МЗП', 'mzp')->default((isset($mzp)) ? $mzp : '')
                                            ->hint('Только цифры'),
                                        Number::make('МРП', 'mrp')->default((isset($mrp)) ? $mrp : '')
                                            ->hint('Только цифры'),
                                        Text::make('ЕСП', 'esp')->default((isset($esp)) ? $esp : '')
                                            ->hint('В произвольной форме'),
                                    ]),

                                ])->columnSpan(12),
                            ])

                        ]),

                        Tab::make(__('TOP3'), [

                            Divider::make('Опции TOP3 (В разработке)'),


                        ]),

                        Tab::make(__('Email получателя системных сообщений'), [

                            Divider::make('Опции'),
                            Grid::make([
                                Column::make([

                                    Box::make([
                                        Json::make('Электронная почта', 'json_emails')->fields([

                                            Text::make('', 'json_email')->hint('Владелец этого email будет получать все уведомления (изменения) при редактировании личных кабинетов пользователями.'),

                                        ])->vertical()->creatable(limit: 3)
                                            ->removable()->default((isset($json_emails)) ? $json_emails : ''),


                                    ]),

                                ])->columnSpan(12),


                            ])


                        ]),


                    ]),


                ])->submit(label: 'Сохранить', attributes: ['class' => 'btn-primary'])
        ];
	}
}
