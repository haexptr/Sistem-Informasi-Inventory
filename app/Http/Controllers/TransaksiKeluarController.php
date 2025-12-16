<?php

namespace App\Http\Controllers;

use App\Models\TransaksiKeluar;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiKeluarController extends Controller
{
    public function index()
    {
        $transaksi = TransaksiKeluar::with(['barang', 'user'])->latest()->get();
        return view('transaksi-keluar.index', compact('transaksi'));
    }

    public function create()
    {
        $barang = Barang::all();
        return view('transaksi-keluar.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_keluar' => 'required|date',
            'tujuan' => 'nullable',
            'keterangan' => 'nullable',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($barang->stok_sekarang < $request->jumlah) {
            return back()->withErrors(['jumlah' => 'Stok tidak mencukupi. Stok saat ini: ' . $barang->stok_sekarang])->withInput();
        }

        $barang->decrement('stok_sekarang', $request->jumlah);

        TransaksiKeluar::create([
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'tanggal_keluar' => $request->tanggal_keluar,
            'tujuan' => $request->tujuan,
            'keterangan' => $request->keterangan,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('transaksi-keluar.index')->with('success', 'Transaksi Keluar berhasil disimpan');
    }
}
