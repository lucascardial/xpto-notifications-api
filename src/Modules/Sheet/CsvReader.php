<?php

namespace Modules\Sheet;

use Core\Interfaces\File\CsvReaderInterface;
use Exception;
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

        if (!$file) {
            throw new Exception("Erro ao ler arquivo.");
        }

        $columns = fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            $chunk[] = $row;
            if (sizeof($chunk) === $chunkSize) {
                yield new CsvChunk($columns, $chunk);
                $chunk = [];
            }
        }

        if (!empty($chunk)) {
            yield new CsvChunk($columns, $chunk);
        }

        fclose($file);
    }

    public function hasRequiredColumns(array $requiredHeaders): bool
    {
        $file = fopen($this->filePath, 'r');

        if (!$file) {
            throw new Exception("Erro ao ler arquivo.");
        }

        $headers = fgetcsv($file);

        fclose($file);

        return empty(array_diff($requiredHeaders, $headers));
    }
}
