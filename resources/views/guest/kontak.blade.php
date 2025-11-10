@extends('layouts.guest')

@section('title', 'Kontak Kami - Sistem Pertanian')

@section('content')
<!-- ======= Page Header ======= -->
<section class="py-5 text-center text-white" style="background: linear-gradient(135deg, #1b5e20, #2e7d32); border-bottom-left-radius: 40% 15%; border-bottom-right-radius: 40% 15%; margin-bottom: 3rem; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
    <div class="container pt-4">
        <h2 class="fw-bold mb-2 display-5">Kontak Kami</h2>
        <p class="mb-0 lead opacity-90">Dinas Pertanian Kabupaten Toba</p>
    </div>
</section>

<!-- ======= Contact Section ======= -->
<section class="contact py-5" style="background-color: #f8f9fa; margin-top: -2rem;">
    <div class="container">
        <div class="row g-5">
            <!-- Info Kontak -->
            <div class="col-lg-5">
                <div class="mb-5">
                    <h4 class="text-success fw-bold mb-3">Informasi Kontak</h4>
                    <p class="text-muted">Hubungi kami melalui kontak di bawah ini atau kirim pesan melalui formulir.</p>
                </div>

                <div class="mb-5 d-flex align-items-start">
                    <div class="flex-shrink-0 bg-success text-white d-flex align-items-center justify-content-center rounded-circle shadow-sm" style="width:50px;height:50px;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="fw-bold mb-1">Alamat Kantor</h6>
                        <p class="mb-0 text-muted">
                            Jl. Sisingamangaraja No.123<br>
                            Balige, Kabupaten Toba<br>
                            Sumatera Utara 22312
                        </p>
                    </div>
                </div>

                <div class="mb-5 d-flex align-items-start">
                    <div class="flex-shrink-0 bg-success text-white d-flex align-items-center justify-content-center rounded-circle shadow-sm" style="width:50px;height:50px;">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="fw-bold mb-1">Telepon</h6>
                        <p class="mb-0 text-muted">(0622) 123456<br>(0622) 123457 (Fax)</p>
                    </div>
                </div>

                <div class="mb-5 d-flex align-items-start">
                    <div class="flex-shrink-0 bg-success text-white d-flex align-items-center justify-content-center rounded-circle shadow-sm" style="width:50px;height:50px;">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="fw-bold mb-1">Email</h6>
                        <p class="mb-0 text-muted">info@distan-toba.go.id<br>support@distan-toba.go.id</p>
                    </div>
                </div>

                <div class="mb-5 d-flex align-items-start">
                    <div class="flex-shrink-0 bg-success text-white d-flex align-items-center justify-content-center rounded-circle shadow-sm" style="width:50px;height:50px;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="fw-bold mb-1">Jam Kerja</h6>
                        <p class="mb-0 text-muted">
                            Senin - Jumat: 08:00 - 16:00 WIB<br>
                            Sabtu: 08:00 - 12:00 WIB<br>
                            <span class="text-danger">Minggu: Tutup</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Formulir Kontak -->
            <div class="col-lg-7">
                <div class="card shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-body p-5">
                        <h4 class="text-success fw-bold mb-4">Kirim Pesan</h4>
                        <form id="contactForm">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nama" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama" name="nama" required style="border-radius: 12px; padding: 0.75rem 1rem;">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required style="border-radius: 12px; padding: 0.75rem 1rem;">
                                </div>
                            </div>

                            <div class="mt-3">
                                <label for="subjek" class="form-label fw-bold">Subjek <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="subjek" name="subjek" required style="border-radius: 12px; padding: 0.75rem 1rem;">
                            </div>

                            <div class="mt-3">
                                <label for="kategori" class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select" id="kategori" name="kategori" required style="border-radius: 12px; padding: 0.75rem 1rem;">
                                    <option value="">Pilih Kategori</option>
                                    <option value="saran">Saran</option>
                                    <option value="keluhan">Keluhan</option>
                                    <option value="pertanyaan">Pertanyaan</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>

                            <div class="mt-3">
                                <label for="pesan" class="form-label fw-bold">Pesan <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="pesan" name="pesan" rows="5" required style="border-radius: 12px; padding: 0.75rem 1rem;"></textarea>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-success px-5 py-2 fw-bold w-100" style="border-radius: 50px; font-size: 1.1rem;">
                                    Kirim Pesan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======= Map Section ======= -->
<section class="py-0">
    <div class="ratio ratio-16x9" style="border-radius: 20px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127707.32853003379!2d99.031379!3d2.326983!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x302e0422832c1ced%3A0xeb88003792bf02ce!2sDinas%20Pertanian%20%26%20Perikanan%20Tobasa!5e0!3m2!1sid!2sid!4v1698730100000!5m2!1sid!2sid"
            width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy">
        </iframe>
    </div>
</section>

<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('/feedback', {
        method: 'POST',
        body: formData,
        headers: {'X-Requested-With': 'XMLHttpRequest'}
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert(data.message);
            this.reset();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.');
    });
});
</script>
@endsection

@push('styles')
<style>
    .contact .card {
        transition: transform 0.3s ease;
    }
    .contact .card:hover {
        transform: translateY(-5px);
    }
    .contact .rounded-circle {
        transition: all 0.3s ease;
    }
    .contact .rounded-circle:hover {
        transform: scale(1.1);
    }
    @media (max-width: 768px) {
        .contact .d-flex {
            flex-direction: column;
            text-align: center;
        }
        .contact .flex-shrink-0 {
            margin-bottom: 1rem;
        }
    }
</style>
@endpush