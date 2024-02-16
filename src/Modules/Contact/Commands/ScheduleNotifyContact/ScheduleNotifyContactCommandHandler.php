<?php

namespace Modules\Contact\Commands\ScheduleNotifyContact;

use Core\Interfaces\Cqrs\CommandHandlerInterface;
use Core\Interfaces\Cqrs\CommandInterface;
use Illuminate\Database\Connection;
use Modules\Contact\Helpers;
use function Ramsey\Uuid\v4;

class ScheduleNotifyContactCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly Connection $connection
    )
    {
    }

    /**
     * @param ScheduleNotifyContactCommand $command
     * @return void
     */
    public function handle(CommandInterface $command): void
    {
        $content = view(
            "contact::{$command->channel}.{$command->template}",
            ['name' => $command->name])->render();

        $this->connection->table('contact_notifications')
            ->insert([
                'id' => v4(),
                'contact' => $command->contact,
                'content' => $content,
                'schedule_time' => $command->scheduleTime,
                'channel' => $command->channel
            ]);
    }
}
