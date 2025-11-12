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
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->json('route');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->time('start_time')->nullable();
            $table->timestamps();
        });

        Schema::create('route_infrastructure_objects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained('routes')->onDelete('cascade');
            $table->foreignId('infrastructure_object_id')->constrained('infrastructure_objects')->onDelete('cascade');
            $table->integer('order')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_infrastructure_objects');
        Schema::dropIfExists('routes');
    }
};