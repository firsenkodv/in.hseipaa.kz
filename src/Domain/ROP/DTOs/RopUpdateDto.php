<?php

namespace Domain\ROP\DTOs;

use Illuminate\Http\Request;
use Support\Traits\Makeable;

class RopUpdateDto
{
    use Makeable;

    /** Список полей, которые будем сохранять **/
    const FIELDS = [
        'username', 'phone', 'email'
    ];

    public function __construct(
        public readonly ?string $username = null,
        public readonly ?string $phone = null,
        public readonly ?string $email = null
    )
    {

    }

    public static function formRequest(Request $request):RopUpdateDto
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
