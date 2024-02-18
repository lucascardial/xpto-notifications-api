<?php

namespace Modules\Contact\Queries\ListContactNotification;

use Core\Interfaces\Cqrs\QueryInterface;
use Modules\Contact\Enums\ContactNotificationStatusEnum;

class ListContactNotificationQuery implements QueryInterface
{
    public function __construct(
        public ?int $page,
        public ?int $limit,
        public ?ContactNotificationStatusEnum $status = ContactNotificationStatusEnum::PENDING
    )
    {
    }
}
