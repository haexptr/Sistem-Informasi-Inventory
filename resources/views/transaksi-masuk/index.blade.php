@extends('adminlte::page')

@section('title', 'Transaksi Masuk')

@section('content_header')
    <h1>Transaksi Masuk</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('transaksi-masuk.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Transaksi</a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Petugas</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->tanggal_masuk }}</td>
                            <td>{{ $item->barang->nama_barang }} ({{ $item->barang->kode_barang }})</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->keterangan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
