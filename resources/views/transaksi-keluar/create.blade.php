@extends('adminlte::page')

@section('title', 'Tambah Transaksi Keluar')

@section('content_header')
    <h1>Tambah Transaksi Keluar</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Scan QR Code</h3>
                </div>
                <div class="card-body text-center">
                    <div id="reader" width="600px"></div>
                    <button id="startScan" class="btn btn-primary mt-3">Mulai Scan Kamera</button>
                    <button id="stopScan" class="btn btn-danger mt-3" style="display:none;">Stop Scan</button>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Transaksi</h3>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('transaksi-keluar.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Kode Barang / Nama Barang</label>
                            <select name="barang_id" id="barang_id" class="form-control select2" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach ($barang as $item)
                                    <option value="{{ $item->id }}" data-kode="{{ $item->kode_barang }}">{{ $item->kode_barang }} - {{ $item->nama_barang }} (Stok: {{ $item->stok_sekarang }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Keluar</label>
                            <input type="date" name="tanggal_keluar" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Jumlah Keluar</label>
                            <input type="number" name="jumlah" class="form-control" min="1" required>
                        </div>
                        <div class="form-group">
                            <label>Tujuan</label>
                            <input type="text" name="tujuan" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('transaksi-keluar.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('js/html5-qrcode.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            let html5QrcodeScanner = new Html5Qrcode("reader");
            
            $('#startScan').click(function() {
                $('#startScan').hide();
                $('#stopScan').show();
                
                html5QrcodeScanner.start(
                    { facingMode: "environment" }, 
                    {
                        fps: 10,
                        qrbox: { width: 250, height: 250 }
                    },
                    (decodedText, decodedResult) => {
                        console.log(`Scan result: ${decodedText}`, decodedResult);
                        
                        let found = false;
                        $('#barang_id option').each(function() {
                            if ($(this).data('kode') === decodedText) {
                                $('#barang_id').val($(this).val()).trigger('change');
                                found = true;
                                alert('Barang ditemukan: ' + decodedText);
                                stopScanning();
                                return false;
                            }
                        });

                        if (!found) {
                            alert('Barang dengan kode ' + decodedText + ' tidak ditemukan di database.');
                        }
                    },
                    (errorMessage) => {
                        // parse error, ignore it.
                    })
                .catch((err) => {
                    console.log(err);
                    $('#startScan').show();
                    $('#stopScan').hide();
                });
            });

            $('#stopScan').click(function() {
                stopScanning();
            });

            function stopScanning() {
                html5QrcodeScanner.stop().then((ignore) => {
                    $('#startScan').show();
                    $('#stopScan').hide();
                }).catch((err) => {
                    console.log(err);
                });
            }
        });
    </script>
@stop
