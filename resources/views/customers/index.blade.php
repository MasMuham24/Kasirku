@extends('layouts.app')

@section('title', 'Pelanggan')
@section('page-title', 'Daftar Pelanggan')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Pelanggan</h1>
            <p class="text-slate-500 text-sm mt-1">Data pelanggan untuk kemudahan transaksi.</p>
        </div>
        <a href="{{ route('customers.create') }}" class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-xl transition-all shadow-lg shadow-indigo-200 group">
            <svg class="w-5 h-5 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Pelanggan
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest w-16">#</th>
                        <th class="px-8 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">Nama Pelanggan</th>
                        <th class="px-8 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">Kontak</th>
                        <th class="px-8 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">Alamat</th>
                        <th class="px-8 py-4 text-right text-[11px] font-bold text-slate-400 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($customers as $customer)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-5 whitespace-nowrap text-sm font-medium text-slate-400">{{ $loop->iteration }}</td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500 font-bold">
                                        {{ substr($customer->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-bold text-slate-900">{{ $customer->name }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex flex-col gap-1">
                                    <span class="text-sm font-medium text-slate-700">{{ $customer->phone ?? 'Tidak ada nomor' }}</span>
                                    <span class="text-xs text-slate-400">{{ $customer->email ?? 'Tidak ada email' }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-sm text-slate-500 max-w-xs truncate">{{ $customer->address ?? '-' }}</td>
                            <td class="px-8 py-5 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('customers.edit', $customer) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.4-9.4a2.12 2.12 0 013 3L12 15l-4 1 1-4 9.6-9.4z"/></svg>
                                    </a>
                                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all" title="Hapus" 
                                            onclick="Swal.fire({
                                                title: 'Hapus Pelanggan?', 
                                                text: 'Data pelanggan ini tidak dapat dikembalikan.', 
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
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.36-1.86M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.36-1.86M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                    <p class="text-slate-400 text-sm font-medium">Belum ada pelanggan terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
