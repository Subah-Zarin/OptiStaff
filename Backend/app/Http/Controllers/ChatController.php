<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function ask(Request $request)
    {
        $request->validate([
            'query' => 'required|string'
        ]);

        $userQuery = $request->input('query');

        // 1. Database Schema for data questions
        $schema = "
        Table 'users': id, name, email, role (admin/user), created_at
        Table 'attendances': id, user_id, date, status (Present/Absent/Leave), check_in, check_out
        Table 'leaves': id, user_id, leave_type (Casual/Sick/Earned), duration, from_date, to_date, number_of_days, status (Pending/Approved/Rejected)
        Table 'holidays': id, name, date
        ";

        // 2. Hybrid Prompt: Telling Gemini to output strict JSON
        $systemPrompt = "You are the OptiStaff 24/7 Virtual HR Assistant. 
        You must respond to every request in strict, valid JSON format with exactly two keys: 'type' and 'content'.
        
        RULE 1: If the user asks a general HR question (e.g., 'how to apply for leave', 'what is the company policy', greetings like 'hello'), 
        set 'type' to 'text' and write a helpful, friendly response in 'content'.
        
        RULE 2: If the user asks for specific company data (e.g., 'who is on leave', 'list holidays', 'who is admin'), 
        set 'type' to 'sql' and write ONLY a valid MySQL SELECT query in 'content'. 
        Only use these tables: " . $schema . "
        
        Example Text output: {\"type\": \"text\", \"content\": \"Hello! I am your HR assistant. How can I help you today?\"}
        Example SQL output: {\"type\": \"sql\", \"content\": \"SELECT name FROM holidays\"}";

        try {
            $apiKey = env('GEMINI_API_KEY');
            
            if (!$apiKey) {
                return view('chat', ['query' => $userQuery, 'error' => 'API Key missing from .env file.']);
            }

           $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey;

            // Call Gemini
            // Call Gemini and give it up to 60 seconds to reply
            $response = Http::withoutVerifying()
                ->timeout(60)
                ->withHeaders([
                    'Content-Type'  => 'application/json',
                ])->post($url, [
                    'systemInstruction' => ['parts' => [['text' => $systemPrompt]]],
                    'contents' => [['parts' => [['text' => $userQuery]]]],
                    'generationConfig' => [
                        'temperature' => 0.2, 
                        'responseMimeType' => 'application/json' 
                    ]
                ]);

            // If Google rejects the request, print the EXACT reason to the screen
            if (!$response->successful()) {
                return view('chat', [
                    'query' => $userQuery, 
                    'error' => 'Google API Error (' . $response->status() . '): ' . $response->body()
                ]);
            }

            $geminiText = $response->json('candidates.0.content.parts.0.text');
            
            // Decode the JSON Gemini gave us
            $aiResponse = json_decode($geminiText, true);

            if (!$aiResponse || !isset($aiResponse['type']) || !isset($aiResponse['content'])) {
                 return view('chat', ['query' => $userQuery, 'error' => 'Failed to parse AI response.']);
            }

            // --- HYBRID LOGIC: TEXT vs SQL ---

            // Scenario A: The AI decided to just talk to the user
            if ($aiResponse['type'] === 'text') {
                return view('chat', [
                    'query' => $userQuery,
                    'text_reply' => $aiResponse['content'] 
                ]);
            }

            // Scenario B: The AI decided it needs to search the database
            if ($aiResponse['type'] === 'sql') {
                $sqlQuery = $aiResponse['content'];

                if (preg_match('/(?:insert|update|delete|drop|truncate|alter|grant|create)/i', $sqlQuery)) {
                    return view('chat', ['query' => $userQuery, 'error' => 'Security Block: I cannot modify data.']);
                }

              $results = DB::select($sqlQuery);

                return view('chat', [
                    'query' => $userQuery,
                    'results' => $results
                ]);
            }

        } catch (QueryException $e) {
            return view('chat', ['query' => $userQuery, 'error' => 'Database Query Failed. Try asking differently.']);
        } catch (\Exception $e) {
            return view('chat', ['query' => $userQuery, 'error' => 'System Error: ' . $e->getMessage()]);
        }
    }
}