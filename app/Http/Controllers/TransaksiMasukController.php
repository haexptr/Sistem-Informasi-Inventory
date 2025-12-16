<?php

namespace App\Http\Controllers;

use App\Models\TransaksiMasuk;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiMasukController extends Controller
{
    public function index()
    {
        $transaksi = TransaksiMasuk::with(['barang', 'user'])->latest()->get();
        return view('transaksi-masuk.index', compact('transaksi'));
    }

    public function create()
    {
        $barang = Barang::all();
        return view('transaksi-masuk.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_masuk' => 'required|date',
            'keterangan' => 'nullable',
        ]);

        $barang = Barang::findOrFail($request->barang_id);
        $barang->increment('stok_sekarang', $request->jumlah);

        TransaksiMasuk::create([
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'tanggal_masuk' => $request->tanggal_masuk,
            'keterangan' => $request->keterangan,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('transaksi-masuk.index')->with('success', 'Transaksi Masuk berhasil disimpan');
    }
}
