<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadLocalFileController extends Controller
{
    public function __invoke(Request $request, string $filePath): BinaryFileResponse
    {
        $path = storage_path('app/public/' . $filePath);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path);
    }
}
