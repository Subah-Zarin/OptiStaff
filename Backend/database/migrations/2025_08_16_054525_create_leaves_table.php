<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // employee applying
            $table->string('leave_type');
            $table->enum('duration', ['Full', 'Half'])->default('Full'); // Full Day or Half Day
            $table->enum('half_day_type', ['AM', 'PM'])->nullable(); // Only for Half Day
            $table->date('from_date');
            $table->date('to_date');
            $table->decimal('number_of_days', 3, 1); // e.g., 0.5 for half day
            $table->string('status')->default('Pending'); // Pending, Approved, Rejected
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('leaves');
    }
};
