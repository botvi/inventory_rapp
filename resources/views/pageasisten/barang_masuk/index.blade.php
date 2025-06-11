@extends('template-admin.layout')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Forms</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Barang Masuk</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--breadcrumb-->
        <h6 class="mb-0 text-uppercase">Data Barang Masuk</h6>
        <hr/>
        <div class="card">
            <div class="card-body">
                <a href="{{ route('barang-masuk.create') }}" class="btn btn-primary mb-3">Tambah Data</a>
                <a href="{{ route('laporan.barang-masuk') }}" target="_blank" class="btn btn-success mb-3">Cetak Laporan</a>
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                <th>DiInput Oleh</th>
                                <th>Supplier</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Stok Saat Ini</th>
                                <th>Tanggal Masuk</th>
                                <th>Aksi</th>
                              
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barang_masuks as $index => $barang_masuk)
                            <tr>
                                <td>{{ $barang_masuk->user->nama }}</td>
                                <td>{{ $barang_masuk->supplier->nama_supplier }}</td>
                                <td>{{ $barang_masuk->barang->kode_barang }}</td>
                                <td>{{ $barang_masuk->barang->nama_barang }}</td>
                                <td>{{ $barang_masuk->jumlah }}</td>
                                <td>{{ $barang_masuk->barang->stok_barang }}</td>
                                <td>{{ $barang_masuk->tanggal_masuk }}</td>
                                <td><img src="{{ asset('gambar_barang/' . $barang_masuk->barang->gambar_barang) }}" alt="Gambar" style="width: 100px; height: 100px;"></td>
                                <td>
                                    <a href="{{ route('barang-masuk.edit', $barang_masuk->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('barang-masuk.destroy', $barang_masuk->id) }}" method="POST" style="display:inline;" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>DiInput Oleh</th>
                                <th>Supplier</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Stok Saat Ini</th>
                                <th>Tanggal Masuk</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection