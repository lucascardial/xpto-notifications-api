<?php

namespace Modules\Contact\Commands\PersistChunkContacts;

use Core\Interfaces\Cqrs\CommandHandlerInterface;
use Core\Interfaces\Cqrs\CommandInterface;
use Illuminate\Database\Connection;
use Modules\Contact\ConfigurationKeys;
use Modules\Contact\Helpers;
use Modules\Contact\Queries\FindContacts\FindContactsQuery;
use Modules\Contact\Queries\FindContacts\FindContactsQueryHandler;
use function Ramsey\Uuid\v4;

class PersistChunkContactsCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly FindContactsQueryHandler $findContactsQueryHandler,
        private readonly Connection $dbConnection
    )
    {
    }

    /**
     * @param PersistChunkContactsCommand $command
     * @return void
     */
    public function handle(CommandInterface $command): void
    {
        $contacts = $command->csvChunk->only(ConfigurationKeys::CONTACT_COLUMN_NAME);

        $checkExistingContacts = $this
            ->findContactsQueryHandler
            ->handle(new FindContactsQuery($contacts));

        $filteredContacts = $command
            ->csvChunk
            ->except(ConfigurationKeys::CONTACT_COLUMN_NAME, $checkExistingContacts);

        $contactsData = [];

        foreach ($filteredContacts as $contactRow) {
            $name = trim($contactRow[ConfigurationKeys::FULL_NAME_COLUMN_NAME]);
            $contact = trim($contactRow[ConfigurationKeys::CONTACT_COLUMN_NAME]);

            if (empty($name) || empty($contact)) {
                continue;
            }

            $contactsData[] = [
                'id' => v4(),
                'name' => $name,
                'contact' => $contact,
                'contact_type' => Helpers::checkContactType($contact)->value,
            ];
        }

        $this->dbConnection->table('contacts')->insert($contactsData);
    }
}
