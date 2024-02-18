<?php

namespace Core\Storage;

use Illuminate\Support\Facades\Storage;

final class StorageUtility
{
    /**
     * This method is used to get the local file path of a file from a given disk
     *
     * @param string $filePath
     * @param string $disk
     * @return string
     */
    public static function getLocalFilePath(string $filePath, string $disk): string
    {
        if($disk === 'local') {
            return storage_path('app/' . $filePath);
        }

        $fileName = basename($filePath);
        $localPath = 'downloads/' . $fileName;
        Storage::disk('local')->put($localPath, Storage::disk($disk)->get($filePath));

        return storage_path('app/' . $localPath);
    }
}
