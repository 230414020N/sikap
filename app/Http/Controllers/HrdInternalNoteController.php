<?php

namespace App\Http\Controllers;

use App\Models\InternalNote;
use Illuminate\Http\Request;

class HrdInternalNoteController extends Controller
{
    public function update(Request $request, InternalNote $internalNote)
    {
        $internalNote->loadMissing('application.job');
        abort_if($internalNote->application->job->company_id !== auth()->user()->company_id, 403);

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

        $internalNote->update([
            'title' => $validated['title'] ?? null,
            'rating' => $validated['rating'] ?? null,
            'recommendation' => $validated['recommendation'] ?? null,
            'summary' => $validated['summary'],
            'strengths' => $this->linesToArray($validated['strengths_text'] ?? null) ?: null,
            'concerns' => $this->linesToArray($validated['concerns_text'] ?? null) ?: null,
            'questions' => $this->linesToArray($validated['questions_text'] ?? null) ?: null,
            'next_steps' => $this->linesToArray($validated['next_steps_text'] ?? null) ?: null,
            'stage' => $validated['stage'] ?? null,
            'follow_up_at' => $validated['follow_up_at'] ?? null,
        ]);

        return back()->with('success', 'Catatan internal diperbarui.');
    }

    public function destroy(InternalNote $internalNote)
    {
        $internalNote->loadMissing('application.job');
        abort_if($internalNote->application->job->company_id !== auth()->user()->company_id, 403);

        $internalNote->delete();

        return back()->with('success', 'Catatan internal dihapus.');
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
