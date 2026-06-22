<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Components\Alert;

class SeoIndexPage extends IndexPage
{
    protected function topLayer(): array
    {
        return [
            Alert::make(type: 'info', icon: 'information-circle')
                ->content('Тут выведены страницы, где не заполнены мета-теги. Редактирование мета-тегов на страницах ресурсов.'),
            ...parent::topLayer(),
        ];
    }
}
