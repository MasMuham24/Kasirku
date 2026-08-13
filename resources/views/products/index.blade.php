@extends('layouts.app')

@section('title', 'Produk')
@section('page-title', 'Daftar Produk')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Produk</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola data inventori produk jualan Anda.</p>
        </div>
        <a href="{{ route('products.create') }}" class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-xl transition-all shadow-lg shadow-indigo-200 group">
            <svg class="w-5 h-5 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Produk
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">Produk</th>
                        <th class="px-8 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">Kategori</th>
                        <th class="px-8 py-4 text-right text-[11px] font-bold text-slate-400 uppercase tracking-widest">Harga Jual</th>
                        <th class="px-8 py-4 text-right text-[11px] font-bold text-slate-400 uppercase tracking-widest">Stok</th>
                        <th class="px-8 py-4 text-center text-[11px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-4 text-right text-[11px] font-bold text-slate-400 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($products as $product)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">{{ $product->name }}</p>
                                        <p class="text-[11px] text-slate-400 font-mono">{{ $product->code }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-medium bg-slate-100 text-slate-600">
                                    {{ $product->category->name ?? 'Tanpa Kategori' }}
                                </span>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-right">
                                <span class="text-sm font-bold text-slate-900">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-right">
                                <span class="inline-flex items-center gap-1.5 {{ $product->stock <= $product->minimum_stock ? 'text-rose-600 font-bold bg-rose-50 px-2 py-0.5 rounded-md' : 'text-slate-600 font-medium' }}">
                                    {{ $product->stock }} {{ $product->unit }}
                                    @if($product->stock <= $product->minimum_stock)
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    @endif
                                </span>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-center">
                                @if ($product->is_active)
                                    <span class="inline-flex items-center w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_0_4px_rgba(16,185,129,0.1)]"></span>
                                @else
                                    <span class="inline-flex items-center w-2 h-2 rounded-full bg-slate-300 shadow-[0_0_0_4px_rgba(203,213,225,0.2)]"></span>
                                @endif
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('products.edit', $product) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.4-9.4a2.12 2.12 0 013 3L12 15l-4 1 1-4 9.6-9.4z"/></svg>
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all" title="Hapus" 
                                            onclick="Swal.fire({
                                                title: 'Hapus Produk?', 
                                                text: 'Data produk tidak dapat dikembalikan.', 
                                                icon: 'warning', 
                                                showCancelButton: true, 
                                                confirmButtonColor: '#4f46e5', 
                                                cancelButtonColor: '#f43f5e', 
                                                confirmButtonText: 'Ya, hapus!', 
                                                cancelButtonText: 'Batal',
                                                customClass: {
                                                    popup: 'rounded-3xl border-none',
                                                    confirmButton: 'rounded-xl px-5 py-2.5 font-semibold text-sm',
                                                    cancelButton: 'rounded-xl px-5 py-2.5 font-semibold text-sm'
                                                }
                                            }).then((result) => { if (result.isConfirmed) { this.form.submit(); } })">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    </div>
                                    <p class="text-slate-400 text-sm font-medium">Belum ada produk diinventaris.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
