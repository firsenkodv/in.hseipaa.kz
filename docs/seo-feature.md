# Функционал «SEO»

## Содержание

1. [Обзор](#1-обзор)
2. [База данных](#2-база-данных)
3. [Модель](#3-модель)
4. [Трейт HasSeo](#4-трейт-hasseo)
5. [Конфигурация](#5-конфигурация)
6. [Хелпер seo_override()](#6-хелпер-seo_override)
7. [Компонент x-seo.meta](#7-компонент-x-seometa)
8. [Администратор (MoonShine)](#8-администратор-moonshine)
9. [Первоначальное заполнение](#9-первоначальное-заполнение)
10. [Как подключить к новой модели](#10-как-подключить-к-новой-модели)
11. [Структура файлов](#11-структура-файлов)

---

## 1. Обзор

Функционал позволяет администратору заполнять SEO-метаданные (`metatitle`, `description`, `keywords`) для всех разделов, категорий и материалов сайта в одном месте — через ресурс **SEO** в MoonShine.

**Принцип работы:**

- Таблица `seos` является **зеркалом** SEO-полей из моделей. При сохранении любой модели её поля автоматически копируются в `seos`.
- SEO-ресурс показывает только **незаполненные** записи — те, где хотя бы одно из трёх полей пустое.
- При сохранении через SEO-ресурс данные записываются **обратно в модель** (`metatitle`/`description`/`keywords`).
- Когда все три поля заполнены — запись исчезает из ресурса. **В идеале ресурс всегда пуст** — это значит, что всё заполнено.

**Статические страницы** (`home`, `contacts` и т.д.) управляются через настройки MoonShine и в SEO-ресурсе **не отображаются**.

**Охват моделей:**

| Уровень | Модели |
|---------|--------|
| Разделы | `Service`, `Useful` |
| Категории | `SiteNew`, `ServiceCategory`, `CompanyCategory`, `UsefulCategory`, `UsefulSubcategory` |
| Материалы | `SiteNewItem`, `UsefulItem`, `ServiceItem`, `CompanyItem`, `Tax`, `Mzp` |

---

## 2. База данных

### Таблица `seos`

| Колонка | Тип | Описание |
|---------|-----|----------|
| `id` | bigint PK | — |
| `key` | varchar(255) UNIQUE | Составной идентификатор: `{prefix}:{id}` или `page:{slug}` |
| `model_class` | varchar(255) nullable | FQCN модели (`App\Models\SiteNewItem`). NULL для статических страниц |
| `label` | varchar(255) | Читаемое название записи (обновляется автоматически из `title` модели) |
| `title` | varchar(255) nullable | Зеркало `metatitle` модели |
| `description` | text nullable | Зеркало `description` модели |
| `keywords` | text nullable | Зеркало `keywords` модели |
| `created_at` / `updated_at` | timestamp | — |

### Формат ключа (`key`)

Ключ состоит из **префикса** (из `config/seo.php`) и **ID записи**:

```
site_new_item:1      →  SiteNewItem с id=1   (prefix из конфига + ':' + id)
service_category:5   →  ServiceCategory с id=5
tax:3                →  Tax с id=3
page:home            →  статическая страница (model_class = null)
```

По ключу `SeoResource::afterUpdated()` определяет, в какую модель записывать данные.

**Миграции:**
```
database/migrations/2026_06_18_300001_create_seos_table.php
database/migrations/2026_06_19_100001_add_model_class_to_seos_table.php
```

---

## 3. Модель

**`App\Models\Seo`**

```php
// Только незаполненные модельные записи (используется в SeoResource)
Seo::incomplete()->get();

// Прямой поиск по ключу (для статических страниц)
seo_override('page:home');
```

**Скоуп `incomplete`** — фильтрует записи где:
- `model_class IS NOT NULL` (только модельные, не статические)
- И хотя бы одно из `title` / `description` / `keywords` — пустое или NULL

---

## 4. Трейт HasSeo

**`App\Models\Concerns\HasSeo`**

Подключён к 13 моделям. Пример подключения:

```php
use App\Models\Concerns\HasSeo;

class SiteNewItem extends Model
{
    use HasSeo;
}
```

**Что делает трейт:**

| Метод | Описание |
|-------|----------|
| `bootHasSeo()` | Слушает событие `saved`, вызывает `syncSeoRecord()`. Обёрнут в `try/catch` — если таблица не создана, сохранение модели не ломается |
| `syncSeoRecord()` | Создаёт или обновляет запись в `seos`: копирует `metatitle`→`title`, `description`→`description`, `keywords`→`keywords`, заполняет `model_class` и `label` |
| `seoPrefix(): string` | Определяет префикс ключа из `config/seo.models` (обратный поиск по классу) |
| `seoLabel(): string` | Возвращает `$this->title` для поля `label` |

**Направление синхронизации:**
```
Сохранение модели → syncSeoRecord() → копирует поля В таблицу seos
Сохранение в SEO-ресурсе → afterUpdated() → записывает обратно В модель
```

---

## 5. Конфигурация

**`config/seo.php`**

```php
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
```

`models` — используется трейтом `HasSeo` для определения префикса и командой `seo:seed`.  
`pages` — только для `seo:seed`; статические страницы записываются в `seos` с `model_class = null` и в SEO-ресурсе не отображаются.

---

## 6. Хелпер seo_override()

**`src/Support/Helpers/helpers.php`**

```php
function seo_override(string $key): ?Seo
```

Используется **только для статических страниц** (где нет модели). Возвращает запись `Seo` по ключу или `null`.

---

## 7. Компонент x-seo.meta

**`resources/views/components/seo/meta.blade.php`**

Принимает `title`, `description`, `keywords` как пропы и необязательный `seo-key`.

**Для модельных страниц** — `seo-key` не передаётся. SEO берётся напрямую из полей модели:

```blade
<x-seo.meta
    title="{{ ($item->metatitle) ?? $item->title }}"
    description="{{ $item->description }}"
    keywords="{{ $item->keywords }}"
/>
```

**Для статических страниц** — передаётся `seo-key`, компонент делает запрос через `seo_override()`:

```blade
<x-seo.meta
    title="{!! config2('moonshine.home.metatitle') !!}"
    description="{!! config2('moonshine.home.description') !!}"
    keywords="{!! config2('moonshine.home.keywords') !!}"
    seo-key="page:home"
/>
```

Вызов `seo_override()` обёрнут в `try/catch` — если таблица не создана, страница не ломается.

---

## 8. Администратор (MoonShine)

**Ресурс:** `app/MoonShine/Resources/SeoResource.php`

Регистрация в провайдере: `app/Providers/MoonShineServiceProvider.php` → `SeoResource::class`.

Меню: `app/MoonShine/Layouts/AxeldLayout.php` → `MenuItem::make('SEO', SeoResource::class, 'magnifying-glass')`.

### Что показывает ресурс

Только записи с `model_class IS NOT NULL` и хотя бы одним пустым полем. Сортировка: сначала записи с максимальным количеством пустых полей.

**Цель: ресурс всегда пуст** — это означает, что SEO заполнено везде.

### Поля формы редактирования

| Поле | Редактируется | Примечание |
|------|---------------|------------|
| Страница / Материал (`label`) | нет | Обновляется автоматически при сохранении модели |
| Ключ (`key`) | нет | Формат `prefix:id` |
| Title | да | Сохраняется в `seos.title` и в `model.metatitle` |
| Description | да | Сохраняется в `seos.description` и в `model.description` |
| Keywords | да | Сохраняется в `seos.keywords` и в `model.keywords` |

### Обратная запись в модель (`afterUpdated`)

При сохранении через SEO-ресурс срабатывает `afterUpdated()`:
1. Парсит `key` → извлекает `id`
2. Находит модель: `$item->model_class::find($id)`
3. Обновляет модель через `withoutEvents()` — чтобы не вызвать повторный `syncSeoRecord()`

### Ограничения действий

Отключены: **CREATE**, **VIEW**, **DELETE**.

---

## 9. Первоначальное заполнение

```bash
php artisan migrate
php artisan seo:seed
```

**Что делает `seo:seed`:**
1. Проходит по всем записям 13 моделей из `config/seo.models`
2. Для каждой вызывает `$item->syncSeoRecord()` — копирует текущие значения `metatitle`/`description`/`keywords` в `seos`
3. Создаёт заглушки для статических страниц из `config/seo.pages` (`model_class = null`)

Команда **идемпотентна** — повторный запуск обновляет существующие записи без дубликатов.

**Новые записи** появляются в `seos` автоматически при первом сохранении через событие `saved`.

---

## 10. Как подключить к новой модели

1. Убедиться, что в модели есть поля `metatitle`, `description`, `keywords`

2. Добавить трейт:
   ```php
   use App\Models\Concerns\HasSeo;

   class NewModel extends Model
   {
       use HasSeo;
   }
   ```

3. Добавить префикс в `config/seo.php → models`:
   ```php
   'new_prefix' => \App\Models\NewModel::class,
   ```

4. View не менять — SEO берётся из полей модели напрямую:
   ```blade
   <x-seo.meta
       title="{{ ($item->metatitle) ?? $item->title }}"
       description="{{ $item->description }}"
       keywords="{{ $item->keywords }}"
   />
   ```

5. Запустить `php artisan seo:seed` для существующих записей.

---

## 11. Структура файлов

```
app/
├── Models/
│   ├── Seo.php                           ← модель со скоупом incomplete
│   └── Concerns/
│       └── HasSeo.php                    ← трейт: синхронизация при saved, seoPrefix, seoLabel
├── MoonShine/Resources/
│   └── SeoResource.php                   ← фильтр незаполненных + afterUpdated (запись в модель)
├── Console/Commands/
│   └── SeoSeedCommand.php                ← artisan seo:seed

config/
└── seo.php                               ← 13 моделей + 4 статических страницы

database/migrations/
├── 2026_06_18_300001_create_seos_table.php
└── 2026_06_19_100001_add_model_class_to_seos_table.php

src/Support/Helpers/
└── helpers.php                           ← seo_override(): только для статических страниц

resources/views/
├── components/seo/
│   └── meta.blade.php                    ← seo-key только для статических страниц
├── home.blade.php                         ← seo-key="page:home"
└── pages/
    ├── contacts.blade.php                 ← seo-key="page:contacts"
    ├── new/category/categories.blade.php  ← seo-key="page:news"
    ├── company/category/categories.blade.php ← seo-key="page:company"
    │
    │   [модельные страницы — seo-key не используется]
    ├── new/item/item.blade.php
    ├── new/category/category.blade.php
    ├── useful/item/item.blade.php
    ├── useful/category/category.blade.php
    ├── useful/category/subcategory.blade.php
    ├── useful/section/section.blade.php
    ├── service/item/item.blade.php
    ├── service/category/category.blade.php
    ├── service/section/section.blade.php
    ├── company/item/item.blade.php
    ├── company/category/category.blade.php
    ├── mzp/item.blade.php
    └── tax/tax_calendar.blade.php
```
