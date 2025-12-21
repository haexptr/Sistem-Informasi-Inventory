@extends('adminlte::page')

@section('title', 'Data Barang')

@section('content_header')
    <h1>Data Barang</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('barang.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Barang</a>
            @if(request('filter') == 'menipis')
                <a href="{{ route('barang.index') }}" class="btn btn-secondary ml-2"><i class="fas fa-sync"></i> Tampilkan Semua</a>
            @endif
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(request('filter') == 'menipis')
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> <strong>Mode Filter:</strong> Menampilkan barang dengan stok menipis (kurang dari 10).
                </div>
            @endif
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                        <th>Tanggal</th>
                        <th>QR Code</th>
                        <th>Aksi</th>
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
                            <td>{{ $item->tanggal }}</td>
                            <td>
                                @if ($item->qr_code && file_exists(public_path($item->qr_code)))
                                    <!-- Embed SVG, forcing size with CSS -->
                                    <div style="width: 50px; height: 50px; overflow: hidden;">
                                        {!! str_replace('<svg', '<svg style="width: 100%; height: 100%;"', file_get_contents(public_path($item->qr_code))) !!}
                                    </div>
                                @else
                                    <span class="badge badge-warning">No QR</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('barang.show', $item->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('barang.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('barang.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
