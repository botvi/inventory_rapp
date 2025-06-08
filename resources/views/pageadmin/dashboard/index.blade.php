@extends('template-admin.layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 text-center mb-4">
                    <img src="{{ asset('env') }}/logo_text.jpg" width="250" alt="Logo RAPP" class="img-fluid">
                    <p class="mt-3">
                        PT Riau Andalan Pulp and Paper (PT RAPP) adalah perusahaan pulp dan kertas besar di Indonesia yang
                        merupakan bagian dari APRIL Group. PT RAPP beroperasi di Provinsi Riau, Indonesia, dengan pabrik
                        utama di Pangkalan Kerinci. Perusahaan ini dikenal karena produksi pulp dan kertas skala besar,
                        serta berbagai program pengembangan masyarakat dan lingkungan.
                    </p>
                </div>
            </div>

            <div class="row justify-content-center mt-4">
                <div class="col-md-5">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Stok Barang Masuk</h5>
                        </div>
                        <div class="card-body text-center">
                            <h2 class="display-4 text-primary">{{ $barang_masuk }}</h2>
                            <p class="text-muted">Pieces</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card border-success">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0">Stok Barang Keluar</h5>
                        </div>
                        <div class="card-body text-center">
                            <h2 class="display-4 text-success">{{ $barang_keluar }}</h2>
                            <p class="text-muted">Pieces</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
