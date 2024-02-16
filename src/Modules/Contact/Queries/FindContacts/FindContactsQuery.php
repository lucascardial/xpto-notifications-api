<?php

namespace Modules\Contact\Queries\FindContacts;

use Core\Interfaces\Cqrs\QueryInterface;

class FindContactsQuery implements QueryInterface
{
    public function __construct(
        public array $contacts,
    )
    {
    }
}
