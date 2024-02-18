<?php

namespace Modules\Contact\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Contact\Commands\PersistChunkContacts\PersistChunkContactsCommand;
use Modules\Contact\Commands\PersistChunkContacts\PersistChunkContactsCommandHandler;
use Modules\Sheet\CsvChunk;

class PersistContactFromCsvChunkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly CsvChunk $csvChunk
    )
    {
    }

    public function handle(PersistChunkContactsCommandHandler $handler): void
    {
        $input = new PersistChunkContactsCommand($this->csvChunk);
        $handler->handle($input);
    }
}
