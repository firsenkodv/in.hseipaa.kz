<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;


use App\MoonShine\Pages\CompanyPage;
use App\MoonShine\Pages\ContactPage;
use App\MoonShine\Pages\HomePage;
use App\MoonShine\Pages\NewPage;
use App\MoonShine\Pages\ServiceModulePage;
use App\MoonShine\Pages\SettingPage;

use App\MoonShine\Pages\UsefulModulePage;
use App\MoonShine\Resources\MoonShineUserResource;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Laravel\Components\Layout\{Locales, Notifications, Profile, Search};
use MoonShine\UI\Components\{Breadcrumbs,
    Components,
    Layout\Flash,
    Layout\Div,
    Layout\Body,
    Layout\Burger,
    Layout\Content,
    Layout\Footer,
    Layout\Head,
    Layout\Favicon,
    Layout\Assets,
    Layout\Meta,
    Layout\Header,
    Layout\Html,
    Layout\Layout,
    Layout\Logo,
    Layout\Menu,
    Layout\Sidebar,
    Layout\ThemeSwitcher,
    Layout\TopBar,
    Layout\Wrapper,
    When
};
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;
use App\MoonShine\Resources\UsefulResource;
use App\MoonShine\Resources\UsefulCategoryResource;
use App\MoonShine\Resources\UsefulSubcategoryResource;
use App\MoonShine\Resources\UsefulItemResource;
use App\MoonShine\Resources\SiteNewResource;
use App\MoonShine\Resources\SiteNewItemResource;
use App\MoonShine\Resources\ServiceResource;
use App\MoonShine\Resources\ServiceCategoryResource;
use App\MoonShine\Resources\ServiceItemResource;
use App\MoonShine\Resources\CompanyCategoryResource;
use App\MoonShine\Resources\CompanyItemResource;
use App\MoonShine\Resources\TaxResource;
use App\MoonShine\Resources\AxeldPassportResource;
use App\MoonShine\Resources\SiteNewModuleResource;
use App\MoonShine\Resources\MzpResource;
use App\MoonShine\Resources\TarifResource;
use App\MoonShine\Resources\SavedFormDataResource;
use App\MoonShine\Resources\UserCityResource;
use App\MoonShine\Resources\UserExpertResource;
use App\MoonShine\Resources\UserFileQualificationResource;
use App\MoonShine\Resources\UserHumanResource;
use App\MoonShine\Resources\UserLecturerResource;
use App\MoonShine\Resources\UserSexResource;
use App\MoonShine\Resources\UserResource;
use App\MoonShine\Resources\MenuResource;


final class AxeldLayout extends AppLayout
{

    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    protected function menu(): array
    {
        return [
            MenuItem::make('Главная', HomePage::class, 'flag'),

            MenuGroup::make('Пользователи', [
                MenuItem::make('Админ', MoonShineUserResource::class, 'user'),
                MenuItem::make('Города', UserCityResource::class, 'building-office-2'),
                MenuItem::make('Эксперты', UserExpertResource::class, 'beaker'),
                MenuItem::make('Квалификации', UserFileQualificationResource::class ,'bolt'),
              /*  MenuItem::make('Физ/Юр лица', UserHumanResource::class),*/
                MenuItem::make('Лекторы', UserLecturerResource::class, 'book-open'),
               /* MenuItem::make('UserSexes', UserSexResource::class),*/
                MenuItem::make('Пользователи', UserResource::class, 'user-group'),

            ]),

            MenuGroup::make(static fn() => __('О нас'), [
                MenuItem::make('Раздел', CompanyPage::class, 'folder'),
                MenuItem::make('Категории', CompanyCategoryResource::class, 'folder-plus'),
                MenuItem::make('Материалы', CompanyItemResource::class, 'folder-arrow-down'),
            ]),


            MenuGroup::make(static fn() => __('Новости'), [
                MenuItem::make('Раздел', NewPage::class, 'folder'),
                MenuItem::make('Категории', SiteNewResource::class, 'folder-plus'),
                MenuItem::make('Материалы', SiteNewItemResource::class, 'folder-arrow-down'),
                MenuItem::make('Модуль', SiteNewModuleResource::class, 'rectangle-group'),

            ]),


            MenuGroup::make(static fn() => __('Полезное'), [
                MenuItem::make('Раздел', UsefulResource::class, 'folder'),
                MenuItem::make('Категория', UsefulCategoryResource::class, 'folder-plus'),
                MenuItem::make('Подкатегория', UsefulSubcategoryResource::class, 'folder-plus'),
                MenuItem::make('Материалы', UsefulItemResource::class, 'folder-arrow-down'),
                MenuItem::make('Модуль', UsefulModulePage::class, 'rectangle-group'),

            ]),


            MenuGroup::make(static fn() => __('Услуги'), [
                MenuItem::make('Раздел', ServiceResource::class, 'folder'),
                MenuItem::make('Категория', ServiceCategoryResource::class, 'folder-plus'),
                MenuItem::make('Материалы', ServiceItemResource::class, 'folder-arrow-down'),
                MenuItem::make('Модуль', ServiceModulePage::class, 'rectangle-group'),

            ]),

            MenuGroup::make(static fn() => __('Налоги/МЗП'), [
                MenuItem::make('Налоговый календарь', TaxResource::class, 'calendar-days'),
                MenuItem::make('МЗП', MzpResource::class, 'calendar-days'),
            ]),

            MenuGroup::make(static fn() => __('Тарифы'), [
                MenuItem::make('Тарифы', TarifResource::class, 'currency-dollar'),
            ]),

            MenuGroup::make(static fn() => __('Контакты'), [
                MenuItem::make('Контакты', ContactPage::class, 'map-pin'),
            ]),

            MenuGroup::make(static fn() => __('Настройки'), [
                MenuItem::make('Настройки', SettingPage::class, 'adjustments-vertical'),
                MenuItem::make('Как пользоваться', AxeldPassportResource::class, 'academic-cap'),

            ]),
            MenuItem::make('Меню', MenuResource::class),

            MenuGroup::make(static fn() => __('Формы отправки'), [
                MenuItem::make('Данные с форм', SavedFormDataResource::class , 'envelope'),

            ]),




        ];
    }

    /**
     * @param ColorManager $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);

        // $colorManager->primary('#00000');
    }

    public function build(): Layout
    {
        return Layout::make([
            Html::make([
                Head::make([
                    Meta::make()->customAttributes([
                        'name' => 'csrf-token',
                        'content' => csrf_token(),
                    ]),
                    Favicon::make()->bodyColor($this->getColorManager()->get('body')),
                    Assets::make(),
                ])
                    ->bodyColor($this->getColorManager()->get('body'))
                    ->title($this->getPage()->getTitle()),
                Body::make([
                    Wrapper::make([
                        Sidebar::make([
                            Div::make([
                                Div::make([
                                    Logo::make(
                                        $this->getHomeUrl(),
                                        $this->getLogo(),
                                        $this->getLogo(small: true),
                                    )->minimized(),
                                ])->class('menu-heading-logo'),

                                Div::make([
                                    Div::make([
                                        ThemeSwitcher::make(),
                                    ])->class('menu-heading-mode'),

                                    Div::make([
                                        Burger::make(),
                                    ])->class('menu-heading-burger'),
                                ])->class('menu-heading-actions'),
                            ])->class('menu-heading'),

                            Div::make([
                                Menu::make(),
                                When::make(
                                    fn(): bool => $this->isAuthEnabled(),
                                    static fn(): array => [Profile::make(withBorder: true)],
                                ),
                            ])->customAttributes([
                                'class' => 'menu',
                                ':class' => "asideMenuOpen && '_is-opened'",
                            ]),
                        ])->collapsed(),

                        Div::make([
                            Flash::make(),
                            Header::make([
                                Breadcrumbs::make($this->getPage()->getBreadcrumbs())->prepend(
                                    $this->getHomeUrl(),
                                    icon: 'home',
                                ),
                                Search::make(),
                                When::make(
                                    fn(): bool => $this->isUseNotifications(),
                                    static fn(): array => [Notifications::make()],
                                ),
                                Locales::make(),
                            ]),

                            Content::make([
                                Components::make(
                                    $this->getPage()->getComponents(),
                                ),
                            ]),

                            Footer::make()
                                ->copyright(static fn(): string => sprintf(
                                    <<<'HTML'
                                        &copy; %d  ❤️  <a href="/" target="_blank">Портал Бухгалтеров  Казахстана</a>
                                        HTML,
                                    now()->year,
                                ))
                                ->menu([
                                    config('app.app_url') => 'Website',
                                ]),
                        ])->class('layout-page'),
                    ]),
                ])->class('theme-minimalistic'),
            ])
                ->customAttributes([
                    'lang' => $this->getHeadLang(),
                ])
                ->withAlpineJs()
                ->withThemes(),
        ]);
    }

}
