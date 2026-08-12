<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionDetailController extends Controller
{
    /**
     * Menampilkan semua detail transaksi.
     */
    public function index()
    {
        $details = TransactionDetail::with(['transaction','product',])->latest()->get();
        return view('transaction-details.index', compact('details'));
    }

    /**
     * Menampilkan form tambah detail transaksi.
     */
    public function create()
    {
        $transactions = Transaction::latest()->get();
        $products = Product::orderBy('name')->get();
        return view('transaction-details.create', compact('transactions', 'products'));
    }

    /**
     * Menyimpan detail transaksi.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
        ]);
        $discount = $validated['discount'] ?? 0;
        $subtotal = ($validated['price'] * $validated['quantity']) - $discount;
        TransactionDetail::create([
            'transaction_id' => $validated['transaction_id'],
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'price' => $validated['price'],
            'discount' => $discount,
            'subtotal' => $subtotal,
        ]);

        return redirect()->route('transaction-details.index')->with('success','Detail transaksi berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail transaksi.
     */
    public function show(TransactionDetail $transactionDetail)
    {
        $transactionDetail->load(['transaction','product',]);
        return view('transaction-details.show', compact('transactionDetail'));
    }

    /**
     * Menampilkan form edit detail transaksi.
     */
    public function edit(TransactionDetail $transactionDetail)
    {
        $transactions = Transaction::latest()->get();
        $products = Product::orderBy('name')->get();
        return view('transaction-details.edit', compact('transactionDetail','transactions','products'));
    }

    /**
     * Update detail transaksi.
     */
    public function update(Request $request, TransactionDetail $transactionDetail) {
        $validated = $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
        ]);
        $discount = $validated['discount'] ?? 0;
        $subtotal = ($validated['price'] * $validated['quantity']) - $discount;
        $transactionDetail->update([
            'transaction_id' => $validated['transaction_id'],
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'price' => $validated['price'],
            'discount' => $discount,
            'subtotal' => $subtotal,
        ]);
        return redirect()->route('transaction-details.index')->with('success','Detail transaksi berhasil diperbarui.');
    }

    /**
     * Menghapus detail transaksi.
     */
    public function destroy(TransactionDetail $transactionDetail)
    {
        $transactionDetail->delete();
        return redirect()->route('transaction-details.index')->with('success','Detail transaksi berhasil dihapus.');
    }
}
