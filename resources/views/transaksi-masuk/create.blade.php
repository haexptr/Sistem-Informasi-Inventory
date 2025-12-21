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
                    <!-- Fix: Style width 100% and min-height to ensure camera area is visible -->
                    <div id="reader" style="width: 100%; min-height: 300px; background: #eee;"></div>
                    <button id="startScan" class="btn btn-primary mt-3">Mulai Scan Kamera</button>
                    <button id="stopScan" class="btn btn-danger mt-3" style="display:none;">Stop Scan</button>
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
    <!-- Use local file as requested -->
    <script src="{{ asset('js/html5-qrcode.min.js') }}"></script>
    <script>
        // DEBUG: Cek apakah library berhasil diload
        if (typeof Html5Qrcode === 'undefined') {
            console.error('Library Html5Qrcode GAGAL diload!');
            alert('Error: Library QR Code tidak terdeteksi.\n\n1. Coba Hard Refresh (Ctrl + F5).\n2. Pastikan file public/js/html5-qrcode.min.js ada dan tidak korup (size sekitar 366kb).');
        } else {
            console.log('Library Html5Qrcode BERHASIL diload.');
        }

        $(document).ready(function() {
            $('.select2').select2();

            let html5QrcodeScanner = null;
            
            $('#startScan').click(function() {
                $('#cameraStatus').text('Sedang memuat kamera...');
                
                // Initialize only when needed
                if (html5QrcodeScanner === null) {
                   html5QrcodeScanner = new Html5Qrcode("reader");
                }

                $('#startScan').hide();
                $('#stopScan').show();
                
                const config = { fps: 10, qrbox: { width: 250, height: 250 } };
                
                // Prefer back camera ("environment")
                html5QrcodeScanner.start({ facingMode: "environment" }, config, onScanSuccess)
                .catch(err => {
                    // ERROR HANDLING: Show alert so user knows WHY it failed
                    console.error("Error starting scanner", err);
                    alert("Gagal membuka kamera: " + err + "\n\nPastikan:\n1. Anda menggunakan HTTPS (bukan HTTP)\n2. Anda mengizinkan akses kamera di browser.");
                    
                    $('#cameraStatus').text('Gagal: ' + err);
                    $('#startScan').show();
                    $('#stopScan').hide();
                });
            });

            function onScanSuccess(decodedText, decodedResult) {
                console.log(`Scan result: ${decodedText}`, decodedResult);
                
                // Find option with matching data-kode
                let found = false;
                $('#barang_id option').each(function() {
                    if ($(this).data('kode') === decodedText) {
                        $('#barang_id').val($(this).val()).trigger('change');
                        found = true;
                        
                        // Audio feedback (optional)
                        // let beep = new Audio('beep.mp3'); beep.play();

                        alert('Barang ditemukan: ' + decodedText);
                        
                        stopScanning();
                        return false;
                    }
                });

                if (!found) {
                    alert('Barang dengan kode ' + decodedText + ' tidak ditemukan di database.');
                }
            }

            $('#stopScan').click(function() {
                stopScanning();
            });

            function stopScanning() {
                if (html5QrcodeScanner) {
                    html5QrcodeScanner.stop().then((ignore) => {
                        console.log("Stopped scanning.");
                        $('#startScan').show();
                        $('#stopScan').hide();
                        $('#cameraStatus').text('Kamera berhenti.');
                    }).catch((err) => {
                        console.log("Failed to stop", err);
                    });
                }
            }
        });
    </script>
@stop
