<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ✅ Create rag_chunks if not exists
        if (!Schema::hasTable('rag_chunks')) {
            Schema::create('rag_chunks', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('source'); // file path or logical source
                $table->unsignedInteger('chunk_index');
                $table->text('content');
                $table->longText('embedding_json'); // JSON array of floats
                $table->timestamps();
                $table->index(['source']);
            });
        }

        // ✅ Create analytics_snapshots if not exists
        if (!Schema::hasTable('analytics_snapshots')) {
            Schema::create('analytics_snapshots', function (Blueprint $table) {
                $table->id();
                $table->string('metric'); // e.g., late_by_day_2025_08
                $table->date('as_of');
                $table->json('payload'); // arbitrary JSON summary
                $table->timestamps();
                $table->index(['metric','as_of']);
            });
        }
    }

    public function down(): void
    {
        // ✅ Drop only if they exist
        if (Schema::hasTable('analytics_snapshots')) {
            Schema::drop('analytics_snapshots');
        }

        if (Schema::hasTable('rag_chunks')) {
            Schema::drop('rag_chunks');
        }
    }
};
