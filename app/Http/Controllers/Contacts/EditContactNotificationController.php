<?php

namespace App\Http\Controllers\Contacts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contacts\EditContactNotificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Contact\Commands\UpdateNotification\UpdateNotificationCommand;
use Modules\Contact\Commands\UpdateNotification\UpdateNotificationCommandHandler;

class EditContactNotificationController extends Controller
{
    public function __construct(
        private readonly UpdateNotificationCommandHandler $handler
    )
    {
    }

    public function __invoke(EditContactNotificationRequest $request, string $id): JsonResponse
    {
        $input = new UpdateNotificationCommand(
            id: $id,
            contact: $request->contact,
            content: $request->content,
            scheduleDate: $request->schedule_date
        );

        $this->handler->handle($input);

        return response()->json(['message' => 'Notification updated successfully']);
    }
}
