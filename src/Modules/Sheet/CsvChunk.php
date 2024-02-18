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

    /**
     * This method returns the values of a specific column.
     * @param string $column
     * @return array
     */
    public function only(string $column): array
    {
        $index = array_search($column, $this->columns);
        if ($index === false) {
            return [];
        }

        $result = [];

        foreach ($this->rows as $row) {
            $result[] = $row[$index];
        }

        return $result;
    }

    /**
     * This method returns the values of the rows combined the columns as keys.
     * @return array
     */
    public function getValuesWithColumns(): array
    {
        $result = [];
        foreach ($this->rows as $row) {
            $result[] = array_combine($this->columns, $row);
        }
        return $result;
    }
}
