<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;
use App\Models\RagChunk;
use App\Support\Rag;

class RagSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ensure HR docs folder exists
        $dir = 'hr_docs';
        if (!Storage::exists($dir)) {
            $this->command->warn("⚠️ storage/app/{$dir} does not exist. Create it and add schema.txt, policies.txt, etc.");
            return;
        }

        $files = Storage::files($dir);
        if (empty($files)) {
            $this->command->warn("⚠️ No files found in storage/app/{$dir}");
            return;
        }

        foreach ($files as $file) {
            if (!str_ends_with($file, '.txt')) continue;

            $text = Storage::get($file);
            $chunks = $this->chunk($text, 800, 120);

            foreach ($chunks as $i => $chunk) {
                $emb = Rag::embed($chunk);

                RagChunk::updateOrCreate(
                    [
                        'source' => $file,
                        'chunk_index' => $i,
                    ],
                    [
                        'id' => Uuid::uuid4()->toString(),
                        'content' => $chunk,
                        'embedding_json' => json_encode($emb),
                    ]
                );
            }

            $this->command->info("✅ Ingested {$file}");
        }
    }

    private function chunk(string $text, int $size, int $overlap): array
    {
        $text = preg_replace('/\s+/', ' ', trim($text));
        $out = [];
        $start = 0;
        $n = strlen($text);

        while ($start < $n) {
            $end = min($n, $start + $size);
            $slice = substr($text, $start, $end - $start);
            $out[] = $slice;
            if ($end === $n) break;
            $start = $end - $overlap;
            if ($start < 0) $start = 0;
        }

        return $out;
    }
}
