<?php

namespace Domain\HH\Resume\DTOs;

use App\Http\Requests\HH\Resume\StoreResumeRequest;
use Support\Traits\Makeable;

class StoreResumeDto
{
    use Makeable;

    const FIELDS = [
        'title',
        'subtitle',
        'post',
        'hunter_category_id',
        'user_city_id',
        'hunter_experience_id',
        'price',
        'desc',
        'must',
        'conditions',
        'address',
        'email',
        'phone',
        'telegram',
        'whatsapp',
    ];

    public function __construct(
        public readonly string  $title,
        public readonly ?string $subtitle = null,
        public readonly ?string $post = null,
        public readonly ?int    $hunter_category_id = null,
        public readonly ?int    $user_city_id = null,
        public readonly ?int    $hunter_experience_id = null,
        public readonly ?int    $price = null,
        public readonly ?string $desc = null,
        public readonly ?string $must = null,
        public readonly ?string $conditions = null,
        public readonly ?string $address = null,
        public readonly ?string $email = null,
        public readonly ?string $phone = null,
        public readonly ?string $telegram = null,
        public readonly ?string $whatsapp = null,
    ) {}

    public static function formRequest(StoreResumeRequest $request): self
    {
        return self::make(...$request->only(self::FIELDS));
    }

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
