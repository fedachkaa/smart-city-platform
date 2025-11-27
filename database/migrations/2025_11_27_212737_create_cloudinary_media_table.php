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
        Schema::create('cloudinary_media', function (Blueprint $table) {
            $table->id();
            $table->string('public_id')->unique();
            $table->string('secure_url', 512);
            $table->string('asset_id')->nullable();
            $table->string('resource_type')->default('image');
            $table->string('file_type', 10)->nullable();
            $table->foreignId('user_request_id')->constrained('user_requests')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cloudinary_media');
    }
};
