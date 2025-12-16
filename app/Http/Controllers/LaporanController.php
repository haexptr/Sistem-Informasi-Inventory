<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\TransaksiMasuk;
use App\Models\TransaksiKeluar;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function barang()
    {
        $barang = Barang::all();
        return view('laporan.barang', compact('barang'));
    }

    public function masuk(Request $request)
    {
        $query = TransaksiMasuk::with('barang');
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal_masuk', [$request->start_date, $request->end_date]);
        }
        $transaksi = $query->get();
        return view('laporan.transaksi-masuk', compact('transaksi'));
    }

    public function keluar(Request $request)
    {
        $query = TransaksiKeluar::with('barang');
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal_keluar', [$request->start_date, $request->end_date]);
        }
        $transaksi = $query->get();
        return view('laporan.transaksi-keluar', compact('transaksi'));
    }
}
