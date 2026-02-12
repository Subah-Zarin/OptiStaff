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
    Schema::create('payments', function (Blueprint $table) {
    $table->id();
    $table->unique(['user_id', 'month']);
$table->foreignId('user_id')->constrained()->onDelete('cascade');
$table->string('month'); // format: Y-m
$table->integer('basic_salary');
$table->integer('absent_days');
$table->integer('deduction');
$table->integer('final_salary');
$table->string('status')->default('pending');
$table->timestamp('paid_at')->nullable();
$table->timestamps();

    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
