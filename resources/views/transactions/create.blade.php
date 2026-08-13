@extends('layouts.app')

@section('title', 'Transaksi Baru')
@section('page-title', 'Transaksi Baru')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Transaksi Baru</h1>
            <p class="text-slate-500 text-sm mt-1">Buat transaksi penjualan baru dengan mudah.</p>
        </div>
    </div>

    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 mb-8">
            <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Informasi Transaksi
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <label for="customer_id" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Pelanggan</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <select name="customer_id" id="customer_id" class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-slate-50 focus:bg-white appearance-none cursor-pointer">
                            <option value="">Pelanggan Umum</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                    @error('customer_id')
                        <p class="mt-1.5 text-xs font-medium text-rose-500 flex items-center gap-1"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="transaction_date" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Tanggal & Waktu <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <input type="datetime-local" name="transaction_date" id="transaction_date" value="{{ old('transaction_date', now()->format('Y-m-d\TH:i')) }}"
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-slate-50 focus:bg-white"
                               required>
                    </div>
                    @error('transaction_date')
                        <p class="mt-1.5 text-xs font-medium text-rose-500 flex items-center gap-1"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="payment_method" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Metode Bayar <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </div>
                        <select name="payment_method" id="payment_method"
                                class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-slate-50 focus:bg-white appearance-none cursor-pointer"
                                required>
                            @foreach (['cash' => 'Tunai', 'transfer' => 'Transfer Bank', 'qris' => 'QRIS', 'debit' => 'Kartu Debit', 'credit' => 'Kartu Kredit'] as $value => $label)
                                <option value="{{ $value }}" {{ old('payment_method', 'cash') === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                    @error('payment_method')
                        <p class="mt-1.5 text-xs font-medium text-rose-500 flex items-center gap-1"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="notes" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Catatan (Opsional)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.4-9.4a2.12 2.12 0 013 3L12 15l-4 1 1-4 9.6-9.4z"/></svg>
                        </div>
                        <input type="text" name="notes" id="notes" value="{{ old('notes') }}" placeholder="Contoh: Pesanan untuk acara..."
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-slate-50 focus:bg-white placeholder:text-slate-300">
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
            <div class="p-6 md:p-8 flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    Daftar Item
                </h2>
                <button type="button" id="add-item" class="inline-flex items-center justify-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-4 py-2 rounded-xl transition-all text-sm group">
                    <div class="w-5 h-5 rounded-full bg-white flex items-center justify-center shadow-sm text-slate-500 group-hover:text-indigo-600 transition-colors">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    Tambah Item
                </button>
            </div>

            @error('details')
                <div class="px-8 py-3 bg-rose-50 border-b border-rose-100 text-sm font-medium text-rose-600 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </div>
            @enderror

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest min-w-[250px]">Produk</th>
                            <th class="px-4 py-4 text-center text-[11px] font-bold text-slate-400 uppercase tracking-widest w-28">Kuantitas</th>
                            <th class="px-4 py-4 text-right text-[11px] font-bold text-slate-400 uppercase tracking-widest w-40">Harga Satuan</th>
                            <th class="px-4 py-4 text-right text-[11px] font-bold text-slate-400 uppercase tracking-widest w-40">Diskon/Item</th>
                            <th class="px-6 py-4 text-right text-[11px] font-bold text-slate-400 uppercase tracking-widest w-40">Subtotal</th>
                            <th class="px-4 py-4 w-14"></th>
                        </tr>
                    </thead>
                    <tbody id="items-body" class="divide-y divide-slate-50"></tbody>
                </table>
            </div>

            <div class="bg-slate-50/50 p-6 md:p-8 flex flex-col md:flex-row justify-end border-t border-slate-100">
                <div class="w-full max-w-sm space-y-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-500 font-medium">Subtotal Item</span>
                        <span id="subtotal-display" class="font-bold text-slate-800">Rp 0</span>
                    </div>
                    
                    <div class="flex items-center justify-between text-sm group">
                        <label for="discount" class="text-slate-500 font-medium group-hover:text-slate-700 transition-colors cursor-pointer">Diskon Transaksi (Rp)</label>
                        <div class="relative w-32">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 pointer-events-none font-medium text-xs">Rp</span>
                            <input type="number" name="discount" id="discount" value="{{ old('discount', 0) }}" min="0" step="0.01"
                                   class="w-full pl-8 pr-3 py-1.5 rounded-lg border border-slate-200 text-sm font-semibold text-right focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-white text-rose-500">
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between text-sm group">
                        <label for="tax" class="text-slate-500 font-medium group-hover:text-slate-700 transition-colors cursor-pointer">Pajak Tambahan (Rp)</label>
                        <div class="relative w-32">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 pointer-events-none font-medium text-xs">Rp</span>
                            <input type="number" name="tax" id="tax" value="{{ old('tax', 0) }}" min="0" step="0.01"
                                   class="w-full pl-8 pr-3 py-1.5 rounded-lg border border-slate-200 text-sm font-semibold text-right focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-white text-slate-700">
                        </div>
                    </div>
                    
                    <div class="my-4 border-t border-slate-200 border-dashed"></div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-slate-900 uppercase tracking-widest">Total Pembayaran</span>
                        <span id="grand-total-display" class="text-2xl font-black text-indigo-600 tracking-tight">Rp 0</span>
                    </div>
                    
                    <div class="mt-6 p-5 bg-white rounded-2xl border border-slate-200 shadow-sm space-y-4 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-16 h-16 bg-indigo-50 rounded-bl-full -mr-8 -mt-8 pointer-events-none"></div>
                        
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="paid_amount" class="text-sm font-bold text-slate-700">Uang Diterima <span class="text-rose-500">*</span></label>
                            </div>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 pointer-events-none font-bold">Rp</span>
                                <input type="number" name="paid_amount" id="paid_amount" value="{{ old('paid_amount') }}" min="0" step="0.01"
                                       class="w-full pl-11 pr-4 py-3 rounded-xl border border-indigo-100 bg-indigo-50/50 text-base font-bold text-slate-900 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                                       placeholder="0" required>
                            </div>
                            @error('paid_amount')
                                <p class="mt-1.5 text-xs font-medium text-rose-500 flex items-center gap-1"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                            <span class="text-sm font-semibold text-slate-500">Kembalian</span>
                            <span id="change-display" class="text-lg font-bold text-emerald-600">Rp 0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 mt-8 sticky bottom-8 z-10 bg-white/80 backdrop-blur-md p-4 rounded-2xl border border-slate-200/60 shadow-lg">
            <a href="{{ route('transactions.index') }}" class="px-6 py-2.5 text-sm font-bold text-slate-500 hover:text-slate-800 transition-colors">Batal</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-8 py-3 rounded-xl transition-all shadow-lg shadow-indigo-200 flex items-center gap-2 group">
                Simpan & Selesaikan
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
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
            
            const changeDisplay = document.getElementById('change-display');
            const change = paid - grandTotal;
            
            if (paid > 0 && change >= 0) {
                changeDisplay.textContent = formatRupiah(change);
                changeDisplay.classList.remove('text-slate-400');
                changeDisplay.classList.add('text-emerald-600');
            } else if (paid > 0 && change < 0) {
                changeDisplay.textContent = "Uang Kurang!";
                changeDisplay.classList.remove('text-emerald-600', 'text-slate-400');
                changeDisplay.classList.add('text-rose-500');
            } else {
                changeDisplay.textContent = "Rp 0";
                changeDisplay.classList.remove('text-emerald-600', 'text-rose-500');
                changeDisplay.classList.add('text-slate-400');
            }
        };

        const productOptions = (selected) =>
            '<option value="">-- Pilih Produk --</option>' +
            products.map((p) =>
                `<option value="${p.id}" data-price="${p.price}" ${selected == p.id ? 'selected' : ''}>${p.name} (${p.code})</option>`
            ).join('');

        const addRow = (values = {}) => {
            const tr = document.createElement('tr');
            tr.className = "group hover:bg-slate-50/50 transition-colors";

            tr.innerHTML = `
                <td class="px-6 py-4">
                    <select name="details[__idx__][product_id]" class="item-product w-full rounded-xl border border-slate-200 px-3 py-2 text-sm font-medium focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer bg-slate-50 focus:bg-white" required>
                        ${productOptions(values.product_id)}
                    </select>
                </td>
                <td class="px-4 py-4 text-center relative">
                    <input type="number" name="details[__idx__][quantity]" class="item-qty w-full rounded-xl border border-slate-200 px-3 py-2 text-sm font-bold text-center focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-slate-50 focus:bg-white" value="${values.quantity || 1}" min="1" required>
                </td>
                <td class="px-4 py-4">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-2.5 flex items-center text-slate-400 pointer-events-none text-xs font-medium">Rp</span>
                        <input type="number" name="details[__idx__][price]" class="item-price w-full pl-8 pr-3 py-2 rounded-xl border border-slate-200 text-sm font-semibold text-right focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-slate-50 focus:bg-white text-slate-600" value="${values.price || 0}" min="0" step="0.01" required>
                    </div>
                </td>
                <td class="px-4 py-4">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-2.5 flex items-center text-slate-400 pointer-events-none text-xs font-medium">Rp</span>
                        <input type="number" name="details[__idx__][discount]" class="item-discount w-full pl-8 pr-3 py-2 rounded-xl border border-slate-200 text-sm font-semibold text-right focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-slate-50 focus:bg-white text-rose-500" value="${values.discount || 0}" min="0" step="0.01">
                    </div>
                </td>
                <td class="px-6 py-4 text-right">
                    <span class="text-sm font-bold text-slate-900 item-subtotal block bg-slate-50 py-2 px-3 rounded-xl border border-slate-100">Rp 0</span>
                </td>
                <td class="px-4 py-4 text-right">
                    <button type="button" class="remove-item p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all" title="Hapus Item">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
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
