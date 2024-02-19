<?php

namespace Modules\Contact\Queries\GetContactNotification;

use Core\Interfaces\Cqrs\QueryHandlerInterface;
use Core\Interfaces\Cqrs\QueryInterface;
use Modules\Contact\Dtos\ContactNotificationDto;
use Modules\Contact\Models\ContactNotification;

class GetContactNotificationQueryHandler implements QueryHandlerInterface
{
    /**
     * @param GetContactNotificationQuery $query
     * @return mixed
     */
    public function handle(QueryInterface $query): mixed
    {
        /** @var ContactNotification $contactNotification */
        $contactNotification = ContactNotification::query()
            ->where('uuid', $query->id)
            ->firstOrFail();

        return new ContactNotificationDto(
            id: $contactNotification->id,
            contact: $contactNotification->contact,
            content: $contactNotification->content,
            channel: $contactNotification->channel,
            status: $contactNotification->status,
            scheduleDate: $contactNotification->schedule_time?->format('Y-m-d H:i:s')
        );
    }
}
