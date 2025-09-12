<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            // Only add 'duration' if it doesn't exist
            if (!Schema::hasColumn('leaves', 'duration')) {
                $table->enum('duration', ['Full', 'Half'])
                      ->default('Full')
                      ->after('leave_type');
            }

            // Only add 'half_day_type' if it doesn't exist
            if (!Schema::hasColumn('leaves', 'half_day_type')) {
                $table->enum('half_day_type', ['AM', 'PM'])
                      ->nullable()
                      ->after('duration');
            }

            // Modify number_of_days if it exists
            if (Schema::hasColumn('leaves', 'number_of_days')) {
                $table->decimal('number_of_days', 3, 1)->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            if (Schema::hasColumn('leaves', 'duration')) {
                $table->dropColumn('duration');
            }
            if (Schema::hasColumn('leaves', 'half_day_type')) {
                $table->dropColumn('half_day_type');
            }
            if (Schema::hasColumn('leaves', 'number_of_days')) {
                $table->decimal('number_of_days', 8, 2)->change(); // restore default
            }
        });
    }
};

