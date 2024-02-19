<?php

namespace Modules\Contact\Commands\ScheduleNotifyContact;

use Core\Interfaces\Cqrs\CommandHandlerInterface;
use Core\Interfaces\Cqrs\CommandInterface;
use Illuminate\Database\Connection;
use Modules\Contact\Enums\ContactNotificationStatusEnum;
use Modules\Contact\Helpers;
use Modules\Contact\Models\ContactNotification;
use function Ramsey\Uuid\v4;

class ScheduleNotifyContactCommandHandler implements CommandHandlerInterface
{
    /**
     * This handler will schedule a notification to be sent to a contact
     * @param ScheduleNotifyContactCommand $command
     * @return void
     */
    public function handle(CommandInterface $command): void
    {
        // Build the view
        $view = "contact::{$command->channel}.{$command->template}";
        $content = view($view, ['name' => $command->name])->render();

        // Schedule the notification
        ContactNotification::query()
            ->insert([
                'uuid' => v4(),
                'contact' => $command->contact,
                'content' => $content,
                'schedule_time' => $command->scheduleTime,
                'channel' => $command->channel,
                'status' => ContactNotificationStatusEnum::PENDING,
                'created_at' => now(),
            ]);
    }
}
