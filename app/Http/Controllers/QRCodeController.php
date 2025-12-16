<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class QRCodeController extends Controller
{
    public function getBarang($kode)
    {
        $barang = Barang::where('kode_barang', $kode)->first();
        if ($barang) {
            return response()->json([
                'status' => 'success',
                'data' => $barang
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Barang tidak ditemukan'
        ], 404);
    }
}
