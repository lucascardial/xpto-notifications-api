<?php

namespace Modules\Contact\Queries\FindContacts;

use Core\Interfaces\Cqrs\QueryHandlerInterface;
use Core\Interfaces\Cqrs\QueryInterface;
use Illuminate\Database\Connection;

class FindContactsQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly Connection $connection
    )
    {
    }

    /**
     * @param FindContactsQuery $query
     * @return array
     */
    public function handle(QueryInterface $query): array
    {
        return $this->connection->table('contacts')
            ->selectRaw('DISTINCT contact')
            ->whereIn('contact', $query->contacts)
            ->get()
            ->pluck('contact')
            ->toArray();
    }
}
