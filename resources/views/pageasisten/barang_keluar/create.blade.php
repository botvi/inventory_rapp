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
                            <li class="breadcrumb-item active" aria-current="page">Barang Keluar</li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Barang Keluar</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--breadcrumb-->

            <div class="row">
                <div class="col-xl-7 mx-auto">
                    <hr />
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body p-5">
                            <div class="card-title d-flex align-items-center">
                                <div><i class="bx bx-upload me-1 font-22 text-primary"></i></div>
                                <h5 class="mb-0 text-primary">Tambah Barang Keluar</h5>
                            </div>
                            <hr>
                            <form action="{{ route('barang-keluar.store') }}" method="POST" class="row g-3" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <label for="barang_id" class="form-label">Barang</label>
                                    <select class="form-control" id="barang_id" name="barang_id">
                                        @foreach ($barangs as $barang)
                                            <option value="{{ $barang->id }}">{{ $barang->kode_barang }} - {{ $barang->nama_barang }} ({{ $barang->stok_barang }} stok)</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">
                                        @foreach ($errors->get('barang_id') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </small>
                                </div>
                               
                                <div class="col-md-12">
                                    <label for="tanggal_keluar" class="form-label">Tanggal Keluar</label>
                                    <input type="date" class="form-control" id="tanggal_keluar" name="tanggal_keluar" required>
                                    <small class="text-danger">
                                        @foreach ($errors->get('tanggal_keluar') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </small>
                                </div>
                               
                                <div class="col-md-12">
                                    <label for="tujuan" class="form-label">Tujuan</label>
                                    <input type="text" class="form-control" id="tujuan" name="tujuan" required>
                                    <small class="text-danger">
                                        @foreach ($errors->get('tujuan') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </small>
                                </div>
                                <div class="col-md-12">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                                    <small class="text-danger">
                                        @foreach ($errors->get('jumlah') as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </small>
                                </div>
                                <div class="col-md-12">
                                    <label for="yang_mengambil" class="form-label">Yang Mengambil</label>
                                    <input type="text" class="form-control" id="yang_mengambil" value="Febri (Store Kiper)" name="yang_mengambil" readonly>
                                </div>
                               
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-5">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
