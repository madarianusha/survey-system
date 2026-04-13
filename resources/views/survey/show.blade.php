<h1>{{ $survey->topic_name }}</h1>

<form action="{{ route('survey.submit', $survey->slug) }}" method="POST">
    @csrf

    @foreach($survey->questions as $question)
        <div style="margin-bottom:20px;">
            <p><strong>{{ $question->question_text }}</strong></p>

            @foreach($question->options->shuffle() as $option)
                <label>
                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" required>
                    {{ $option->option_text }}
                </label><br>
            @endforeach
        </div>
    @endforeach

    <button type="submit">Submit Answers</button>
</form>