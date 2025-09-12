<?php
namespace App\Support;

use OpenAI;
use App\Models\RagChunk;
use Exception;

class Rag
{
    public static function embed(string $text): array
{
    $apiKey = env('OPENAI_API_KEY');
    
    if (empty($apiKey)) {
        throw new Exception('OPENAI_API_KEY is not set in .env file');
    }
    
    $maxRetries = 3;
    $baseDelay = 2;
    
    for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
        try {
            $client = OpenAI::client($apiKey);
            $resp = $client->embeddings()->create([
                'model' => env('OPENAI_EMBED_MODEL', 'text-embedding-3-small'),
                'input' => $text,
            ]);
            
            return $resp->embeddings[0]->embedding;
            
        } catch (Exception $e) {
            // If rate limited and we have retries left
            if (strpos($e->getMessage(), 'rate limit') !== false && $attempt < $maxRetries) {
                $delay = $baseDelay * pow(2, $attempt - 1); // Exponential backoff
                sleep($delay);
                continue; // Try again
            }
            
            // For other errors or final failure
            throw new Exception('OpenAI API error: ' . $e->getMessage());
        }
    }
}
    public static function cosine(array $a, array $b): float
    {
        $dot = 0.0; 
        $na = 0.0; 
        $nb = 0.0; 
        $n = min(count($a), count($b));
        
        for ($i=0; $i<$n; $i++) { 
            $dot += $a[$i]*$b[$i]; 
            $na += $a[$i]*$a[$i]; 
            $nb += $b[$i]*$b[$i]; 
        }
        
        if ($na==0 || $nb==0) return 0.0; 
        return $dot / (sqrt($na)*sqrt($nb));
    }

    /** Retrieve top-k relevant chunks for a query */
    public static function retrieve(string $query, int $k=6): array
    {
        try {
            $q = self::embed($query);
            $scored = RagChunk::query()->get()->map(function($c) use ($q){
                $score = self::cosine($q, $c->embedding);
                return [
                    'id' => $c->id,
                    'source' => $c->source,
                    'content' => $c->content,
                    'score' => $score,
                ];
            })->sortByDesc('score')->take($k)->values()->all();

            return $scored;
        } catch (Exception $e) {
            // Fallback: return empty array if embedding fails
            return [];
        }
    }
}