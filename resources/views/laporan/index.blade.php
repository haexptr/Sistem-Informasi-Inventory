@extends('adminlte::page')

@section('title', 'Laporan')

@section('content_header')
    <h1>Laporan</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>Stok</h3>
                    <p>Laporan Stok Barang</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box"></i>
                </div>
                <a href="{{ route('laporan.barang') }}" class="small-box-footer">Lihat Laporan <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Masuk</h3>
                    <p>Laporan Transaksi Masuk</p>
                </div>
                <div class="icon">
                    <i class="fas fa-arrow-down"></i>
                </div>
                <a href="{{ route('laporan.masuk') }}" class="small-box-footer">Lihat Laporan <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>Keluar</h3>
                    <p>Laporan Transaksi Keluar</p>
                </div>
                <div class="icon">
                    <i class="fas fa-arrow-up"></i>
                </div>
                <a href="{{ route('laporan.keluar') }}" class="small-box-footer">Lihat Laporan <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@stop
