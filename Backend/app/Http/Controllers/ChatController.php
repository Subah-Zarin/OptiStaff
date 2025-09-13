<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use OpenAI;
use App\Support\Rag;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function ask(Request $request)
    {
        $client = OpenAI::client(env('OPENAI_API_KEY'));
        $userQuery = trim($request->input('query'));
        if ($userQuery === '') return back();

        // 1) Retrieve grounding context from RAG index
        $top = Rag::retrieve($userQuery, 6);
        $context = collect($top)->map(fn($c) => "[{$c['source']}#{$c['score']}]\n{$c['content']}")->implode("\n\n---\n\n");

        // 2) Ask model to produce STRICT JSON with SQL (read-only)
        $system = <<<SYS
You are an enterprise HR analytics assistant for the OptiStaff system. Use the supplied CONTEXT and the database schema conventions to write a single, safe MySQL SELECT query that answers the user's question. Never modify data. Only use known tables/columns. If unknown, ask for clarification instead of guessing.
Output strictly in JSON: {"sql": string, "notes": string}. No code fences.

Important database specifics:
- Table names: users, attendances, leaves
- Time format: Use 'HH:MM:SS' for time comparisons
- Date format: Use 'YYYY-MM-DD' for date comparisons
- Late definition: check_in > '09:30:00'
SYS;

        $user = <<<USR
QUESTION: {$userQuery}

CONTEXT:
{$context}

Constraints:
- Only SELECT; no INSERT/UPDATE/DELETE/ALTER/DROP.
- Use table names and columns exactly as in context.
- "Late" means check_in > '09:30:00' unless policy overrides.
- Prefer parameterized literals for dates (YYYY-MM-DD).
- Use table aliases for better readability.
USR;

        $resp = $client->chat()->create([
            'model' => env('OPENAI_CHAT_MODEL', 'gpt-4o-mini'),
            'response_format' => ['type' => 'json_object'],
            'messages' => [
                ['role' => 'system', 'content' => $system],
                ['role' => 'user', 'content' => $user],
            ],
            'temperature' => 0.1,
        ]);

        $payload = json_decode($resp->choices[0]->message->content, true);
        $sql = $payload['sql'] ?? '';
        $notes = $payload['notes'] ?? '';

        // 3) Safety checks
        $upper = Str::upper($sql);
        if (preg_match('/\\b(INSERT|UPDATE|DELETE|ALTER|DROP|TRUNCATE|CREATE|EXEC|DECLARE|GRANT|REVOKE)\\b/', $upper)) {
            return view('chat', [
                'query' => $userQuery,
                'sql' => $sql,
                'error' => 'Blocked potentially unsafe SQL. Ask a read-only question.',
                'context' => $top,
                'notes' => $notes,
            ]);
        }

        // 4) Execute and render
        try {
            $rows = DB::select($sql);
            return view('chat', [
                'query' => $userQuery,
                'sql' => $sql,
                'results' => $rows,
                'context' => $top,
                'notes' => $notes,
            ]);
        } catch (\Throwable $e) {
            return view('chat', [
                'query' => $userQuery,
                'sql' => $sql,
                'error' => $e->getMessage(),
                'context' => $top,
                'notes' => $notes,
            ]);
        }
    }
}