<!DOCTYPE html>
<html>
<head>
    <title>HR Analytics Chatbot</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .chat-box { border: 1px solid #ccc; padding: 15px; border-radius: 10px; max-width: 600px; }
        .query { font-weight: bold; margin-bottom: 10px; }
        .sql { background: #f5f5f5; padding: 10px; border-radius: 5px; font-family: monospace; }
        .results { margin-top: 15px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>HR Analytics Chatbot</h2>

    <form method="POST" action="{{ route('chat.ask') }}">
        @csrf
        <input type="text" name="query" placeholder="Ask HR Analytics..." style="width: 400px; padding: 8px;">
        <button type="submit">Send</button>
    </form>

    @if(isset($query))
        <div class="chat-box">
            <div class="query">❓ {{ $query }}</div>
            
            <div class="sql">
                <strong>Generated SQL:</strong><br>
                {{ $sql }}
            </div>

            @if(isset($error))
                <div class="error" style="color:red;">
                    <strong>Error:</strong> {{ $error }}
                </div>
            @else
                <div class="results">
                    <strong>Results:</strong>
                    <table>
                        <thead>
                            <tr>
                                @foreach(array_keys((array)$results[0] ?? []) as $col)
                                    <th>{{ $col }}</th>
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
            @endif
        </div>
    @endif
</body>
</html>
