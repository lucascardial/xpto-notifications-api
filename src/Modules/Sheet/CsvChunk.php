<?php

namespace Modules\Sheet;

class CsvChunk
{
    public function __construct(
        public readonly array $columns,
        public readonly array $rows
    )
    {
    }
}
