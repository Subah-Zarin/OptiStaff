<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Analytics Chatbot</title>
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --background-color: #f9f9f9;
            --light-gray: #eef2f5;
            --border-color: #ddd;
            --success-color: #2ecc71;
            --error-color: #e74c3c;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background-color);
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        
        header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 25px;
            text-align: center;
        }
        
        header h1 {
            font-weight: 600;
            font-size: 28px;
            margin-bottom: 5px;
        }
        
        header p {
            opacity: 0.9;
            font-size: 16px;
        }
        
        .chat-container {
            padding: 25px;
        }
        
        .input-form {
            display: flex;
            margin-bottom: 25px;
            gap: 12px;
        }
        
        .input-form input {
            flex: 1;
            padding: 14px 18px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .input-form input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
        
        .input-form button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0 25px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .input-form button:hover {
            background-color: #2980b9;
        }
        
        .response-container {
            background-color: var(--light-gray);
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }
        
        .user-query {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        
        .user-icon {
            background-color: var(--primary-color);
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            flex-shrink: 0;
        }
        
        .query-text {
            background: white;
            padding: 15px;
            border-radius: 18px 18px 18px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            font-size: 16px;
        }
        
        .results-section {
            margin-top: 25px;
        }

        .text-reply-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid var(--primary-color);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            font-size: 16px;
            color: var(--secondary-color);
        }
        
        .results-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .results-icon {
            background-color: var(--success-color);
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }
        
        .results-title {
            font-weight: 600;
            color: var(--secondary-color);
        }
        
        .results-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .results-table th {
            background-color: #f1f5f9;
            padding: 14px 12px;
            text-align: left;
            font-weight: 600;
            color: var(--secondary-color);
            border-bottom: 2px solid var(--border-color);
        }
        
        .results-table td {
            padding: 12px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .results-table tr:last-child td {
            border-bottom: none;
        }
        
        .results-table tr:hover {
            background-color: #f8fafc;
        }
        
        .no-results {
            text-align: center;
            padding: 30px;
            color: #7a8594;
            font-style: italic;
        }
        
        .error-message {
            background-color: #ffebee;
            color: var(--error-color);
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            display: flex;
            align-items: center;
        }
        
        .error-icon {
            margin-right: 10px;
            font-weight: bold;
        }
        
        @media (max-width: 768px) {
            .container {
                border-radius: 0;
            }
            
            .input-form {
                flex-direction: column;
            }
            
            .input-form button {
                padding: 14px;
            }
            
            .results-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>HR Analytics Chatbot</h1>
            <p>Get insights about your HR data with natural language queries</p>
        </header>
        
        <div class="chat-container">
            <form method="POST" action="{{ route('hr.chat.ask') }}" class="input-form">
                @csrf
                <input type="text" name="query" placeholder="Ask HR Analytics (e.g., 'Hello' or 'Show me all holidays')" autocomplete="off" required>
                <button type="submit">Send</button>
            </form>
            
            @if(isset($query))
            <div class="response-container">
                <div class="user-query">
                    <div class="user-icon">👤</div>
                    <div class="query-text">{{ $query }}</div>
                </div>
                
                {{-- SCENARIO 1: ERROR OCCURRED --}}
                @if(isset($error))
                <div class="error-message">
                    <span class="error-icon">⚠️</span>
                    <strong>Error:</strong> {{ $error }}
                </div>
                
                {{-- SCENARIO 2: NORMAL TEXT CONVERSATION (Hello, How-to questions) --}}
                @elseif(isset($text_reply))
                <div class="results-section">
                    <div class="text-reply-section">
                        {!! nl2br(e($text_reply)) !!}
                    </div>
                </div>

                {{-- SCENARIO 3: DATABASE SQL RESULTS --}}
                @elseif(isset($results))
                    @php $firstRow = $results[0] ?? null; @endphp

                    @if($firstRow)
                    <div class="results-section">
                        <div class="results-header">
                            <div class="results-icon">✓</div>
                            <div class="results-title">Query Results</div>
                        </div>
                        
                        <div style="overflow-x: auto;">
                            <table class="results-table">
                                <thead>
                                    <tr>
                                        @foreach(array_keys((array)$firstRow) as $col)
                                            <th>{{ ucwords(str_replace('_', ' ', $col)) }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($results as $row)
                                        <tr>
                                            @foreach((array)$row as $value)
                                                <td>{{ $value }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                    <div class="no-results">
                        No records matched your request.
                    </div>
                    @endif
                @endif
            </div>
            @endif
        </div>
    </div>
</body>
</html>