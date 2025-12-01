@extends('layouts.guest')

@section('title', 'Tentang Kami')

@push('styles')
<!-- Font Awesome CDN - Multiple Sources for Reliability -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.1/css/all.css" crossorigin="anonymous" />
<style>
/* SVG Icon Styles */
.svg-icon {
    width: 1em;
    height: 1em;
    fill: currentColor;
    vertical-align: -0.125em;
    display: inline-block;
}
.svg-icon-lg { width: 1.5em; height: 1.5em; }
.svg-icon-xl { width: 2em; height: 2em; }
.svg-icon-2x { width: 2em; height: 2em; }
.svg-icon-3x { width: 3em; height: 3em; }
.svg-icon-4x { width: 4em; height: 4em; }
.svg-icon-5x { width: 5em; height: 5em; }

/* Force Font Awesome Icons Visibility */
.fas, .far, .fab, .fa, .fa-solid, .fa-regular, .fa-brands,
i[class^="fa-"], i[class*=" fa-"] {
    font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands", "FontAwesome", sans-serif !important;
    font-style: normal !important;
    -webkit-font-smoothing: antialiased !important;
    -moz-osx-font-smoothing: grayscale !important;
    display: inline-block !important;
    visibility: visible !important;
    opacity: 1 !important;
    text-rendering: auto !important;
    line-height: 1 !important;
    speak: never !important;
}
.fas, .fa-solid, .fa { font-weight: 900 !important; }
.far, .fa-regular { font-weight: 400 !important; }
.fab, .fa-brands { font-family: "Font Awesome 6 Brands", "FontAwesome" !important; font-weight: 400 !important; }

/* Icon circle background */
.icon-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.icon-circle-lg {
    width: 70px;
    height: 70px;
}
.icon-circle-xl {
    width: 80px;
    height: 80px;
}
</style>
@endpush

@section('content')
<!-- Hero Section dengan Gradient Modern -->
<section class="py-5" style="background: linear-gradient(135deg, #1e5631 0%, #2d7a46 50%, #3d9a5c 100%); min-height: 350px;">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="me-1" viewBox="0 0 576 512"><path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V416c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v56c0 22.1-17.9 40-40 40H152 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/></svg>Beranda</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Tentang Kami</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold text-white mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="me-3" viewBox="0 0 384 512"><path d="M48 0C21.5 0 0 21.5 0 48V464c0 26.5 21.5 48 48 48h96V432c0-26.5 21.5-48 48-48s48 21.5 48 48v80h96c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48H48zM64 240c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V240zm112-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16V240c0-8.8 7.2-16 16-16zm80 16c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H272c-8.8 0-16-7.2-16-16V240zM80 96h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16zm80 16c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16V112zM272 96h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H272c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16z"/></svg>Tentang Kami
                </h1>
                <p class="lead text-white-50 mb-0" style="font-size: 1.2rem;">
                    Mengenal lebih dekat Dinas Pertanian Kabupaten Toba - Melayani dengan sepenuh hati untuk kemajuan pertanian daerah
                </p>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <div class="position-relative">
                    <div class="bg-white bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 200px; height: 200px; backdrop-filter: blur(10px);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="white" style="opacity: 0.9;" viewBox="0 0 512 512"><path d="M240 0c4.6 0 9.2 1 13.4 2.9L441.7 82.8c22 9.3 38.4 31 38.3 57.2c-.5 99.2-41.3 280.7-213.7 363.2c-16.7 8-36.1 8-52.8 0C41.3 420.7 .5 239.2 0 140c-.1-26.2 16.3-47.9 38.3-57.2L226.6 2.9C230.8 1 235.4 0 240 0zm0 66.8V444.8C394 378 431.1 230.1 432 141.4L240 66.8z"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Cards -->
<section class="py-0" style="margin-top: -50px;">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-lg h-100" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-body p-4 text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="bg-white bg-opacity-25 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="white" viewBox="0 0 640 512"><path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z"/></svg>
                        </div>
                        <h2 class="display-5 fw-bold text-white mb-1">50+</h2>
                        <p class="text-white-50 mb-0 fw-medium">Pegawai Aktif</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-lg h-100" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-body p-4 text-center" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <div class="bg-white bg-opacity-25 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="white" viewBox="0 0 448 512"><path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zM329 305c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-95 95-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L329 305z"/></svg>
                        </div>
                        <h2 class="display-5 fw-bold text-white mb-1">2005</h2>
                        <p class="text-white-50 mb-0 fw-medium">Tahun Berdiri</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-lg h-100" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-body p-4 text-center" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <div class="bg-white bg-opacity-25 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="white" viewBox="0 0 576 512"><path d="M384 476.1L192 421.2V35.9L384 90.8V476.1zm32-1.2V88.4L543.1 37.5c15.8-6.3 32.9 5.3 32.9 22.3V394.6c0 9.8-6 18.6-15.1 22.3L416 474.8zM15.1 95.1L160 37.2V423.6L32.9 474.5C17.1 480.8 0 469.2 0 452.2V117.4c0-9.8 6-18.6 15.1-22.3z"/></svg>
                        </div>
                        <h2 class="display-5 fw-bold text-white mb-1">16</h2>
                        <p class="text-white-50 mb-0 fw-medium">Kecamatan Layanan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Profile Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <!-- Profil Dinas -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-header py-4 border-0" style="background: linear-gradient(135deg, #1e5631 0%, #2d7a46 100%);">
                        <h4 class="mb-0 text-white fw-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="me-2" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>Profil Dinas
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start mb-4">
                            <div class="flex-shrink-0">
                                <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#198754" viewBox="0 0 512 512"><path d="M512 32c0 113.6-84.6 207.5-194.2 222c-7.1-53.4-30.6-101.6-65.3-139.3C290.8 46.3 364 0 448 0h32c17.7 0 32 14.3 32 32zM0 96C0 78.3 14.3 64 32 64H64c123.7 0 224 100.3 224 224v32V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V320C100.3 320 0 219.7 0 96z"/></svg>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-0 text-secondary" style="line-height: 1.8;">
                                    Dinas Pertanian Kabupaten Toba merupakan instansi pemerintah yang bergerak di bidang pertanian, 
                                    bertanggung jawab untuk mengembangkan dan memajukan sektor pertanian di wilayah Kabupaten Toba, 
                                    Sumatera Utara.
                                </p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#0d6efd" viewBox="0 0 512 512"><path d="M448 256A192 192 0 1 0 64 256a192 192 0 1 0 384 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm256 80a80 80 0 1 0 0-160 80 80 0 1 0 0 160zm0-224a144 144 0 1 1 0 288 144 144 0 1 1 0-288zM224 256a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/></svg>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-0 text-secondary" style="line-height: 1.8;">
                                    Kami berkomitmen untuk memberikan pelayanan terbaik kepada masyarakat petani melalui berbagai 
                                    program pemberdayaan, penyuluhan, dan bantuan pertanian yang berkelanjutan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alamat & Kontak -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-header py-4 border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <h4 class="mb-0 text-white fw-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="me-2" viewBox="0 0 384 512"><path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg>Alamat & Kontak
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex align-items-start mb-3 pb-3 border-bottom">
                                <div class="bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 45px; height: 45px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#dc3545" viewBox="0 0 384 512"><path d="M48 0C21.5 0 0 21.5 0 48V464c0 26.5 21.5 48 48 48h96V432c0-26.5 21.5-48 48-48s48 21.5 48 48v80h96c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48H48zM64 240c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V240zm112-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16V240c0-8.8 7.2-16 16-16zm80 16c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H272c-8.8 0-16-7.2-16-16V240zM80 96h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16zm80 16c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16V112zM272 96h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H272c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16z"/></svg>
                                </div>
                                <div class="ms-3">
                                    <small class="text-muted d-block">Alamat Kantor</small>
                                    <span class="fw-medium">Jl. Parbuluan No. 1, Balige, Kabupaten Toba, Sumatera Utara</span>
                                </div>
                            </li>
                            <li class="d-flex align-items-start mb-3 pb-3 border-bottom">
                                <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 45px; height: 45px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#198754" viewBox="0 0 512 512"><path d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/></svg>
                                </div>
                                <div class="ms-3">
                                    <small class="text-muted d-block">Telepon</small>
                                    <span class="fw-medium">(0632) 21234</span>
                                </div>
                            </li>
                            <li class="d-flex align-items-start mb-3 pb-3 border-bottom">
                                <div class="bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 45px; height: 45px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#0dcaf0" viewBox="0 0 512 512"><path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/></svg>
                                </div>
                                <div class="ms-3">
                                    <small class="text-muted d-block">Email</small>
                                    <span class="fw-medium">dinas.pertanian@tobakab.go.id</span>
                                </div>
                            </li>
                            <li class="d-flex align-items-start">
                                <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 45px; height: 45px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#ffc107" viewBox="0 0 512 512"><path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"/></svg>
                                </div>
                                <div class="ms-3">
                                    <small class="text-muted d-block">Jam Operasional</small>
                                    <span class="fw-medium">Senin - Jumat, 08:00 - 16:00 WIB</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Visi Misi Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Visi -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-body p-0">
                        <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                            <div class="bg-white bg-opacity-25 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white" viewBox="0 0 576 512"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg>
                            </div>
                            <h3 class="fw-bold mb-0">VISI</h3>
                        </div>
                        <div class="p-4">
                            <div class="bg-light rounded-3 p-4 text-center">
                                <p class="mb-0 text-secondary fst-italic" style="font-size: 1.1rem; line-height: 1.8;">
                                    "Mewujudkan pertanian yang maju, mandiri, dan berkelanjutan untuk kesejahteraan masyarakat Kabupaten Toba"
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Misi -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-body p-0">
                        <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #f5af19 0%, #f12711 100%);">
                            <div class="bg-white bg-opacity-25 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white" viewBox="0 0 512 512"><path d="M448 256A192 192 0 1 0 64 256a192 192 0 1 0 384 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm256 80a80 80 0 1 0 0-160 80 80 0 1 0 0 160zm0-224a144 144 0 1 1 0 288 144 144 0 1 1 0-288zM224 256a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/></svg>
                            </div>
                            <h3 class="fw-bold mb-0">MISI</h3>
                        </div>
                        <div class="p-4">
                            <ul class="list-unstyled mb-0">
                                <li class="d-flex align-items-start mb-3">
                                    <span class="badge rounded-pill me-3 flex-shrink-0" style="background: linear-gradient(135deg, #f5af19 0%, #f12711 100%); width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;">1</span>
                                    <span class="text-secondary">Meningkatkan produksi dan produktivitas pertanian</span>
                                </li>
                                <li class="d-flex align-items-start mb-3">
                                    <span class="badge rounded-pill me-3 flex-shrink-0" style="background: linear-gradient(135deg, #f5af19 0%, #f12711 100%); width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;">2</span>
                                    <span class="text-secondary">Mengembangkan infrastruktur pertanian yang memadai</span>
                                </li>
                                <li class="d-flex align-items-start mb-3">
                                    <span class="badge rounded-pill me-3 flex-shrink-0" style="background: linear-gradient(135deg, #f5af19 0%, #f12711 100%); width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;">3</span>
                                    <span class="text-secondary">Meningkatkan kapasitas SDM pertanian</span>
                                </li>
                                <li class="d-flex align-items-start">
                                    <span class="badge rounded-pill me-3 flex-shrink-0" style="background: linear-gradient(135deg, #f5af19 0%, #f12711 100%); width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;">4</span>
                                    <span class="text-secondary">Mewujudkan pertanian ramah lingkungan</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Struktur Organisasi -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge px-4 py-2 mb-3" style="background: linear-gradient(135deg, #1e5631 0%, #2d7a46 100%); font-size: 0.9rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white" class="me-2" viewBox="0 0 576 512"><path d="M208 80c0-26.5 21.5-48 48-48h64c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48h-8v40H464c30.9 0 56 25.1 56 56v32h8c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H464c-26.5 0-48-21.5-48-48V368c0-26.5 21.5-48 48-48h8V288c0-4.4-3.6-8-8-8H312v40h8c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H256c-26.5 0-48-21.5-48-48V368c0-26.5 21.5-48 48-48h8V280H112c-4.4 0-8 3.6-8 8v32h8c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V368c0-26.5 21.5-48 48-48h8V288c0-30.9 25.1-56 56-56H264V192h-8c-26.5 0-48-21.5-48-48V80z"/></svg>Struktur Organisasi
            </span>
            <h2 class="fw-bold text-dark mb-3">Pimpinan Dinas Pertanian</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">
                Tim pimpinan yang berdedikasi untuk memajukan sektor pertanian di Kabupaten Toba
            </p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <!-- Kepala Dinas -->
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm text-center h-100" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-body p-4">
                        <div class="position-relative d-inline-block mb-4">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 120px; height: 120px; background: linear-gradient(135deg, #1e5631 0%, #2d7a46 100%);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="white" viewBox="0 0 448 512"><path d="M224 0c70.7 0 128 57.3 128 128s-57.3 128-128 128S96 198.7 96 128 153.3 0 224 0zm-14.9 359.2-18.6-31c-6.4-10.7-1.3-24.2 10.7-28.4l16.8-5.6V274.8c-52.5 12.1-108 36.1-108 83.2 0 34.6 54.7 44.5 108 46.6zm28.8 0c53.3-2.1 108-12 108-46.6 0-47.1-55.5-71.1-108-83.2v19.4l16.8 5.6c12 4.2 17.1 17.7 10.7 28.4l-18.6 31c-1.8 3-4.6 5.4-7.9 6.8h-1zm4.4-264.1l-18.3 30.5 52.3 17.4c6 2 10.2 7.5 10.2 13.9 0 8-6.5 14.5-14.5 14.5H176.5c-8 0-14.5-6.5-14.5-14.5 0-6.4 4.2-12 10.2-13.9l52.3-17.4-18.3-30.5c-3.2-5.3-3.2-12 0-17.2l18.3-30.5-52.3-17.4c-6-2-10.2-7.5-10.2-13.9 0-8 6.5-14.5 14.5-14.5H271.5c8 0 14.5 6.5 14.5 14.5 0 6.4-4.2 12-10.2 13.9l-52.3 17.4 18.3 30.5c3.2 5.3 3.2 12 0 17.2zM38.6 367.5C15.7 369.5 0 385.3 0 408v8c0 30.9 25.1 56 56 56h336c30.9 0 56-25.1 56-56v-8c0-22.7-15.7-38.5-38.6-40.5-.3 32-13.1 62.5-38.4 82.9-28.3 22.8-69.2 33.6-111 33.6s-82.7-10.8-111-33.6c-25.4-20.4-38.2-50.9-38.4-82.9z"/></svg>
                            </div>
                            <span class="position-absolute bottom-0 end-0 bg-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" viewBox="0 0 576 512"><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg>
                            </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Ir. Mangapul Siahaan, M.Si</h5>
                        <span class="badge px-3 py-2 mb-3" style="background: linear-gradient(135deg, #1e5631 0%, #2d7a46 100%);">Kepala Dinas</span>
                        <p class="text-muted small mb-0">Memimpin dan mengkoordinasikan seluruh kegiatan dinas</p>
                    </div>
                </div>
            </div>

            <!-- Sekretaris -->
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm text-center h-100" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-body p-4">
                        <div class="position-relative d-inline-block mb-4">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 120px; height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="white" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
                            </div>
                            <span class="position-absolute bottom-0 end-0 bg-info rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" viewBox="0 0 384 512"><path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM112 256H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>
                            </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Drs. Parulian Hutabarat</h5>
                        <span class="badge px-3 py-2 mb-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">Sekretaris</span>
                        <p class="text-muted small mb-0">Mengelola administrasi dan kesekretariatan</p>
                    </div>
                </div>
            </div>

            <!-- Kabid Tanaman Pangan -->
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm text-center h-100" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-body p-4">
                        <div class="position-relative d-inline-block mb-4">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 120px; height: 120px; background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="white" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
                            </div>
                            <span class="position-absolute bottom-0 end-0 bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" viewBox="0 0 512 512"><path d="M272 96c-78.6 0-145.1 51.5-167.7 122.5c33.6-17 71.5-26.5 111.7-26.5h88c8.8 0 16 7.2 16 16s-7.2 16-16 16H288 216s0 0 0 0c-16.6 0-32.7 1.9-48.2 5.4c-25.9 5.9-50 16.4-71.4 30.7c0 0 0 0 0 0C38.3 298.8 0 364.9 0 440v16c0 13.3 10.7 24 24 24s24-10.7 24-24V440c0-48.7 20.7-92.5 53.8-123.2C121.6 392.3 190.3 448 272 448l1 0c132.1-.7 239-130.9 239-291.4c0-42.6-7.5-83.1-21.1-119.6c-2.6-6.9-12.7-6.6-16.2-.1C455.9 72.1 418.7 96 376 96L272 96z"/></svg>
                            </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Ir. Romaulina Simbolon</h5>
                        <span class="badge px-3 py-2 mb-3" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">Kabid Tanaman Pangan</span>
                        <p class="text-muted small mb-0">Mengembangkan sektor tanaman pangan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Layanan Kami -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge px-4 py-2 mb-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); font-size: 0.9rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white" class="me-2" viewBox="0 0 512 512"><path d="M216 64c-13.3 0-24 10.7-24 24s10.7 24 24 24h16v33.3C119.6 157.2 32 252.4 32 368H480c0-115.6-87.6-210.8-200-222.7V112h16c13.3 0 24-10.7 24-24s-10.7-24-24-24H256 216zM24 400c-13.3 0-24 10.7-24 24s10.7 24 24 24H488c13.3 0 24-10.7 24-24s-10.7-24-24-24H24z"/></svg>Layanan
            </span>
            <h2 class="fw-bold text-dark mb-3">Layanan Kami</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">
                Berbagai layanan yang kami sediakan untuk mendukung kemajuan pertanian
            </p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 text-center" style="border-radius: 20px; transition: all 0.3s ease;">
                    <div class="card-body p-4">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px; background: linear-gradient(135deg, #1e5631 0%, #2d7a46 100%);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white" viewBox="0 0 640 512"><path d="M160 64c0-35.3 28.7-64 64-64H576c35.3 0 64 28.7 64 64V352c0 35.3-28.7 64-64 64H336.8c-11.8-25.5-29.9-47.5-52.4-64H384V320c0-17.7 14.3-32 32-32h64c17.7 0 32 14.3 32 32v32h64V64L224 64v49.1C205.2 102.2 183.3 96 160 96V64zm0 64a96 96 0 1 1 0 192 96 96 0 1 1 0-192zM133.3 352h53.3C260.3 352 320 411.7 320 485.3c0 14.7-11.9 26.7-26.7 26.7H26.7C11.9 512 0 500.1 0 485.3C0 411.7 59.7 352 133.3 352z"/></svg>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">Penyuluhan</h5>
                        <p class="text-muted small mb-0">Program penyuluhan dan pelatihan untuk meningkatkan keterampilan petani</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 text-center" style="border-radius: 20px; transition: all 0.3s ease;">
                    <div class="card-body p-4">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white" viewBox="0 0 576 512"><path d="M312 24V34.5c6.4 1.2 12.6 2.7 18.2 4.2c12.8 3.4 20.4 16.6 17 29.4s-16.6 20.4-29.4 17c-10.9-2.9-21.1-4.9-30.2-5c-7.3-.1-14.7 1.7-19.4 4.4c-2.1 1.3-3.1 2.4-3.5 3c-.3 .5-.7 1.2-.7 2.8c0 .3 0 .5 0 .6c.2 .2 .9 1.2 3.3 2.6c5.8 3.5 14.4 6.2 27.4 10.1l.9 .3 0 0c11.1 3.3 25.9 7.8 37.9 15.3c13.7 8.6 26.1 22.9 26.4 44.9c.3 22.5-11.4 38.9-26.7 48.5c-6.7 4.1-13.9 7-21.3 8.8V232c0 13.3-10.7 24-24 24s-24-10.7-24-24V220.6c-9.5-2.3-18.2-5.3-25.6-7.8c-2.1-.7-4.1-1.4-6-2c-12.6-4.2-19.4-17.8-15.2-30.4s17.8-19.4 30.4-15.2c2.6 .9 5 1.7 7.3 2.5c13.6 4.6 23.4 7.9 33.9 8.3c8 .3 15.1-1.6 19.2-4.1c1.9-1.2 2.8-2.2 3.2-2.9c.4-.6 .9-1.8 .8-4.1l0-.2c0-1 0-2.1-4-4.6c-5.7-3.6-14.3-6.4-27.1-10.3l-1.9-.6c-10.8-3.2-25-7.5-36.4-14.4c-13.5-8.1-26.5-22-26.6-44.1c-.1-22.9 12.9-38.6 27.7-47.4c6.4-3.8 13.3-6.4 20.2-8.2V24c0-13.3 10.7-24 24-24s24 10.7 24 24zM568.2 336.3c13.1 17.8 9.3 42.8-8.5 55.9L433.1 485.5c-23.4 17.2-51.6 26.5-80.7 26.5H192 32c-17.7 0-32-14.3-32-32V416c0-17.7 14.3-32 32-32H68.8l44.9-36c22.7-18.2 50.9-28 80-28H272h16 64c17.7 0 32 14.3 32 32s-14.3 32-32 32H288 272c-8.8 0-16 7.2-16 16s7.2 16 16 16H392.6l119.7-88.2c17.8-13.1 42.8-9.3 55.9 8.5z"/></svg>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">Bantuan Pertanian</h5>
                        <p class="text-muted small mb-0">Penyaluran bantuan bibit, pupuk, dan alat pertanian</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 text-center" style="border-radius: 20px; transition: all 0.3s ease;">
                    <div class="card-body p-4">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white" viewBox="0 0 384 512"><path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM80 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm16 96H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V256c0-17.7 14.3-32 32-32z"/></svg>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">Perizinan</h5>
                        <p class="text-muted small mb-0">Layanan perizinan usaha pertanian dan rekomendasi teknis</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 text-center" style="border-radius: 20px; transition: all 0.3s ease;">
                    <div class="card-body p-4">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px; background: linear-gradient(135deg, #f5af19 0%, #f12711 100%);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white" viewBox="0 0 512 512"><path d="M256 48C141.1 48 48 141.1 48 256v40c0 13.3-10.7 24-24 24s-24-10.7-24-24V256C0 114.6 114.6 0 256 0S512 114.6 512 256V400.1c0 48.6-39.4 88-88.1 88L313.6 488c-8.3 14.3-23.8 24-41.6 24H240c-26.5 0-48-21.5-48-48s21.5-48 48-48h32c17.8 0 33.3 9.7 41.6 24l110.4 .1c22.1 0 40-17.9 40-40V256c0-114.9-93.1-208-208-208zM144 208h16c17.7 0 32 14.3 32 32V352c0 17.7-14.3 32-32 32H144c-35.3 0-64-28.7-64-64V272c0-35.3 28.7-64 64-64zm224 0c35.3 0 64 28.7 64 64v48c0 35.3-28.7 64-64 64H352c-17.7 0-32-14.3-32-32V240c0-17.7 14.3-32 32-32h16z"/></svg>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">Konsultasi</h5>
                        <p class="text-muted small mb-0">Konsultasi teknis budidaya dan penanganan hama penyakit</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sejarah & Timeline -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge px-4 py-2 mb-3" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); font-size: 0.9rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white" class="me-2" viewBox="0 0 512 512"><path d="M75 75L41 41C25.9 25.9 0 36.6 0 57.9V168c0 13.3 10.7 24 24 24H134.1c21.4 0 32.1-25.9 17-41l-30.8-30.8C155 85.5 203 64 256 64c106 0 192 86 192 192s-86 192-192 192c-40.8 0-78.6-12.7-109.7-34.4c-14.5-10.1-34.4-6.6-44.6 7.9s-6.6 34.4 7.9 44.6C151.2 495 201.7 512 256 512c141.4 0 256-114.6 256-256S397.4 0 256 0C185.3 0 121.3 28.7 75 75zm181 53c-13.3 0-24 10.7-24 24V256c0 6.4 2.5 12.5 7 17l72 72c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-65-65V152c0-13.3-10.7-24-24-24z"/></svg>Perjalanan Kami
            </span>
            <h2 class="fw-bold text-dark mb-3">Sejarah Singkat</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">
                Perjalanan Dinas Pertanian Kabupaten Toba dalam melayani masyarakat
            </p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge me-2" style="background: linear-gradient(135deg, #1e5631 0%, #2d7a46 100%);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="white" class="me-1" viewBox="0 0 448 512"><path d="M64 32C64 14.3 49.7 0 32 0S0 14.3 0 32V64 368 480c0 17.7 14.3 32 32 32s32-14.3 32-32V352l64.3-16.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30V66.1c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L64 48V32z"/></svg>2005
                                </span>
                                <h6 class="mb-0 fw-bold">Pembentukan Dinas</h6>
                            </div>
                            <p class="text-muted small mb-0">Dinas Pertanian Kabupaten Toba resmi dibentuk seiring pemekaran kabupaten dari Kabupaten Tapanuli Utara</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge me-2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="white" class="me-1" viewBox="0 0 384 512"><path d="M48 0C21.5 0 0 21.5 0 48V464c0 26.5 21.5 48 48 48h96V432c0-26.5 21.5-48 48-48s48 21.5 48 48v80h96c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48H48zM64 240c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V240z"/></svg>2010
                                </span>
                                <h6 class="mb-0 fw-bold">Pembangunan Kantor Baru</h6>
                            </div>
                            <p class="text-muted small mb-0">Peresmian gedung kantor baru yang representatif untuk pelayanan masyarakat yang lebih baik</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge me-2" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="white" class="me-1" viewBox="0 0 640 512"><path d="M128 32C92.7 32 64 60.7 64 96V352h64V96H512V352h64V96c0-35.3-28.7-64-64-64H128zM19.2 384C8.6 384 0 392.6 0 403.2C0 445.6 34.4 480 76.8 480H563.2c42.4 0 76.8-34.4 76.8-76.8c0-10.6-8.6-19.2-19.2-19.2H19.2z"/></svg>2020
                                </span>
                                <h6 class="mb-0 fw-bold">Digitalisasi Layanan</h6>
                            </div>
                            <p class="text-muted small mb-0">Meluncurkan sistem informasi pertanian digital untuk kemudahan akses layanan</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge me-2" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="white" class="me-1" viewBox="0 0 512 512"><path d="M156.6 384.9L125.7 354c-8.5-8.5-11.5-20.8-7.7-32.2c3-8.9 7-17.5 11.9-25.7l.2 .3c21.4-32.4 51.3-60.9 84.5-83.3c20.8-14 43.2-25.5 66.6-33.8c-4.3 21.4-2.4 43.4 5.4 63.8c7.8 20.3 21.4 38.4 39.4 51.8c18 13.5 39.3 21.4 61.5 23c22.1 1.6 44.5-2.6 64.5-12.1c-2.6 24.3-11 47.9-24.5 68.5c-13.5 20.6-32 38-53.2 50.5s-45.1 19.5-69.2 20.2c-24.2 .7-48.3-4.9-69.8-16.2c-7.2 4.8-14.8 8.8-22.8 12.1c-11.5 4.6-23.2 7.1-35 7.4c-5.3 .1-10.7-.4-15.9-1.4c-11 2.2-22.3 3.4-33.9 3.4c-10.9 0-21.5-1.1-31.8-3.1l-4.1-.8c7.2-2 14.1-4.6 20.6-7.7c7.3-3.4 14.3-7.5 21-12.3c6.3-4.5 12.1-9.5 17.3-15l3.2-3.3zm257.3-82.5c-12.8-14.6-21.8-32.2-26.3-51.1c-4.4-18.9-4.1-38.5 .9-57.3c5-18.8 14.8-36.1 28.2-50.2C429.8 130.7 446.8 121 464.7 116c18.1-5 37.2-5.3 55.4-.9c18.2 4.4 35.3 13.5 49.1 26.3c-26.4-2.2-50.6 8.1-65.4 27.3c-14.7 19.1-19.4 44.8-12.7 69.5c6.7 24.7 23.1 45.5 44.3 56.3c21.2 10.8 46.2 11.2 67.6 1.1c-8.9 23.5-26.5 43.2-49.2 55.1c-22.8 11.9-49.2 15.2-73.7 9.3c-24.5-5.9-46.5-20.6-61.4-41.2z"/></svg>2024
                                </span>
                                <h6 class="mb-0 fw-bold">Transformasi Digital</h6>
                            </div>
                            <p class="text-muted small mb-0">Penerapan teknologi modern untuk meningkatkan efisiensi dan transparansi layanan pertanian</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tugas Pokok & Fungsi -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge px-4 py-2 mb-3" style="background: linear-gradient(135deg, #f5af19 0%, #f12711 100%); font-size: 0.9rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white" class="me-2" viewBox="0 0 512 512"><path d="M152.1 38.2c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 113C-2.3 103.6-2.3 88.4 7 79s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zm0 160c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 273c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zM224 96c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zm0 160c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zM160 416c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H192c-17.7 0-32-14.3-32-32zM48 368a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg>Tupoksi
            </span>
            <h2 class="fw-bold text-dark mb-3">Tugas Pokok & Fungsi</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">
                Tugas dan fungsi utama Dinas Pertanian dalam melayani masyarakat
            </p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #1e5631 0%, #2d7a46 100%);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 384 512"><path d="M192 0c-41.8 0-77.4 26.7-90.5 64H64C28.7 64 0 92.7 0 128V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H282.5C269.4 26.7 233.8 0 192 0zm0 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM72 272a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zm104-16H304c8.8 0 16 7.2 16 16s-7.2 16-16 16H176c-8.8 0-16-7.2-16-16s7.2-16 16-16zM72 368a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zm104-16H304c8.8 0 16 7.2 16 16s-7.2 16-16 16H176c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>
                            </div>
                            <h5 class="fw-bold mb-0">Tugas Pokok</h5>
                        </div>
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex align-items-start mb-3">
                                <span class="badge rounded-pill bg-success me-3 mt-1">
                                    ✓
                                </span>
                                <span class="text-secondary">Merumuskan kebijakan teknis bidang pertanian tanaman pangan dan hortikultura</span>
                            </li>
                            <li class="d-flex align-items-start mb-3">
                                <span class="badge rounded-pill bg-success me-3 mt-1">
                                    ✓
                                </span>
                                <span class="text-secondary">Menyelenggarakan urusan pemerintahan dan pelayanan umum</span>
                            </li>
                            <li class="d-flex align-items-start mb-3">
                                <span class="badge rounded-pill bg-success me-3 mt-1">
                                    ✓
                                </span>
                                <span class="text-secondary">Membina dan melaksanakan tugas bidang pertanian</span>
                            </li>
                            <li class="d-flex align-items-start">
                                <span class="badge rounded-pill bg-success me-3 mt-1">
                                    ✓
                                </span>
                                <span class="text-secondary">Melaksanakan tugas lain yang diberikan oleh Bupati</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 640 512"><path d="M308.5 135.3c7.1-6.3 9.9-16.2 6.2-25c-2.3-5.3-4.8-10.5-7.6-15.5L304 89.4c-3-5-6.3-9.9-9.8-14.6c-5.7-7.6-15.7-10.1-24.7-7.1l-28.2 9.3c-10.7-8.8-23-16-36.2-20.9L199 27.1c-1.9-9.3-9.1-16.7-18.5-17.8C173.9 8.4 167.2 8 160.4 8h-.7c-6.8 0-13.5 .4-20.1 1.2c-9.4 1.1-16.6 8.6-18.5 17.8L115 56.1c-13.3 5-25.5 12.1-36.2 20.9L50.6 67.7c-9-3-18.9-.5-24.7 7.1c-3.5 4.7-6.8 9.6-9.9 14.6l-3 5.3c-2.8 5-5.3 10.2-7.6 15.6c-3.7 8.7-.9 18.6 6.2 25l22.2 19.8C32.6 161.9 32 168.9 32 176s.6 14.1 1.7 20.9L11.5 216.7c-7.1 6.3-9.9 16.2-6.2 25c2.3 5.3 4.8 10.5 7.6 15.6l3 5.2c3 5.1 6.3 9.9 9.9 14.6c5.7 7.6 15.7 10.1 24.7 7.1l28.2-9.3c10.7 8.8 23 16 36.2 20.9l6.1 29.1c1.9 9.3 9.1 16.7 18.5 17.8c6.7 .8 13.5 1.2 20.4 1.2s13.7-.4 20.4-1.2c9.4-1.1 16.6-8.6 18.5-17.8l6.1-29.1c13.3-5 25.5-12.1 36.2-20.9l28.2 9.3c9 3 18.9 .5 24.7-7.1c3.5-4.7 6.8-9.5 9.8-14.6l3.1-5.4c2.8-5 5.3-10.2 7.6-15.5c3.7-8.7 .9-18.6-6.2-25l-22.2-19.8c1.1-6.8 1.7-13.8 1.7-20.9s-.6-14.1-1.7-20.9l22.2-19.8zM112 176a48 48 0 1 1 96 0 48 48 0 1 1 -96 0z"/></svg>
                            </div>
                            <h5 class="fw-bold mb-0">Fungsi</h5>
                        </div>
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex align-items-start mb-3">
                                <span class="badge rounded-pill bg-primary me-3 mt-1">
                                    ✓
                                </span>
                                <span class="text-secondary">Penyusunan program kerja bidang pertanian</span>
                            </li>
                            <li class="d-flex align-items-start mb-3">
                                <span class="badge rounded-pill bg-primary me-3 mt-1">
                                    ✓
                                </span>
                                <span class="text-secondary">Pelaksanaan koordinasi dengan instansi terkait</span>
                            </li>
                            <li class="d-flex align-items-start mb-3">
                                <span class="badge rounded-pill bg-primary me-3 mt-1">
                                    ✓
                                </span>
                                <span class="text-secondary">Pembinaan dan pengawasan teknis pertanian</span>
                            </li>
                            <li class="d-flex align-items-start">
                                <span class="badge rounded-pill bg-primary me-3 mt-1">
                                    ✓
                                </span>
                                <span class="text-secondary">Pengelolaan administrasi dan keuangan</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge px-4 py-2 mb-3" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); font-size: 0.9rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white" class="me-2" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/></svg>FAQ
            </span>
            <h2 class="fw-bold text-dark mb-3">Pertanyaan Umum</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">
                Jawaban untuk pertanyaan yang sering diajukan
            </p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 mb-3" style="border-radius: 15px; overflow: hidden; box-shadow: 0 3px 15px rgba(0,0,0,0.08);">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" style="border-radius: 15px;">
                                <span class="text-success me-2 fw-bold">❓</span>Bagaimana cara mengajukan bantuan pertanian?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                <p class="mb-0">Petani dapat mengajukan bantuan melalui:</p>
                                <ol class="mb-0 mt-2">
                                    <li>Login ke sistem dengan akun yang terdaftar</li>
                                    <li>Pilih menu "Pengajuan Bantuan"</li>
                                    <li>Isi formulir pengajuan dengan lengkap</li>
                                    <li>Upload dokumen pendukung yang diperlukan</li>
                                    <li>Tunggu verifikasi dari petugas</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 mb-3" style="border-radius: 15px; overflow: hidden; box-shadow: 0 3px 15px rgba(0,0,0,0.08);">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" style="border-radius: 15px;">
                                <span class="text-success me-2 fw-bold">❓</span>Apa saja syarat untuk mendaftar sebagai petani?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                <p class="mb-0">Syarat pendaftaran sebagai petani:</p>
                                <ul class="mb-0 mt-2">
                                    <li>WNI dan berdomisili di Kabupaten Toba</li>
                                    <li>Memiliki KTP dan KK yang masih berlaku</li>
                                    <li>Memiliki lahan pertanian atau menggarap lahan</li>
                                    <li>Aktif dalam kegiatan usaha tani</li>
                                    <li>Bersedia mengikuti penyuluhan pertanian</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 mb-3" style="border-radius: 15px; overflow: hidden; box-shadow: 0 3px 15px rgba(0,0,0,0.08);">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" style="border-radius: 15px;">
                                <span class="text-success me-2 fw-bold">❓</span>Berapa lama proses verifikasi pengajuan bantuan?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Proses verifikasi pengajuan bantuan biasanya memakan waktu <strong>3-7 hari kerja</strong> tergantung kelengkapan dokumen. Status pengajuan dapat dipantau melalui dashboard akun petani Anda.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0" style="border-radius: 15px; overflow: hidden; box-shadow: 0 3px 15px rgba(0,0,0,0.08);">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" style="border-radius: 15px;">
                                <span class="text-success me-2 fw-bold">❓</span>Bagaimana cara melaporkan hasil panen?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                <p class="mb-0">Untuk melaporkan hasil panen:</p>
                                <ol class="mb-0 mt-2">
                                    <li>Login ke sistem sebagai petani</li>
                                    <li>Pilih menu "Laporan Panen"</li>
                                    <li>Isi informasi hasil panen (komoditas, jumlah, tanggal)</li>
                                    <li>Upload foto hasil panen (opsional)</li>
                                    <li>Kirim laporan untuk diverifikasi</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255,255,255,0.5);
    }
    
    /* Timeline styles */
    .timeline {
        position: relative;
        padding: 20px 0;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, #1e5631, #3d9a5c);
        border-radius: 2px;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 30px;
    }
    .timeline-item:last-child {
        margin-bottom: 0;
    }
    .timeline-dot {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        width: 20px;
        height: 20px;
        background: #1e5631;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 0 0 4px rgba(30, 86, 49, 0.2);
        z-index: 1;
    }
    .timeline-content {
        width: 45%;
        padding: 20px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    .timeline-item:nth-child(odd) .timeline-content {
        margin-left: auto;
    }
    @media (max-width: 768px) {
        .timeline::before {
            left: 20px;
        }
        .timeline-dot {
            left: 20px;
        }
        .timeline-content {
            width: calc(100% - 60px);
            margin-left: 50px !important;
        }
    }
    
    /* Accordion custom */
    .accordion-button:not(.collapsed) {
        background: linear-gradient(135deg, #1e5631 0%, #2d7a46 100%);
        color: white;
    }
    .accordion-button:focus {
        box-shadow: 0 0 0 0.25rem rgba(30, 86, 49, 0.25);
    }
    
    /* Service card hover */
    .service-card {
        transition: all 0.4s ease;
    }
    .service-card:hover {
        transform: translateY(-10px) scale(1.02);
    }
    .service-card:hover .service-icon {
        transform: rotateY(180deg);
    }
    .service-icon {
        transition: transform 0.6s ease;
    }
    
    /* Counter animation */
    .counter-number {
        font-size: 3rem;
        font-weight: 800;
        background: linear-gradient(135deg, #fff 0%, #e0e0e0 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>
@endsection
