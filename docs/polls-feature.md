# Функционал «Голосования»

## Содержание

1. [Обзор](#1-обзор)
2. [База данных](#2-база-данных)
3. [Модели](#3-модели)
4. [Логика доступа (аудитория)](#4-логика-доступа-аудитория)
5. [Жизненный цикл голосования](#5-жизненный-цикл-голосования)
6. [Администратор (MoonShine)](#6-администратор-moonshine)
7. [Кабинет пользователя](#7-кабинет-пользователя)
8. [Маршруты (Routes)](#8-маршруты-routes)
9. [Контроллер](#9-контроллер)
10. [Flash-сообщения](#10-flash-сообщения)
11. [Хлебные крошки](#11-хлебные-крошки)
12. [Стили (SCSS)](#12-стили-scss)
13. [Структура файлов](#13-структура-файлов)

---

## 1. Обзор

Функционал позволяет администратору создавать опросы (голосования) с произвольным числом вопросов и гибко задавать аудиторию. Пользователь видит в кабинете только те опросы, под критерии которых он подходит. После прохождения опрос закрывается для редактирования — можно лишь просмотреть свои ответы.

**Участники:**

| Роль | Возможности |
|------|-------------|
| Администратор (MoonShine) | Создать опрос, добавить вопросы, настроить аудиторию, активировать/деактивировать |
| Пользователь | Видеть доступные опросы, пройти один раз, просматривать свои ответы |

---

## 2. База данных

### Таблица `polls`

| Колонка | Тип | Описание |
|---------|-----|----------|
| `id` | bigint PK | — |
| `title` | string | Название опроса |
| `questions` | json | Массив вопросов: `[{"question": "..."}]` |
| `is_active` | boolean | Активен ли опрос (default: `true`) |
| `for_all` | boolean | Показывать всем пользователям (default: `true`) |
| `city_ids` | json nullable | Список ID городов (`user_cities.id`) |
| `has_tariff` | boolean | Только пользователи с активным тарифом |
| `person_type` | string nullable | `'individual'` / `'legal'` — тип лица |
| `is_specialist` | boolean | Только специалисты |
| `is_expert` | boolean | Только эксперты |
| `is_lecturer` | boolean | Только лекторы |
| `created_at` / `updated_at` | timestamp | — |

### Таблица `poll_responses`

Фиксирует факт прохождения пользователем конкретного опроса.

| Колонка | Тип | Описание |
|---------|-----|----------|
| `id` | bigint PK | — |
| `poll_id` | bigint FK → polls | — |
| `user_id` | bigint FK → users | — |
| `created_at` / `updated_at` | timestamp | — |

> Уникальный индекс: `(poll_id, user_id)` — пройти опрос можно только один раз.

### Таблица `poll_answers`

Хранит ответы на каждый вопрос в рамках одного прохождения.

| Колонка | Тип | Описание |
|---------|-----|----------|
| `id` | bigint PK | — |
| `poll_response_id` | bigint FK → poll_responses | — |
| `question_index` | unsigned int | Порядковый номер вопроса в массиве `questions` |
| `question_text` | text | Снимок текста вопроса на момент ответа |
| `answer` | text | Ответ пользователя |
| `created_at` / `updated_at` | timestamp | — |

> `question_text` хранится денормализованно, чтобы ответы не зависели от будущих правок вопросов.

**Миграции:**
```
database/migrations/2026_06_18_200001_create_polls_table.php
database/migrations/2026_06_18_200002_create_poll_responses_table.php
database/migrations/2026_06_18_200003_create_poll_answers_table.php
```

---

## 3. Модели

### `App\Models\Poll`

```php
// Связи
$poll->responses()           // HasMany → PollResponse
$poll->responseByUser($id)   // ?PollResponse (with answers)
$poll->hasRespondedBy($id)   // bool

// Проверка доступа
$poll->isEligible(User $user) // bool — см. раздел 4
```

**Касты:**
`questions`, `city_ids` → `array`; булевые поля → `boolean`.

### `App\Models\PollResponse`

```php
$response->poll()     // BelongsTo → Poll
$response->user()     // BelongsTo → User
$response->answers()  // HasMany → PollAnswer (order by question_index)
```

### `App\Models\PollAnswer`

```php
$answer->response()   // BelongsTo → PollResponse
// Поля: poll_response_id, question_index, question_text, answer
```

---

## 4. Логика доступа (аудитория)

Метод `Poll::isEligible(User $user): bool` реализует логику **OR**:

```
if for_all == true          → доступен всем
if city_ids содержит user.user_city_id → доступен
if has_tariff и user.has_tarif         → доступен
if person_type == 'individual' и user.individual → доступен
if person_type == 'legal'    и user.legal_entity → доступен
if is_specialist и user.UserSpecialist()->exists() → доступен
if is_expert     и user.UserExpert()->exists()     → доступен
if is_lecturer   и user.UserLecturer()->exists()   → доступен
иначе → недоступен
```

**Важно:** при `for_all = true` все остальные критерии игнорируются. При `for_all = false` пользователь видит опрос, если соответствует **хотя бы одному** из указанных критериев.

---

## 5. Жизненный цикл голосования

```
Администратор создаёт опрос → задаёт вопросы → выбирает аудиторию → активирует
        ↓
Пользователь заходит в /cabinet/polls → видит список доступных опросов
        ↓
Открывает опрос → видит форму с вопросами (все textarea, все обязательны)
        ↓
Отправляет ответы (POST) → создаётся PollResponse + PollAnswer × N
        ↓
Повторное открытие → только просмотр своих ответов (форма недоступна)
```

---

## 6. Администратор (MoonShine)

**Ресурс:** `app/MoonShine/Resources/PollResource.php`

Регистрация в провайдере: `app/Providers/MoonShineServiceProvider.php` → массив `->resources([..., PollResource::class])`.

Регистрация в меню: `app/MoonShine/Layouts/AxeldLayout.php` → `MenuItem::make('Голосования', PollResource::class, 'chat-bubble-left-right')`.

### Вкладка «Основное»

| Поле | Тип | Описание |
|------|-----|----------|
| `title` | Text | Название опроса (required) |
| `is_active` | Switcher | Активен ли опрос |
| `questions` | Json (repeater) | Вопросы — каждый элемент: `{question: "..."}` |

### Вкладка «Аудитория»

| Поле | Тип | Описание |
|------|-----|----------|
| `for_all` | Switcher | Для всех (default on) |
| `city_ids` | Select multiple | Города из `user_cities` |
| `person_type` | Select nullable | `individual` / `legal` |
| `has_tariff` | Switcher | Только с активным тарифом |
| `is_specialist` | Switcher | Специалисты |
| `is_expert` | Switcher | Эксперты |
| `is_lecturer` | Switcher | Лекторы |

---

## 7. Кабинет пользователя

Меню: `resources/views/components/menu/cabinet-user-top-menu.blade.php` — добавлен пункт «Голосование».

### Список опросов `/cabinet/polls`

- Показывает все активные опросы, прошедшие проверку `isEligible()`
- Бейдж **«Новое»** (оранжевый) — пользователь ещё не отвечал
- Бейдж **«Пройдено»** (зелёный) — ответы уже сданы
- Ссылка ведёт на страницу опроса

### Страница опроса `/cabinet/polls/{id}`

**Режим прохождения** (ещё не отвечал):
- Заголовок вопроса над полем (`poll-question__text`)
- `<x-form.form-textarea>` для каждого вопроса — используются стандартные стили проекта (`.input-group`, плавающий label, `.input_error`)
- Кнопки «Отправить ответы» / «Отмена» через `.button` / `.button.white`
- Все поля обязательны, валидация на сервере (`required|string|max:5000`)

**Режим просмотра** (уже отвечал):
- Пары вопрос–ответ в карточках `.cabinet_radius12_fff` с синей левой рамкой
- Ответ отображается с сохранением переносов строк (`white-space: pre-wrap`)

---

## 8. Маршруты (Routes)

Все маршруты в `routes/web.php`, middleware `UserMiddleware`.

```
GET  /cabinet/polls          cabinet_polls        → cabinetPolls()
GET  /cabinet/polls/{id}     cabinet_poll         → cabinetPoll($id)
POST /cabinet/polls/{id}     cabinet_poll_submit  → cabinetPollSubmit($id)
```

---

## 9. Контроллер

**`App\Http\Controllers\Cabinet\CabinetUser\CabinetUserController`**

### `cabinetPolls()`
Загружает все активные опросы, фильтрует через `isEligible()`, определяет какие уже пройдены.

### `cabinetPoll(int $id)`
Проверяет `is_active` и `isEligible()`, загружает ответ пользователя если есть.

### `cabinetPollSubmit(int $id, Request $request)`
- Повторная отправка игнорируется (redirect на страницу)
- Валидация: `answers.{index}` → `required|string|max:5000` для каждого вопроса
- Транзакция: создаёт `PollResponse` + `PollAnswer` для каждого вопроса
- Сохраняет снимок текста вопроса в `question_text`

---

## 10. Flash-сообщения

| Ключ | Файл | Текст |
|------|------|-------|
| `poll_submit_ok` | `config/message_flash/info.php` | Ваши ответы успешно сохранены. |
| `poll_submit_error` | `config/message_flash/alert.php` | Ошибка при сохранении ответов. Попробуйте ещё раз. |

---

## 11. Хлебные крошки

`routes/breadcrumbs.php`:

```
Главная → Кабинет → Голосования
Главная → Кабинет → Голосования → {poll.title}
```

Имена: `cabinet_polls`, `cabinet_poll`.

---

## 12. Стили (SCSS)

**Файл:** `resources/css/components/cabinet-user/cabinet-user-polls-component.scss`
**Подключение:** `resources/css/app.css` после `cabinet-user-reports-component.scss`

| Класс | Назначение |
|-------|------------|
| `.user_contracts .user-polls` | Контейнер списка опросов |
| `.user-polls__item` | Карточка опроса (синяя левая рамка) |
| `.user-polls__badge--new` | Бейдж «Новое» (оранжевый) |
| `.user-polls__badge--done` | Бейдж «Пройдено» (зелёный) |
| `.poll-question__text` | Заголовок вопроса над textarea |
| `.poll-answers__item` | Карточка Q&A в режиме просмотра |
| `.poll-answers__answer` | Блок ответа (`pre-wrap`, серый фон) |

Форма прохождения использует **существующие стили проекта**: `.input-group`, `.button`, `.button.white`, `.cu_row_50`, `.cu__col`.

---

## 13. Структура файлов

```
app/
├── Models/
│   ├── Poll.php
│   ├── PollResponse.php
│   └── PollAnswer.php
├── MoonShine/Resources/
│   └── PollResource.php
├── Http/Controllers/Cabinet/CabinetUser/
│   └── CabinetUserController.php   ← методы cabinetPolls, cabinetPoll, cabinetPollSubmit
└── Providers/
    └── MoonShineServiceProvider.php ← PollResource::class в ->resources()

database/migrations/
├── 2026_06_18_200001_create_polls_table.php
├── 2026_06_18_200002_create_poll_responses_table.php
└── 2026_06_18_200003_create_poll_answers_table.php

resources/
├── views/
│   ├── cabinet/cabinet_user/polls/
│   │   ├── index.blade.php          ← список опросов
│   │   └── show.blade.php           ← прохождение / просмотр ответов
│   └── components/menu/
│       └── cabinet-user-top-menu.blade.php  ← пункт «Голосование»
└── css/components/cabinet-user/
    └── cabinet-user-polls-component.scss

routes/
├── web.php           ← 3 маршрута /cabinet/polls*
└── breadcrumbs.php   ← cabinet_polls, cabinet_poll

config/message_flash/
├── info.php    ← poll_submit_ok
└── alert.php   ← poll_submit_error
```
