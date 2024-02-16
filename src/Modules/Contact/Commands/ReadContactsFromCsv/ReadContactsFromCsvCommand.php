<?php

namespace Modules\Contact\Commands\ReadContactsFromCsv;

use Core\Interfaces\Cqrs\CommandInterface;

class ReadContactsFromCsvCommand implements CommandInterface
{
    public function __construct(
        public string $filePath,
        public string $disk = 'local'
    )
    {
    }
}
