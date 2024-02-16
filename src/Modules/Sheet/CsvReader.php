<?php

namespace Modules\Sheet;

use Core\Interfaces\CsvReaderInterface;
use Generator;

class CsvReader implements CsvReaderInterface
{
    private string $filePath;

    public function __construct(
        public readonly int $chunkSize = 500
    )
    {
    }

    public function setFilePath(string $filePath): void
    {
        $this->filePath = $filePath;
    }

    public function read(): array
    {
        $file = fopen($this->filePath, 'r');

        $data = [];

        while (($row = fgetcsv($file)) !== false) {
            $data[] = $row;
        }

        fclose($file);

        return $data;
    }

    public function readAsChunk(int $chunkSize): Generator
    {
        $file = fopen($this->filePath, 'r');

        $columns = fgetcsv($file);

        $chunk = [];

        while (($row = fgetcsv($file))) {
            $chunk[] = $row;
            if(count($chunk) === $chunkSize) {
                yield new CsvChunk($columns, $chunk);
                $chunk = [];
            }
        }

        fclose($file);
    }
}
