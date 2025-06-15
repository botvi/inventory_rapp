@extends('template-admin.layout')
@section('style')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 text-center mb-4">
                    <img src="{{ asset('env') }}/logo_text.jpg" width="250" alt="Logo RAPP" class="img-fluid">
                   
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Stok Barang</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="stokChart"></canvas>
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

    new Chart(ctx, {
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
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Stok'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Nama Barang'
                    }
                }
            }
        }
    });
</script>
@endsection