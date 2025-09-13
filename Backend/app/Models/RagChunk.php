<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RagChunk extends Model
{
    use HasUuids;

    protected $table = 'rag_chunks';
    protected $fillable = ['source','chunk_index','content','embedding_json'];
    protected $keyType = 'string';
    public $incrementing = false; 

    public function getEmbeddingAttribute(): array
    {
        return json_decode($this->embedding_json, true) ?? [];
    }
}