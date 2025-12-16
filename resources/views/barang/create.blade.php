@extends('adminlte::page')

@section('title', 'Tambah Barang')

@section('content_header')
    <h1>Tambah Barang</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <input type="text" name="kategori" class="form-control">
                </div>
                <div class="form-group">
                    <label>Satuan</label>
                    <input type="text" name="satuan" class="form-control" placeholder="Contoh: Pcs, Box, Kg" required>
                </div>
                <div class="form-group">
                    <label>Stok Awal</label>
                    <input type="number" name="stok_sekarang" class="form-control" value="0" min="0" required>
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@stop
