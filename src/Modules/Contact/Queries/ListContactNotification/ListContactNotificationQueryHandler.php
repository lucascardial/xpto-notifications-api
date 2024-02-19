<?php

namespace Modules\Contact\Queries\ListContactNotification;

use Core\Interfaces\Cqrs\QueryHandlerInterface;
use Core\Interfaces\Cqrs\QueryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Contact\Models\ContactNotification;

class ListContactNotificationQueryHandler implements QueryHandlerInterface
{
    /**
     * @param ListContactNotificationQuery $query
     * @return LengthAwarePaginator
     */
    public function handle(QueryInterface $query): LengthAwarePaginator
    {
        $limit = $query->limit ?? 5;
        $page = $query->page ?? 1;

        return  ContactNotification::query()
            ->where('status', $query->status)
            ->orderBy('id', 'asc')
            ->paginate($limit, ['*'], 'page', $page)
            ->through(function (ContactNotification $notification) {
                return [
                    'id' => $notification->id,
                    'contact' => $notification->contact,
                    'content' => $notification->content,
                    'status' => $notification->status,
                    'schedule_date' => $notification->schedule_time?->format('Y-m-d H:i:s'),
                    'channel' => $notification->channel
                ];
            });
    }
}
