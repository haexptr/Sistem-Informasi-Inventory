@extends('adminlte::page')

@section('title', 'Laporan Transaksi Masuk')

@section('content_header')
    <h1>Laporan Transaksi Masuk</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header no-print">
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
            <!-- Print Header (Only visible when printing) -->
            <div class="print-header">
                <div class="text-center mb-4">
                    <h2 style="margin: 0; font-weight: bold;">SISTEM INFORMASI INVENTORY</h2>
                    <h3 style="margin: 5px 0;">LAPORAN TRANSAKSI MASUK</h3>
                    <p style="margin: 5px 0;">
                        @if(request('start_date') && request('end_date'))
                            Periode: {{ \Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') }} - {{ \Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') }}
                        @else
                            Semua Data
                        @endif
                    </p>
                    <p style="margin: 5px 0; font-size: 12px;">Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
                    <hr style="border-top: 2px solid #000; margin: 10px 0;">
                </div>
            </div>

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
                    @php $totalJumlah = 0; @endphp
                    @foreach ($transaksi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d/m/Y') }}</td>
                            <td>{{ $item->barang->kode_barang }}</td>
                            <td>{{ $item->barang->nama_barang }}</td>
                            <td class="text-center">{{ $item->jumlah }}</td>
                            <td>{{ $item->keterangan }}</td>
                        </tr>
                        @php $totalJumlah += $item->jumlah; @endphp
                    @endforeach
                    <tr class="font-weight-bold">
                        <td colspan="4" class="text-right">TOTAL:</td>
                        <td class="text-center">{{ $totalJumlah }}</td>
                        <td></td>
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

