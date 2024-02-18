<?php

namespace App\Http\Controllers\Contacts;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Contact\Queries\ListContactFileImport\ListContactFileImportQueryHandler;

class ListContactFileImportController extends Controller
{
    public function __construct(
        private readonly ListContactFileImportQueryHandler $queryHandler
    )
    {
    }

    public function __invoke(): JsonResponse
    {
        return response()->json($this->queryHandler->handle());
    }
}
