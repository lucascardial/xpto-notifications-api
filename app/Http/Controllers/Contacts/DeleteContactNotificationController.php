<?php

namespace App\Http\Controllers\Contacts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Contact\Commands\DeleteNotification\DeleteNotificationCommand;
use Modules\Contact\Commands\DeleteNotification\DeleteNotificationCommandHandler;

class DeleteContactNotificationController extends Controller
{
    public function __construct(
        private readonly DeleteNotificationCommandHandler $deleteNotificationCommandHandler
    )
    {
    }

    public function __invoke(Request $request, string $id): \Illuminate\Http\Response
    {
        $input = new DeleteNotificationCommand($id);

        $this->deleteNotificationCommandHandler->handle($input);

        return response('', 204);
    }
}
