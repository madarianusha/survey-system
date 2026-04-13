<h1>Admin Dashboard</h1>

<a href="{{ route('admin.surveys.create') }}">Create Survey</a>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Topic</th>
        <th>URL</th>
        <th>Status</th>
        <th>Responses</th>
        <th>Actions</th>
    </tr>

    @foreach($surveys as $survey)
    <tr>
        <td>{{ $survey->id }}</td>
        <td>{{ $survey->topic_name }}</td>
        <td>
            <a href="{{ route('survey.show', $survey->slug) }}" target="_blank">
                {{ route('survey.show', $survey->slug) }}
            </a>
        </td>
        <td>{{ $survey->is_active ? 'Active' : 'Inactive' }}</td>
        <td>{{ $survey->responses_count }}</td>
        <td>
            <form action="{{ route('admin.surveys.toggle', $survey->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit">
                    {{ $survey->is_active ? 'Deactivate' : 'Activate' }}
                </button>
            </form>

            <a href="{{ route('admin.surveys.results', $survey->id) }}">View Results</a>
            <a href="{{ route('admin.surveys.download', $survey->id) }}">Download</a>
        </td>
    </tr>
    @endforeach
</table>