@extends('adminlte::page')

@section('title', 'Transaksi Keluar')

@section('content_header')
    <h1>Transaksi Keluar</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('transaksi-keluar.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Transaksi</a>
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
                        <th>Tujuan</th>
                        <th>Petugas</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->tanggal_keluar }}</td>
                            <td>{{ $item->barang->nama_barang }} ({{ $item->barang->kode_barang }})</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ $item->tujuan }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->keterangan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
