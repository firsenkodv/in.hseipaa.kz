<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use MoonShine\Laravel\Enums\Action;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Http\Responses\MoonShineJsonResponse;
use MoonShine\Laravel\MoonShineRequest;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\ListOf;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Field;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Password;
use MoonShine\UI\Fields\PasswordRepeat;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends ModelResource<User>
 */
class UserResource extends ModelResource
{
    protected string $model = User::class;
    protected string $title = 'Пользователи';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Image::make(__('Аватар'), 'avatar'),
            Text::make(__('ФИО'), 'username'),
            Text::make(__('Email'), 'email'),
            Text::make(__('Телефон'), 'phone'),
            Switcher::make('Публикация', 'published')->updateOnPreview(),
            BelongsTo::make('Вид', 'UserHuman', 'title', resource: UserHumanResource::class)

        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [

            Box::make([
                ID::make(),

                Tabs::make([

                    Tab::make(__('Общие настройки'), [
                        Grid::make([
                            Column::make([
                                Collapse::make('', [

                                    Text::make(__('ФИО'), 'username'),

                                    Image::make(__('Аватар'), 'avatar')
                                        ->disk('public')
                                        ->onAfterApply(function (Model $data, $file, Image $field) {

                                                    /*           dump($data);
                                                                 dump($file);
                                                                 dd($field);   */

                                            if ($file !== false) {

                                                $destinationPath = 'users/' . $data->id . '/avatar';
                                                $file->storeAs($destinationPath, $data->avatar);
                                                Storage::disk('public')->delete($data->avatar);
                                                User::query()
                                                    ->where('id', $data->id)
                                                    ->update(['avatar' => $destinationPath . '/' . $data->avatar]);

                                            }

                                        })
                                        ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg', 'webp', 'gif'])
                                        ->removable(),

                                    Text::make(__('Email'), 'email'),
                                    Number::make('Телефон', 'phone')->min(1000)->max(1000000000000)->nullable()->hint('ТОЛЬКО цифры'),
                                ]),

                                Collapse::make('', [

                                    Divider::make('Социальные сети'),
                                    Text::make('Телеграм', 'telegram')->hint('Заполняйте правильно - t.me/hseipaa или @hseipaa'),
                                    Number::make('WhatsApp', 'whatsapp')->hint('Заполняйте правильно  - (только цифры) - 77075594059'),
                                    Text::make('Website', 'website')->hint('Заполняйте правильно - https://in.hseipaa.kz'),
                                    Text::make('Instagram', 'instagram')->hint('Заполняйте правильно только аккаунт - hseipaa.kz'),
                                    Text::make('Другая соц. сеть', 'network')->hint('Заполняйте правильно -  https://vk.com/axeld'),
                                ]),


                            ])->columnSpan(6),
                            Column::make([
                                Collapse::make('', [
                                    Switcher::make('Публикация', 'published')->default(1),
                                    Switcher::make('Запрос на удаление', 'account_delete')->default(0),

                                ]),
                                Collapse::make('Связи', [

                                    BelongsTo::make('Город', 'UserCity', 'title', resource: UserCityResource::class)
                                        ->valuesQuery(fn(Builder $query, Field $field) => $query->orderBy('sorting', 'DESC'))
                                        ->nullable()->searchable()->creatable(),

                                    BelongsTo::make('Тариф', 'tarif', 'title', resource: TarifResource::class)->nullable(),

                                    BelongsTo::make('Физ.лицо/Юл. лицо', 'UserHuman', 'title', resource: UserHumanResource::class)
                                        ->valuesQuery(fn(Builder $query, Field $field) => $query->orderBy('sorting', 'DESC'))
                                        ->creatable(),


                                    BelongsTo::make('Пол', 'UserSex', 'title', resource: UserSexResource::class)->nullable(),

                                    BelongsToMany::make('Языки', 'UserLanguage', 'title', resource: UserLanguageResource::class)
                                        ->valuesQuery(fn(Builder $query, Field $field) => $query->orderBy('sorting', 'DESC'))
                                        ->nullable()->creatable(),

                                    BelongsToMany::make('Специалист', 'UserSpecialist', 'title', resource: UserSpecialistResource::class)
                                        ->valuesQuery(fn(Builder $query, Field $field) => $query->orderBy('sorting', 'DESC'))
                                        ->nullable()->creatable(),


                                    BelongsToMany::make('Эксперт', 'UserExpert', 'title', resource: UserExpertResource::class)
                                        ->valuesQuery(fn(Builder $query, Field $field) => $query->orderBy('sorting', 'DESC'))
                                        ->nullable()->creatable(),

                                    BelongsToMany::make('Лектор', 'UserLecturer', 'title', resource: UserLecturerResource::class)
                                        ->valuesQuery(fn(Builder $query, Field $field) => $query->orderBy('sorting', 'DESC'))
                                        ->nullable()->creatable(),

                                    BelongsToMany::make('Вид деятельности', 'UserProduction', 'title', resource: UserProductionResource::class)
                                        ->valuesQuery(fn(Builder $query, Field $field) => $query->orderBy('sorting', 'DESC'))
                                        ->nullable()->creatable(),

                                    BelongsToMany::make('Квалификации', 'UserFileQualification', 'title', resource: UserFileQualificationResource::class)
                                        ->valuesQuery(fn(Builder $query, Field $field) => $query->orderBy('sorting', 'DESC'))
                                        ->fields([
                                            Text::make('Номер', 'custom_documents'),
                                            /*      Json::make('Инфо', 'custom_documents')->fields([
                                                      Text::make('Номер', 'number'),
                                                  ]),*/
                                        ])
                                        ->nullable()


                                ]),

                            ])->columnSpan(6)
                        ]),
                        Grid::make([
                            Column::make([
                                Collapse::make('', [

                                    Divider::make('Физическое лицо'),
                                    Text::make(__('ИИН'), 'iin'),
                                    Box::make('Адрес', [

                                        Json::make('', 'address')->fields([
                                            Text::make(__('Индекс'), 'json_address_post_index')->unescape(),
                                            Text::make(__('Область'), 'json_address_area')->unescape(),
                                            Text::make(__('Улица'), 'json_address_street')->unescape(),
                                            Text::make(__('Дом'), 'json_address_house')->unescape(),
                                            Text::make(__('кв/офис'), 'json_address_office')->unescape(),

                                        ])->object(),
                                    ]),
                                    Date::make(__('Дата рождения'), 'date_birthday')->format('d.m.Y'),
                                    TinyMce::make(__('Сертификат'), 'certificate'),
                                    TinyMce::make(__('Обо мне'), 'about_me')->hint('Напишите коротко о себе для анкеты консультанта'),
                                    TinyMce::make(__('Опыт'), 'experience'),
                                    Text::make('Место работы (наименование организации)', 'accountant_work')->unescape(),
                                    Text::make('Должность', 'accountant_position')->unescape(),
                                    Text::make('Номер сертификата профессионального бухгалтера', 'accountant_ticket')->unescape(),
                                    Date::make('Дата выдачи сертификата профессионального бухгалтера', 'accountant_ticket_date')->format('d.m.Y'),
                                    Date::make('Дата вступления в профессиональную организацию', 'date_entry')->format('d.m.Y')->hint('Заполняем менеджер'),
                                ]),

                            ])->columnSpan(6),
                            Column::make([
                                Collapse::make('', [

                                    Divider::make('Юридическое лицо'),
                                    Text::make(__('БИН'), 'bin')->unescape(),
                                    Text::make(__('Компания'), 'company')->unescape(),
                                    Text::make(__('ФИО первого руководителя'), 'position_boss')->unescape(),
                                ]),

                            ])->columnSpan(6)
                        ]),

                        Grid::make([
                            Column::make([
                                Collapse::make('', [

                                    Divider::make('Файлы'),

                                    Json::make('Удостоверение личности', 'file_id_card')->fields([
                                        File::make(__('Документ'), 'json_file')
                                            ->disk('public')
                                            ->keepOriginalFileName()
                                            ->removable(),
                                    ])
                                        ->onAfterApply(function (Model $data, false|array $values) {
                                            $this->moveDocuments($data, 'file_id_card');
                                        })
                                        ->vertical()->creatable(limit: 4)
                                        ->removable(),

                                    Json::make('Справка об отсутствии судимости', 'file_criminal_record')->fields([
                                        File::make(__('Документ'), 'json_file')
                                            ->disk('public')
                                            ->keepOriginalFileName()
                                            ->removable(),
                                    ])->onAfterApply(function (Model $data, false|array $values) {
                                        $this->moveDocuments($data, 'file_criminal_record');
                                    })
                                        ->vertical()->creatable(limit: 4)
                                        ->removable(),

                                    Json::make('Справка с псих. Диспансера', 'file_dispensary')->fields([File::make(
                                        __('Документ'), 'json_file')
                                        ->disk('public')
                                        ->keepOriginalFileName()
                                        ->removable(),
                                    ])->onAfterApply(function (Model $data, false|array $values) {
                                        $this->moveDocuments($data, 'file_dispensary');
                                    })
                                        ->vertical()->creatable(limit: 4)
                                        ->removable(),


                                    Json::make('Диплом о высшем образовании', 'file_diploma_education')->fields([
                                        File::make(__('Документ'), 'json_file')
                                            ->disk('public')
                                            ->keepOriginalFileName()
                                            ->removable(),
                                    ])->onAfterApply(function (Model $data, false|array $values) {
                                        $this->moveDocuments($data, 'file_diploma_education');
                                    })
                                        ->vertical()->creatable(limit: 4)
                                        ->removable(),

                                    Json::make('Сертификат бухгалтера', 'file_accountant_certificate')->fields([
                                        File::make(__('Документ'), 'json_file')
                                            ->disk('public')
                                            ->keepOriginalFileName()
                                            ->removable(),
                                    ])->onAfterApply(function (Model $data, false|array $values) {
                                        $this->moveDocuments($data, 'file_accountant_certificate');
                                    })
                                        ->vertical()->creatable(limit: 4)
                                        ->removable(),

                                    Json::make('Научные степени', 'file_scientific_degrees')->fields([File::make(__(
                                        'Документ'), 'json_file')
                                        ->disk('public')
                                        ->keepOriginalFileName()
                                        ->removable(),
                                    ])->onAfterApply(function (Model $data, false|array $values) {
                                        $this->moveDocuments($data, 'file_scientific_degrees');
                                    })
                                        ->vertical()->creatable(limit: 4)
                                        ->removable(),

                                    Json::make('Справка о регистрации компании', 'file_legal_registration')->fields([
                                        File::make(__('Документ'), 'json_file')
                                            ->disk('public')
                                            ->keepOriginalFileName()
                                            ->removable(),
                                    ])->onAfterApply(function (Model $data, false|array $values) {
                                        $this->moveDocuments($data, 'file_legal_registration');
                                    })
                                        ->vertical()->creatable(limit: 4)
                                        ->removable(),

                                    Json::make('Устав', 'file_legal_regulation')->fields([File::make(__('
                                    Документ'), 'json_file')
                                        ->disk('public')
                                        ->keepOriginalFileName()
                                        ->removable(),
                                    ])->onAfterApply(function (Model $data, false|array $values) {
                                        $this->moveDocuments($data, 'file_legal_regulation');
                                    })
                                        ->vertical()->creatable(limit: 4)
                                        ->removable(),

                                    Json::make('Приказ на первого руководителя', 'file_legal_first_boss')->fields([
                                        File::make(__('Документ'), 'json_file')
                                            ->disk('public')
                                            ->keepOriginalFileName()
                                            ->removable(),
                                    ])->onAfterApply(function (Model $data, false|array $values) {
                                        $this->moveDocuments($data, 'file_legal_first_boss');
                                    })
                                        ->vertical()->creatable(limit: 4)
                                        ->removable(),

                                ]),
                            ])->columnSpan(6),
                            Column::make([


                            ])->columnSpan(6)
                        ]),
                    ]),

                    Tab::make(__('Пароль'), [
                        Grid::make([
                            Column::make([
                                Collapse::make('Пароль', [

                                    Password::make(__('moonshine::ui.resource.password'), 'password')
                                        ->customAttributes(['autocomplete' => 'new-password'])
                                        ->eye(),

                                    PasswordRepeat::make(__('moonshine::ui.resource.repeat_password'), 'password_repeat')
                                        ->customAttributes(['autocomplete' => 'confirm-password'])
                                        ->eye(),
                                ]),
                            ])->columnSpan(12),
                        ]),

                    ]),

                ])
            ])
        ];
    }


    protected function moveDocuments(Model $data, string $field): void
    {
        if (!empty($data->$field)) {
            // Проверяем существование значения file_id_card
            $newFilePaths = [];

            foreach ($data->$field as &$file) {
                // Берём старое имя файла (без лишнего path)
                $originalFilename = basename($file['json_file']);
                // Определяем целевую директорию
                $destinationPath = 'users/' . $data->id . '/' . $field . '/';

                // Если директория не существует, создадим её
                if (!is_dir(storage_path('app/public/' . $destinationPath))) {
                    mkdir(storage_path('app/public/' . $destinationPath), 0755, true);
                }

                // Перемещаем файл в новое местоположение
                Storage::disk('public')->move($file['json_file'], $destinationPath . $originalFilename);

                // Формируем правильный путь для базы данных
                $newFilePaths[] = ['json_file' => $destinationPath . $originalFilename];
            }

            // Записываем новые пути обратно в модель
            $data->$field = $newFilePaths;
            $data->save();
        }
    }







    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
        ];
    }

    protected function rules(mixed $item): array
    {

        return [
            'username' => 'max:90',
            'email' => [
                'sometimes',
                'bail',
                'required',
                'email',
                Rule::unique('users')->ignore($item->email, 'email'),
            ],
            'password' => $item->exists
                ? 'sometimes|nullable|min:5|required_with:password_repeat|same:password_repeat'
                : 'required|min:5|required_with:password_repeat|same:password_repeat',
        ];
    }

    protected function activeActions(): ListOf
    {
        return parent::activeActions()
            ->except(Action::VIEW /*Action::MASS_DELETE, Action::DELETE, Action::CREATE*/)// ->only(Action::VIEW)
            ;
    }
}
