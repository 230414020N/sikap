<?php

namespace App\Http\Controllers;

use App\Models\Portofolio;
use Illuminate\Http\Request;

class AdminShowcaseModerationController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'status' => ['nullable', 'in:pending,approved,rejected,all'],
            'q' => ['nullable', 'string', 'max:120'],
            'sort' => ['nullable', 'in:latest,oldest'],
        ]);

        $query = Portofolio::query()
            ->with(['user', 'moderator'])
            ->where('is_showcase', true);

        $status = $validated['status'] ?? 'pending';

        if ($status !== 'all') {
            $query->where('moderation_status', $status);
        }

        if (!empty($validated['q'])) {
            $terms = preg_split('/\s+/', trim($validated['q'])) ?: [];

            $query->where(function ($outer) use ($terms) {
                foreach ($terms as $term) {
                    if ($term === '') {
                        continue;
                    }

                    $like = '%' . $this->escapeLike($term) . '%';

                    $outer->where(function ($sub) use ($like) {
                        $sub->where('judul', 'like', $like)
                            ->orWhere('kategori', 'like', $like)
                            ->orWhere('tools', 'like', $like)
                            ->orWhereHas('user', function ($u) use ($like) {
                                $u->where('name', 'like', $like)
                                    ->orWhere('email', 'like', $like);
                            });
                    });
                }
            });
        }

        $sort = $validated['sort'] ?? 'latest';
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $portofolios = $query->paginate(12)->withQueryString();

        return view('admin.showcase.index', compact('portofolios', 'status'));
    }

    public function show(Portofolio $portofolio)
    {
        abort_if(!$portofolio->is_showcase, 404);

        $portofolio->load(['user', 'moderator']);

        return view('admin.showcase.show', compact('portofolio'));
    }

    public function approve(Request $request, Portofolio $portofolio)
    {
        abort_if(!$portofolio->is_showcase, 404);

        $portofolio->update([
            'moderation_status' => 'approved',
            'moderation_reason' => null,
            'moderated_by' => auth()->id(),
            'moderated_at' => now(),
        ]);

        return redirect()->route('admin.showcase.show', $portofolio->id)->with('success', 'Showcase disetujui.');
    }

    public function reject(Request $request, Portofolio $portofolio)
    {
        abort_if(!$portofolio->is_showcase, 404);

        $validated = $request->validate([
            'moderation_reason' => ['required', 'string', 'max:2000'],
        ]);

        $portofolio->update([
            'moderation_status' => 'rejected',
            'moderation_reason' => $validated['moderation_reason'],
            'moderated_by' => auth()->id(),
            'moderated_at' => now(),
        ]);

        return redirect()->route('admin.showcase.show', $portofolio->id)->with('success', 'Showcase ditolak.');
    }

    private function escapeLike(string $value): string
    {
        return addcslashes($value, "\\%_");
    }
}
