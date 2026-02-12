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
        Schema::table('users', function (Blueprint $table) {
            $table->date('birthdate')->nullable()->after('password');       // ← added
            $table->string('gender')->nullable()->after('birthdate');        // ← added
            $table->string('profile_photo_path')->nullable()->after('gender'); // ← added
        });
    }

    /**
     * Reverse the migrations.
     */
     public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['birthdate', 'gender', 'profile_photo_path']);
        });
    }
};
