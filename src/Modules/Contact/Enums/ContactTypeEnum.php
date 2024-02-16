<?php

namespace Modules\Contact\Enums;

enum ContactTypeEnum: string
{
    case EMAIL = 'email';
    case PHONE = 'phone';
    case UNKNOWN = 'unknown';

    public function notifyBy(): string | null
    {
        return match ($this) {
            self::EMAIL => 'email',
            self::PHONE => 'sms',
            default => null,
        };
    }
}
