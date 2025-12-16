@extends('adminlte::page')

@section('title', 'Detail Barang')

@section('content_header')
    <h1>Detail Barang</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if ($barang->qr_code)
                        <img src="{{ asset($barang->qr_code) }}" alt="QR Code" class="img-fluid mb-3" style="max-width: 300px;">
                        <br>
                        <a href="{{ asset($barang->qr_code) }}" download="QR-{{ $barang->kode_barang }}.svg" class="btn btn-success"><i class="fas fa-download"></i> Download QR</a>
                        <button onclick="printQR()" class="btn btn-secondary"><i class="fas fa-print"></i> Print QR</button>
                    @else
                        <p>No QR Code</p>
                    @endif
                </div>
                <div class="col-md-8">
                    <table class="table">
                        <tr>
                            <th width="200">Kode Barang</th>
                            <td>{{ $barang->kode_barang }}</td>
                        </tr>
                        <tr>
                            <th>Nama Barang</th>
                            <td>{{ $barang->nama_barang }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>{{ $barang->kategori }}</td>
                        </tr>
                        <tr>
                            <th>Satuan</th>
                            <td>{{ $barang->satuan }}</td>
                        </tr>
                        <tr>
                            <th>Stok Sekarang</th>
                            <td>{{ $barang->stok_sekarang }}</td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $barang->keterangan }}</td>
                        </tr>
                    </table>
                    <a href="{{ route('barang.index') }}" class="btn btn-default mt-3">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printQR() {
            var win = window.open('', '', 'height=500,width=500');
            win.document.write('<html><head><title>Print QR</title>');
            win.document.write('</head><body style="text-align:center;">');
            win.document.write('<img src="{{ asset($barang->qr_code) }}" style="width:300px;">');
            win.document.write('<br><h3>{{ $barang->nama_barang }} ({{ $barang->kode_barang }})</h3>');
            win.document.write('</body></html>');
            win.document.close();
            win.print();
        }
    </script>
@stop
