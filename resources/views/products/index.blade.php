@extends('layouts.app')

@section('title', 'Produk')
@section('page-title', 'Daftar Produk')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Produk</h1>
        <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Produk
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga Beli</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga Jual</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $product->code }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $product->category->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 text-right">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700 text-right">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm text-right">
                                <span class="{{ $product->stock <= $product->minimum_stock ? 'text-red-600 font-semibold' : 'text-gray-700' }}">
                                    {{ $product->stock }} {{ $product->unit }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                @if ($product->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-right whitespace-nowrap space-x-2">
                                <a href="{{ route('products.edit', $product) }}" class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.4-9.4a2.12 2.12 0 013 3L12 15l-4 1 1-4 9.6-9.4z"/></svg>
                                    Edit
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="inline-flex items-center gap-1 text-red-600 hover:text-red-800" onclick="Swal.fire({title: 'Yakin?', text: 'Anda yakin ingin menghapus produk ini?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal'}).then((result) => { if (result.isConfirmed) { this.form.submit(); } })">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-sm text-gray-400">Belum ada produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
