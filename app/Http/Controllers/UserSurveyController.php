<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Response;
use App\Models\ResponseAnswer;
use Illuminate\Http\Request;

class UserSurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::where('is_active', true)->get();
        return view('survey.index', compact('surveys'));
    }

    public function show($slug)
    {
        $survey = Survey::where('slug', $slug)
            ->where('is_active', true)
            ->with('questions.options')
            ->firstOrFail();

        return view('survey.show', compact('survey'));
    }

    public function submit(Request $request, $slug)
    {
        $survey = Survey::where('slug', $slug)->where('is_active', true)->with('questions.options')->firstOrFail();

        $response = Response::create([
            'survey_id' => $survey->id,
            'submitted_at' => now(),
            'score' => 0,
        ]);

        $score = 0;

        foreach ($survey->questions as $question) {
            $selectedOptionId = $request->input('answers.' . $question->id);

            if ($selectedOptionId) {
                ResponseAnswer::create([
                    'response_id' => $response->id,
                    'question_id' => $question->id,
                    'selected_option_id' => $selectedOptionId,
                ]);

                $selectedOption = $question->options->where('id', $selectedOptionId)->first();
                if ($selectedOption && $selectedOption->is_correct) {
                    $score++;
                }
            }
        }

        $response->update(['score' => $score]);

        return redirect()->route('home')->with('success', 'Survey submitted successfully.');
    }
}