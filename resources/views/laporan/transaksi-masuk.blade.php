@extends('adminlte::page')

@section('title', 'Laporan Transaksi Masuk')

@section('content_header')
    <h1>Laporan Transaksi Masuk</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="{{ route('laporan.masuk') }}" method="GET" class="form-inline">
                <div class="form-group mr-2">
                    <label class="mr-2">Dari Tanggal:</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="form-group mr-2">
                    <label class="mr-2">Sampai Tanggal:</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <button type="submit" class="btn btn-primary mr-2">Filter</button>
                <button type="button" onclick="window.print()" class="btn btn-secondary"><i class="fas fa-print"></i> Print</button>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->tanggal_masuk }}</td>
                            <td>{{ $item->barang->kode_barang }}</td>
                            <td>{{ $item->barang->nama_barang }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ $item->keterangan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
