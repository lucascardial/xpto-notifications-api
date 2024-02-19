<?php

namespace Modules\Contact\Queries\ListContactFileImport;

use Illuminate\Database\Eloquent\Collection;
use Modules\Contact\Models\ContactFileImport;

class ListContactFileImportQueryHandler
{
    public function handle(): Collection
    {
        return ContactFileImport::query()
            ->get()
            ->transform(fn(ContactFileImport $contactFileImport ) => [
                'id' => $contactFileImport->uuid,
                'name' => $contactFileImport->file_name,
                'status' => $contactFileImport->status->getLabel(),
                'date' => $contactFileImport->created_at,
                'total_lines' => $contactFileImport->total_lines,
            ]);
    }
}
