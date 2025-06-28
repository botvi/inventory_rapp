@extends('template-admin.layout')
@section('style')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* CSS untuk responsivitas */
        .page-wrapper {
            min-height: 100vh;
            width: 100%;
            overflow-x: auto;
        }
        
        .page-content {
            padding: 20px;
            width: 100%;
            max-width: 100%;
        }
        
        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .logo-container img {
            max-width: 100%;
            height: auto;
            max-height: 80px;
        }
        
        .chart-container {
            position: relative;
            width: 100%;
            height: auto;
            min-height: 400px;
        }
        
        .card {
            margin-bottom: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 1rem;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        /* Responsif untuk layar kecil */
        @media (max-width: 768px) {
            .page-content {
                padding: 10px;
            }
            
            .logo-container img {
                max-width: 200px;
                max-height: 60px;
            }
            
            .chart-container {
                min-height: 300px;
            }
            
            .card-header h4 {
                font-size: 1.1rem;
            }
        }
        
        /* Responsif untuk layar sangat kecil */
        @media (max-width: 576px) {
            .page-content {
                padding: 5px;
            }
            
            .logo-container img {
                max-width: 150px;
                max-height: 50px;
            }
            
            .chart-container {
                min-height: 250px;
            }
            
            .card-header h4 {
                font-size: 1rem;
            }
        }
        
        /* Responsif untuk zoom out */
        @media (max-width: 1200px) {
            .chart-container {
                min-height: 350px;
            }
        }
        
        /* Responsif untuk zoom in */
        @media (min-width: 1400px) {
            .chart-container {
                min-height: 500px;
            }
        }
    </style>
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="logo-container">
                <img src="{{ asset('env') }}/logo_text.jpg" alt="Logo RAPP" class="img-fluid">
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Stok Barang</h4>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="stokChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    const ctx = document.getElementById('stokChart').getContext('2d');
    const labels = @json($labels);
    const stok = @json($stok);

    // Array warna untuk setiap bar
    const backgroundColors = [
        'rgba(255, 99, 132, 0.5)',
        'rgba(54, 162, 235, 0.5)',
        'rgba(255, 206, 86, 0.5)',
        'rgba(75, 192, 192, 0.5)',
        'rgba(153, 102, 255, 0.5)',
        'rgba(255, 159, 64, 0.5)',
        'rgba(199, 199, 199, 0.5)',
        'rgba(83, 102, 255, 0.5)',
        'rgba(40, 159, 64, 0.5)',
        'rgba(210, 199, 199, 0.5)'
    ];

    const borderColors = [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(199, 199, 199, 1)',
        'rgba(83, 102, 255, 1)',
        'rgba(40, 159, 64, 1)',
        'rgba(210, 199, 199, 1)'
    ];

    // Fungsi untuk membuat chart yang responsif
    function createResponsiveChart() {
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Stok Barang',
                    data: stok,
                    backgroundColor: backgroundColors,
                    borderColor: borderColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: window.innerWidth < 768 ? 12 : 14
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Stok',
                            font: {
                                size: window.innerWidth < 768 ? 12 : 14
                            }
                        },
                        ticks: {
                            font: {
                                size: window.innerWidth < 768 ? 10 : 12
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Nama Barang',
                            font: {
                                size: window.innerWidth < 768 ? 12 : 14
                            }
                        },
                        ticks: {
                            font: {
                                size: window.innerWidth < 768 ? 10 : 12
                            },
                            maxRotation: 45,
                            minRotation: 0
                        }
                    }
                }
            }
        });
        
        return chart;
    }

    // Membuat chart
    let chart = createResponsiveChart();

    // Event listener untuk resize window
    window.addEventListener('resize', function() {
        if (chart) {
            chart.destroy();
        }
        chart = createResponsiveChart();
    });

    // Event listener untuk zoom
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            if (chart) {
                chart.destroy();
            }
            chart = createResponsiveChart();
        }, 250);
    });
</script>
@endsection