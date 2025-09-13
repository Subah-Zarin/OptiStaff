<?php

namespace App\Support;

use App\Models\RagChunk;
use Exception;

class Rag
{
    public static function embed(string $text): array
    {
        // Use local embeddings instead of OpenAI to avoid rate limits
        return LocalEmbedder::embed($text);
    }

    public static function cosine(array $a, array $b): float
    {
        return LocalEmbedder::cosineSimilarity($a, $b);
    }

    /** Retrieve top-k relevant chunks for a query */
    public static function retrieve(string $query, int $k = 6): array
    {
        $q = self::embed($query);
        $scored = RagChunk::query()->get()->map(function($c) use ($q) {
            $score = self::cosine($q, json_decode($c->embedding_json, true));
            return [
                'id' => $c->id,
                'source' => $c->source,
                'content' => $c->content,
                'score' => $score,
            ];
        })->sortByDesc('score')->take($k)->values()->all();

        return $scored;
    }
}