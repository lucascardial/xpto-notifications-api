<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Modules\Contact\Enums\ContactFileImportStatusEnum;
use Tests\TestCase;

class ImportContactsTest extends TestCase
{
    use RefreshDatabase;

    public function test_import_csv_expect_success() {
        $this->post(route('v1.contacts.upload-csv'), [
            'attachment' => new UploadedFile(
                __DIR__ . '/../files/import.csv',
                'import.csv',
                'text/csv',
                null,
                true
            )
        ])->assertStatus(200);

        $this->assertDatabaseCount('contacts', 20);
        $this->assertDatabaseCount('contact_notifications', 20);
        $this->assertDatabaseHas('contact_file_imports', [
            'total_lines' => 20,
            'status' => ContactFileImportStatusEnum::COMPLETED
        ]);
    }
}
