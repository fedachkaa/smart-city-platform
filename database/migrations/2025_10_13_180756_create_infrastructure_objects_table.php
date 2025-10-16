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
        Schema::create('infrastructure_objects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['Lighting', 'TrashBin', 'Parking', 'Sensor', 'Road'])->default('Lighting');
            $table->enum('status', ['Active', 'Maintenance', 'Inactive', 'Error'])->default('Active');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->text('description')->nullable();
            $table->string('district')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infrastructure_objects');
    }
};