<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid;
use App\Models\RagChunk;
use App\Support\Rag;

class RagIngest extends Command
{
    protected $signature = 'rag:ingest {--path=hr_docs} {--chunk=800} {--overlap=120}';
    protected $description = 'Ingest .txt knowledge files into rag_chunks with embeddings';

    public function handle(): int
    {
        $dir = $this->option('path');
        $chunkSize = (int)$this->option('chunk');
        $overlap = (int)$this->option('overlap');

        $this->info("Starting ingestion process...");
        
        // Use direct filesystem access instead of Storage facade
        $storagePath = storage_path('app/' . $dir);
        $this->info("Looking for files in: {$storagePath}");

        if (!file_exists($storagePath)) {
            $this->error("Directory does not exist: {$storagePath}");
            return 0;
        }

        // Get all files in the directory
        $allFiles = scandir($storagePath);
        $txtFiles = array_filter($allFiles, function($file) use ($storagePath) {
            $fullPath = $storagePath . '/' . $file;
            return is_file($fullPath) && pathinfo($file, PATHINFO_EXTENSION) === 'txt';
        });

        $this->info("Found " . count($txtFiles) . " text files");
        
        if (empty($txtFiles)) {
            $this->error("No .txt files found in: {$storagePath}");
            return 0;
        }

        foreach ($txtFiles as $file) {
            $filePath = $storagePath . '/' . $file;
            $this->info("Processing: {$filePath}");
            
            // Use direct file access
            $text = file_get_contents($filePath);
            
            if ($text === false) {
                $this->error("Failed to read file: {$filePath}");
                continue;
            }
            
            $text = trim($text);
            $this->info("File size: " . strlen($text) . " characters");
            
            if (empty($text)) {
                $this->error("File {$file} is empty!");
                continue;
            }
            
            $chunks = $this->chunk($text, $chunkSize, $overlap);
            $this->info("Split into " . count($chunks) . " chunks");
            
            // In the chunk processing loop, add:
$maxRetries = 5;
$baseDelay = 5; // seconds

$totalChunks = count($chunks);
$processed = 0;

foreach ($chunks as $i => $chunk) {
    $processed++;
    $percent = round(($processed / $totalChunks) * 100);
    $this->info("  [{$percent}%] Embedding chunk {$i}... ($processed/$totalChunks)");
    
    for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
        try {
            $emb = Rag::embed($chunk);
            
            RagChunk::create([
                'id' => Uuid::uuid4()->toString(),
                'source' => $file,
                'chunk_index' => $i,
                'content' => $chunk,
                'embedding_json' => json_encode($emb),
            ]);
            
            $this->info("  Ingested {$file} [chunk {$i}]");
            
            sleep(1); // small delay between chunks
            break; // success, exit retry loop
            
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), 'rate limit') !== false && $attempt < $maxRetries) {
                // Exponential backoff: wait longer each retry
                $delay = $baseDelay * pow(2, $attempt - 1); // 5, 10, 20, 40, 80 seconds
                $this->warn("Rate limited on chunk {$i}, attempt $attempt/$maxRetries. Retrying in $delay seconds...");
                sleep($delay);
            } else if (strpos($e->getMessage(), 'rate limit') !== false) {
                $this->error("Failed after $maxRetries attempts due to rate limiting: " . $e->getMessage());
                throw $e;
            } else {
                $this->error("Error embedding chunk {$i}: " . $e->getMessage());
                throw $e;
            }
        }
    }
}
        }
        
        $this->info('Done.');
        return 0;
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