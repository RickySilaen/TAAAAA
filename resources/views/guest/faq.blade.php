@extends('layouts.guest')

@section('title', 'FAQ - Sistem Pertanian')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h4 class="mb-0">Pertanyaan yang Sering Diajukan (FAQ)</h4>
                </div>
                <div class="card-body">
                    <div class="accordion" id="faqAccordion">

                        <!-- Akun dan Registrasi -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <i class="fas fa-user me-2 text-primary"></i>Akun dan Registrasi
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <h6>Bagaimana cara mendaftar sebagai petani?</h6>
                                        <p>Jika Anda adalah petani, silakan hubungi admin sistem untuk mendapatkan akun. Sistem ini menggunakan registrasi terbatas untuk memastikan keamanan data.</p>
                                    </div>
                                    <div class="mb-3">
                                        <h6>Apakah saya bisa melihat data tanpa login?</h6>
                                        <p>Ya, Anda dapat melihat informasi publik seperti daftar bantuan dan laporan tanpa perlu login. Namun untuk membuat laporan atau mengakses fitur tertentu, Anda perlu memiliki akun.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Laporan Panen -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <i class="fas fa-chart-line me-2 text-success"></i>Laporan Panen
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <h6>Siapa saja yang bisa membuat laporan panen?</h6>
                                        <p>Laporan panen dapat dibuat oleh petani terdaftar maupun masyarakat umum. Untuk petani terdaftar, laporan akan terhubung dengan akun mereka. Untuk masyarakat umum, laporan akan disimpan sebagai laporan publik.</p>
                                    </div>
                                    <div class="mb-3">
                                        <h6>Data apa saja yang perlu diisi dalam laporan panen?</h6>
                                        <p>Data yang perlu diisi meliputi: nama petani, alamat desa, deskripsi kemajuan, jenis tanaman, hasil panen, luas lahan, tanggal, dan catatan tambahan.</p>
                                    </div>
                                    <div class="mb-3">
                                        <h6>Apakah laporan panen bersifat rahasia?</h6>
                                        <p>Laporan panen bersifat transparan dan dapat dilihat oleh publik untuk meningkatkan akuntabilitas program pertanian.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bantuan Pertanian -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <i class="fas fa-hand-holding-heart me-2 text-warning"></i>Bantuan Pertanian
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <h6>Bagaimana cara mendapatkan bantuan pertanian?</h6>
                                        <p>Bantuan pertanian didistribusikan berdasarkan kebutuhan dan kriteria yang telah ditentukan. Petani dapat melihat daftar bantuan yang tersedia dan mengajukan permohonan melalui sistem ini.</p>
                                    </div>
                                    <div class="mb-3">
                                        <h6>Jenis bantuan apa saja yang tersedia?</h6>
                                        <p>Jenis bantuan meliputi: bibit tanaman, pupuk, alat pertanian, pelatihan, dan bantuan finansial sesuai dengan program pemerintah.</p>
                                    </div>
                                    <div class="mb-3">
                                        <h6>Bagaimana proses verifikasi penerima bantuan?</h6>
                                        <p>Setiap permohonan bantuan akan diverifikasi oleh admin sistem berdasarkan data petani dan kriteria yang berlaku.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Berita dan Informasi -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    <i class="fas fa-newspaper me-2 text-info"></i>Berita dan Informasi
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <h6>Di mana saya bisa mendapatkan informasi terbaru tentang pertanian?</h6>
                                        <p>Informasi terbaru dapat dilihat di halaman Berita. Kami menyediakan artikel tentang teknologi pertanian, tips budidaya, dan informasi program pemerintah.</p>
                                    </div>
                                    <div class="mb-3">
                                        <h6>Apakah saya bisa berlangganan newsletter?</h6>
                                        <p>Ya, Anda dapat berlangganan newsletter melalui formulir yang tersedia di halaman utama untuk mendapatkan update informasi terbaru.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Galeri -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    <i class="fas fa-images me-2 text-secondary"></i>Galeri
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <h6>Apa yang bisa dilihat di galeri?</h6>
                                        <p>Galeri berisi dokumentasi kegiatan pertanian, hasil panen, kegiatan bantuan, dan momen penting dalam program pertanian.</p>
                                    </div>
                                    <div class="mb-3">
                                        <h6>Apakah gambar di galeri bisa didownload?</h6>
                                        <p>Gambar di galeri dapat dilihat secara publik, namun untuk keperluan komersial atau pendidikan, silakan hubungi admin untuk mendapatkan izin.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kontak dan Dukungan -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingSix">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    <i class="fas fa-headset me-2 text-danger"></i>Kontak dan Dukungan
                                </button>
                            </h2>
                            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <h6>Bagaimana cara menghubungi tim dukungan?</h6>
                                        <p>Anda dapat menghubungi kami melalui halaman Kontak, email support@sistempertanian.com, atau telepon (021) 123-4567.</p>
                                    </div>
                                    <div class="mb-3">
                                        <h6>Apakah ada dukungan teknis?</h6>
                                        <p>Ya, tim dukungan teknis siap membantu Anda dengan masalah penggunaan sistem. Silakan kirim pesan melalui formulir kontak atau email.</p>
                                    </div>
                                    <div class="mb-3">
                                        <h6>Berapa lama waktu respon dukungan?</h6>
                                        <p>Kami berusaha merespon dalam waktu 24 jam pada hari kerja. Untuk kasus mendesak, Anda dapat menghubungi hotline kami.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mt-4 p-3 bg-light rounded">
                        <h6 class="text-primary mb-2">Masih ada pertanyaan?</h6>
                        <p class="mb-2">Jika pertanyaan Anda tidak terjawab di FAQ ini, silakan hubungi kami melalui:</p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="{{ route('kontak') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-envelope me-1"></i>Halaman Kontak
                            </a>
                            <a href="mailto:support@sistempertanian.com" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-envelope me-1"></i>Email Support
                            </a>
                            <a href="tel:+62211234567" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-phone me-1"></i>Hotline
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
