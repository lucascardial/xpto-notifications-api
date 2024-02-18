<?php

namespace Modules\Contact\Dtos;

class ContactNotificationDto
{
    public function __construct(
        public readonly string $id,
        public readonly string $contact,
        public readonly string $content,
        public readonly string $channel,
        public readonly string $status,
        public readonly string $scheduleDate,
    )
    {
    }
}
