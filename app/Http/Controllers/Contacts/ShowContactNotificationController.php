<?php

namespace App\Http\Controllers\Contacts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Contact\Queries\GetContactNotification\GetContactNotificationQuery;
use Modules\Contact\Queries\GetContactNotification\GetContactNotificationQueryHandler;

class ShowContactNotificationController extends Controller
{
    public function __construct(
        private readonly GetContactNotificationQueryHandler $queryHandler
    )
    {
    }

    public function __invoke(Request $request, string $id)
    {
        $input = new GetContactNotificationQuery($id);

        return response()->json($this->queryHandler->handle($input));
    }
}
