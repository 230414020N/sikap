<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\EducationLevel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EducationLevelController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'status' => ['nullable', 'in:active,inactive'],
            'sort' => ['nullable', 'in:order_asc,order_desc,az,za,latest,oldest'],
        ]);

        $query = EducationLevel::query();

        if (!empty($validated['q'])) {
            $like = '%' . $this->escapeLike(trim($validated['q'])) . '%';
            $query->where('nama', 'like', $like);
        }

        if (!empty($validated['status'])) {
            $query->where('is_active', $validated['status'] === 'active');
        }

        $sort = $validated['sort'] ?? 'order_asc';
        if ($sort === 'order_asc') $query->orderBy('sort_order', 'asc')->orderBy('nama', 'asc');
        if ($sort === 'order_desc') $query->orderBy('sort_order', 'desc')->orderBy('nama', 'asc');
        if ($sort === 'za') $query->orderBy('nama', 'desc');
        if ($sort === 'az') $query->orderBy('nama', 'asc');
        if ($sort === 'latest') $query->orderBy('created_at', 'desc');
        if ($sort === 'oldest') $query->orderBy('created_at', 'asc');

        $items = $query->paginate(12)->withQueryString();

        return view('admin.master.education_levels.index', compact('items'));
    }

    public function create()
    {
        return view('admin.master.education_levels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:120', 'unique:education_levels,nama'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        EducationLevel::create([
            'nama' => $validated['nama'],
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ]);

        return redirect()->route('admin.master.education-levels.index')->with('success', 'Pendidikan berhasil dibuat.');
    }

    public function edit(EducationLevel $education_level)
    {
        return view('admin.master.education_levels.edit', ['item' => $education_level]);
    }

    public function update(Request $request, EducationLevel $education_level)
    {
        $validated = $request->validate([
            'nama' => [
                'required', 'string', 'max:120',
                Rule::unique('education_levels', 'nama')->ignore($education_level->id),
            ],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $education_level->update([
            'nama' => $validated['nama'],
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return redirect()->route('admin.master.education-levels.index')->with('success', 'Pendidikan berhasil diperbarui.');
    }

    public function updateStatus(Request $request, EducationLevel $education_level)
    {
        $validated = $request->validate([
            'is_active' => ['required', 'boolean'],
        ]);

        $education_level->update(['is_active' => (bool) $validated['is_active']]);

        return back()->with('success', 'Status pendidikan diperbarui.');
    }

    public function destroy(EducationLevel $education_level)
    {
        $education_level->delete();
        return back()->with('success', 'Pendidikan berhasil dihapus.');
    }

    private function escapeLike(string $value): string
    {
        return addcslashes($value, "\\%_");
    }
}
