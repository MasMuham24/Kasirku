@extends('layouts.app')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Transaksi <span class="text-indigo-600">#{{ $transaction->invoice_number }}</span></h1>
            <p class="text-slate-500 text-sm mt-1">Detail rincian transaksi dan pembayaran.</p>
        </div>
        <div class="flex items-center gap-3 no-print">
            <button onclick="window.print()" class="inline-flex items-center justify-center gap-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold px-5 py-2.5 rounded-xl transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Struk
            </button>
            <a href="{{ route('transactions.index') }}" class="inline-flex items-center justify-center gap-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold px-5 py-2.5 rounded-xl transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
            <a href="{{ route('transactions.create') }}" class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-xl transition-all shadow-lg shadow-indigo-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Transaksi Baru
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
            <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                Rincian Item
            </h2>
            <div class="overflow-x-auto -mx-8 px-8">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-4 py-3 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest rounded-l-xl">Produk</th>
                            <th class="px-4 py-3 text-center text-[11px] font-bold text-slate-400 uppercase tracking-widest">Qty</th>
                            <th class="px-4 py-3 text-right text-[11px] font-bold text-slate-400 uppercase tracking-widest">Harga</th>
                            <th class="px-4 py-3 text-right text-[11px] font-bold text-slate-400 uppercase tracking-widest">Diskon</th>
                            <th class="px-4 py-3 text-right text-[11px] font-bold text-slate-400 uppercase tracking-widest rounded-r-xl">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($transaction->details as $detail)
                            <tr class="group hover:bg-slate-50/30 transition-colors">
                                <td class="px-4 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-900">{{ $detail->product->name ?? 'Produk dihapus' }}</span>
                                        <span class="text-xs text-slate-400 font-mono mt-0.5">{{ $detail->product->code ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex items-center justify-center min-w-[2.5rem] h-8 px-2 rounded-lg bg-slate-100 text-slate-700 text-sm font-bold">
                                        {{ $detail->quantity }}<span class="text-[10px] ml-1 font-normal text-slate-500">{{ $detail->product->unit ?? '' }}</span>
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-right text-sm text-slate-600 font-medium">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                <td class="px-4 py-4 text-right text-sm text-rose-500 font-medium">{{ $detail->discount > 0 ? '-Rp ' . number_format($detail->discount, 0, ',', '.') : '-' }}</td>
                                <td class="px-4 py-4 text-right">
                                    <span class="text-sm font-bold text-slate-900">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 flex flex-col">
            <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Ringkasan Biaya
            </h2>
            <dl class="space-y-4 flex-1">
                <div class="flex justify-between items-center text-sm">
                    <dt class="text-slate-500 font-medium">Subtotal</dt>
                    <dd class="font-bold text-slate-700">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</dd>
                </div>
                @if($transaction->discount > 0)
                <div class="flex justify-between items-center text-sm">
                    <dt class="text-slate-500 font-medium">Diskon Tambahan</dt>
                    <dd class="font-bold text-rose-500">- Rp {{ number_format($transaction->discount, 0, ',', '.') }}</dd>
                </div>
                @endif
                @if($transaction->tax > 0)
                <div class="flex justify-between items-center text-sm">
                    <dt class="text-slate-500 font-medium">Pajak</dt>
                    <dd class="font-bold text-slate-700">+ Rp {{ number_format($transaction->tax, 0, ',', '.') }}</dd>
                </div>
                @endif
                <div class="flex justify-between items-end border-t border-slate-100 pt-4 mt-4">
                    <dt class="text-sm font-bold text-slate-900 uppercase tracking-wide">Total Pembayaran</dt>
                    <dd class="text-2xl font-bold text-indigo-600 tracking-tight">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</dd>
                </div>
                
                <div class="bg-slate-50 rounded-2xl p-4 mt-6 space-y-3">
                    <div class="flex justify-between items-center text-sm">
                        <dt class="text-slate-500 font-medium">Uang Diterima</dt>
                        <dd class="font-bold text-slate-700">Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</dd>
                    </div>
                    <div class="flex justify-between items-center text-sm pt-3 border-t border-slate-200">
                        <dt class="text-slate-500 font-medium">Kembalian</dt>
                        <dd class="font-bold text-slate-700">Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</dd>
                    </div>
                </div>
            </dl>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center flex-shrink-0 text-indigo-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tanggal & Waktu</p>
                <p class="text-sm font-bold text-slate-900">{{ $transaction->transaction_date->format('d M Y') }}</p>
                <p class="text-xs font-medium text-slate-500">{{ $transaction->transaction_date->format('H:i') }} WIB</p>
            </div>
        </div>
        
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center flex-shrink-0 text-indigo-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Pelanggan</p>
                <p class="text-sm font-bold text-slate-900">{{ $transaction->customer->name ?? 'Pelanggan Umum' }}</p>
                @if($transaction->customer)
                    <p class="text-xs font-medium text-slate-500">{{ $transaction->customer->phone ?? '-' }}</p>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center flex-shrink-0 text-indigo-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Metode & Status</p>
                <p class="text-sm font-bold text-slate-900 uppercase">{{ $transaction->payment_method }}</p>
                <p class="text-xs font-medium mt-0.5">
                    @if ($transaction->payment_status === 'paid')
                        <span class="text-emerald-600">Lunas</span>
                    @elseif ($transaction->payment_status === 'partial')
                        <span class="text-amber-600">Sebagian</span>
                    @else
                        <span class="text-rose-600">Belum Lunas</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center flex-shrink-0 text-indigo-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Kasir Bertugas</p>
                <p class="text-sm font-bold text-slate-900">{{ $transaction->user->name ?? '-' }}</p>
            </div>
        </div>
    </div>

    @if ($transaction->notes)
        <div class="mt-6 bg-amber-50 rounded-3xl border border-amber-200 shadow-sm p-6 flex gap-4 items-start">
            <svg class="w-6 h-6 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p class="text-[11px] font-bold text-amber-600 uppercase tracking-widest mb-1.5">Catatan Transaksi</p>
                <p class="text-sm text-amber-900 font-medium">{{ $transaction->notes }}</p>
            </div>
        </div>
    @endif
@endsection
