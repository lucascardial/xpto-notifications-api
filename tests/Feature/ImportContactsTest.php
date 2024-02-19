<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Modules\Contact\Enums\ContactFileImportStatusEnum;
use Modules\Contact\Models\ContactNotification;
use Tests\TestCase;

class ImportContactsTest extends TestCase
{
    use RefreshDatabase;

    public function test_import_csv_expect_success() {
        $this->postJson(route('v1.contacts.upload-csv'), [
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

    public function test_import_csv_invalid_file_expect_failure() {
       $response =  $this->postJson(route('v1.contacts.upload-csv'), [
            'attachment' => new UploadedFile(
                __DIR__ . '/../files/invalid.csv',
                'invalid.csv',
                'text/csv',
                null,
                true
            )
        ]);

        $response->assertStatus(422);
    }

    public function test_list_contacts_file_import_without_data()
    {
        $this->get(route('v1.contacts.imports'))
            ->assertStatus(200)
            ->assertJsonCount(0);
    }

    public function test_list_contacts_file_import_with_data()
    {
        $this->test_import_csv_expect_success();

        $this->get(route('v1.contacts.imports'))
            ->assertStatus(200)
            ->assertJsonCount(1);
    }

    public function test_list_contact_notifications_without_data()
    {
        $this->get(route('v1.contacts.notifications'))
            ->assertStatus(200)
            ->assertJson([
                "total" => 0
            ]);
    }

    public function test_list_contact_notifications_with_data()
    {
        $this->test_import_csv_expect_success();

        $this->get(route('v1.contacts.notifications'))
            ->assertStatus(200)
            ->assertJson([
                "total" => 20
            ]);

    }

    public function test_show_contact_notification()
    {
        $this->test_import_csv_expect_success();
        $id = ContactNotification::query()->first()->uuid;

        $response = $this->get(route('v1.contacts.notifications.show', ['id' => $id]));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'contact',
            'content',
        ]);
    }

    public function test_update_contact_notification()
    {
        $this->test_import_csv_expect_success();
        $id = ContactNotification::query()->first()->uuid;

        $response = $this->putJson(route('v1.contacts.notifications.update', ['id' => $id]), [
            'contact' => 'new contact',
            'content' => 'Hello, new contact',
            'schedule_date' => '2021-01-01 00:00:00'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('contact_notifications', [
            'contact' => 'new contact',
        ]);
    }

    public function test_delete_contact_notification()
    {
        $this->test_import_csv_expect_success();
        $id = ContactNotification::query()->first()->uuid;

        $response = $this->delete(route('v1.contacts.notifications.delete', ['id' => $id]));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('contact_notifications', [
            'uuid' => $id
        ]);
    }
}
