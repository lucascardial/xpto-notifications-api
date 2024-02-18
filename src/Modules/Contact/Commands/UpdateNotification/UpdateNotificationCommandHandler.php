<?php

namespace Modules\Contact\Commands\UpdateNotification;

use Core\Interfaces\Cqrs\CommandHandlerInterface;
use Core\Interfaces\Cqrs\CommandInterface;
use Modules\Contact\Models\ContactNotification;

class UpdateNotificationCommandHandler implements CommandHandlerInterface
{
    /**
     * @param UpdateNotificationCommand $command
     * @return void
     */
    public function handle(CommandInterface $command): void
    {
       ContactNotification::query()
            ->where('id', $command->id)
            ->update([
                'content' => $command->content,
                'contact' => $command->contact,
                'schedule_time' => $command->scheduleDate
            ]);
    }
}
