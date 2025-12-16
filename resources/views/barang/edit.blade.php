@extends('adminlte::page')

@section('title', 'Edit Barang')

@section('content_header')
    <h1>Edit Barang</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('barang.update', $barang->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" value="{{ $barang->nama_barang }}" required>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <input type="text" name="kategori" class="form-control" value="{{ $barang->kategori }}">
                </div>
                <div class="form-group">
                    <label>Satuan</label>
                    <input type="text" name="satuan" class="form-control" value="{{ $barang->satuan }}" required>
                </div>
                <div class="form-group">
                    <label>Stok Sekarang</label>
                    <input type="number" name="stok_sekarang" class="form-control" value="{{ $barang->stok_sekarang }}" min="0" required>
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control">{{ $barang->keterangan }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@stop
