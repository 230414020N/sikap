<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobCategoryController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'status' => ['nullable', 'in:active,inactive'],
            'sort' => ['nullable', 'in:az,za,latest,oldest'],
        ]);

        $query = JobCategory::query();

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

        return view('admin.master.job_categories.index', compact('items'));
    }

    public function create()
    {
        return view('admin.master.job_categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:120', 'unique:job_categories,nama'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        JobCategory::create([
            'nama' => $validated['nama'],
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ]);

        return redirect()->route('admin.master.job-categories.index')->with('success', 'Kategori berhasil dibuat.');
    }

    public function edit(JobCategory $job_category)
    {
        return view('admin.master.job_categories.edit', ['item' => $job_category]);
    }

    public function update(Request $request, JobCategory $job_category)
    {
        $validated = $request->validate([
            'nama' => [
                'required', 'string', 'max:120',
                Rule::unique('job_categories', 'nama')->ignore($job_category->id),
            ],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $job_category->update([
            'nama' => $validated['nama'],
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return redirect()->route('admin.master.job-categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function updateStatus(Request $request, JobCategory $job_category)
    {
        $validated = $request->validate([
            'is_active' => ['required', 'boolean'],
        ]);

        $job_category->update(['is_active' => (bool) $validated['is_active']]);

        return back()->with('success', 'Status kategori diperbarui.');
    }

    public function destroy(JobCategory $job_category)
    {
        $job_category->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }

    private function escapeLike(string $value): string
    {
        return addcslashes($value, "\\%_");
    }
}
