<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Contact\Enums\ContactNotificationStatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contact_notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('contact');
            $table->text('content');
            $table->timestamp('schedule_time');
            $table->string('channel');
            $table->string('status')->default(ContactNotificationStatusEnum::PENDING);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_notifications');
    }
};
