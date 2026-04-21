# CLAUDE.md

## Project Overview

**Портал Бухгалтеров Казахстана** — Laravel 12 web application (accountant portal for Kazakhstan).

## Tech Stack

- **Backend:** PHP 8.3, Laravel 12, Livewire 3
- **Admin Panel:** MoonShine 3
- **Frontend:** Vite, Tailwind CSS 4, Sass, Swiper, IMask, Trix, FancyApps
- **Database:** MySQL/MariaDB (MariaDB-11.7), DB name: `in-hseipaa`
- **Queue:** Database driver
- **Cache/Session:** Redis (phpredis)
- **Image processing:** Intervention Image 3

## Architecture

Domain-Driven Design (DDD) structure:

```
src/Domain/        — Domain logic (Models, Repositories, etc.)
  CabinetMessage, City, Company, Contact, Manager, Menu, Mzp, ROP,
  Registry, SavedFormData, Search, Service, SiteNew, Tarif, Tax,
  UseFul, User, UserExpert, UserLanguage, UserLecturer,
  UserProduction, UserSex, UserSpecialist
src/Support/       — Shared helpers (helpers.php)
app/Http/          — Controllers, Middleware, Requests
app/MoonShine/     — Admin panel resources
app/Livewire/      — Livewire components
```

## Common Commands

```bash
# Setup
composer run setup

# Development (runs server + queue + pail + vite concurrently)
composer run dev

# Tests
composer run test

# Build assets
npm run build
```

## Key Packages

- `moonshine/moonshine` — admin panel
- `livewire/livewire` — reactive components
- `diglactic/laravel-breadcrumbs` — breadcrumbs
- `intervention/image` — image manipulation
- `maatwebsite/excel` — Excel export/import
- `cleantalk/laravel-antispam` + `spatie/laravel-honeypot` — spam protection
- `predis/predis` — Redis client

## MoonShine Tips

### BelongsTo — кастомное отображение без изменения модели

Третий параметр `BelongsTo::make()` принимает closure, которая получает объект связанной модели. Это позволяет формировать любую строку прямо в ресурсе:

```php
BelongsTo::make('Пользователь', 'user',
    fn($user) => $user->username . ($user->UserHuman?->title ? ' (' . $user->UserHuman->title . ')' : ''),
    resource: UserResource::class
),
```

Аналогично работает в `asyncSearch()` через параметр `formatted`:

```php
->asyncSearch('title', formatted: fn($item, $field) => $item->id . ' | ' . $item->title)
```

## Flash-сообщения

Системные сообщения выводятся через хелпер `flash()`. Тексты хранятся в `config/message_flash/`:

- `config/message_flash/info.php` — положительные сообщения
- `config/message_flash/alert.php` — сообщения об ошибках

**Использование в контроллере:**

```php
// Успех
flash()->info(config('message_flash.info.vacancy_create_ok'));

// Ошибка
flash()->alert(config('message_flash.alert.vacancy_create_error'));
```

**Добавление нового сообщения:**

1. Добавить ключ в `config/message_flash/info.php` или `alert.php`:
```php
'vacancy_create_ok' => '<p>Ваша вакансия успешно добавлена. Она будет опубликована после проверки.</p>',
```

2. Вызвать в контроллере через `config('message_flash.info.ключ')`.

Компоненты `<x-message.message/>` и `<x-message.message_error/>` подключены в `layouts/layout.blade.php` и отображаются автоматически.

## Environment

- Local dev via OSPanel (Windows)
- DB host: `MariaDB-11.7`, DB: `in-hseipaa`, user: `root`
- Queue: database driver (run `php artisan queue:listen`)
