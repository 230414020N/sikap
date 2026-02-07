<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\JobLocation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobLocationController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:140'],
            'status' => ['nullable', 'in:active,inactive'],
            'sort' => ['nullable', 'in:az,za,latest,oldest'],
        ]);

        $query = JobLocation::query();

        if (!empty($validated['q'])) {
            $like = '%' . $this->escapeLike(trim($validated['q'])) . '%';
            $query->where('nama', 'like', $like);
        }

        if (!empty($validated['status'])) {
            $query->where('is_active', $validated['status'] === 'active');
        }

        $sort = $validated['sort'] ?? 'az';
        if ($sort === 'za') $query->orderBy('nama', 'desc');
        if ($sort === 'az') $query->orderBy('nama', 'asc');
        if ($sort === 'latest') $query->orderBy('created_at', 'desc');
        if ($sort === 'oldest') $query->orderBy('created_at', 'asc');

        $items = $query->paginate(12)->withQueryString();

        return view('admin.master.job_locations.index', compact('items'));
    }

    public function create()
    {
        return view('admin.master.job_locations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:140', 'unique:job_locations,nama'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        JobLocation::create([
            'nama' => $validated['nama'],
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ]);

        return redirect()->route('admin.master.job-locations.index')->with('success', 'Lokasi berhasil dibuat.');
    }

    public function edit(JobLocation $job_location)
    {
        return view('admin.master.job_locations.edit', ['item' => $job_location]);
    }

    public function update(Request $request, JobLocation $job_location)
    {
        $validated = $request->validate([
            'nama' => [
                'required', 'string', 'max:140',
                Rule::unique('job_locations', 'nama')->ignore($job_location->id),
            ],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $job_location->update([
            'nama' => $validated['nama'],
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return redirect()->route('admin.master.job-locations.index')->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function updateStatus(Request $request, JobLocation $job_location)
    {
        $validated = $request->validate([
            'is_active' => ['required', 'boolean'],
        ]);

        $job_location->update(['is_active' => (bool) $validated['is_active']]);

        return back()->with('success', 'Status lokasi diperbarui.');
    }

    public function destroy(JobLocation $job_location)
    {
        $job_location->delete();
        return back()->with('success', 'Lokasi berhasil dihapus.');
    }

    private function escapeLike(string $value): string
    {
        return addcslashes($value, "\\%_");
    }
}
