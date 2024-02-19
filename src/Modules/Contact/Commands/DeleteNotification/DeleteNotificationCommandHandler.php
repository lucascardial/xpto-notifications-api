<?php

namespace Modules\Contact\Commands\DeleteNotification;

use Core\Interfaces\Cqrs\CommandHandlerInterface;
use Core\Interfaces\Cqrs\CommandInterface;
use Modules\Contact\Models\ContactNotification;

class DeleteNotificationCommandHandler implements CommandHandlerInterface
{
    /**
     * @param DeleteNotificationCommand $command
     * @return void
     */
    public function handle(CommandInterface $command): void
    {
        ContactNotification::query()
            ->where('uuid', $command->id)
            ->delete();
    }
}
