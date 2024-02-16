<?php

namespace Modules\Contact\Commands\ScheduleNotifyContact;

use Core\Interfaces\Cqrs\CommandInterface;
use DateTime;

class ScheduleNotifyContactCommand implements CommandInterface
{
    public function __construct(
        public string $name,
        public string $contact,
        public string $channel,
        public string $template,
        public DateTime $scheduleTime
    )
    {
    }
}
