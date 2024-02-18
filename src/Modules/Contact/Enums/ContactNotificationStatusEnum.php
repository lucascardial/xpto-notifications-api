<?php

namespace Modules\Contact\Enums;

enum ContactNotificationStatusEnum: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case SENT = 'sent';
    case FAILED = 'failed';
    case CANCELLED = 'cancelled';
}
