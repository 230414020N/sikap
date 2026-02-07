@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-[#E5E7EB]">
    <aside class="w-64 bg-[#E5E7EB] border-r border-gray-300 hidden md:flex flex-col p-6 sticky top-0 h-screen">
        <div class="mb-10 px-2 font-bold text-2xl tracking-tighter italic text-gray-900">
            SIKAP<span class="text-xs font-normal align-top not-italic">.</span>
        </div>
        <nav class="flex-1 space-y-2 text-sm font-medium">
            <a href="{{ route('pelamar.jobs.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-200 transition">
                <span>🔍</span> Cari Lowongan
            </a>
            <a href="{{ route('pelamar.notifications.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 bg-[#4B4B4B] text-white shadow-md transition">
                <span>🔔</span> Notifikasi
            </a>
        </nav>
    </aside>

    <main class="flex-1 bg-[#4B4B4B] p-6 lg:p-10 overflow-y-auto">
        <header class="flex justify-between items-center mb-10 text-white">
            <div>
                <h1 class="text-4xl font-black uppercase tracking-tight">Pemberitahuan Anda!</h1>
                <p class="text-sm opacity-70">Update status lamaran kamu akan muncul di sini.</p>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm font-bold italic">{{ Auth::user()->name ?? '(nama user)' }}</span>
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-gray-900">
                    👤
                </div>
            </div>
        </header>

        <div class="max-w-5xl mx-auto space-y-4">
            @forelse($notifications as $n)
                <div class="bg-white rounded-[32px] p-8 shadow-sm transition-all hover:shadow-xl border-l-8 {{ $n->read_at ? 'border-gray-200' : 'border-[#00D1A0]' }}">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="text-[10px] font-black uppercase tracking-widest px-3 py-1 bg-gray-900 text-white rounded-full">
                                    {{ $n->data['title'] ?? 'Notifikasi' }}
                                </span>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">
                                    {{ $n->created_at->diffForHumans() }}
                                </span>
                            </div>
                            
                            <h3 class="text-xl font-black text-gray-900 mb-1">
                                {{ $n->data['message'] ?? '-' }}
                            </h3>

                            @if(!empty($n->data['note']))
                                <div class="mt-3 p-4 bg-gray-50 rounded-2xl border border-gray-100 italic text-sm text-gray-600">
                                    <span class="font-bold not-italic text-gray-900 block mb-1">Catatan HRD:</span>
                                    "{{ $n->data['note'] }}"
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-3 shrink-0">
                            @if($n->read_at)
                                <span class="text-[10px] font-bold text-gray-400 border border-gray-200 px-4 py-2 rounded-xl uppercase">
                                    Dibaca pada {{ $n->read_at->format('d/m/Y') }}
                                </span>
                            @else
                                <form method="POST" action="{{ route('pelamar.notifications.read', $n->id) }}">
                                    @csrf
                                    <button class="bg-[#00D1A0] hover:bg-emerald-400 text-gray-900 text-xs font-black uppercase tracking-widest px-6 py-3 rounded-xl transition-all shadow-md active:scale-95">
                                        Tandai Dibaca
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-32 text-white/50 italic">
                    <div class="text-6xl mb-6 opacity-20">🔔</div>
                    <p class="text-2xl font-bold tracking-tight">Belum Ada Pemberitahuan</p>
                </div>
            @endforelse

            <div class="mt-10 flex justify-center custom-pagination">
                {{ $notifications->links() }}
            </div>
        </div>

        <footer class="mt-20 text-center text-gray-400 text-xs py-6">
            © 2026, Sistem Informasi Karier dan Portofolio (SIKAP)
        </footer>
    </main>
</div>

<style>
    /* Menyesuaikan pagination Laravel agar cocok dengan tema gelap */
    .custom-pagination nav svg { height: 1.5rem; }
    .custom-pagination nav p { color: #9CA3AF; margin-right: 1rem; }
</style>
@endsection