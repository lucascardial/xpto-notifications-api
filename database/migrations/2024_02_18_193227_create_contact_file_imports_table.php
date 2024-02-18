<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contact_file_imports', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('file_name');
            $table->unsignedBigInteger('total_lines')->default(0);
            $table->string('status');
            $table->string('error_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_file_imports');
    }
};
