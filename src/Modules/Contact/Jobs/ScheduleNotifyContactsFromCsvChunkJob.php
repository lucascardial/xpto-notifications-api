<?php

namespace Modules\Contact\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Contact\Commands\ScheduleNotifyContact\ScheduleNotifyContactCommand;
use Modules\Contact\Commands\ScheduleNotifyContact\ScheduleNotifyContactCommandHandler;
use Modules\Contact\ConfigurationKeys;
use Modules\Contact\Enums\ContactTypeEnum;
use Modules\Contact\Helpers;
use Modules\Sheet\CsvChunk;

class ScheduleNotifyContactsFromCsvChunkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly CsvChunk $csvChunk
    )
    {
    }

    /**
     * For each row in the csv chunk, schedule a notification
     * @param ScheduleNotifyContactCommandHandler $handler
     * @return void
     */
    public function handle(ScheduleNotifyContactCommandHandler $handler): void
    {

        foreach ($this->csvChunk->rows as $row) {
            $data = array_combine($this->csvChunk->columns, $row);
            $name = $data[ConfigurationKeys::FULL_NAME_COLUMN_NAME];
            $contact = $data[ConfigurationKeys::CONTACT_COLUMN_NAME];
            $contactType = Helpers::checkContactType($contact);

            if($contactType === ContactTypeEnum::UNKNOWN)
                continue;

            $command = new ScheduleNotifyContactCommand(
                name: $name,
                contact: $contact,
                channel: $contactType->notifyBy(),
                template: 'default-notification',
                scheduleTime: now()->addMinutes(5)
            );

            $handler->handle($command);
        }
    }
}
