@extends('layouts.app')

@section('content')
    @php
        $application->loadMissing(['job.company', 'pelamar.pelamarProfile', 'internalNotes.creator']);
        $profile = $application->pelamar->pelamarProfile;
        $fullName = $profile?->nama_lengkap ?: $application->pelamar->name;

        $notes = $application->internalNotes->sortByDesc('created_at');

        $toLines = function ($arr) {
            if (!$arr || !is_array($arr)) return '';
            return implode("\n", $arr);
        };

        $badgeClass = function ($value, $type) {
            $v = strtolower((string) $value);

            if ($type === 'recommendation') {
                if ($v === 'hire') return 'border-green-200 bg-green-50 text-green-800';
                if ($v === 'shortlist') return 'border-blue-200 bg-blue-50 text-blue-800';
                if ($v === 'hold') return 'border-amber-200 bg-amber-50 text-amber-800';
                if ($v === 'reject') return 'border-red-200 bg-red-50 text-red-800';
                return 'border-gray-200 bg-gray-50 text-gray-800';
            }

            if ($type === 'rating') {
                $r = (int) $value;
                if ($r >= 4) return 'border-green-200 bg-green-50 text-green-800';
                if ($r === 3) return 'border-amber-200 bg-amber-50 text-amber-800';
                if ($r > 0) return 'border-red-200 bg-red-50 text-red-800';
                return 'border-gray-200 bg-gray-50 text-gray-800';
            }

            if ($type === 'followup') {
                return 'border-purple-200 bg-purple-50 text-purple-800';
            }

            return 'border-gray-200 bg-gray-50 text-gray-800';
        };

        $countAll = $notes->count();
        $countFollowUp = $notes->filter(fn ($n) => !empty($n->follow_up_at))->count();
        $avgRating = $notes->filter(fn ($n) => !empty($n->rating))->avg('rating');
        $avgRatingText = $avgRating ? number_format($avgRating, 1) : null;

        $recCounts = [
            'Shortlist' => $notes->where('recommendation', 'Shortlist')->count(),
            'Hold' => $notes->where('recommendation', 'Hold')->count(),
            'Reject' => $notes->where('recommendation', 'Reject')->count(),
            'Hire' => $notes->where('recommendation', 'Hire')->count(),
        ];

        $hasAny = $countAll > 0;
    @endphp

    <div class="min-h-screen bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between mb-8">
                <div class="min-w-0">
                    <h1 class="text-2xl font-semibold tracking-tight text-gray-900">FR-H07 • Internal Notes</h1>
                    <p class="mt-1 text-sm text-gray-600 truncate">
                        {{ $fullName }} • {{ $application->job->judul }} • {{ $application->job->company->nama }}
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('hrd.applications.show', $application->id) }}"
                       class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                        Kembali ke Detail Kandidat
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-3xl border border-gray-900 bg-gray-900 text-white px-5 py-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 rounded-3xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                    Input belum valid. Coba cek lagi.
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-200">
                            <p class="text-sm font-semibold text-gray-900">Ringkasan</p>
                            <p class="mt-1 text-xs text-gray-600">Snapshot cepat dari catatan yang ada.</p>
                        </div>

                        <div class="p-6 grid grid-cols-2 gap-3">
                            <div class="rounded-3xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs text-gray-600">Total</p>
                                <p class="mt-2 text-2xl font-semibold text-gray-900">{{ $countAll }}</p>
                            </div>

                            <div class="rounded-3xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs text-gray-600">Follow-up</p>
                                <p class="mt-2 text-2xl font-semibold text-gray-900">{{ $countFollowUp }}</p>
                            </div>

                            <div class="rounded-3xl border border-gray-200 bg-gray-50 p-4 col-span-2">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-xs text-gray-600">Rata-rata Rating</p>
                                        <p class="mt-2 text-2xl font-semibold text-gray-900">{{ $avgRatingText ?? '—' }}</p>
                                    </div>
                                    <div class="text-xs text-gray-500">dari {{ $notes->filter(fn ($n) => !empty($n->rating))->count() }} catatan</div>
                                </div>
                            </div>

                            <div class="rounded-3xl border border-gray-200 bg-white p-4 col-span-2">
                                <p class="text-xs font-semibold text-gray-900">Rekomendasi</p>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    @foreach($recCounts as $k => $v)
                                        @if($v > 0)
                                            <span class="inline-flex items-center text-xs px-3 py-1 rounded-full border font-medium {{ $badgeClass($k, 'recommendation') }}">
                                                {{ $k }} • {{ $v }}
                                            </span>
                                        @endif
                                    @endforeach
                                    @if(!$hasAny || array_sum($recCounts) === 0)
                                        <span class="text-xs text-gray-600">Belum ada rekomendasi.</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-200">
                            <p class="text-sm font-semibold text-gray-900">Tambah Catatan Terstruktur</p>
                            <p class="mt-1 text-xs text-gray-600">Gunakan format ini supaya evaluasi konsisten antar HRD.</p>
                        </div>

                        <form method="POST" action="{{ route('hrd.applications.internal_notes.store', $application->id) }}" class="p-6 space-y-4">
                            @csrf

                            <div>
                                <label class="text-xs font-medium text-gray-700">Judul</label>
                                <input type="text" name="title" value="{{ old('title') }}"
                                       class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition"
                                       placeholder="Contoh: Screen CV • First Impression">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="text-xs font-medium text-gray-700">Rating</label>
                                    <select name="rating"
                                            class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition">
                                        <option value="">—</option>
                                        @for($i=1; $i<=5; $i++)
                                            <option value="{{ $i }}" @selected(old('rating') == $i)>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div>
                                    <label class="text-xs font-medium text-gray-700">Rekomendasi</label>
                                    <select name="recommendation"
                                            class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition">
                                        <option value="">—</option>
                                        @foreach(['Shortlist','Hold','Reject','Hire'] as $r)
                                            <option value="{{ $r }}" @selected(old('recommendation') === $r)>{{ $r }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="text-xs font-medium text-gray-700">Ringkasan</label>
                                <textarea name="summary" rows="5"
                                          class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition"
                                          placeholder="Tulis ringkasan singkat dan to-the-point.">{{ old('summary') }}</textarea>
                            </div>

                            <div>
                                <label class="text-xs font-medium text-gray-700">Kelebihan</label>
                                <textarea name="strengths_text" rows="4"
                                          class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition"
                                          placeholder="1 baris = 1 poin">{{ old('strengths_text') }}</textarea>
                            </div>

                            <div>
                                <label class="text-xs font-medium text-gray-700">Concern/Risiko</label>
                                <textarea name="concerns_text" rows="4"
                                          class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition"
                                          placeholder="1 baris = 1 poin">{{ old('concerns_text') }}</textarea>
                            </div>

                            <div>
                                <label class="text-xs font-medium text-gray-700">Pertanyaan Interview</label>
                                <textarea name="questions_text" rows="4"
                                          class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition"
                                          placeholder="1 baris = 1 poin">{{ old('questions_text') }}</textarea>
                            </div>

                            <div>
                                <label class="text-xs font-medium text-gray-700">Next Step</label>
                                <textarea name="next_steps_text" rows="4"
                                          class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition"
                                          placeholder="1 baris = 1 poin">{{ old('next_steps_text') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="text-xs font-medium text-gray-700">Stage</label>
                                    <input type="text" name="stage" value="{{ old('stage') }}"
                                           class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition"
                                           placeholder="Contoh: Screening / Interview 1">
                                </div>

                                <div>
                                    <label class="text-xs font-medium text-gray-700">Follow-up</label>
                                    <input type="date" name="follow_up_at" value="{{ old('follow_up_at') }}"
                                           class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition">
                                </div>
                            </div>

                            <button type="submit"
                                    class="w-full inline-flex items-center justify-center rounded-2xl bg-gray-900 px-5 py-3 text-sm font-medium text-white hover:bg-black transition shadow-sm">
                                Simpan
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-200 flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-900">Daftar Catatan</p>
                                <p class="mt-1 text-xs text-gray-600">Edit catatan tanpa pindah halaman.</p>
                            </div>
                            <p class="text-xs text-gray-500">{{ $countAll }} catatan</p>
                        </div>

                        <div class="p-6 space-y-4">
                            @forelse($notes as $n)
                                <div x-data="{ edit: false }" class="rounded-3xl border border-gray-200 bg-white overflow-hidden">
                                    <div class="p-5">
                                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $n->title ?: 'Catatan Internal' }}</p>
                                                <p class="mt-1 text-xs text-gray-600">
                                                    {{ $n->created_at->format('d M Y, H:i') }}
                                                    @if($n->creator) • {{ $n->creator->name }} @endif
                                                </p>

                                                <div class="mt-3 flex flex-wrap gap-2">
                                                    @if($n->rating)
                                                        <span class="inline-flex text-xs px-3 py-1 rounded-full border font-medium {{ $badgeClass($n->rating, 'rating') }}">
                                                            Rating {{ $n->rating }}/5
                                                        </span>
                                                    @endif
                                                    @if($n->recommendation)
                                                        <span class="inline-flex text-xs px-3 py-1 rounded-full border font-medium {{ $badgeClass($n->recommendation, 'recommendation') }}">
                                                            {{ $n->recommendation }}
                                                        </span>
                                                    @endif
                                                    @if($n->stage)
                                                        <span class="inline-flex text-xs px-3 py-1 rounded-full border font-medium border-gray-200 bg-gray-50 text-gray-800">
                                                            {{ $n->stage }}
                                                        </span>
                                                    @endif
                                                    @if($n->follow_up_at)
                                                        <span class="inline-flex text-xs px-3 py-1 rounded-full border font-medium {{ $badgeClass('x', 'followup') }}">
                                                            Follow-up: {{ $n->follow_up_at->format('d M Y') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <button type="button"
                                                        @click="edit = !edit"
                                                        class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-4 py-2 text-xs font-medium text-gray-900 hover:bg-gray-50 transition">
                                                    <span x-text="edit ? 'Tutup' : 'Edit'"></span>
                                                </button>

                                                <form method="POST" action="{{ route('hrd.internal_notes.destroy', $n->id) }}"
                                                      onsubmit="return confirm('Hapus catatan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center justify-center rounded-2xl bg-red-600 px-4 py-2 text-xs font-medium text-white hover:bg-red-700 transition">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="mt-4" x-show="!edit">
                                            <div class="text-sm text-gray-800 whitespace-pre-line">
                                                {{ $n->summary ?: '—' }}
                                            </div>

                                            <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                                <div class="rounded-3xl border border-gray-200 bg-gray-50 p-4">
                                                    <p class="text-xs font-semibold text-gray-900">Kelebihan</p>
                                                    @if($n->strengths && count($n->strengths))
                                                        <ul class="mt-2 list-disc list-inside text-gray-700 space-y-1">
                                                            @foreach($n->strengths as $it)
                                                                <li>{{ $it }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <p class="mt-2 text-gray-600">—</p>
                                                    @endif
                                                </div>

                                                <div class="rounded-3xl border border-gray-200 bg-gray-50 p-4">
                                                    <p class="text-xs font-semibold text-gray-900">Concern/Risiko</p>
                                                    @if($n->concerns && count($n->concerns))
                                                        <ul class="mt-2 list-disc list-inside text-gray-700 space-y-1">
                                                            @foreach($n->concerns as $it)
                                                                <li>{{ $it }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <p class="mt-2 text-gray-600">—</p>
                                                    @endif
                                                </div>

                                                <div class="rounded-3xl border border-gray-200 bg-gray-50 p-4">
                                                    <p class="text-xs font-semibold text-gray-900">Pertanyaan Interview</p>
                                                    @if($n->questions && count($n->questions))
                                                        <ul class="mt-2 list-disc list-inside text-gray-700 space-y-1">
                                                            @foreach($n->questions as $it)
                                                                <li>{{ $it }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <p class="mt-2 text-gray-600">—</p>
                                                    @endif
                                                </div>

                                                <div class="rounded-3xl border border-gray-200 bg-gray-50 p-4">
                                                    <p class="text-xs font-semibold text-gray-900">Next Step</p>
                                                    @if($n->next_steps && count($n->next_steps))
                                                        <ul class="mt-2 list-disc list-inside text-gray-700 space-y-1">
                                                            @foreach($n->next_steps as $it)
                                                                <li>{{ $it }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <p class="mt-2 text-gray-600">—</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4" x-show="edit">
                                            <form method="POST" action="{{ route('hrd.internal_notes.update', $n->id) }}" class="space-y-4">
                                                @csrf
                                                @method('PUT')

                                                <div>
                                                    <label class="text-xs font-medium text-gray-700">Judul</label>
                                                    <input type="text" name="title" value="{{ $n->title }}"
                                                           class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition">
                                                </div>

                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="text-xs font-medium text-gray-700">Rating</label>
                                                        <select name="rating"
                                                                class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition">
                                                            <option value="">—</option>
                                                            @for($i=1; $i<=5; $i++)
                                                                <option value="{{ $i }}" @selected((int) $n->rating === $i)>{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>

                                                    <div>
                                                        <label class="text-xs font-medium text-gray-700">Rekomendasi</label>
                                                        <select name="recommendation"
                                                                class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition">
                                                            <option value="">—</option>
                                                            @foreach(['Shortlist','Hold','Reject','Hire'] as $r)
                                                                <option value="{{ $r }}" @selected($n->recommendation === $r)>{{ $r }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div>
                                                    <label class="text-xs font-medium text-gray-700">Ringkasan</label>
                                                    <textarea name="summary" rows="5"
                                                              class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition">{{ $n->summary }}</textarea>
                                                </div>

                                                <div>
                                                    <label class="text-xs font-medium text-gray-700">Kelebihan</label>
                                                    <textarea name="strengths_text" rows="4"
                                                              class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition">{{ $toLines($n->strengths) }}</textarea>
                                                </div>

                                                <div>
                                                    <label class="text-xs font-medium text-gray-700">Concern/Risiko</label>
                                                    <textarea name="concerns_text" rows="4"
                                                              class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition">{{ $toLines($n->concerns) }}</textarea>
                                                </div>

                                                <div>
                                                    <label class="text-xs font-medium text-gray-700">Pertanyaan Interview</label>
                                                    <textarea name="questions_text" rows="4"
                                                              class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition">{{ $toLines($n->questions) }}</textarea>
                                                </div>

                                                <div>
                                                    <label class="text-xs font-medium text-gray-700">Next Step</label>
                                                    <textarea name="next_steps_text" rows="4"
                                                              class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition">{{ $toLines($n->next_steps) }}</textarea>
                                                </div>

                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="text-xs font-medium text-gray-700">Stage</label>
                                                        <input type="text" name="stage" value="{{ $n->stage }}"
                                                               class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition">
                                                    </div>

                                                    <div>
                                                        <label class="text-xs font-medium text-gray-700">Follow-up</label>
                                                        <input type="date" name="follow_up_at" value="{{ $n->follow_up_at?->format('Y-m-d') }}"
                                                               class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition">
                                                    </div>
                                                </div>

                                                <div class="flex justify-end gap-2 pt-2">
                                                    <button type="button"
                                                            @click="edit = false"
                                                            class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-5 py-3 text-xs font-medium text-gray-900 hover:bg-gray-50 transition">
                                                        Batal
                                                    </button>
                                                    <button type="submit"
                                                            class="inline-flex items-center justify-center rounded-2xl bg-gray-900 px-5 py-3 text-xs font-medium text-white hover:bg-black transition shadow-sm">
                                                        Simpan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-3xl border border-gray-200 bg-gray-50 px-5 py-4 text-sm text-gray-700">
                                    Belum ada catatan internal.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
