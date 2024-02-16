<?php

namespace Core\Interfaces;

use Generator;
use Modules\Sheet\CsvChunk;

interface SheetReaderInterface
{
    /**
     * Set the file path to read
     * @param string $filePath
     * @return void
     */
    public function setFilePath(string $filePath): void;

    /**
     * Read the file and return the data as array
     * @return array
     */
    public function read(): array;

    /**
     * Read the file and return the data as Generated chunk
     * @param int $chunkSize
     * @return Generator<CsvChunk>
     */
    public function readAsChunk(int $chunkSize): Generator;
}
