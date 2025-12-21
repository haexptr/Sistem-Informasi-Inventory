<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        // Check if filter is active
        if ($request->get('filter') == 'menipis') {
            // Only show items with stock less than 10
            $barang = Barang::where('stok_sekarang', '<', 10)->get();
        } else {
            // Show all items
            $barang = Barang::all();
        }
        
        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|max:255',
            'satuan' => 'required',
            'stok_sekarang' => 'required|numeric|min:0',
            'kategori' => 'nullable',
            'keterangan' => 'nullable',
            'tanggal' => 'nullable|date',
        ]);

        // Generate Kode Barang
        $lastBarang = Barang::latest()->first();
        $nextId = $lastBarang ? $lastBarang->id + 1 : 1;
        $kode_barang = 'BRG' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        // Generate QR Code
        if (!file_exists(public_path('qrcodes'))) {
            mkdir(public_path('qrcodes'), 0755, true);
        }
        
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qr_filename = $kode_barang . '.svg';
        $writer->writeFile($kode_barang, public_path('qrcodes/' . $qr_filename));

        Barang::create([
            'kode_barang' => $kode_barang,
            'nama_barang' => $request->nama_barang,
            'satuan' => $request->satuan,
            'stok_sekarang' => $request->stok_sekarang,
            'kategori' => $request->kategori,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
            'qr_code' => 'qrcodes/' . $qr_filename,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan');
    }

    public function show(Barang $barang)
    {
        if ($barang->kode_barang && (! $barang->qr_code || ! file_exists(public_path($barang->qr_code)))) {
            if (!file_exists(public_path('qrcodes'))) {
                mkdir(public_path('qrcodes'), 0755, true);
            }
            
            $renderer = new ImageRenderer(
                new RendererStyle(200),
                new SvgImageBackEnd()
            );
            $writer = new Writer($renderer);
            $qr_filename = $barang->kode_barang . '.svg';
            $writer->writeFile($barang->kode_barang, public_path('qrcodes/' . $qr_filename));
            
            $barang->update(['qr_code' => 'qrcodes/' . $qr_filename]);
        }

        $qrCodeContent = '';
        if ($barang->qr_code && file_exists(public_path($barang->qr_code))) {
             $qrCodeContent = file_get_contents(public_path($barang->qr_code));
        }

        return view('barang.show', compact('barang', 'qrCodeContent'));
    }

    public function edit(Barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required|max:255',
            'satuan' => 'required',
            'stok_sekarang' => 'required|numeric|min:0',
            'kategori' => 'nullable',
            'keterangan' => 'nullable',
            'tanggal' => 'nullable|date',
        ]);

        $barang->update($request->all());

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate');
    }

    public function destroy(Barang $barang)
    {
        if ($barang->qr_code && file_exists(public_path($barang->qr_code))) {
            unlink(public_path($barang->qr_code));
        }
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
    }
}