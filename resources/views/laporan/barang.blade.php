@extends('adminlte::page')

@section('title', 'Laporan Stok Barang')

@section('content_header')
    <h1>Laporan Stok Barang</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <button onclick="window.print()" class="btn btn-secondary"><i class="fas fa-print"></i> Print</button>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barang as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->kode_barang }}</td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->kategori }}</td>
                            <td>{{ $item->satuan }}</td>
                            <td>{{ $item->stok_sekarang }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
