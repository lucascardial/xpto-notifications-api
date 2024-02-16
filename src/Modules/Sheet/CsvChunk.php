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
     * @param string $column
     * @param array $values
     * @return array[]
     */
    public function except(string $column, array $values): array
    {
        $index = array_search($column, $this->columns);
        if ($index === false) {
            return [];
        }

        $result = [];

        foreach ($this->rows as $row) {
            if (!in_array($row[$index], $values)) {
                $result[] = array_combine($this->columns, $row);
            }
        }

        return $result;
    }
}
