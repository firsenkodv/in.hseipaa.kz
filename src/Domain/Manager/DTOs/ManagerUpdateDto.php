<?php

namespace Domain\Manager\DTOs;

use Illuminate\Http\Request;
use Support\Traits\Makeable;

class ManagerUpdateDto
{
    use Makeable;

    /** Список полей, которые будем сохранять **/
    const FIELDS = [
        'username', 'phone', 'email', 'telegram', 'whatsapp', 'instagram'
    ];

    public function __construct(
        public readonly ?string $username = null,
        public readonly ?string $phone = null,
        public readonly ?string $email = null,
        public readonly ?string $telegram = null,
        public readonly ?string $whatsapp = null,
        public readonly ?string $instagram = null
    )
    {

    }

    public static function formRequest(Request $request):ManagerUpdateDto
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
