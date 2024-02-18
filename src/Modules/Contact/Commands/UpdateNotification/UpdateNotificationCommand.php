<?php

namespace Modules\Contact\Commands\UpdateNotification;

use Core\Interfaces\Cqrs\CommandInterface;

class UpdateNotificationCommand implements CommandInterface
{
    public function __construct(
        public string $id,
        public string $contact,
        public string $content,
        public string $scheduleDate
    )
    {
    }
}
