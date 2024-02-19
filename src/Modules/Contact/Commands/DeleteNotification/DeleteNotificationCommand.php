<?php

namespace Modules\Contact\Commands\DeleteNotification;

use Core\Interfaces\Cqrs\CommandInterface;

class DeleteNotificationCommand implements CommandInterface
{
    public function __construct(
        public string $id
    )
    {
    }
}
