<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang Rusak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
        }
        .header p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
            <img src="https://images.bisnis.com/posts/2017/03/06/765384/rapp.jpg" alt="Logo RAPP" style="width: 80px; height: auto; margin-right: 20px;">
            <div>
                <h2 style="margin: 0;">PT. Riau Andalan Pulp Paper (RAPP)</h2>
                <p style="margin: 5px 0;">Alamat: Kompl PT. RAPP Estate, Baserah, Desa Gunung Melintang, Kec. Kuantan Hilir, Kab. Kuantan Singingi, Prov. Riau</p>
            </div>
        </div>
        <hr style="border: 2px solid #000;">
        <h3 style="text-align: center;">LAPORAN BARANG RUSAK</h3>
        <p style="text-align: center;">Tanggal Cetak: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Jumlah Rusak</th>
                <th>Keterangan</th>
                <th>DiInput Oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barang_rusaks as $index => $br)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $br->barang->kode_barang }}</td>
                <td>{{ $br->barang->nama_barang }}</td>
                <td>{{ $br->jumlah_rusak }}</td>
                <td>{{ $br->keterangan }}</td>
                <td>{{ $br->user->nama }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Taluk Kuantan, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</p>
        <br><br><br>
        <p>{{ $asisten_kiper->nama }}</p>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
