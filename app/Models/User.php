<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\User\Status;
use Carbon\Carbon;
use Domain\City\ViewModels\CityViewModel;
use Domain\User\ViewModels\UserFilesViewModel;
use Domain\UserExpert\ViewModels\UserExpertViewModel;
use Domain\UserLanguage\ViewModels\UserLanguageViewModel;
use Domain\UserLecturer\ViewModels\UserLecturerViewModel;
use Domain\UserProduction\View_Models\UserProductionViewModel;
use Domain\UserSex\ViewModels\UserSexViewModel;
use Domain\UserSpecialist\ViewModels\UserSpecialistViewModel;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Support\Casts\TarifCast;
use Support\Casts\TelegramCast;

class User extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $fillable = [
        'username',
        'phone',
        'email',
        'password',
        'iin', // ИИН
        'avatar', //
        'published',
        'address', // адрес (json)
        'date_birthday', // Дата рождения
        'certificate', // Сертификат
        'about_me', // Напишите коротко о себе для анкеты консультанта
        'experience', // Опыт
        'telegram', // telegram
        'whatsapp', // whatsapp
        'website', // website
        'instagram', // instagram
        'network', // network
        'accountant_work', // Место работы (наименование организации)
        'accountant_position', // Должность
        'accountant_ticket', // Номер сертификата профессионального бухгалтера
        'accountant_ticket_date', // Дата выдачи сертификата профессионального бухгалтера
        'date_entry', // Дата вступления в профессиональную организацию (заполняем менеджер)
        'bin', // БИН
        'company', // Компания
        'position_boss', // ФИО первого руководителя
        'account_delete', // Удалим аккаунт

        'file_id_card', // Удостоверение личности
        'file_criminal_record', // Справка об отсутствии судимости
        'file_dispensary', // Справка с псих. Диспансера
        'file_diploma_education', // Диплом о высшем образовании
        'file_accountant_certificate', // Сертификат бухгалтера
        'file_scientific_degrees', // Научные степени

        'file_legal_registration', // Справка о регистрации компании
        'file_legal_regulation', // Устав
        'file_legal_first_boss', // Приказ на первого руководителя

        'tarif_id', // belongsTo - пол только один тариф, который у пользователя
        'user_sex_id', // belongsTo - пол
        'user_human_id', // belongsTo - физ лицо - юр. лицо
        'user_city_id', // belongsTo - город
        'created_at', // дата создания
        'user_expert_id', // не нужное поле
        'user_lecturer_id', // не нужное поле
        'manager_id',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

/*    protected $with = ['UserSex', 'UserHuman', 'UserCity', 'UserExpert', 'UserLecturer', 'UserSpecialist', 'UserLanguage', 'UserProduction'];*/
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'address' => 'collection',
            'file_id_card' => 'collection',
            'file_criminal_record' => 'collection',
            'file_dispensary' => 'collection',
            'file_diploma_education' => 'collection',
            'file_accountant_certificate' => 'collection',
            'file_scientific_degrees' => 'collection',
            'file_legal_registration' => 'collection',
            'file_legal_regulation' => 'collection',
            'file_legal_first_boss' => 'collection',
            'date_birthday' => 'date', // Кастует к дате без времени
            'published' => 'integer',
            'tarif_id' => TarifCast::class,
            'tarif_expires_at' => 'datetime',


        ];
    }


    public function UserSex(): BelongsTo
    {
        return $this->belongsTo(UserSex::class, 'user_sex_id');

    }

    public function UserHuman(): BelongsTo
    {
        return $this->belongsTo(UserHuman::class, 'user_human_id');

    }

    public function UserCity(): BelongsTo
    {
        return $this->belongsTo(UserCity::class, 'user_city_id');

    }

    public function UserExpert(): BelongsToMany
    {
        return $this->belongsToMany(UserExpert::class);

    }

    public function UserLecturer(): BelongsToMany
    {
        return $this->belongsToMany(UserLecturer::class);

    }

    public function UserSpecialist(): BelongsToMany
    {
        return $this->belongsToMany(UserSpecialist::class);

    }

    public function UserLanguage(): BelongsToMany
    {
        return $this->belongsToMany(UserLanguage::class);

    }

    public function UserProduction(): BelongsToMany
    {
        return $this->belongsToMany(UserProduction::class);

    }

    public function UserFileQualification(): BelongsToMany
    {
        return $this->belongsToMany(UserFileQualification::class)
            ->withPivot(['custom_documents']);

    }

    public function Manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class, 'manager_id');

    }

    public function Tarif(): BelongsTo {
        return $this->belongsTo(Tarif::class, 'tarif_id')->where('published', 1);
    }


    /**
     * @return bool
     * Проверка на юр лицо
     */
    public function getLegalEntityAttribute(): bool
    {

        if (!is_null($this->user_human_id)) {
            // 1 - физ лицо, 2 - юр лицо
            return $this->user_human_id === Status::LEGALENTITY->value;
        }
        return false;
    }

    /**
     * @return bool
     * Проверка на физ лицо
     */
    public function getIndividualAttribute(): bool
    {

        // 1 - физ лицо, 2 - юр лицо
        if (!is_null($this->user_human_id)) {
            return $this->user_human_id === Status::INDIVIDUAL->value;
        }
        return false;
    }

    /**
     * @return array
     * Получение всех городов в виде массива
     */
    public function getUserCitiesAttribute(): array
    {
        $cities = CityViewModel::make()->Cities();
        if (!is_null($cities)) {
            return $cities->toArray();
        }
        return [];
    }

    /**
     * @return array
     * Получение всех полов в виде массива
     */
    public function getUserSexesAttribute(): array
    {
        $sexes = UserSexViewModel::make()->Sexes();
        if (!is_null($sexes)) {
            return $sexes->toArray();
        }
        return [];
    }

    /**
     * @return string
     * Для русскоязычных доменов
     */
    public function getSiteUtf8Attribute(): string
    {
        if ($this->website) {
            /** Извлекаем домен из полного URL **/
            $parsedUrl = parse_url($this->website);

            if (!$parsedUrl || !isset($parsedUrl['host'])) {
                throw new Exception("Некорректный URL");
            }

            $domain = $parsedUrl['host'];

            // Проверяем, является ли домен Punycode-доменом
            if (substr($domain, 0, 4) === 'xn--') {
                // Да, это Punycode, делаем дешифровку
                $decodedDomain = idn_to_utf8($domain);
            } else {
                // Нет, оставляем как есть
                $decodedDomain = $domain;
            }

            // Реконструируем URL
            $newPath = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
            $newQuery = isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '';
            $newFragment = isset($parsedUrl['fragment']) ? '#' . $parsedUrl['fragment'] : '';

            // Собираем полный URL
            return $parsedUrl['scheme'] . '://' . $decodedDomain . $newPath . $newQuery . $newFragment;

        }
        return '';
    }

    /**
     * Выводим реальный телеграм
     */
    public function getCorrectedTelegramAttribute(): ?string
    {
        return (!$this->attributes['telegram'])? '' : checkTelegram($this->attributes['telegram']);

    }


     /**
     * Выводим  whatsapp
     */

    public function getCorrectedWhatsappAttribute(): string
    {
        return (!$this->attributes['whatsapp'])? '' : checkWhatsapp($this->attributes['whatsapp']);
    }

     /**
     * Выводим  instagram
     */

    public function getCorrectedInstagramAttribute(): string
    {
        return (!$this->attributes['instagram'])? '' : checkInstagram($this->attributes['instagram']);

    }

    /**
     * @return array
     * Получение всех типов экспертности
     */
    public
    function getUserExpertsAttribute(): array
    {
        $experts = UserExpertViewModel::make()->UserExperts($this->id);
        if (!is_null($experts)) {
            return $experts->toArray();
        }
        return [];
    }

    /**
     * @return array
     * Получение всех типов языков
     */
    public
    function getUserLanguagesAttribute(): array
    {
        $languages = UserLanguageViewModel::make()->UserLanguages($this->id);
        if (!is_null($languages)) {
            return $languages->toArray();
        }
        return [];
    }

    /**
     * @return array
     * Получение всех типов специалистов
     */
    public
    function getUserSpecialistsAttribute(): array
    {
        $specialists = UserSpecialistViewModel::make()->UserSpecialists($this->id);
        if (!is_null($specialists)) {
            return $specialists->toArray();
        }
        return [];
    }

    /**
     * @return array
     * Получение всех типов лекторов
     */
    public
    function getUserLecturersAttribute(): array
    {
        $lecturers = UserLecturerViewModel::make()->UserLecturers($this->id);
        if (!is_null($lecturers)) {
            return $lecturers->toArray();
        }
        return [];
    }

    /**
     * @return array
     * Получение всех типов видов деятельности компании
     */
    public
    function getUserProductionsAttribute(): array
    {
        $productions = UserProductionViewModel::make()->UserProductions($this->id);
        if (!is_null($productions)) {
            return $productions->toArray();
        }
        return [];
    }

    /** Кастомный акцессор в модель User **/
    /** get **/
    public
    function getDateBirthdayAttribute(?string $value): string|null
    {
        if ($value === null || empty($value)) {
            return null; // Можно вернуть null или строку "", зависит от ваших предпочтений
        }
        return \Carbon\Carbon::parse($value)->format('d.m.Y');
    }

    public
    function getAccountantTicketDateAttribute(?string $value): string|null
    {
        if ($value === null || empty($value)) {
            return null; // Можно вернуть null или строку "", зависит от ваших предпочтений
        }
        return \Carbon\Carbon::parse($value)->format('d.m.Y');
    }

    /** Мутация атрибута для изменения формата даты **/
    public function setDateBirthdayAttribute($value): void
    {
        if (!empty($value)) {
            $this->attributes['date_birthday'] = Carbon::parse($value)->format('Y-m-d');
        }
    }

    /** Мутация атрибута для изменения формата даты **/
    public function setAccountantTicketDateAttribute($value): void
    {
        if (!empty($value)) {
            $this->attributes['accountant_ticket_date'] = Carbon::parse($value)->format('Y-m-d');
        }
    }


    /**
     * @return bool
     * Проверяем является ли пользователь мужчиной
     */
    public function getManAttribute(): bool
    {
        /** 1 -id в БД */
        if($this->user_sex_id == 1) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     * Проверяем является ли пользователь женщиной
     */
    public function getWomanAttribute(): bool
    {
        /** 2 -id в БД */
        if($this->user_sex_id == 2) {
            return true;
        }
        return false;
    }

    protected static function boot()
    {
        parent::boot();

        // Обработка первичного создания пользователя
        static::creating(function ($user) {
            if (!is_null($user->tarif_id)) {
                // Ставим дату истечения срока действия при первом назначении тарифа
                $user->tarif_expires_at = now()->addYear();
            }
        });

        // Обработка последующего изменения тарифа
        static::updating(function ($user) {
            $oldTarifId = $user->getOriginal('tarif_id');
            $newTarifId = $user->tarif_id;

            if ($oldTarifId != $newTarifId) {
                // Если тариф сменился, обновляем дату окончания действия
                $user->tarif_expires_at = now()->addYear();
            }
        });
    }


}
