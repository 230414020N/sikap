<?php

namespace App\Http\Controllers;

use App\Models\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortofolioController extends Controller
{
    public function index()
    {
        $portofolios = auth()->user()->portofolios()->latest()->get();
        return view('pelamar.portofolio.index', compact('portofolios'));
    }

    public function create()
    {
        return view('pelamar.portofolio.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:2000',
            'kategori' => 'nullable|string|max:100',
            'tools' => 'nullable|string|max:255',
            'link_demo' => 'nullable|url|max:255',
            'link_github' => 'nullable|url|max:255',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $data = $request->only([
            'judul','deskripsi','kategori','tools','link_demo','link_github'
        ]);

        $data['user_id'] = auth()->id();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail_path'] = $request->file('thumbnail')->store('uploads/thumbnails');
        }

        Portofolio::create($data);

        return redirect()->route('pelamar.portofolio.index')->with('success', 'Portofolio berhasil ditambahkan!');
    }

    public function edit(Portofolio $portofolio)
    {
        abort_if($portofolio->user_id !== auth()->id(), 403);
        return view('pelamar.portofolio.edit', compact('portofolio'));
    }

    public function update(Request $request, Portofolio $portofolio)
    {
        abort_if($portofolio->user_id !== auth()->id(), 403);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:2000',
            'kategori' => 'nullable|string|max:100',
            'tools' => 'nullable|string|max:255',
            'link_demo' => 'nullable|url|max:255',
            'link_github' => 'nullable|url|max:255',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $data = $request->only([
            'judul','deskripsi','kategori','tools','link_demo','link_github'
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($portofolio->thumbnail_path) Storage::delete($portofolio->thumbnail_path);
            $data['thumbnail_path'] = $request->file('thumbnail')->store('uploads/thumbnails');
        }

        $portofolio->update($data);

        return redirect()->route('pelamar.portofolio.index')->with('success', 'Portofolio berhasil diperbarui!');
    }

    public function destroy(Portofolio $portofolio)
    {
        abort_if($portofolio->user_id !== auth()->id(), 403);

        if ($portofolio->thumbnail_path) Storage::delete($portofolio->thumbnail_path);
        $portofolio->delete();

        return redirect()->route('pelamar.portofolio.index')->with('success', 'Portofolio berhasil dihapus!');
    }
}
