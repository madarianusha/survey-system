<h1>Results for {{ $survey->topic_name }}</h1>

<table border="1" cellpadding="10">
    <tr>
        <th>Response ID</th>
        <th>Score</th>
        <th>Submitted At</th>
    </tr>

    @forelse($survey->responses as $response)
        <tr>
            <td>{{ $response->id }}</td>
            <td>{{ $response->score }}</td>
            <td>{{ $response->submitted_at }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="3">No responses yet.</td>
        </tr>
    @endforelse
</table>

<br>

<a href="{{ route('admin.dashboard') }}">Back to Dashboard</a>