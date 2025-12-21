@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $total_barang }}</h3>
                    <p>Total Barang</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box"></i>
                </div>
                <a href="{{ route('barang.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $transaksi_masuk_today }}</h3>
                    <p>Transaksi Masuk Hari Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-arrow-down"></i>
                </div>
                <a href="{{ route('transaksi-masuk.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $transaksi_keluar_today }}</h3>
                    <p>Transaksi Keluar Hari Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-arrow-up"></i>
                </div>
                <a href="{{ route('transaksi-keluar.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stok_menipis }}</h3>
                    <p>Stok Menipis</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <!-- Link otomatis filter ke barang yang stoknya kurang dari 10 -->
                <a href="{{ route('barang.index', ['filter' => 'menipis']) }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Grafik Section -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-area mr-1"></i>
                        Grafik Transaksi 7 Hari Terakhir
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="transactionChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<style>
    /* HIDE User Menu Dropdown Arrow & Disable Click */
    .user-menu .dropdown-menu { display: none !important; }
    .user-menu .nav-link { cursor: default !important; pointer-events: none !important; }
    .user-menu .nav-link::after { display: none !important; } /* Hide Bootstrap arrow if present */
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>
    $(document).ready(function() {
        // Manual Toggle for Burger Menu (Sidebar)
        $(document).on('click', '[data-widget="pushmenu"]', function(e) {
            e.preventDefault();
            var body = $('body');
            if (body.hasClass('sidebar-collapse')) {
                body.removeClass('sidebar-collapse').addClass('sidebar-open');
            } else {
                body.addClass('sidebar-collapse').removeClass('sidebar-open');
            }
        });


        // Initialize Chart
        if (typeof Chart === 'undefined') {
            console.error('Chart.js not loaded!');
        } else {
            var ctx = document.getElementById('transactionChart').getContext('2d');
            
            // Parse data safely from PHP
            var chartLabels = {!! json_encode($chart_labels) !!};
            var dataMasuk = {!! json_encode($data_masuk) !!};
            var dataKeluar = {!! json_encode($data_keluar) !!};

            var transactionChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [
                        {
                            label: 'Barang Masuk',
                            backgroundColor: 'rgba(40, 167, 69, 0.5)', 
                            borderColor: 'rgba(40, 167, 69, 1)',
                            pointRadius: 4,
                            pointBackgroundColor: '#28a745',
                            data: dataMasuk,
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Barang Keluar',
                            backgroundColor: 'rgba(255, 193, 7, 0.5)', 
                            borderColor: 'rgba(255, 193, 7, 1)',
                            pointRadius: 4,
                            pointBackgroundColor: '#ffc107',
                            data: dataKeluar,
                            fill: true,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: { display: false }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                }
            });
        }
    });
</script>
@stop
