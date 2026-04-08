<?php

namespace Domain\CabinetMessage\DTOs;

use Support\Traits\Makeable;

class CabinetMessageDto
{
    use Makeable;

    public function __construct(
        public readonly int    $user_id,
        public readonly string $body,
        public readonly string $staff_type,
        public readonly int    $staff_id,
        public readonly string $sender_type,
        public readonly int    $sender_id,
    ) {}
}
