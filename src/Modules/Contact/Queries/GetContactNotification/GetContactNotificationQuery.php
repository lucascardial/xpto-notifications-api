<?php

namespace Modules\Contact\Queries\GetContactNotification;

use Core\Interfaces\Cqrs\QueryInterface;

class GetContactNotificationQuery implements QueryInterface
{
    public function __construct(
        public string $id
    )
    {
    }
}
