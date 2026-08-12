<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Menampilkan semua transaksi.
     */
    public function index()
    {
        $transactions = Transaction::with(['customer', 'user'])->latest('transaction_date')->get();
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Menampilkan form transaksi baru.
     */
    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $productsData = $products->map(fn ($p) => [
            'id' => $p->id,
            'name' => $p->name,
            'code' => $p->code,
            'price' => (float) $p->selling_price,
        ]);
        return view('transactions.create', compact('customers', 'products', 'productsData'));
    }

    /**
     * Menyimpan transaksi baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'transaction_date' => 'required|date',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:50',
            'notes' => 'nullable|string',
            'details' => 'required|array|min:1',
            'details.*.product_id' => ['required','exists:products,id',],
            'details.*.quantity' => ['required','integer','min:1',],
            'details.*.price' => ['required','numeric','min:0',],
            'details.*.discount' => ['nullable','numeric','min:0',],
        ]);

        DB::transaction(function () use ($validated) {
            $subtotal = 0;
            foreach ($validated['details'] as $detail) {
                $price = $detail['price'];
                $quantity = $detail['quantity'];
                $discount = $detail['discount'] ?? 0;
                $detailSubtotal = ($price * $quantity) - $discount;
                $subtotal += $detailSubtotal;
            }
            $discount = $validated['discount'] ?? 0;
            $tax = $validated['tax'] ?? 0;
            $grandTotal = $subtotal - $discount + $tax;
            $paidAmount = $validated['paid_amount'];
            $changeAmount = max(
                0,
                $paidAmount - $grandTotal
            );
            $transaction = Transaction::create([
                'invoice_number' => 'INV-' . now()->format('YmdHis'),
                'user_id' => Auth::id(),
                'customer_id' => $validated['customer_id'] ?? null,
                'transaction_date' => $validated['transaction_date'],
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'paid_amount' => $paidAmount,
                'change_amount' => $changeAmount,
                'payment_method' => $validated['payment_method'],
                'payment_status' => $paidAmount >= $grandTotal ? 'paid' : 'unpaid',
                'status' => 'completed',
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['details'] as $detail) {
                $price = $detail['price'];
                $quantity = $detail['quantity'];
                $discount = $detail['discount'] ?? 0;
                $detailSubtotal = ($price * $quantity) - $discount;
                $transaction->details()->create([
                    'product_id' => $detail['product_id'],
                    'quantity' => $quantity,
                    'price' => $price,
                    'discount' => $discount,
                    'subtotal' => $detailSubtotal,
                ]);

                Product::where('id', $detail['product_id'])->decrement('stock', $quantity);
            }
        });

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dibuat.');
    }

    /**
     * Menampilkan detail transaksi.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load([
            'customer',
            'user',
            'details.product',
        ]);

        return view('transactions.show', compact('transaction'));
    }

    /**
     * Menampilkan form edit transaksi.
     */
    public function edit(Transaction $transaction)
    {
        $customers = Customer::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $transaction->load('details.product');
        return view('transactions.edit', compact('transaction', 'customers', 'products'));
    }

    /**
     * Update transaksi.
     */
    public function update(Request $request, Transaction $transaction) {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'transaction_date' => 'required|date',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:50',
            'payment_status' => 'required|string|max:50',
            'status' => 'required|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $subtotal = $transaction->subtotal;
        $discount = $validated['discount'] ?? 0;
        $tax = $validated['tax'] ?? 0;
        $grandTotal = $subtotal - $discount + $tax;
        $paidAmount = $validated['paid_amount'];
        $changeAmount = max(0, $paidAmount - $grandTotal);
        $transaction->update([
            'customer_id' => $validated['customer_id'] ?? null,
            'transaction_date' => $validated['transaction_date'],
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax' => $tax,
            'grand_total' => $grandTotal,
            'paid_amount' => $paidAmount,
            'change_amount' => $changeAmount,
            'payment_method' => $validated['payment_method'],
            'payment_status' => $validated['payment_status'],
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Menghapus transaksi.
     */
    public function destroy(Transaction $transaction)
    {
        DB::transaction(function () use ($transaction) {
            $transaction->load('details');
            foreach ($transaction->details as $detail) {
                Product::where('id', $detail->product_id)->increment('stock', $detail->quantity);
            }
            $transaction->details()->delete();
            $transaction->delete();
        });
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
