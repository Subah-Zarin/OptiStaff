<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('leaves', function (Blueprint $table) {
            $table->enum('duration', ['Full', 'Half'])->default('Full')->after('leave_type');
            $table->enum('half_day_type', ['AM', 'PM'])->nullable()->after('duration');
            $table->decimal('number_of_days', 3, 1)->change();
        });
    }

    public function down(): void {
        Schema::table('leaves', function (Blueprint $table) {
            $table->dropColumn(['duration', 'half_day_type']);
        });
    }
};
