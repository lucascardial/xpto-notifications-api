<?php

namespace Modules\Contact\Commands\ReadContactsFromCsv;

use Core\Interfaces\Cqrs\CommandHandlerInterface;
use Core\Interfaces\Cqrs\CommandInterface;
use Core\Interfaces\File\CsvReaderInterface;
use Illuminate\Bus\Dispatcher;
use Illuminate\Config\Repository as Configuration;
use Modules\Contact\ConfigurationKeys;
use Modules\Contact\Jobs\NotifyContactsFromCsvChunkJob;
use Modules\Contact\Jobs\PersistContactFromCsvChunkJob;

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
     * @param ReadContactsFromCsvCommand $command
     * @return void
     */
    public function handle(CommandInterface $command): void
    {
        $csvChunkSize = $this->config->get(ConfigurationKeys::CHUNK_SIZE) ?? 1000;
        $this->csvReader->setFilePath($command->filePath);
        $csvChunk = $this->csvReader->readAsChunk($csvChunkSize);

        foreach ($csvChunk as $chunk) {
            $this->dispatcher->dispatch(new PersistContactFromCsvChunkJob($chunk));
            $this->dispatcher->dispatch(new NotifyContactsFromCsvChunkJob($chunk));
        }
    }
}
