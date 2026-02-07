<?php

namespace App\Http\Controllers;

use App\Models\Portofolio;
use App\Models\PortfolioLike;

class PublicPortfolioController extends Controller
{
    public function index()
    {
        $portofolios = Portofolio::query()
            ->with(['user'])
            ->withCount('likes')
            ->withExists([
                'likedBy as is_liked' => fn ($q) => $q->where('users.id', auth()->id()),
            ])
            ->where('is_public', true)
            ->where('is_taken_down', false)
            ->latest()
            ->paginate(9);

        return view('pelamar.portofolio.public', compact('portofolios'));
    }

    public function toggleLike(Portofolio $portofolio)
    {
        $existing = PortfolioLike::where('portofolio_id', $portofolio->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            PortfolioLike::create([
                'portofolio_id' => $portofolio->id,
                'user_id' => auth()->id(),
            ]);
        }

        return back();
    }
}
