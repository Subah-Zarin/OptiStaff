<?php

namespace App\Support;

class LocalEmbedder
{
    public static function embed(string $text): array
    {
        // Create a simple 256-dimension embedding (good enough for demo)
        $embedding = array_fill(0, 256, 0.0);
        
        // Clean and normalize text
        $text = strtolower(trim($text));
        $words = preg_split('/\s+/', $text);
        
        foreach ($words as $word) {
            // Remove punctuation
            $word = preg_replace('/[^\w]/', '', $word);
            if (empty($word)) continue;
            
            // Create a deterministic hash-based position and value
            $hash = crc32($word);
            $position = abs($hash) % 256;
            $value = (($hash % 1000) / 1000.0) - 0.5; // Value between -0.5 and 0.5
            
            $embedding[$position] += $value;
        }
        
        // Normalize the embedding vector
        $magnitude = sqrt(array_sum(array_map(function($x) { return $x * $x; }, $embedding)));
        if ($magnitude > 0) {
            $embedding = array_map(function($x) use ($magnitude) { 
                return $x / $magnitude; 
            }, $embedding);
        }
        
        return $embedding;
    }
    
    public static function cosineSimilarity(array $vecA, array $vecB): float
    {
        $dot = 0.0;
        $normA = 0.0;
        $normB = 0.0;
        
        for ($i = 0; $i < min(count($vecA), count($vecB)); $i++) {
            $dot += $vecA[$i] * $vecB[$i];
            $normA += $vecA[$i] * $vecA[$i];
            $normB += $vecB[$i] * $vecB[$i];
        }
        
        if ($normA == 0 || $normB == 0) {
            return 0.0;
        }
        
        return $dot / (sqrt($normA) * sqrt($normB));
    }
}