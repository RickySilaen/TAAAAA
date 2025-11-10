@extends('layouts.guest')

@section('title', 'Tentang Kami - Sistem Pertanian Kabupaten Toba')

@section('content')
<style>
    /* Tema hijau turquoise */
    .text-toba {
        color: #007E4E !important;
    }
    .bg-toba {
        background-color: #00A676 !important;
    }
    .border-toba {
        border-color: #00A676 !important;
    }
    .card-custom {
        border: none;
        border-top: 4px solid #00A676;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    .card-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 166, 118, 0.2);
    }
    .icon-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(0, 166, 118, 0.1);
        color: #00A676;
        font-size: 20px;
        margin-right: 15px;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-5">
                    <h3 class="text-center text-toba mb-4 fw-bold">Profil Sistem Pertanian Kabupaten Toba</h3>
                    <p class="text-muted text-center mb-5">
                        Sistem Pertanian Kabupaten Toba merupakan platform digital yang dikembangkan untuk mendukung program
                        Dinas Pertanian dan Perikanan Kabupaten Toba dalam meningkatkan produktivitas pertanian, efisiensi distribusi bantuan,
                        serta kemudahan pelaporan hasil panen secara digital.
                    </p>

                    <h5 class="fw-bold text-toba mb-3">Visi</h5>
                    <p class="mb-4">
                        “Terwujudnya pertanian yang mandiri, berdaya saing, dan berkelanjutan melalui penerapan teknologi digital.”
                    </p>

                    <h5 class="fw-bold text-toba mb-3">Misi</h5>
                    <ul>
                        <li>Meningkatkan pelayanan publik melalui sistem informasi pertanian berbasis digital.</li>
                        <li>Mendukung kesejahteraan petani melalui data yang akurat dan transparan.</li>
                        <li>Mendorong inovasi dalam pengelolaan sumber daya pertanian di Kabupaten Toba.</li>
                    </ul>

                    <h5 class="fw-bold text-toba mt-5 mb-3">Fitur Utama Sistem</h5>
                    <div class="row text-center">
                        <div class="col-md-3 mb-4">
                            <div class="card card-custom p-3">
                                <i class="fas fa-chart-line text-toba fs-2 mb-2"></i>
                                <p class="fw-semibold mb-1">Laporan Panen</p>
                                <small class="text-muted">Pelaporan hasil panen petani secara digital.</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card card-custom p-3">
                                <i class="fas fa-hand-holding-heart text-warning fs-2 mb-2"></i>
                                <p class="fw-semibold mb-1">Bantuan Pertanian</p>
                                <small class="text-muted">Distribusi bantuan dengan data yang terintegrasi.</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card card-custom p-3">
                                <i class="fas fa-users text-info fs-2 mb-2"></i>
                                <p class="fw-semibold mb-1">Manajemen Petani</p>
                                <small class="text-muted">Data petani tersimpan dalam sistem terpusat.</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card card-custom p-3">
                                <i class="fas fa-seedling text-success fs-2 mb-2"></i>
                                <p class="fw-semibold mb-1">Hasil Panen</p>
                                <small class="text-muted">Monitoring hasil panen dan produktivitas daerah.</small>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-bold text-toba mt-5 mb-3">Informasi Kontak</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex mb-3">
                                <div class="icon-circle">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <p class="fw-semibold mb-1">Alamat</p>
                                    <p class="text-muted mb-0">
                                        Dinas Pertanian & Perikanan Kabupaten Toba<br>
                                        Jl. Soposurung, Balige, Kabupaten Toba, Sumatera Utara 22312
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="icon-circle">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <p class="fw-semibold mb-1">Telepon</p>
                                    <p class="text-muted mb-0">(0632) 21312</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="icon-circle">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <p class="fw-semibold mb-1">Email</p>
                                    <p class="text-muted mb-0">distan@tobakab.go.id</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="ratio ratio-16x9 shadow-sm rounded overflow-hidden">
                                <iframe 
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127671.04729903108!2d99.012774!3d2.329974!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x302e0422832c1ced%3A0xeb88003792bf02ce!2sDinas%20Pertanian%20%26%20Perikanan%20Tobasa!5e0!3m2!1sid!2sid!4v1730341020000!5m2!1sid!2sid"
                                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-3">
                <small class="text-muted">
                    &copy; {{ date('Y') }} Dinas Pertanian & Perikanan Kabupaten Toba. Semua hak dilindungi.
                </small>
            </div>
        </div>
    </div>
</div>
@endsection
