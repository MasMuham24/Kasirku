@extends('layouts.app')

@section('title', 'Transaksi')
@section('page-title', 'Daftar Transaksi')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Transaksi</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola dan pantau semua riwayat transaksi penjualan.</p>
        </div>
        <a href="{{ route('transactions.create') }}" class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-xl transition-all shadow-lg shadow-indigo-200 group">
            <svg class="w-5 h-5 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Transaksi Baru
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">No. Invoice</th>
                        <th class="px-8 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-8 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">Pelanggan</th>
                        <th class="px-8 py-4 text-center text-[11px] font-bold text-slate-400 uppercase tracking-widest">Status Pembayaran</th>
                        <th class="px-8 py-4 text-right text-[11px] font-bold text-slate-400 uppercase tracking-widest">Total Transaksi</th>
                        <th class="px-8 py-4 text-right text-[11px] font-bold text-slate-400 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($transactions as $transaction)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-5 whitespace-nowrap">
                                <span class="text-sm font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg">{{ $transaction->invoice_number }}</span>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-sm text-slate-600">
                                {{ $transaction->transaction_date->format('d M Y') }}
                                <span class="block text-[10px] text-slate-400 font-medium">{{ $transaction->transaction_date->format('H:i') }} WIB</span>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-sm font-medium text-slate-700">
                                {{ $transaction->customer->name ?? 'Pelanggan Umum' }}
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-center">
                                @if ($transaction->payment_status === 'paid')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-700 uppercase tracking-wide">Lunas</span>
                                @elseif ($transaction->payment_status === 'partial')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-700 uppercase tracking-wide">Sebagian</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-rose-100 text-rose-700 uppercase tracking-wide">Belum Lunas</span>
                                @endif
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-right">
                                <span class="text-sm font-bold text-slate-900">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('transactions.show', $transaction) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all" title="Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all" title="Hapus"
                                            onclick="Swal.fire({
                                                title: 'Hapus Transaksi?',
                                                text: 'Stok produk akan dikembalikan otomatis.',
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
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                    </div>
                                    <p class="text-slate-400 text-sm font-medium">Belum ada transaksi tercatat.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
