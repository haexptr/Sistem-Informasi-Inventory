@extends('adminlte::page')

@section('title', 'Tambah Transaksi Masuk')

@section('content_header')
    <h1>Tambah Transaksi Masuk</h1>
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
                    <form action="{{ route('transaksi-masuk.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Kode Barang / Nama Barang</label>
                            <select name="barang_id" id="barang_id" class="form-control select2" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach ($barang as $item)
                                    <option value="{{ $item->id }}" data-kode="{{ $item->kode_barang }}">{{ $item->kode_barang }} - {{ $item->nama_barang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Jumlah Masuk</label>
                            <input type="number" name="jumlah" class="form-control" min="1" required>
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('transaksi-masuk.index') }}" class="btn btn-secondary">Batal</a>
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
                        // Handle on success condition with the decoded message.
                        console.log(`Scan result: ${decodedText}`, decodedResult);
                        
                        // Find option with matching data-kode
                        let found = false;
                        $('#barang_id option').each(function() {
                            if ($(this).data('kode') === decodedText) {
                                $('#barang_id').val($(this).val()).trigger('change');
                                found = true;
                                alert('Barang ditemukan: ' + decodedText);
                                
                                // Stop scanning after success
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
                    // Start failed, handle it.
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
                    // QR Code scanning is stopped.
                    $('#startScan').show();
                    $('#stopScan').hide();
                }).catch((err) => {
                    // Stop failed, handle it.
                    console.log(err);
                });
            }
        });
    </script>
@stop
