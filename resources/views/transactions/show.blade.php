@extends('layouts.app')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Transaksi {{ $transaction->invoice_number }}</h1>
        <div class="flex items-center gap-3">
            <a href="{{ route('transactions.index') }}" class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-4 py-2 rounded-lg transition">
                Kembali
            </a>
            <a href="{{ route('transactions.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                Transaksi Baru
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h2 class="text-base font-semibold mb-4">Item</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Qty</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Diskon</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($transaction->details as $detail)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-800">
                                    {{ $detail->product->name ?? 'Produk dihapus' }}
                                    <span class="text-gray-400 text-xs">({{ $detail->product->code ?? '-' }})</span>
                                </td>
                                <td class="px-4 py-3 text-sm text-center text-gray-600">{{ $detail->quantity }} {{ $detail->product->unit ?? '' }}</td>
                                <td class="px-4 py-3 text-sm text-right text-gray-600">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-sm text-right text-gray-600">Rp {{ number_format($detail->discount, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h2 class="text-base font-semibold mb-4">Ringkasan</h2>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500">Subtotal</dt>
                    <dd class="font-medium">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Diskon</dt>
                    <dd class="font-medium text-red-600">- Rp {{ number_format($transaction->discount, 0, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Pajak</dt>
                    <dd class="font-medium">+ Rp {{ number_format($transaction->tax, 0, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between border-t border-gray-200 pt-2">
                    <dt class="font-semibold">Total</dt>
                    <dd class="font-semibold text-lg">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Dibayar</dt>
                    <dd class="font-medium">Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Kembalian</dt>
                    <dd class="font-medium">Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Tanggal</p>
            <p class="text-sm font-medium">{{ $transaction->transaction_date->format('d M Y H:i') }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Pelanggan</p>
            <p class="text-sm font-medium">{{ $transaction->customer->name ?? 'Umum' }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Metode & Status</p>
            <p class="text-sm font-medium uppercase">
                {{ $transaction->payment_method }} -
                @if ($transaction->payment_status === 'paid')
                    <span class="text-green-600">Lunas</span>
                @elseif ($transaction->payment_status === 'partial')
                    <span class="text-yellow-600">Sebagian</span>
                @else
                    <span class="text-red-600">Belum Lunas</span>
                @endif
            </p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Kasir</p>
            <p class="text-sm font-medium">{{ $transaction->user->name ?? '-' }}</p>
        </div>
    </div>

    @if ($transaction->notes)
        <div class="mt-6 bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Catatan</p>
            <p class="text-sm">{{ $transaction->notes }}</p>
        </div>
    @endif
@endsection
