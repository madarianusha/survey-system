<h1>Admin Dashboard</h1>

<form method="POST" action="{{ route('admin.logout') }}" style="float:right;">
    @csrf
    <button type="submit" style="background:red; color:white; padding:6px 12px; border:none;">
        Logout
    </button>
</form>

<a href="{{ route('admin.surveys.create') }}">Create Survey</a>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<p>Dashboard file loaded successfully</p>
<p>Total surveys: {{ $surveys->count() }}</p>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Topic</th>
        <th>URL</th>
        <th>Status</th>
        <th>Responses</th>
        <th>Actions</th>
    </tr>

    @forelse($surveys as $survey)
    <tr>
        <td>{{ $survey->id }}</td>
        <td>{{ $survey->topic_name }}</td>
        <td>
            <a href="{{ route('survey.show', $survey->slug) }}" target="_blank">
                {{ route('survey.show', $survey->slug) }}
            </a>
        </td>
        <td>{{ $survey->is_active ? 'Active' : 'Inactive' }}</td>
        <td>{{ $survey->responses_count ?? 0 }}</td>
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
    @empty
    <tr>
        <td colspan="6">No surveys found</td>
    </tr>
    @endforelse
</table>