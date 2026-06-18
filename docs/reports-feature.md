# Функционал «Отчёты об обучении»

## Содержание

1. [Обзор](#1-обзор)
2. [База данных](#2-база-данных)
3. [Жизненный цикл отчёта](#3-жизненный-цикл-отчёта)
4. [Роль: Пользователь](#4-роль-пользователь)
5. [Роль: Менеджер](#5-роль-менеджер)
6. [Чат по отчёту](#6-чат-по-отчёту)
7. [Счётчики непрочитанных сообщений](#7-счётчики-непрочитанных-сообщений)
8. [Маршруты (Routes)](#8-маршруты-routes)
9. [Контроллеры](#9-контроллеры)
10. [JavaScript](#10-javascript)
11. [Структура файлов](#11-структура-файлов)

---

## 1. Обзор

Функционал позволяет пользователям подавать отчёты об обучении, а менеджерам — модерировать их. К каждому отчёту привязан отдельный чат между пользователем и менеджером.

**Участники:**

| Роль | Возможности |
|------|-------------|
| Пользователь | Создать, редактировать (до принятия), просматривать, переписываться |
| Менеджер | Просматривать отчёты своих пользователей, редактировать поля, принять, переписываться |

---

## 2. База данных

### Таблица `reports`

| Колонка | Тип | Описание |
|---------|-----|----------|
| `id` | bigint PK | — |
| `user_id` | bigint FK → users | Автор отчёта |
| `period_from` | date | Начало периода обучения |
| `period_to` | date | Конец периода обучения |
| `report_type` | string | Вид отчёта (обязательные дисциплины) |
| `discipline_name` | string | Наименование дисциплины |
| `school_name` | string | Наименование учебного заведения |
| `certificates` | json | Массив загруженных PDF-файлов `[{json_file, url}]` |
| `accepted` | boolean | `false` — на рассмотрении, `true` — принят (блокировка редактирования) |
| `created_at` / `updated_at` | timestamps | — |

### Таблица `cabinet_conversations` (расширенная)

Для чата по отчётам добавлена колонка `report_id`:

| Колонка | Описание |
|---------|----------|
| `report_id` | `0` = общая переписка, `> 0` = переписка привязана к конкретному отчёту |

Уникальный индекс: `(user_id, staff_type, staff_id, report_id)` — гарантирует одну переписку на каждую пару пользователь–менеджер в рамках конкретного отчёта.

### Миграции

```
2026_06_18_000001_add_accepted_to_reports_table.php
2026_06_18_000002_add_report_id_to_cabinet_conversations_table.php
```

---

## 3. Жизненный цикл отчёта

```
[Создан пользователем]
        │
        ▼
  accepted = false
  («На рассмотрении»)
        │
  Менеджер нажимает «Принять отчёт»
        │
        ▼
  accepted = true
     («Принят»)
        │
  Редактирование заблокировано
  (ни пользователь, ни менеджер не могут изменять данные)
```

---

## 4. Роль: Пользователь

### 4.1 Страница отчётов

**Маршрут:** `GET /cabinet/reports` → `cabinetReports` (middleware: `UserMiddleware`)

Показывает список отчётов пользователя. Для каждого отчёта отображаются:
- Период (date range)
- Вид отчёта, дисциплина, заведение
- Загруженные сертификаты (ссылки для скачивания)
- Бейдж статуса: **«Принят»** (зелёный) или без бейджа
- Кнопка **«Редактировать»** — только если `accepted = false`
- Кнопка **«Переписка»** — всегда, с красным бейджем числа непрочитанных сообщений от менеджера

### 4.2 Создание отчёта

Открывается через Fancybox-модал (`data-form="user_report_create"`).

**POST** `/user_report_create` → `fancyboxUserReportCreate` (middleware: `UserMiddleware`)

Поля формы:
- `report_period_from` / `report_period_to` — датапикер
- `report_type` — текстовое поле
- `discipline_name` — текстовое поле
- `school_name` — текстовое поле
- Загрузка PDF-сертификатов (до 4 файлов, до 15 МБ каждый)

После успешного сохранения страница перезагружается (`report_created: true`).

### 4.3 Редактирование отчёта

Открывается через Fancybox-модал (`data-form="user_report_edit"`, `data-transfer='{"report_id": N}'`).

**POST** `/user_report_update` → `fancyboxUserReportUpdate` (middleware: `UserMiddleware`)

Доступно только при `accepted = false`. Те же поля, что при создании, плюс возможность удалить или добавить сертификаты.

После успешного сохранения страница перезагружается (`report_updated: true`).

### 4.4 Загрузка/удаление файлов сертификатов

| Действие | Маршрут |
|----------|---------|
| Загрузка | `POST /cabinet.upload.report.files` → `uploadReportFiles` |
| Удаление | `POST /cabinet.delete.report.files` → `deleteReportFiles` |

Ограничения: только PDF, до 15 МБ на файл, максимум 4 файла суммарно.

---

## 5. Роль: Менеджер

### 5.1 Страница отчётов

**Маршрут:** `GET /cabinet-manager/reports` → `managerReports` (middleware: `IsManagerMiddleware`)

Показывает отчёты всех пользователей, закреплённых за данным менеджером. Для каждого отчёта:
- Имя пользователя, период
- Вид отчёта, дисциплина, заведение
- Загруженные сертификаты (ссылки для скачивания)
- Бейдж: **«Принят»** (зелёный) или **«На рассмотрении»** (оранжевый)
- Кнопка **«Редактировать»** — только если `accepted = false`, открывает модал `manager_report_view`
- Иконка чата с красным бейджем — если есть непрочитанные сообщения от пользователя; открывает тот же модал `manager_report_view` (содержащий чат)

### 5.2 Просмотр и редактирование отчёта (модал)

Открывается через Fancybox-модал (`data-form="manager_report_view"`).

При открытии модала непрочитанные сообщения от пользователя **автоматически помечаются прочитанными**.

**Если отчёт принят (`accepted = true`):**
- Показывается уведомление «Отчёт принят и не может быть изменён»
- Все поля отображаются в режиме read-only
- Чат по-прежнему доступен

**Если отчёт не принят (`accepted = false`):**
- Редактируемая форма: период, вид отчёта, дисциплина, заведение
- Файлы сертификатов — только для просмотра/скачивания (не редактируются)
- Кнопки:
  - **«Сохранить изменения»** → `POST /manager_report_update`
  - **«Принять отчёт»** → `POST /manager_report_accept`

### 5.3 Редактирование полей отчёта менеджером

**POST** `/manager_report_update` → `fancyboxManagerReportUpdate` (middleware: `IsManagerMiddleware`)

Проверяется: менеджер является владельцем отчёта (через `manager_id` пользователя), `accepted = false`.

После сохранения страница перезагружается (`manager_report_updated: true`).

### 5.4 Принятие отчёта

**POST** `/manager_report_accept` → `fancyboxManagerReportAccept` (middleware: `IsManagerMiddleware`)

Устанавливает `accepted = true`. После этого редактирование заблокировано для обеих сторон.

После принятия страница перезагружается (`manager_report_accepted: true`).

---

## 6. Чат по отчёту

Каждый отчёт имеет собственную переписку между пользователем и его менеджером.

### 6.1 Чат менеджера

Расположен внизу модала `manager_report_view` (всегда виден, даже для принятых отчётов).

**Отправка сообщения:**
`POST /report-chat/manager-send` → `ReportChatController::managerSend`

Параметры: `report_id`, `user_id`, `body` (до 5000 символов).

### 6.2 Чат пользователя

Открывается через Fancybox-модал (`data-form="report_chat_user"`).

При открытии сообщения от менеджера **автоматически помечаются прочитанными**.

**Отправка сообщения:**
`POST /report-chat/user-send` → `ReportChatController::userSend`

Параметры: `report_id`, `body` (до 5000 символов).

### 6.3 Отображение сообщений

Сообщения добавляются в DOM без перезагрузки страницы (AJAX). Компонент `x-report-chat.message` рендерит каждое сообщение:
- Сообщения менеджера — слева, синяя левая граница
- Сообщения пользователя — справа, серая правая граница

---

## 7. Счётчики непрочитанных сообщений

### У пользователя (кнопка «Переписка»)

Показывает количество непрочитанных сообщений **от менеджера** по данному отчёту. Красный кружок с числом появляется рядом с кнопкой «Переписка». Сбрасывается при открытии чата.

Метод: `CabinetMessageViewModel::unreadCountsByReportsForUser(array $reportIds, int $userId)`

### У менеджера (иконка чата)

Показывает количество непрочитанных сообщений **от пользователя** по данному отчёту. Красный кружок с числом появляется как отдельная иконка рядом с кнопкой «Редактировать». Сбрасывается при открытии модала отчёта.

Метод: `CabinetMessageViewModel::unreadCountsByReports(array $reportIds, string $staffType, int $staffId)`

---

## 8. Маршруты (Routes)

| Метод | URI | Контроллер / метод | Middleware | Название |
|-------|-----|--------------------|-----------|----------|
| GET | `/cabinet/reports` | `CabinetUserController::cabinetReports` | UserMiddleware | `cabinet_reports` |
| POST | `/user_report_create` | `FancyBoxSendingFromFormController::fancyboxUserReportCreate` | UserMiddleware | — |
| POST | `/user_report_update` | `FancyBoxSendingFromFormController::fancyboxUserReportUpdate` | UserMiddleware | — |
| POST | `/cabinet.upload.report.files` | `AxiosUploadFilesController::uploadReportFiles` | UserMiddleware | — |
| POST | `/cabinet.delete.report.files` | `AxiosUploadFilesController::deleteReportFiles` | UserMiddleware | — |
| GET | `/cabinet-manager/reports` | `CabinetManagerController::managerReports` | IsManagerMiddleware | `manager_reports` |
| POST | `/manager_report_update` | `FancyBoxSendingFromFormController::fancyboxManagerReportUpdate` | IsManagerMiddleware | — |
| POST | `/manager_report_accept` | `FancyBoxSendingFromFormController::fancyboxManagerReportAccept` | IsManagerMiddleware | — |
| POST | `/report-chat/manager-send` | `ReportChatController::managerSend` | IsManagerMiddleware | `report_chat_manager_send` |
| POST | `/report-chat/user-send` | `ReportChatController::userSend` | UserMiddleware | `report_chat_user_send` |
| POST | `/fancybox-ajax` | `FancyBoxController::fancybox` | — | — |

---

## 9. Контроллеры

| Файл | Назначение |
|------|-----------|
| `app/Http/Controllers/Cabinet/CabinetUser/CabinetUserController.php` | `cabinetReports()` — список отчётов пользователя |
| `app/Http/Controllers/Cabinet/CabinetManager/CabinetManagerController.php` | `managerReports()` — список отчётов менеджера |
| `app/Http/Controllers/FancyBox/FancyBoxController.php` | Рендер модалов: `user_report_create`, `user_report_edit`, `manager_report_view`, `report_chat_user` |
| `app/Http/Controllers/FancyBox/FancyBoxSendingFromFormController.php` | Сохранение данных форм из модалов |
| `app/Http/Controllers/Cabinet/Message/ReportChatController.php` | AJAX-отправка сообщений чата |
| `app/Http/Controllers/Axios/AxiosUploadFilesController.php` | Загрузка и удаление PDF-файлов |

---

## 10. JavaScript

| Файл | Назначение |
|------|-----------|
| `resources/js/include/cabinet/uploadReportFiles.js` | Загрузка/удаление PDF, превью файлов, валидация (тип, размер, количество) |
| `resources/js/include/cabinet/reportChat.js` | AJAX-чат: отправка, добавление сообщений в DOM, автоскролл |
| `resources/js/include/fancybox/fancybox.js` | Открытие модалов, обработка `form:success` (перезагрузка страницы после создания/сохранения/принятия) |

---

## 11. Структура файлов

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Cabinet/
│   │   │   ├── CabinetUser/CabinetUserController.php
│   │   │   ├── CabinetManager/CabinetManagerController.php
│   │   │   └── Message/ReportChatController.php
│   │   └── FancyBox/
│   │       ├── FancyBoxController.php
│   │       └── FancyBoxSendingFromFormController.php
│   └── Requests/
│       ├── Cabinet/UserReportCreateRequest.php
│       ├── Cabinet/UserReportUpdateRequest.php
│       ├── CabinetManager/ManagerReportUpdateRequest.php
│       └── CabinetManager/ManagerReportAcceptRequest.php
└── Models/Report.php

database/migrations/
├── 2026_06_17_000001_create_reports_table.php
├── 2026_06_18_000001_add_accepted_to_reports_table.php
└── 2026_06_18_000002_add_report_id_to_cabinet_conversations_table.php

resources/
├── js/include/cabinet/
│   ├── uploadReportFiles.js
│   └── reportChat.js
├── views/
│   ├── cabinet/cabinet_user/cabinet_reports.blade.php
│   ├── cabinet/cabinet_manager/reports/items.blade.php
│   ├── fancybox/forms/cabinet/
│   │   ├── user_report_create.blade.php
│   │   ├── user_report_edit.blade.php
│   │   ├── manager_report_view.blade.php
│   │   └── report_chat_user.blade.php
│   └── components/report-chat/message.blade.php
└── css/components/cabinet-user/cabinet-user-reports-component.scss

src/Domain/CabinetMessage/
├── DTOs/CabinetMessageDto.php
└── ViewModels/CabinetMessageViewModel.php
```
