<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPortfolioModerationController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $status = (string) $request->query('status', 'all');

        $portofolios = Portofolio::query()
            ->with(['user'])
            ->withCount('likes')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('judul', 'like', "%{$q}%")
                        ->orWhere('deskripsi', 'like', "%{$q}%")
                        ->orWhere('kategori', 'like', "%{$q}%")
                        ->orWhere('tools', 'like', "%{$q}%")
                        ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%"));
                });
            })
            ->when($status !== 'all', function ($query) use ($status) {
                if ($status === 'active') {
                    $query->where('is_public', true)->where('is_taken_down', false);
                }
                if ($status === 'takedown') {
                    $query->where('is_taken_down', true);
                }
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.portofolios.index', compact('portofolios', 'q', 'status'));
    }

    public function show(Portofolio $portofolio)
    {
        $portofolio->load(['user', 'takenDownBy'])->loadCount('likes');

        return view('admin.portofolios.show', compact('portofolio'));
    }

    public function takedown(Request $request, Portofolio $portofolio)
    {
        $validated = $request->validate([
            'taken_down_reason' => ['nullable', 'string', 'max:255'],
        ]);

        $portofolio->update([
            'is_taken_down' => true,
            'taken_down_reason' => $validated['taken_down_reason'] ?? null,
            'taken_down_at' => now(),
            'taken_down_by' => auth()->id(),
        ]);

        return back()->with('success', 'Portofolio diturunkan dari publik.');
    }

    public function restore(Portofolio $portofolio)
    {
        $portofolio->update([
            'is_taken_down' => false,
            'taken_down_reason' => null,
            'taken_down_at' => null,
            'taken_down_by' => null,
        ]);

        return back()->with('success', 'Portofolio dipulihkan ke publik.');
    }

    public function destroy(Portofolio $portofolio)
    {
        if ($portofolio->thumbnail_path) {
            Storage::disk('public')->delete($portofolio->thumbnail_path);
        }

        $portofolio->delete();

        return redirect()->route('admin.portofolios.index')->with('success', 'Portofolio dihapus.');
    }
}
