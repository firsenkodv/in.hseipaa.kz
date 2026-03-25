<?php

namespace Domain\Manager\DTOs;

use Illuminate\Http\Request;
use Support\Traits\Makeable;

class ManagerDto
{
    use Makeable;

    /** Список полей, которые будем сохранять **/
    const FIELDS = [
        'username', 'phone', 'email', 'password', 'telegram', 'whatsapp', 'instagram', 'r_o_p_id'
    ];

    public function __construct(
        public readonly ?string $username = null,
        public readonly ?string $phone = null,
        public readonly ?string $email = null,
        public readonly ?string $password = null,
        public readonly ?int $r_o_p_id = null,
        public readonly ?string $telegram = null,
        public readonly ?string $whatsapp = null,
        public readonly ?string $instagram = null
    )
    {

    }

    public static function formRequest(Request $request):ManagerDto
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
