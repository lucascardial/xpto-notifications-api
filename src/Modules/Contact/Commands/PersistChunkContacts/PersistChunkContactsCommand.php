<?php

namespace Modules\Contact\Commands\PersistChunkContacts;

use Core\Interfaces\Cqrs\CommandInterface;
use Modules\Sheet\CsvChunk;

class PersistChunkContactsCommand implements CommandInterface
{
    public function __construct(
        public readonly CsvChunk $csvChunk
    )
    {
    }
}
