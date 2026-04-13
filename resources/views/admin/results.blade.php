<!DOCTYPE html>
<html>
<head>
    <title>Survey Results</title>
</head>
<body>
    <h1>Results for: {{ $survey->topic_name }}</h1>

    <a href="{{ route('admin.dashboard') }}">Back to Dashboard</a>
    <br><br>

    <a href="{{ route('admin.surveys.download', $survey->id) }}">Download CSV</a>

    <br><br>

    @if($survey->responses->count() > 0)
        <table border="1" cellpadding="10">
            <tr>
                <th>Response ID</th>
                <th>Question</th>
                <th>Selected Answer</th>
                <th>Submitted At</th>
            </tr>

            @foreach($survey->responses as $response)
                @foreach($response->answers as $answer)
                    <tr>
                        <td>{{ $response->id }}</td>
                        <td>{{ $answer->question->question_text ?? 'N/A' }}</td>
                        <td>{{ $answer->selectedOption->option_text ?? 'N/A' }}</td>
                        <td>{{ $response->submitted_at ?? $response->created_at }}</td>
                    </tr>
                @endforeach
            @endforeach
        </table>
    @else
        <p>No responses found for this survey.</p>
    @endif
</body>
</html>