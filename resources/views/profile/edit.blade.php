@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between mb-8">
            <div class="min-w-0">
                <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Pengaturan Akun</h1>
                <p class="mt-1 text-sm text-gray-600">Kelola data profil, keamanan, dan penghapusan akun.</p>
            </div>

            <a href="{{ route('dashboard') }}"
               class="text-sm text-gray-900 underline underline-offset-4 hover:text-gray-700">
                ← Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <aside class="lg:col-span-1">
                <div class="bg-white border border-gray-200 rounded-3xl shadow-sm p-6">
                    <p class="text-sm font-semibold text-gray-900">Ringkasan</p>
                    <p class="mt-1 text-xs text-gray-600">Update akun kamu di sini.</p>

                    <div class="mt-5 space-y-3">
                        <a href="#profile"
                           class="block rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900 hover:bg-gray-100 transition">
                            Profil
                        </a>
                        <a href="#security"
                           class="block rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900 hover:bg-gray-100 transition">
                            Keamanan
                        </a>
                        <a href="#danger"
                           class="block rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700 hover:bg-red-100 transition">
                            Hapus Akun
                        </a>
                    </div>

                    <div class="mt-6 rounded-3xl border border-gray-200 bg-white p-5">
                        <p class="text-xs text-gray-600">Tips</p>
                        <p class="mt-2 text-sm font-semibold text-gray-900">Gunakan password kuat</p>
                        <p class="mt-1 text-xs text-gray-600">Minimal 8 karakter + kombinasi huruf & angka.</p>
                    </div>
                </div>
            </aside>

            <main class="lg:col-span-2 space-y-6">
                <section id="profile" class="bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <p class="text-sm font-semibold text-gray-900">Profil</p>
                        <p class="mt-1 text-xs text-gray-600">Perbarui nama, email, dan informasi akun.</p>
                    </div>
                    <div class="p-6">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </section>

                <section id="security" class="bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <p class="text-sm font-semibold text-gray-900">Keamanan</p>
                        <p class="mt-1 text-xs text-gray-600">Ganti password untuk menjaga akun tetap aman.</p>
                    </div>
                    <div class="p-6">
                        @include('profile.partials.update-password-form')
                    </div>
                </section>

                <section id="danger" class="bg-white border border-red-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-red-200 bg-red-50">
                        <p class="text-sm font-semibold text-red-700">Zona Berbahaya</p>
                        <p class="mt-1 text-xs text-red-600">Aksi ini bersifat permanen dan tidak bisa dibatalkan.</p>
                    </div>
                    <div class="p-6">
                        @include('profile.partials.delete-user-form')
                    </div>
                </section>
            </main>
        </div>
    </div>
</div>
@endsection
