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
        Schema::table('infrastructure_objects', function (Blueprint $table) {
            if (Schema::hasColumn('infrastructure_objects', 'district_id')) {
                $table->dropForeign(['district_id']);
                $table->dropColumn('district_id');
            }
        });

        Schema::table('user_requests', function (Blueprint $table) {
            if (Schema::hasColumn('user_requests', 'district_id')) {
                $table->dropForeign(['district_id']);
                $table->dropColumn('district_id');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'district_id')) {
                $table->dropForeign(['district_id']);
                $table->dropColumn('district_id');
            }
        });

        Schema::dropIfExists('districts');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('district_id')->nullable()->constrained()->onDelete('set null')->after('city_id');
        });

        Schema::table('user_requests', function (Blueprint $table) {
            $table->foreignId('district_id')->nullable()->constrained()->onDelete('set null')->after('city_id');
        });

        Schema::table('infrastructure_objects', function (Blueprint $table) {
            $table->foreignId('district_id')->nullable()->constrained()->onDelete('set null')->after('city_id');
        });
    }
};
