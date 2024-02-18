<?php

namespace Modules\Contact\Queries\FindContacts;

use Core\Interfaces\Cqrs\QueryHandlerInterface;
use Core\Interfaces\Cqrs\QueryInterface;
use Illuminate\Database\Connection;
use Modules\Contact\Models\Contact;

class FindContactsQueryHandler implements QueryHandlerInterface
{
    /**
     * @param FindContactsQuery $query
     * @return array
     */
    public function handle(QueryInterface $query): array
    {
        return Contact::query()
            ->selectRaw('DISTINCT contact')
            ->whereIn('contact', $query->contacts)
            ->get()
            ->pluck('contact')
            ->toArray();
    }
}
