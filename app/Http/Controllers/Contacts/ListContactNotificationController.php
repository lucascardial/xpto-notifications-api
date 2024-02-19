<?php

namespace App\Http\Controllers\Contacts;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Contact\Enums\ContactNotificationStatusEnum;
use Modules\Contact\Queries\ListContactNotification\ListContactNotificationQuery;
use Modules\Contact\Queries\ListContactNotification\ListContactNotificationQueryHandler;

class ListContactNotificationController extends Controller
{
    public function __construct(
        private readonly ListContactNotificationQueryHandler $queryHandler
    )
    {
    }

    public function __invoke(Request $request): LengthAwarePaginator
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 5);

        $status =  ContactNotificationStatusEnum::tryFrom($request->get('status'))
            ?? ContactNotificationStatusEnum::PENDING;

        return $this->queryHandler->handle(new ListContactNotificationQuery(
            page: $page, limit: $limit, status: $status));
    }
}
