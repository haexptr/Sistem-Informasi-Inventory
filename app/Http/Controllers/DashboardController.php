<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Barang;
use App\Models\TransaksiMasuk;
use App\Models\TransaksiKeluar;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $total_barang = Barang::count();
        $transaksi_masuk_today = TransaksiMasuk::whereDate('created_at', Carbon::today())->count();
        $transaksi_keluar_today = TransaksiKeluar::whereDate('created_at', Carbon::today())->count();
        $stok_menipis = Barang::where('stok_sekarang', '<', 10)->count();

        return view('dashboard.index', compact('total_barang', 'transaksi_masuk_today', 'transaksi_keluar_today', 'stok_menipis'));
    }
}
