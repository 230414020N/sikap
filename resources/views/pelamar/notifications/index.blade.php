@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="mb-8">
                <h1 class="text-2xl font-semibold text-gray-900">Notifikasi</h1>
                <p class="mt-1 text-sm text-gray-600">Update status lamaran kamu akan muncul di sini.</p>
            </div>

            <div class="space-y-3">
                @forelse($notifications as $n)
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $n->data['title'] ?? 'Notifikasi' }}
                                </p>
                                <p class="mt-1 text-sm text-gray-700">
                                    {{ $n->data['message'] ?? '-' }}
                                </p>
                                @if(!empty($n->data['note']))
                                    <p class="mt-2 text-sm text-gray-600 whitespace-pre-line">
                                        Catatan: {{ $n->data['note'] }}
                                    </p>
                                @endif
                                <p class="mt-2 text-xs text-gray-500">
                                    {{ $n->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>

                            <div class="flex items-center gap-2">
                                @if($n->read_at)
                                    <span class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-700 border border-gray-200">
                                        Read
                                    </span>
                                @else
                                    <form method="POST" action="{{ route('pelamar.notifications.read', $n->id) }}">
                                        @csrf
                                        <button class="rounded-xl bg-black px-4 py-2 text-xs font-medium text-white hover:bg-gray-900">
                                            Mark as read
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-10 text-center text-gray-600">
                        Belum ada notifikasi.
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
@endsection
