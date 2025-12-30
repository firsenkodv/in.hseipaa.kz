<?php

namespace Domain\User\DTOs;

use Illuminate\Http\Request;
use Support\Traits\Makeable;

class UserUpdateDto
{
    use Makeable;

    /** Список полей, которые будем сохранять **/
    const FIELDS = [
        'username', 'phone', 'email', 'about_me', 'experience', 'date_birthday', 'user_city_id', 'user_sex_id', 'iin', 'address', 'bin', 'company', 'position_boss', 'accountant_work', 'accountant_position', 'accountant_ticket', 'accountant_ticket_date', 'telegram', 'whatsapp', 'instagram', 'website', 'published'
    ];

    public function __construct(
        public readonly ?string $username = null,
        public readonly ?string $phone = null,
        public readonly ?string $email = null,
        public readonly ?string $about_me = null,
        public readonly ?string $experience = null,
        public readonly ?string $date_birthday = null,
        public readonly ?int    $user_city_id = null,
        public readonly ?int    $user_sex_id = null,
        public readonly ?string $iin = null,
        public readonly ?array $address = null,
        public readonly ?string $bin = null,
        public readonly ?string $company = null,
        public readonly ?string $position_boss = null,
        public readonly ?string $accountant_work = null,
        public readonly ?string $accountant_position = null,
        public readonly ?string $accountant_ticket = null,
        public readonly ?string $accountant_ticket_date = null,
        public readonly ?string $telegram = null,
        public readonly ?string $whatsapp = null,
        public readonly ?string $instagram = null,
        public readonly ?string $website = null,
        public  ?int $published = 0,

    )
    {

    }

    public static function formRequest(Request $request):UserUpdateDto
    {
        return self::make( ... $request->only(self::FIELDS));

    }


    /** Формирование массива нужных полей **/
    public function toArray(): array
    {
        $result = [];
        foreach (self::FIELDS as $field) {
            if (isset($this->$field)) {
                $result[$field] = $this->$field;
            }
        }
        return $result;
    }
}
