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
        Schema::table('attendances', function (Blueprint $table) {
            // Change the 'status' column to a string to allow capitalized values
            $table->string('status')->change();

            // Add the 'notes' column if it doesn't already exist
            if (!Schema::hasColumn('attendances', 'notes')) {
                $table->text('notes')->nullable()->after('check_out');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // This defines how to undo the changes
            $table->enum('status', ['present', 'absent', 'late', 'half_day', 'leave'])->default('present')->change();
            $table->dropColumn('notes');
        });
    }
};