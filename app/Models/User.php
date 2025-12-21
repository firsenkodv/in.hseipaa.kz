<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Domain\City\ViewModels\CityViewModel;
use Domain\UserExpert\ViewModels\UserExpertViewModel;
use Domain\UserSex\ViewModels\UserSexViewModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

        'user_sex_id', // belongsTo - пол
        'user_human_id', // belongsTo - физ лицо - юр. лицо
        'user_city_id', // belongsTo - город
        'created_at',
        'user_expert_id',
        'user_lecturer_id',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    public function UserFileQualification(): BelongsToMany
    {
        return $this->belongsToMany(UserFileQualification::class)
            ->withPivot(['custom_documents']);

    }

    /**
     * @return bool
     * Проверка на юр лицо
     */
    public function getLegalEntityAttribute(): bool
    {

        if (!is_null($this->user_human_id)) {
            return $this->user_human_id == 2;
        }
        return false;
    }

    /**
     * @return bool
     * Проверка на физ лицо
     */
    public function getIndividualAttribute(): bool
    {

        if (!is_null($this->user_human_id)) {
            return $this->user_human_id == 1;
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
     * @return array
     * Получение всех типов экспертности
     */
    public function getUserExpertsAttribute(): array
    {
         $experts = UserExpertViewModel::make()->UserExperts($this->id);
            if (!is_null($experts)) {
                return $experts->toArray();
            }
        return [];
    }

    /** Кастомный акцессор в модель User **/
    /** get **/
    public function getDateBirthdayAttribute(?string $value): string|null
    {
        if ($value === null || empty($value)) {
            return null; // Можно вернуть null или строку "", зависит от ваших предпочтений
        }
        return \Carbon\Carbon::parse($value)->format('d.m.Y');
    }
    public function getAccountantTicketDateAttribute(?string $value): string|null
    {
        if ($value === null || empty($value)) {
            return null; // Можно вернуть null или строку "", зависит от ваших предпочтений
        }
        return \Carbon\Carbon::parse($value)->format('d.m.Y');
    }



    protected static function boot()
    {
        parent::boot();

        # Проверка данных  перед сохранением
        #  static::saving(function ($Moonshine) {   });


        static::created(function () {
            cache_clear();
        });

        static::updated(function () {
            cache_clear();
        });

        static::deleted(function () {
            cache_clear();
        });


    }


}
