<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Contact\Commands\ReadContactsFromCsv\ReadContactsFromCsvCommand;
use Modules\Contact\Commands\ReadContactsFromCsv\ReadContactsFromCsvCommandHandler;
use Modules\Contact\ConfigurationKeys;
use PHPUnit\Framework\MockObject\Exception;
use Illuminate\Config\Repository as Configuration;
use Tests\TestCase;

class ImportContactsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws Exception
     */
    public function testImportContacts(): void
    {
        $filePath = __DIR__ . '/../files/import.csv';
        $dispatcherStub = $this->createMock(\Illuminate\Bus\Dispatcher::class);
        $configurationsStub = $this->createMock(Configuration::class);

        $configurationsStub
            ->expects($this->exactly(1))
            ->method('get')
            ->with(ConfigurationKeys::CHUNK_SIZE)
            ->willReturn(5);


        $dispatcherStub
            ->expects($this->exactly(3))
            ->method('dispatch')
            ->with($this->isInstanceOf(\Modules\Contact\Jobs\PersistContactFromCsvChunkJob::class));

        $command = new ReadContactsFromCsvCommand($filePath);

        /** @var ReadContactsFromCsvCommandHandler  $handler */
        $handler = app(ReadContactsFromCsvCommandHandler::class, [
            'dispatcher' => $dispatcherStub,
            'config' => $configurationsStub
        ]);

        $handler->handle($command);

    }


    public function testImportContacts2(): void
    {
        $filePath = __DIR__ . '/../files/import.csv';

        $command = new ReadContactsFromCsvCommand($filePath);

        /** @var ReadContactsFromCsvCommandHandler  $handler */
        $handler = app(ReadContactsFromCsvCommandHandler::class);

        $handler->handle($command);

        $this->assertDatabaseCount('contacts', 20);
        $this->assertDatabaseCount('contact_notifications', 20);
    }
}
