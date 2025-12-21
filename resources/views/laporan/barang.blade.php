@extends('adminlte::page')

@section('title', 'Laporan Stok Barang')

@section('content_header')
    <h1>Laporan Stok Barang</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header no-print">
            <button onclick="window.print()" class="btn btn-secondary"><i class="fas fa-print"></i> Print</button>
        </div>
        <div class="card-body">
            <!-- Print Header (Only visible when printing) -->
            <div class="print-header">
                <div class="text-center mb-4">
                    <h2 style="margin: 0; font-weight: bold;">SISTEM INFORMASI INVENTORY</h2>
                    <h3 style="margin: 5px 0;">LAPORAN STOK BARANG</h3>
                    <p style="margin: 5px 0; font-size: 12px;">Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
                    <hr style="border-top: 2px solid #000; margin: 10px 0;">
                </div>
            </div>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalStok = 0; @endphp
                    @foreach ($barang as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->kode_barang }}</td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->kategori }}</td>
                            <td>{{ $item->satuan }}</td>
                            <td class="text-center">{{ $item->stok_sekarang }}</td>
                        </tr>
                        @php $totalStok += $item->stok_sekarang; @endphp
                    @endforeach
                    <tr class="font-weight-bold">
                        <td colspan="5" class="text-right">TOTAL STOK:</td>
                        <td class="text-center">{{ $totalStok }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Print Footer (Only visible when printing) -->
            <div class="print-footer">
                <div class="row mt-5">
                    <div class="col-6 text-center">
                        <p>Mengetahui,</p>
                        <br><br><br>
                        <p style="border-top: 1px solid #000; display: inline-block; padding-top: 5px; min-width: 200px;">
                            ( _________________ )
                        </p>
                    </div>
                    <div class="col-6 text-center">
                        <p>{{ \Carbon\Carbon::now()->format('d F Y') }}</p>
                        <p>Petugas,</p>
                        <br><br>
                        <p style="border-top: 1px solid #000; display: inline-block; padding-top: 5px; min-width: 200px;">
                            ( {{ Auth::user()->name }} )
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<style>
    @media print {
        /* Hide everything except the content */
        body * {
            visibility: hidden;
        }
        
        .card-body, .card-body * {
            visibility: visible;
        }
        
        .card-body {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 20px;
        }
        
        /* Hide elements with no-print class */
        .no-print, .no-print * {
            display: none !important;
            visibility: hidden !important;
        }
        
        /* Show print-only elements */
        .print-header, .print-footer {
            display: block !important;
        }
        
        /* Table styling for print */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        
        table th, table td {
            border: 1px solid #000;
            padding: 8px;
        }
        
        table thead {
            background-color: #f0f0f0 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        /* Page break settings */
        tr {
            page-break-inside: avoid;
        }
    }
    
    /* Hide print elements on screen */
    @media screen {
        .print-header, .print-footer {
            display: none;
        }
    }
</style>
@stop
