<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $laporan->judul }} - Detail Laporan</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Lightbox CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    
    <style>
        :root {
            --green: #27ae60;
            --dark-green: #1e8449;
            --light-green: #d4edda;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .header-section {
            background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 50%, #388e3c 100%);
            color: white;
            padding: 3rem 0 2rem;
            margin-bottom: -3rem;
            position: relative;
            box-shadow: 0 10px 40px rgba(27,94,32,0.3);
        }

        .header-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
        }

        .header-section .container {
            position: relative;
            z-index: 2;
        }

        .content-wrapper {
            margin-top: 3rem;
            padding-bottom: 3rem;
        }

        .content-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            padding: 2.5rem;
            margin-bottom: 2rem;
            border: none;
            transition: all 0.3s ease;
        }

        .content-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(0,0,0,0.12);
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }

        .article-title {
            font-size: 2rem;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 1.5rem;
            line-height: 1.3;
        }

        .info-box {
            background: linear-gradient(135deg, #f8fdf9, #e8f5e9);
            border-left: 5px solid #2e7d32;
            padding: 2rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(46,125,50,0.1);
        }

        .info-box h5 {
            color: #1b5e20;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .info-item {
            display: flex;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(46,125,50,0.1);
            align-items: flex-start;
        }

        .info-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .info-label {
            font-weight: 600;
            min-width: 200px;
            color: #2e7d32;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-label i {
            width: 20px;
            text-align: center;
        }

        .info-value {
            color: #333;
            flex: 1;
            font-weight: 500;
        }

        .badge {
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.95rem;
        }

        .verification-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 700;
            background: white;
            color: #2e7d32;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
            50% { box-shadow: 0 6px 20px rgba(46,125,50,0.3); }
        }

        .btn-back {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 2px solid white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s;
            backdrop-filter: blur(10px);
        }

        .btn-back:hover {
            background: white;
            color: #2e7d32;
            transform: translateX(-5px);
        }

        .photo-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .gallery-item {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.4s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .gallery-item:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }

        .gallery-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            display: block;
            transition: transform 0.4s;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .gallery-item::after {
            content: '🔍';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            font-size: 3rem;
            transition: all 0.3s;
            opacity: 0;
        }

        .gallery-item:hover::after {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }

        .share-btn {
            border-radius: 16px;
            padding: 1rem;
            font-weight: 700;
            transition: all 0.3s;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .share-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }

        .stats-item {
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 12px;
            margin-bottom: 1rem;
            transition: all 0.3s;
        }

        .stats-item:hover {
            background: #e8f5e9;
            transform: translateX(5px);
        }

        .stats-item i {
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: white;
        }

        .section-title {
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert {
            border-radius: 16px;
            border: none;
            padding: 1.5rem;
        }

        footer {
            background: #1b5e20;
            margin-top: 4rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-title {
                font-size: 1.8rem;
            }
            
            .article-title {
                font-size: 1.5rem;
            }

            .info-label {
                min-width: 150px;
                font-size: 0.9rem;
            }

            .photo-gallery {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-9">
                    <a href="{{ route('transparansi.bantuan') }}" class="btn btn-back mb-3">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                    </a>
                    <h1 class="page-title">Detail Laporan Bantuan</h1>
                    <p style="opacity: 0.9; font-size: 1.1rem;">Informasi lengkap penyaluran bantuan pertanian</p>
                </div>
                <div class="col-lg-3 text-lg-end mt-3 mt-lg-0">
                    <div class="verification-badge">
                        <i class="fas fa-check-circle"></i>
                        <span>Terverifikasi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container content-wrapper">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="content-card">
                    <h2 class="article-title">{{ $laporan->judul }}</h2>
                    
                    <div class="mb-4 d-flex gap-2 flex-wrap">
                        <span class="badge bg-primary">
                            <i class="fas fa-tag me-1"></i>{{ $laporan->jenis_bantuan }}
                        </span>
                        @if($laporan->jumlah_bantuan)
                            <span class="badge bg-success">
                                <i class="fas fa-box me-1"></i>{{ number_format($laporan->jumlah_bantuan, 0, ',', '.') }} {{ $laporan->satuan }}
                            </span>
                        @endif
                    </div>

                    <div class="info-box">
                        <h5><i class="fas fa-info-circle me-2"></i>Informasi Laporan</h5>
                        
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-user me-2"></i>Pelapor
                            </div>
                            <div class="info-value">{{ $laporan->user->name }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-calendar-alt me-2"></i>Tanggal Pelaporan
                            </div>
                            <div class="info-value">{{ $laporan->tanggal_pelaporan->format('d F Y') }}</div>
                        </div>

                        @if($laporan->tanggal_penerimaan)
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-calendar-check me-2"></i>Tanggal Penerimaan
                            </div>
                            <div class="info-value">{{ $laporan->tanggal_penerimaan->format('d F Y') }}</div>
                        </div>
                        @endif

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-map-marker-alt me-2"></i>Lokasi
                            </div>
                            <div class="info-value">
                                {{ $laporan->alamat_desa ?? 'N/A' }}, Kec. {{ $laporan->alamat_kecamatan ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-eye me-2"></i>Dilihat
                            </div>
                            <div class="info-value">{{ $laporan->views_count }} kali</div>
                        </div>

                        @if($laporan->verifier)
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-user-check me-2"></i>Diverifikasi oleh
                            </div>
                            <div class="info-value">
                                {{ $laporan->verifier->name }} - {{ $laporan->verified_at->format('d F Y H:i') }}
                            </div>
                        </div>
                        @endif
                    </div>

                    <h5 class="section-title">
                        <i class="fas fa-file-alt text-success"></i>
                        <span>Deskripsi</span>
                    </h5>
                    <div class="mb-4" style="text-align: justify; line-height: 1.8; color: #333; font-size: 1.05rem;">
                        {{ $laporan->deskripsi }}
                    </div>

                    @if($laporan->catatan_verifikasi)
                    <div class="alert alert-info">
                        <h6 class="fw-bold mb-2">
                            <i class="fas fa-sticky-note me-2"></i>Catatan Verifikasi
                        </h6>
                        <p class="mb-0">{{ $laporan->catatan_verifikasi }}</p>
                    </div>
                    @endif

                    @if($laporan->bantuan)
                    <div class="alert alert-light border-0" style="background: #f8f9fa;">
                        <h6 class="fw-bold mb-2">
                            <i class="fas fa-link me-2 text-primary"></i>Terkait Pengajuan Bantuan
                        </h6>
                        <p class="mb-0">
                            <strong>{{ $laporan->bantuan->jenis_bantuan }}</strong> - 
                            Diajukan pada {{ $laporan->bantuan->created_at->format('d F Y') }}
                        </p>
                    </div>
                    @endif
                </div>

                <!-- Photo Gallery -->
                @if(!empty($laporan->foto_bukti_urls))
                <div class="content-card">
                    <h5 class="section-title">
                        <i class="fas fa-images text-warning"></i>
                        <span>Foto Bukti Bantuan ({{ count($laporan->foto_bukti_urls) }})</span>
                    </h5>
                    <p class="text-muted mb-3">Klik pada foto untuk memperbesar</p>
                    
                    <div class="photo-gallery">
                        @foreach($laporan->foto_bukti_urls as $index => $photo)
                        <div class="gallery-item">
                            <a href="{{ $photo }}" data-lightbox="laporan-{{ $laporan->id }}" data-title="{{ $laporan->judul }}">
                                <img src="{{ $photo }}" alt="Foto {{ $index + 1 }}">
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Share -->
                <div class="content-card">
                    <h5 class="section-title">
                        <i class="fas fa-share-alt"></i>
                        <span>Bagikan</span>
                    </h5>
                    <div class="d-grid gap-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                           target="_blank" 
                           class="btn btn-primary share-btn">
                            <i class="fab fa-facebook fa-lg"></i>
                            <span>Facebook</span>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($laporan->judul) }}" 
                           target="_blank" 
                           class="btn btn-info text-white share-btn">
                            <i class="fab fa-twitter fa-lg"></i>
                            <span>Twitter</span>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($laporan->judul . ' - ' . request()->url()) }}" 
                           target="_blank" 
                           class="btn btn-success share-btn">
                            <i class="fab fa-whatsapp fa-lg"></i>
                            <span>WhatsApp</span>
                        </a>
                    </div>
                </div>

                <!-- Stats -->
                <div class="content-card">
                    <h5 class="section-title">
                        <i class="fas fa-chart-bar"></i>
                        <span>Statistik</span>
                    </h5>
                    <div class="stats-item">
                        <i class="fas fa-eye text-primary"></i>
                        <strong class="ms-2">{{ $laporan->views_count }}</strong> kali dilihat
                    </div>
                    <div class="stats-item">
                        <i class="fas fa-calendar text-success"></i>
                        Dilaporkan <strong class="ms-2">{{ $laporan->created_at->diffForHumans() }}</strong>
                    </div>
                    <div class="stats-item">
                        <i class="fas fa-check-circle text-info"></i>
                        Status: <strong class="ms-2">Published</strong>
                    </div>
                </div>

                <!-- Info -->
                <div class="content-card" style="background: linear-gradient(135deg, #f8fdf9, #e8f5e9); border: 2px solid #c8e6c9;">
                    <h6 class="fw-bold mb-3" style="color: #1b5e20;">
                        <i class="fas fa-info-circle me-2"></i>Tentang Transparansi
                    </h6>
                    <p class="small mb-0" style="color: #2e7d32; line-height: 1.6;">
                        Semua laporan bantuan yang ditampilkan di portal ini telah diverifikasi oleh tim kami 
                        untuk memastikan transparansi dan akuntabilitas penyaluran bantuan pertanian.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-4 text-white text-center">
        <div class="container">
            <p class="mb-0" style="font-weight: 600;">&copy; {{ date('Y') }} Dinas Pertanian Kabupaten Toba. All rights reserved.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    
    <script>
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': "Foto %1 dari %2"
        });
    </script>
</body>
</html>
