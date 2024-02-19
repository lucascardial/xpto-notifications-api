<?php

use App\Http\Controllers\Contacts\DeleteContactNotificationController;
use App\Http\Controllers\Contacts\EditContactNotificationController;
use App\Http\Controllers\Contacts\ListContactFileImportController;
use App\Http\Controllers\Contacts\ListContactNotificationController;
use App\Http\Controllers\Contacts\ShowContactNotificationController;
use App\Http\Controllers\Contacts\UploadCsvController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->name('v1.')->group(function () {
    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('notifications', ListContactNotificationController::class)->name('notifications');

        Route::get('notifications/{id}', ShowContactNotificationController::class)
            ->name('notifications.show');

        Route::put('notifications/{id}', EditContactNotificationController::class)
            ->name('notifications.update');

        Route::delete('notifications/{id}', DeleteContactNotificationController::class)
            ->name('notifications.delete');

        Route::post('upload-csv', UploadCsvController::class)->name('upload-csv');

        Route::get('imports', ListContactFileImportController::class)->name('imports');
    });
});
