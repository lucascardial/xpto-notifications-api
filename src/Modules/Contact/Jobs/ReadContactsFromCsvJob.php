<?php

namespace Modules\Contact\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Contact\Commands\ReadContactsFromCsv\ReadContactsFromCsvCommand;
use Modules\Contact\Commands\ReadContactsFromCsv\ReadContactsFromCsvCommandHandler;

class ReadContactsFromCsvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $filePath,
        public string $disk
    )
    {
    }

    public function handle(ReadContactsFromCsvCommandHandler $handler): void
    {
        $input = new ReadContactsFromCsvCommand(filePath: $this->filePath, disk: $this->disk);
        $handler->handle($input);
    }
}
