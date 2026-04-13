<h1>Available Surveys</h1>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

@foreach($surveys as $survey)
    <p>
        <a href="{{ route('survey.show', $survey->slug) }}">
            {{ $survey->topic_name }}
        </a>
    </p>
@endforeach