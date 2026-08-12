@extends('layouts.app')

@section('title', 'Transaksi Baru')
@section('page-title', 'Transaksi Baru')

@section('content')
    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
            <h2 class="text-base font-semibold mb-4">Informasi Transaksi</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">Pelanggan</label>
                    <select name="customer_id" id="customer_id"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Umum</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="transaction_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="transaction_date" id="transaction_date" value="{{ old('transaction_date', now()->format('Y-m-d\TH:i')) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           required>
                    @error('transaction_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran <span class="text-red-500">*</span></label>
                    <select name="payment_method" id="payment_method"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                        @foreach (['cash' => 'Tunai', 'transfer' => 'Transfer', 'qris' => 'QRIS', 'debit' => 'Debit', 'credit' => 'Kredit'] as $value => $label)
                            <option value="{{ $value }}" {{ old('payment_method', 'cash') === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('payment_method')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                    <input type="text" name="notes" id="notes" value="{{ old('notes') }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-semibold">Item Produk</h2>
                <button type="button" id="add-item" class="inline-flex items-center gap-2 bg-gray-800 hover:bg-gray-900 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Tambah Item
                </button>
            </div>

            @error('details')
                <p class="mb-3 text-sm text-red-600">{{ $message }}</p>
            @enderror

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Qty</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Diskon</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Subtotal</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody id="items-body" class="divide-y divide-gray-100"></tbody>
                </table>
            </div>

            <div class="mt-4 max-w-xs ml-auto space-y-2 text-sm">
                <div class="flex items-center justify-between">
                    <span class="text-gray-500">Subtotal</span>
                    <span id="subtotal-display" class="font-semibold">Rp 0</span>
                </div>
                <div class="flex items-center justify-between">
                    <label for="discount" class="text-gray-500">Diskon Transaksi</label>
                    <input type="number" name="discount" id="discount" value="{{ old('discount', 0) }}" min="0" step="0.01"
                           class="w-32 rounded-lg border border-gray-300 px-3 py-1.5 text-sm text-right focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="flex items-center justify-between">
                    <label for="tax" class="text-gray-500">Pajak</label>
                    <input type="number" name="tax" id="tax" value="{{ old('tax', 0) }}" min="0" step="0.01"
                           class="w-32 rounded-lg border border-gray-300 px-3 py-1.5 text-sm text-right focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="flex items-center justify-between border-t border-gray-200 pt-2">
                    <span class="font-semibold">Total</span>
                    <span id="grand-total-display" class="font-semibold text-lg">Rp 0</span>
                </div>
                <div class="flex items-center justify-between">
                    <label for="paid_amount" class="text-gray-500">Bayar <span class="text-red-500">*</span></label>
                    <input type="number" name="paid_amount" id="paid_amount" value="{{ old('paid_amount') }}" min="0" step="0.01"
                           class="w-32 rounded-lg border border-gray-300 px-3 py-1.5 text-sm text-right focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           required>
                </div>
                @error('paid_amount')
                    <p class="text-red-600 text-xs">{{ $message }}</p>
                @enderror
                <div class="flex items-center justify-between">
                    <span class="text-gray-500">Kembalian</span>
                    <span id="change-display" class="font-semibold">Rp 0</span>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('transactions.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">Batal</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">Simpan Transaksi</button>
        </div>
    </form>

    <script>
        const products = @json($productsData);

        const formatRupiah = (n) => 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(n));

        const recalc = () => {
            let subtotal = 0;
            document.querySelectorAll('#items-body tr').forEach((row) => {
                const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
                const price = parseFloat(row.querySelector('.item-price').value) || 0;
                const discount = parseFloat(row.querySelector('.item-discount').value) || 0;
                const s = (qty * price) - discount;
                row.querySelector('.item-subtotal').textContent = formatRupiah(s);
                subtotal += s;
            });
            const discount = parseFloat(document.getElementById('discount').value) || 0;
            const tax = parseFloat(document.getElementById('tax').value) || 0;
            const grandTotal = subtotal - discount + tax;
            const paid = parseFloat(document.getElementById('paid_amount').value) || 0;

            document.getElementById('subtotal-display').textContent = formatRupiah(subtotal);
            document.getElementById('grand-total-display').textContent = formatRupiah(grandTotal);
            document.getElementById('change-display').textContent = formatRupiah(Math.max(0, paid - grandTotal));
        };

        const productOptions = (selected) =>
            '<option value="">-- Pilih Produk --</option>' +
            products.map((p) =>
                `<option value="${p.id}" data-price="${p.price}" ${selected == p.id ? 'selected' : ''}>${p.name} (${p.code})</option>`
            ).join('');

        const addRow = (values = {}) => {
            const tr = document.createElement('tr');

            tr.innerHTML = `
                <td class="px-4 py-3">
                    <select name="details[__idx__][product_id]" class="item-product w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                        ${productOptions(values.product_id)}
                    </select>
                </td>
                <td class="px-4 py-3 w-24">
                    <input type="number" name="details[__idx__][quantity]" class="item-qty w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-right focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="${values.quantity || 1}" min="1" required>
                </td>
                <td class="px-4 py-3 w-40">
                    <input type="number" name="details[__idx__][price]" class="item-price w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-right focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="${values.price || 0}" min="0" step="0.01" required>
                </td>
                <td class="px-4 py-3 w-32">
                    <input type="number" name="details[__idx__][discount]" class="item-discount w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-right focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="${values.discount || 0}" min="0" step="0.01">
                </td>
                <td class="px-4 py-3 text-right text-sm font-medium item-subtotal">Rp 0</td>
                <td class="px-4 py-3">
                    <button type="button" class="remove-item inline-flex items-center text-red-600 hover:text-red-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </td>
            `;

            tr.querySelectorAll('select, input').forEach((el) => {
                el.name = el.name.replace('__idx__', document.querySelectorAll('#items-body tr').length);
            });

            const select = tr.querySelector('.item-product');
            const priceInput = tr.querySelector('.item-price');

            select.addEventListener('change', () => {
                const opt = select.options[select.selectedIndex];
                if (opt.dataset.price) priceInput.value = opt.dataset.price;
                recalc();
            });
            tr.querySelectorAll('.item-qty, .item-price, .item-discount').forEach((el) =>
                el.addEventListener('input', recalc)
            );
            tr.querySelector('.remove-item').addEventListener('click', () => {
                tr.remove();
                recalc();
            });

            document.getElementById('items-body').appendChild(tr);
            recalc();
        };

        const oldDetails = @json(old('details', []));

        if (oldDetails.length > 0) {
            oldDetails.forEach((d) => addRow(d));
        } else {
            addRow();
        }

        document.getElementById('add-item').addEventListener('click', () => addRow());
        document.getElementById('discount').addEventListener('input', recalc);
        document.getElementById('tax').addEventListener('input', recalc);
        document.getElementById('paid_amount').addEventListener('input', recalc);
    </script>
@endsection
