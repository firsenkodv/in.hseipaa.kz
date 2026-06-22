<?php

return [
    'models' => [
        // Разделы
        'service'            => \App\Models\Service::class,
        'useful'             => \App\Models\Useful::class,

        // Категории
        'site_new'           => \App\Models\SiteNew::class,
        'service_category'   => \App\Models\ServiceCategory::class,
        'company_category'   => \App\Models\CompanyCategory::class,
        'useful_category'    => \App\Models\UsefulCategory::class,
        'useful_subcategory' => \App\Models\UsefulSubcategory::class,

        // Материалы
        'site_new_item'      => \App\Models\SiteNewItem::class,
        'useful_item'        => \App\Models\UsefulItem::class,
        'service_item'       => \App\Models\ServiceItem::class,
        'company_item'       => \App\Models\CompanyItem::class,
        'tax'                => \App\Models\Tax::class,
        'mzp'                => \App\Models\Mzp::class,
    ],

    'pages' => [
        'page:home'     => 'Главная страница',
        'page:contacts' => 'Контакты',
        'page:news'     => 'Новости (раздел)',
        'page:company'  => 'О нас (раздел)',
    ],
];
