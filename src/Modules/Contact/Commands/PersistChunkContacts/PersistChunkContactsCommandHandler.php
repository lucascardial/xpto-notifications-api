<?php

namespace Modules\Contact\Commands\PersistChunkContacts;

use Core\Interfaces\Cqrs\CommandHandlerInterface;
use Core\Interfaces\Cqrs\CommandInterface;
use Illuminate\Database\Connection;
use Modules\Contact\ConfigurationKeys;
use Modules\Contact\Helpers;
use Modules\Contact\Models\Contact;
use Modules\Contact\Queries\FindContacts\FindContactsQuery;
use Modules\Contact\Queries\FindContacts\FindContactsQueryHandler;
use function Ramsey\Uuid\v4;

class PersistChunkContactsCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly FindContactsQueryHandler $findContactsQueryHandler
    )
    {
    }

    /**
     * @param PersistChunkContactsCommand $command
     * @return void
     */
    public function handle(CommandInterface $command): void
    {
        // Get only the contacts values from the csv chunk
        $contacts = $command->csvChunk->only(ConfigurationKeys::CONTACT_COLUMN_NAME);

        // Check if the contacts already exist in the database
        $checkExistingContacts = $this
            ->findContactsQueryHandler
            ->handle(new FindContactsQuery($contacts));

        // Prepare the contacts payload
        $contactsPayload = [];

        // Loop through the csv chunk and prepare the contacts payload
        foreach ($command->csvChunk->getValuesWithColumns() as $contactRow) {
            $name = trim($contactRow[ConfigurationKeys::FULL_NAME_COLUMN_NAME]);
            $contact = trim($contactRow[ConfigurationKeys::CONTACT_COLUMN_NAME]);

            // Skip the row if the name or contact is empty or if the contact already exists
            if(empty($name) || empty($contact) || in_array($contact, $checkExistingContacts))
                continue;

            $contactsPayload[] = [
                'uuid' => v4(),
                'name' => $name,
                'contact' => $contact,
                'contact_type' => Helpers::checkContactType($contact)->value,
                'created_at' => now(),
            ];
        }

        Contact::query()->insert($contactsPayload);
    }
}
