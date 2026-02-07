<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\InternalNote;
use Illuminate\Http\Request;

class HrdApplicationInternalNoteController extends Controller
{
    public function store(Request $request, Application $application)
    {
        $application->loadMissing('job');
        abort_if($application->job->company_id !== auth()->user()->company_id, 403);

        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:120'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'recommendation' => ['nullable', 'in:Shortlist,Hold,Reject,Hire'],
            'summary' => ['required', 'string', 'max:5000'],

            'strengths_text' => ['nullable', 'string', 'max:5000'],
            'concerns_text' => ['nullable', 'string', 'max:5000'],
            'questions_text' => ['nullable', 'string', 'max:5000'],
            'next_steps_text' => ['nullable', 'string', 'max:5000'],

            'stage' => ['nullable', 'string', 'max:50'],
            'follow_up_at' => ['nullable', 'date'],
        ]);

        $strengths = $this->linesToArray($validated['strengths_text'] ?? null);
        $concerns = $this->linesToArray($validated['concerns_text'] ?? null);
        $questions = $this->linesToArray($validated['questions_text'] ?? null);
        $nextSteps = $this->linesToArray($validated['next_steps_text'] ?? null);

        InternalNote::create([
            'application_id' => $application->id,
            'created_by' => auth()->id(),
            'title' => $validated['title'] ?? null,
            'rating' => $validated['rating'] ?? null,
            'recommendation' => $validated['recommendation'] ?? null,
            'summary' => $validated['summary'],
            'strengths' => $strengths ?: null,
            'concerns' => $concerns ?: null,
            'questions' => $questions ?: null,
            'next_steps' => $nextSteps ?: null,
            'stage' => $validated['stage'] ?? null,
            'follow_up_at' => $validated['follow_up_at'] ?? null,
        ]);

        return back()->with('success', 'Catatan internal tersimpan.');
    }

    private function linesToArray(?string $text): array
    {
        if ($text === null) {
            return [];
        }

        $lines = preg_split("/\r\n|\n|\r/", $text) ?: [];
        $lines = array_map('trim', $lines);
        $lines = array_values(array_filter($lines, fn ($v) => $v !== ''));

        return $lines;
    }
}
