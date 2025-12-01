@extends('layouts.guest')

@section('title', 'Kontak Kami - Dinas Pertanian Kabupaten Toba')

@section('content')
<!-- Hero Section -->
<section class="kontak-hero py-5" style="background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 50%, #388e3c 100%); min-height: 280px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">🏠 Beranda</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Kontak Kami</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold text-white mb-3">
                    📞 Hubungi Kami
                </h1>
                <p class="lead text-white-50 mb-0" style="font-size: 1.2rem;">
                    Kami siap membantu Anda. Silakan hubungi kami melalui informasi kontak di bawah atau kirim pesan langsung.
                </p>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <div class="position-relative">
                    <div class="bg-white bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 180px; height: 180px; backdrop-filter: blur(10px);">
                        <span style="font-size: 5rem;">📬</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5" style="background: linear-gradient(180deg, #f8fdf8 0%, #ffffff 100%); margin-top: -30px;">
    <div class="container">
        <div class="row g-5">
            <!-- Info Kontak -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-lg h-100" style="border-radius: 24px; overflow: hidden;">
                    <div class="card-body p-0">
                        <!-- Header Card -->
                        <div class="p-4" style="background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);">
                            <h4 class="text-white fw-bold mb-2">📍 Informasi Kontak</h4>
                            <p class="text-white-50 mb-0 small">Dinas Pertanian Kabupaten Toba</p>
                        </div>
                        
                        <!-- Contact Items -->
                        <div class="p-4">
                            <!-- Alamat -->
                            <div class="contact-item d-flex align-items-start mb-4 p-3 rounded-3" style="background: linear-gradient(135deg, #e8f5e9 0%, #f1f8e9 100%);">
                                <div class="contact-icon flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background: linear-gradient(135deg, #2e7d32 0%, #43a047 100%); font-size: 1.3rem;">
                                    🏢
                                </div>
                                <div class="ms-3">
                                    <h6 class="fw-bold text-success mb-1">Alamat Kantor</h6>
                                    <p class="mb-0 text-muted small">
                                        Jl. Sisingamangaraja No.123<br>
                                        Balige, Kabupaten Toba<br>
                                        Sumatera Utara 22312
                                    </p>
                                </div>
                            </div>

                            <!-- Telepon -->
                            <div class="contact-item d-flex align-items-start mb-4 p-3 rounded-3" style="background: linear-gradient(135deg, #e3f2fd 0%, #e8eaf6 100%);">
                                <div class="contact-icon flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%); font-size: 1.3rem;">
                                    📞
                                </div>
                                <div class="ms-3">
                                    <h6 class="fw-bold text-primary mb-1">Telepon</h6>
                                    <p class="mb-0 text-muted small">
                                        <a href="tel:+620622123456" class="text-decoration-none text-muted">(0622) 123456</a><br>
                                        <a href="tel:+620622123457" class="text-decoration-none text-muted">(0622) 123457 (Fax)</a>
                                    </p>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="contact-item d-flex align-items-start mb-4 p-3 rounded-3" style="background: linear-gradient(135deg, #fff3e0 0%, #ffecb3 100%);">
                                <div class="contact-icon flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background: linear-gradient(135deg, #f57c00 0%, #ffb74d 100%); font-size: 1.3rem;">
                                    ✉️
                                </div>
                                <div class="ms-3">
                                    <h6 class="fw-bold" style="color: #e65100;">Email</h6>
                                    <p class="mb-0 text-muted small">
                                        <a href="mailto:info@distan-toba.go.id" class="text-decoration-none text-muted">info@distan-toba.go.id</a><br>
                                        <a href="mailto:support@distan-toba.go.id" class="text-decoration-none text-muted">support@distan-toba.go.id</a>
                                    </p>
                                </div>
                            </div>

                            <!-- Jam Kerja -->
                            <div class="contact-item d-flex align-items-start p-3 rounded-3" style="background: linear-gradient(135deg, #fce4ec 0%, #f8bbd9 100%);">
                                <div class="contact-icon flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background: linear-gradient(135deg, #c2185b 0%, #e91e63 100%); font-size: 1.3rem;">
                                    🕐
                                </div>
                                <div class="ms-3">
                                    <h6 class="fw-bold" style="color: #c2185b;">Jam Operasional</h6>
                                    <p class="mb-0 text-muted small">
                                        <span class="d-flex justify-content-between"><span>Senin - Jumat</span> <span class="fw-semibold">08:00 - 16:00</span></span>
                                        <span class="d-flex justify-content-between"><span>Sabtu</span> <span class="fw-semibold">08:00 - 12:00</span></span>
                                        <span class="d-flex justify-content-between"><span>Minggu</span> <span class="text-danger fw-semibold">Tutup</span></span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="p-4 border-top">
                            <h6 class="fw-bold text-muted mb-3">🌐 Ikuti Kami</h6>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-sm px-3 py-2" style="background: #1877f2; color: white; border-radius: 10px;">
                                    📘 Facebook
                                </a>
                                <a href="#" class="btn btn-sm px-3 py-2" style="background: #e4405f; color: white; border-radius: 10px;">
                                    📷 Instagram
                                </a>
                                <a href="#" class="btn btn-sm px-3 py-2" style="background: #25d366; color: white; border-radius: 10px;">
                                    💬 WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulir Kontak -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
                    <div class="card-body p-0">
                        <!-- Header Form -->
                        <div class="p-4" style="background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);">
                            <h4 class="text-white fw-bold mb-2">✍️ Kirim Pesan</h4>
                            <p class="text-white-50 mb-0 small">Isi formulir di bawah ini dan kami akan segera merespons</p>
                        </div>
                        
                        <div class="p-4 p-md-5">
                            <form id="contactForm">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="nama" class="form-label fw-semibold text-muted">
                                            👤 Nama Lengkap <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control form-control-lg" id="nama" name="nama" placeholder="Masukkan nama lengkap" required style="border-radius: 12px; border: 2px solid #e0e0e0; padding: 0.875rem 1rem;">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-semibold text-muted">
                                            📧 Email <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="contoh@email.com" required style="border-radius: 12px; border: 2px solid #e0e0e0; padding: 0.875rem 1rem;">
                                    </div>
                                </div>

                                <div class="row g-4 mt-1">
                                    <div class="col-md-6">
                                        <label for="subjek" class="form-label fw-semibold text-muted">
                                            📝 Subjek <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control form-control-lg" id="subjek" name="subjek" placeholder="Subjek pesan" required style="border-radius: 12px; border: 2px solid #e0e0e0; padding: 0.875rem 1rem;">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="kategori" class="form-label fw-semibold text-muted">
                                            📂 Kategori <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select form-select-lg" id="kategori" name="kategori" required style="border-radius: 12px; border: 2px solid #e0e0e0; padding: 0.875rem 1rem;">
                                            <option value="">Pilih Kategori</option>
                                            <option value="pertanyaan">❓ Pertanyaan Umum</option>
                                            <option value="saran">💡 Saran & Masukan</option>
                                            <option value="keluhan">⚠️ Keluhan</option>
                                            <option value="kerjasama">🤝 Kerjasama</option>
                                            <option value="lainnya">📋 Lainnya</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label for="pesan" class="form-label fw-semibold text-muted">
                                        💬 Pesan <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control" id="pesan" name="pesan" rows="5" placeholder="Tuliskan pesan Anda di sini..." required style="border-radius: 12px; border: 2px solid #e0e0e0; padding: 1rem;"></textarea>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-lg w-100 text-white fw-bold" style="background: linear-gradient(135deg, #2e7d32 0%, #43a047 100%); border-radius: 50px; padding: 1rem; font-size: 1.1rem; border: none; box-shadow: 0 4px 15px rgba(46, 125, 50, 0.3);">
                                        📤 Kirim Pesan
                                    </button>
                                </div>

                                <div class="text-center mt-3">
                                    <small class="text-muted">
                                        🔒 Data Anda aman dan tidak akan dibagikan ke pihak ketiga
                                    </small>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-5" style="background: #f8f9fa;">
    <div class="container">
        <div class="text-center mb-4">
            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill mb-3">📍 Lokasi Kami</span>
            <h3 class="fw-bold text-dark">Temukan Kantor Kami</h3>
            <p class="text-muted">Kunjungi kantor Dinas Pertanian Kabupaten Toba</p>
        </div>
        <div class="card border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
            <div class="ratio ratio-21x9">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127707.32853003379!2d99.031379!3d2.326983!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x302e0422832c1ced%3A0xeb88003792bf02ce!2sDinas%20Pertanian%20%26%20Perikanan%20Tobasa!5e0!3m2!1sid!2sid!4v1698730100000!5m2!1sid!2sid"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = this.querySelector('button[type="submit"]');
    const originalText = btn.innerHTML;
    btn.innerHTML = '⏳ Mengirim...';
    btn.disabled = true;

    const formData = new FormData(this);

    fetch('/feedback', {
        method: 'POST',
        body: formData,
        headers: {'X-Requested-With': 'XMLHttpRequest'}
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            // Success alert
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show mt-3';
            alertDiv.innerHTML = `
                <strong>✅ Berhasil!</strong> ${data.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            this.appendChild(alertDiv);
            this.reset();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show mt-3';
        alertDiv.innerHTML = `
            <strong>❌ Error!</strong> Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        this.appendChild(alertDiv);
    })
    .finally(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
});
</script>
@endsection

@push('styles')
<style>
    .kontak-hero {
        position: relative;
        overflow: hidden;
    }
    
    .kontak-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.3;
    }

    .contact-item {
        transition: all 0.3s ease;
    }
    
    .contact-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .contact-icon {
        transition: all 0.3s ease;
    }
    
    .contact-item:hover .contact-icon {
        transform: scale(1.1);
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #2e7d32 !important;
        box-shadow: 0 0 0 4px rgba(46, 125, 50, 0.1) !important;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(46, 125, 50, 0.4) !important;
    }

    .card {
        transition: all 0.3s ease;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255,255,255,0.5);
    }

    @media (max-width: 768px) {
        .kontak-hero {
            min-height: auto;
            padding: 2rem 0;
        }
        
        .kontak-hero h1 {
            font-size: 2rem;
        }
        
        .contact-item {
            flex-direction: column;
            text-align: center;
        }
        
        .contact-item .contact-icon {
            margin-bottom: 1rem;
        }
        
        .contact-item .ms-3 {
            margin-left: 0 !important;
        }
    }
</style>
@endpush