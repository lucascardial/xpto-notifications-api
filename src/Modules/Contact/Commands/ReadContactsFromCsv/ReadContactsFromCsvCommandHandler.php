<?php

namespace Modules\Contact\Commands\ReadContactsFromCsv;

use Core\Interfaces\Cqrs\CommandHandlerInterface;
use Core\Interfaces\Cqrs\CommandInterface;
use Core\Interfaces\File\CsvReaderInterface;
use Core\Storage\StorageUtility;
use Exception;
use Illuminate\Bus\Dispatcher;
use Illuminate\Config\Repository as Configuration;
use Modules\Contact\ConfigurationKeys;
use Modules\Contact\Enums\ContactFileImportStatusEnum;
use Modules\Contact\Errors\InvalidCsvTemplateError;
use Modules\Contact\Jobs\NotifyContactsFromCsvChunkJob;
use Modules\Contact\Jobs\PersistContactFromCsvChunkJob;
use Modules\Contact\Models\ContactFileImport;
use function Ramsey\Uuid\v4;

class ReadContactsFromCsvCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CsvReaderInterface $csvReader,
        private readonly Dispatcher $dispatcher,
        private readonly Configuration $config
    )
    {
    }

    /**
     * This method handles the command to read the contacts from a csv file
     * and dispatch the jobs to persist and notify the contacts.
     *
     * @param ReadContactsFromCsvCommand $command
     * @return void
     * @throws InvalidCsvTemplateError
     */
    public function handle(CommandInterface $command): void
    {
        $filePath = StorageUtility::getLocalFilePath($command->filePath, $command->disk);

        // get the chunk size from the configuration
        $csvChunkSize = $this->config->get(ConfigurationKeys::CHUNK_SIZE) ?? 1000;
        // set the file path to the csv reader
        $this->csvReader->setFilePath($filePath);

        $hasRequiredHeaders = $this->csvReader->hasRequiredColumns([
            ConfigurationKeys::FULL_NAME_COLUMN_NAME,
            ConfigurationKeys::CONTACT_COLUMN_NAME
        ]);

        if (!$hasRequiredHeaders) {
            throw new InvalidCsvTemplateError();
        }

        $contactFileImport = ContactFileImport::query()->create([
            'uuid' => v4(),
            'file_name' =>  pathinfo($command->filePath, PATHINFO_FILENAME),
            'status' => ContactFileImportStatusEnum::PROCESSING
        ]);

        // read the csv file as a chunk
        $csvChunk = $this->csvReader->readAsChunk($csvChunkSize);

        $totalLines = 0;

        // dispatch the jobs to persist and notify the contacts
        foreach ($csvChunk as $chunk) {
            $totalLines += count($chunk->rows);
            $this->dispatcher->dispatch(new PersistContactFromCsvChunkJob($chunk));
            $this->dispatcher->dispatch(new NotifyContactsFromCsvChunkJob($chunk));
        }

        $contactFileImport->update([
            'total_lines' => $totalLines,
            'status' => ContactFileImportStatusEnum::COMPLETED
        ]);
    }
}
