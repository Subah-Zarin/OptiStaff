<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Support\Rag;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function ask(Request $request)
    {
        $query = $request->input('query');
        
        // Step 1: Retrieve relevant context from RAG system
        $context = $this->getRelevantContext($query);
        
        // Step 2: Generate SQL based on context and query (LOCAL ONLY)
        $sql = $this->generateSQLWithRAGContext($query, $context['chunks']);
        $source = 'local_rag';
        
        // Step 3: Execute SQL and return results
        try {
            $results = DB::select($sql);
            
            return view('chat', [
                'query' => $query,
                'sql' => $sql . " \n-- Generated via: " . $source,
                'results' => $results,
                'context' => $context['chunks'], // Show retrieved context
                'error' => null
            ]);
            
        } catch (\Exception $e) {
            // If SQL fails, try to generate a simpler query
            $fallbackSql = $this->generateFallbackSQL($query);
            try {
                $fallbackResults = DB::select($fallbackSql);
                
                return view('chat', [
                    'query' => $query,
                    'sql' => $fallbackSql . " \n-- Fallback query (original failed)",
                    'results' => $fallbackResults,
                    'context' => $context['chunks'],
                    'error' => 'Original query failed, showing simplified results: ' . $e->getMessage()
                ]);
            } catch (\Exception $fallbackError) {
                return view('chat', [
                    'query' => $query,
                    'sql' => $sql,
                    'results' => [],
                    'context' => $context['chunks'],
                    'error' => 'Database error: ' . $e->getMessage()
                ]);
            }
        }
    }

    /**
     * Get relevant context from RAG system
     */
    private function getRelevantContext(string $query): array
    {
        $chunks = Rag::retrieve($query, 6);
        
        $hasRelevantData = false;
        $relevantChunks = [];
        
        foreach ($chunks as $chunk) {
            if ($chunk['score'] > 0.3) { // Lower threshold for local embeddings
                $hasRelevantData = true;
                $relevantChunks[] = $chunk;
            }
        }
        
        // If no chunks meet threshold, use top 2 anyway for context
        if (!$hasRelevantData && !empty($chunks)) {
            $relevantChunks = array_slice($chunks, 0, 2);
            $hasRelevantData = true;
        }
        
        return [
            'chunks' => $relevantChunks,
            'has_relevant_data' => $hasRelevantData
        ];
    }

    /**
     * Generate SQL using RAG context with schema awareness (LOCAL ONLY)
     */
    private function generateSQLWithRAGContext(string $query, array $chunks): string
    {
        $lowerQuery = strtolower($query);
        
        // Simple keyword-based SQL generation
        if (strpos($lowerQuery, 'pending') !== false && strpos($lowerQuery, 'leave') !== false) {
            return "SELECT l.*, u.name as user_name, u.email 
                    FROM leaves l 
                    JOIN users u ON l.user_id = u.id 
                    WHERE l.status = 'Pending' 
                    ORDER BY l.created_at DESC";
        }
        
        if (strpos($lowerQuery, 'approved') !== false && strpos($lowerQuery, 'leave') !== false) {
            return "SELECT l.*, u.name as user_name, u.email 
                    FROM leaves l 
                    JOIN users u ON l.user_id = u.id 
                    WHERE l.status = 'Approved' 
                    ORDER BY l.from_date DESC";
        }
        
        if (strpos($lowerQuery, 'leave') !== false) {
            return "SELECT l.*, u.name as user_name, u.email 
                    FROM leaves l 
                    JOIN users u ON l.user_id = u.id 
                    ORDER BY l.created_at DESC 
                    LIMIT 15";
        }
        
        if (strpos($lowerQuery, 'attendance') !== false) {
            if (strpos($lowerQuery, 'present') !== false) {
                return "SELECT a.*, u.name as user_name, u.email 
                        FROM attendances a 
                        JOIN users u ON a.user_id = u.id 
                        WHERE a.status = 'Present' 
                        ORDER BY a.date DESC 
                        LIMIT 15";
            } else {
                return "SELECT a.*, u.name as user_name, u.email 
                        FROM attendances a 
                        JOIN users u ON a.user_id = u.id 
                        ORDER BY a.date DESC 
                        LIMIT 15";
            }
        }
        
        if (strpos($lowerQuery, 'user') !== false || strpos($lowerQuery, 'employee') !== false) {
            if (strpos($lowerQuery, 'count') !== false) {
                if (strpos($lowerQuery, 'admin') !== false) {
                    return "SELECT COUNT(*) as total_admins FROM users WHERE role = 'admin'";
                } else {
                    return "SELECT COUNT(*) as total_users FROM users WHERE role = 'user'";
                }
            } else {
                return "SELECT id, name, email, role, created_at 
                        FROM users 
                        ORDER BY created_at DESC 
                        LIMIT 15";
            }
        }
        
        if (strpos($lowerQuery, 'holiday') !== false) {
            return "SELECT * FROM holidays ORDER BY date";
        }
        
        if (strpos($lowerQuery, 'late') !== false) {
            return "SELECT a.*, u.name as user_name, u.email 
                    FROM attendances a 
                    JOIN users u ON a.user_id = u.id 
                    WHERE a.check_in > '09:30:00' 
                    ORDER BY a.date DESC 
                    LIMIT 15";
        }
        
        // Default fallback
        return "SELECT 'Try asking about: leaves, attendance, users, holidays, or late arrivals' as suggestion 
                UNION SELECT 'Example: Show me pending leave requests' as suggestion
                UNION SELECT 'Example: List all employees' as suggestion
                UNION SELECT 'Example: Show late arrivals' as suggestion";
    }

    /**
     * Simple fallback SQL for when complex queries fail
     */
    private function generateFallbackSQL(string $query): string
    {
        $lowerQuery = strtolower($query);
        
        if (strpos($lowerQuery, 'leave') !== false) {
            return "SELECT id, user_id, leave_type, status, from_date, to_date FROM leaves ORDER BY created_at DESC LIMIT 5";
        } elseif (strpos($lowerQuery, 'attendance') !== false) {
            return "SELECT id, user_id, date, status FROM attendances ORDER BY date DESC LIMIT 5";
        } elseif (strpos($lowerQuery, 'user') !== false) {
            return "SELECT id, name, email, role FROM users ORDER BY created_at DESC LIMIT 5";
        } else {
            return "SELECT 'Showing sample data' as info, 'leaves' as table_name, COUNT(*) as count FROM leaves
                   UNION ALL SELECT 'Showing sample data' as info, 'attendances' as table_name, COUNT(*) as count FROM attendances
                   UNION ALL SELECT 'Showing sample data' as info, 'users' as table_name, COUNT(*) as count FROM users";
        }
    }
}