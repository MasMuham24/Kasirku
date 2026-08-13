@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Tambah Kategori</h1>
            <p class="text-slate-500 text-sm mt-1">Tambahkan kategori baru untuk pengelompokan produk.</p>
        </div>
        <a href="{{ route('categories.index') }}" class="inline-flex items-center justify-center gap-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold px-5 py-2.5 rounded-xl transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <div class="max-w-3xl">
        <form action="{{ route('categories.store') }}" method="POST" class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
            @csrf

            <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2 border-b border-slate-100 pb-4">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v6a4 4 0 004 4h10a4 4 0 004-4V7M3 7a4 4 0 008 0M3 7a4 4 0 018 0m0 0a4 4 0 008 0m0 0a4 4 0 018 0m0 0a4 4 0 018 0"/></svg>
                Informasi Kategori
            </h2>

            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nama Kategori <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-medium focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-slate-50 focus:bg-white text-slate-900 placeholder:text-slate-400"
                           placeholder="Contoh: Makanan Ringan, Minuman Dingin..."
                           required>
                    @error('name')
                        <p class="mt-2 text-xs font-medium text-rose-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Deskripsi (Opsional)</label>
                    <textarea name="description" id="description" rows="4"
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-medium focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-slate-50 focus:bg-white text-slate-900 placeholder:text-slate-400 resize-none"
                              placeholder="Keterangan lebih lanjut mengenai kategori ini...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-xs font-medium text-rose-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('categories.index') }}" class="px-6 py-2.5 text-sm font-bold text-slate-500 hover:text-slate-800 transition-colors">Batal</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-8 py-2.5 rounded-xl transition-all shadow-lg shadow-indigo-200 flex items-center gap-2 group">
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-y-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
@endsection
