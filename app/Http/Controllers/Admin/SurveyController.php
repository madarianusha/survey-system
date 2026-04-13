<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\Question;
use App\Models\Option;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SurveyController extends Controller
{
    public function dashboard()
    {
        $surveys = Survey::withCount('responses')->latest()->get();
        return view('admin.dashboard', compact('surveys'));
    }

    public function create()
    {
        return view('admin.create-survey');
    }

    public function store(Request $request)
    {
        $request->validate([
            'topic_name' => 'required|string|max:255',
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        $survey = Survey::create([
            'topic_name' => $request->topic_name,
            'slug' => Str::slug($request->topic_name) . '-' . time(),
            'is_active' => true,
            'created_by' => auth()->id(),
        ]);

        $file = fopen($request->file('csv_file')->getRealPath(), 'r');

        $header = fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            if (count($row) < 3) {
                continue;
            }

            $questionText = $row[0];
            $correctAnswer = $row[1];
            $wrongOptions = explode('|', $row[2]);

            $question = Question::create([
                'survey_id' => $survey->id,
                'question_text' => $questionText,
                'correct_answer' => $correctAnswer,
            ]);

            Option::create([
                'question_id' => $question->id,
                'option_text' => $correctAnswer,
                'is_correct' => true,
            ]);

            foreach ($wrongOptions as $wrong) {
                Option::create([
                    'question_id' => $question->id,
                    'option_text' => trim($wrong),
                    'is_correct' => false,
                ]);
            }
        }

        fclose($file);

        return redirect()->route('admin.dashboard')->with('success', 'Survey created successfully.');
    }

    public function toggle($id)
    {
        $survey = Survey::findOrFail($id);
        $survey->is_active = !$survey->is_active;
        $survey->save();

        return redirect()->route('admin.dashboard')->with('success', 'Survey status updated.');
    }

    public function results($id)
    {
        $survey = Survey::with(['responses.answers'])->findOrFail($id);
        return view('admin.results', compact('survey'));
    }

   public function download($id)
{
    $survey = Survey::with(['responses.answers.question', 'responses.answers.selectedOption'])->findOrFail($id);

    $response = new \Symfony\Component\HttpFoundation\StreamedResponse(function () use ($survey) {
        $handle = fopen('php://output', 'w');

        fputcsv($handle, ['Response ID', 'Question', 'Selected Answer', 'Submitted At']);

        foreach ($survey->responses as $responseItem) {
            foreach ($responseItem->answers as $answer) {
                fputcsv($handle, [
                    $responseItem->id,
                    $answer->question->question_text ?? '',
                    $answer->selectedOption->option_text ?? '',
                    $responseItem->submitted_at,
                ]);
            }
        }

        fclose($handle);
    });

    $response->headers->set('Content-Type', 'text/csv');
    $response->headers->set('Content-Disposition', 'attachment; filename="survey_results.csv"');

    return $response;
}
}