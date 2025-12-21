@extends('adminlte::page')

@section('title', 'Tambah Transaksi Masuk')

@section('content_header')
    <h1>Tambah Transaksi Masuk</h1>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Scan QR Code</h3>
                </div>
                <div class="card-body text-center">
                    <!-- Fix: Style width 100% and min-height to ensure camera area is visible -->
                    <div id="reader" style="width: 100%; min-height: 300px; background: #eee;"></div>
                    <button type="button" id="startScan" class="btn btn-primary mt-3">Mulai Scan Kamera</button>
                    <button type="button" id="stopScan" class="btn btn-danger mt-3" style="display:none;">Stop Scan</button>
                    <p class="mt-2 text-muted text-sm" id="cameraStatus">Pastikan izin kamera aktif & gunakan HTTPS.</p>
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
    <!-- Load Select2 first -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Then load QR Scanner -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 with error handling
            try {
                if (typeof $.fn.select2 !== 'undefined') {
                    $('.select2').select2();
                }
            } catch (e) {
                console.error('Select2 initialization failed:', e);
            }

            let html5QrcodeScanner = null;
            
            $('#startScan').on('click', function(e) {
                console.log('Starting QR Scanner...');
                $('#cameraStatus').text('Sedang memuat kamera...');
                
                if (html5QrcodeScanner === null) {
                    try {
                        html5QrcodeScanner = new Html5Qrcode("reader");
                    } catch (error) {
                        console.error('ERROR creating Html5Qrcode:', error);
                        alert('Error: ' + error.message);
                        return;
                    }
                }

                $('#startScan').hide();
                $('#stopScan').show();
                
                const config = { fps: 10, qrbox: { width: 250, height: 250 } };
                
                html5QrcodeScanner.start({ facingMode: "environment" }, config, onScanSuccess)
                .then(() => {
                    console.log('Camera started successfully!');
                })
                .catch(err => {
                    console.error('ERROR starting camera:', err);
                    alert("Gagal membuka kamera: " + err.message);
                    $('#cameraStatus').text('Gagal: ' + err.message);
                    $('#startScan').show();
                    $('#stopScan').hide();
                });
            });

            function onScanSuccess(decodedText, decodedResult) {
                console.log('QR Code scanned:', decodedText);
                
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
            }

            $('#stopScan').on('click', function() {
                stopScanning();
            });

            function stopScanning() {
                if (html5QrcodeScanner) {
                    html5QrcodeScanner.stop().then((ignore) => {
                        console.log("Scanner stopped");
                        $('#startScan').show();
                        $('#stopScan').hide();
                        $('#cameraStatus').text('Kamera berhenti.');
                    }).catch((err) => {
                        console.error("Failed to stop scanner:", err);
                    });
                }
            }
        });
    </script>
@stop
