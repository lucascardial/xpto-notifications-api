<?php

namespace App\Http\Controllers\Contacts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contacts\UploadCsvRequest;
use Core\Interfaces\File\CsvReaderInterface;
use Illuminate\Http\JsonResponse;
use Modules\Contact\ConfigurationKeys;
use Modules\Contact\Errors\InvalidCsvTemplateError;
use Modules\Contact\Jobs\ReadContactsFromCsvJob;

class UploadCsvController extends Controller
{
    public function __construct(
        private readonly CsvReaderInterface $csvReader
    )
    {
    }

    /**
     * @throws InvalidCsvTemplateError
     */
    public function __invoke(UploadCsvRequest $request): JsonResponse
    {
        $file = $request->file('attachment');

        $this->csvReader->setFilePath($file);

        $hasRequiredColumns = $this->csvReader->hasRequiredColumns([
            ConfigurationKeys::CONTACT_COLUMN_NAME,
            ConfigurationKeys::FULL_NAME_COLUMN_NAME,
        ]);

        if (!$hasRequiredColumns) {
            throw new InvalidCsvTemplateError();
        }

        $disk = 'local';

        $fileNameWithExt = $file->getClientOriginalName();
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileNameToStore = $fileName.'_'.time().'.'.$extension;

        $path = $file->storeAs('csv', $fileNameToStore, ['disk' => 'local']);

        ReadContactsFromCsvJob::dispatch($path, $disk);

        return response()->json(['message' => 'File uploaded successfully']);
    }
}
