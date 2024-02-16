<?php

namespace Tests\Unit;

use Tests\TestCase;

class CsvReaderTest extends TestCase
{
    public function test_it_can_read_csv_file()
    {
        $csvReader = new \Modules\Sheet\CsvReader();
        $csvReader->setFilePath(__DIR__ . '/../files/import.csv');
        $data = $csvReader->read();
        $this->assertIsArray($data);
    }

    public function test_it_can_read_csv_file_as_chunk()
    {
        $csvReader = new \Modules\Sheet\CsvReader();
        $csvReader->setFilePath(__DIR__ . '/../files/RandomData.csv');
        $data = $csvReader->readAsChunk(1000);

        $counter = 0;
        $this->assertInstanceOf(\Generator::class, $data);

        foreach ($data as $chunk) {
            $this->assertInstanceOf(\Modules\Sheet\CsvChunk::class, $chunk);
            $counter++;
        }

        $this->assertEquals(10, $counter);
        $this->assertFalse($data->valid());
    }
}
