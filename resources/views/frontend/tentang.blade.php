@extends('layouts.frontend')

@section('content')
    <!-- common banner -->
    <section class="common-banner">
        <div class="bg-layer" style="background: url('{{ asset('assets/images/background/common-banner-bg.jpg')}}');"></div>
        <div class="common-banner-content">
            <h3>Tentang Kami</h3>
            <div class="breadcrumb">
                <ul>
                    <li class="breadcrumb-item active"><a href="{{ url('/')}}">Beranda</a></li>
                    <li class="breadcrumb-item"><i class="fa-solid fa-angles-right"></i> tentang</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- common banner -->


    <!-- about page -->
    <section class="about-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="about-page-left">
                        <div class="yellow-shape"></div>
                        <div class="pink-shape"></div>
                        <div class="about-page-left-image">
                            <img src="{{ asset('assets/images/resource/tentang dekat.png') }}" alt="image">
                            <div class="about-shape">
                                <img src="{{ asset('assets/images/shape/about-1.png') }}" alt="shape">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="rewards-left-container">
                        <div class="rewards-left-container-inner">
                            <div class="common-title mb_30">
                                <h6><i class="fa-solid fa-angles-right"></i> TENTANG PERUSAHAAN</h6>
                                <h3>Solusi Terbaik untuk Berbagai Jenis Layanan</h3>
                                <p style="text-align: justify;">Dekat adalah platform layanan digital yang dikembangkan oleh Disnaker Kota Depok untuk mempermudah masyarakat dalam mencari dan menggunakan berbagai jasa profesional. Kami menghadirkan layanan dengan paket lengkap dan harga tetap, dirancang untuk memenuhi kebutuhan Anda secara praktis dan efisien.</p>
                            </div>
                            <div class="rewards-left-list">
                                <ul>
                                    <li><i class="fa-sharp fa-light fa-circle-check"></i>Mitra Profesional & Berpengalaman</li>
                                    <li><i class="fa-sharp fa-light fa-circle-check"></i>Akses Gratis ke Ribuan Peluang Kerja</li>
                                    <li><i class="fa-sharp fa-light fa-circle-check"></i>Dukung Pertumbuhan Bisnis & Basis Klien</li>
                                    <li><i class="fa-sharp fa-light fa-circle-check"></i>Penghasilan Tambahan dengan Jadwal Fleksibel</li>
                                    <li><i class="fa-sharp fa-light fa-circle-check"></i>Mitra Profesional & Berpengalama</li>
                                </ul>
                            </div>
                            <div class="reward-btn">
                                <a href="{{ url('/layanan') }}" class="btn-1">Telusuri Lebih Lanjut <i class="icon-arrow-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about page -->

    <!-- contact page -->
<section class="contact-section bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="contact-content position-relative">
                    <div class="common-title mb-4">
                        <h6><i class="fa-solid fa-angles-right"></i> HUBUNGI KAMI</h6>
                        <h3>Butuh Bantuan? Hubungi Kami</h3>
                        <p>Kami siap membantu Anda dengan solusi terbaik untuk setiap kebutuhan.</p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ url('/kontak') }}" class="btn-1">Hubungi Kami <i class="icon-arrow-1"></i></a>
                    </div>
                    <!-- Decorative elements -->
                    <div class="yellow-shape position-absolute" style="top: -20px; right: -20px; width: 100px; height: 100px; background-color: #ffd700; opacity: 0.2; border-radius: 50%;"></div>
                    <div class="pink-shape position-absolute" style="bottom: -30px; left: -30px; width: 150px; height: 150px; background-color: #ff69b4; opacity: 0.1; border-radius: 50%;"></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="contact-image position-relative">
                    <img src="{{ asset('assets/images/resource/bantuan.png') }}" alt="contact"">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- contact page  -->

<!-- Partner Registration Steps -->
    <section class="registration-steps py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center mb-5">
                    <div class="common-title">
                        <h6><i class="fa-solid fa-angles-right"></i> ALUR PENDAFTARAN</h6>
                        <h3>Bergabung Sebagai Mitra DEKAT</h3>
                        <p>Ikuti langkah-langkah berikut untuk menjadi bagian dari platform layanan digital terpercaya di Kota Depok</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <!-- Step 1 -->
                <div class="col-lg-4 mb-4">
                    <div class="step-card position-relative bg-white rounded-lg p-4 h-100 shadow-sm">
                        <div class="step-number position-absolute" style="top: -15px; left: -15px; width: 40px; height: 40px; background-color: #007bff; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">1</div>
                        <div class="step-icon text-center mb-3">
                            <i class="fa-solid fa-graduation-cap fa-3x text-primary"></i>
                        </div>
                        <h4 class="text-center mb-3">Ikuti Pelatihan Resmi</h4>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <i class="fa-solid fa-check text-success me-2"></i>
                                Wajib mengikuti program pelatihan dari <strong>Dinas Tenaga Kerja Kota Depok</strong>
                            </li>
                            <li class="mb-2">
                                <i class="fa-solid fa-check text-success me-2"></i>
                                Cek jadwal dan pendaftaran di <strong>Instagram resmi Pelatihan Disnaker Depok</strong>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="col-lg-4 mb-4">
                    <div class="step-card position-relative bg-white rounded-lg p-4 h-100 shadow-sm">
                        <div class="step-number position-absolute" style="top: -15px; left: -15px; width: 40px; height: 40px; background-color: #007bff; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">2</div>
                        <div class="step-icon text-center mb-3">
                            <i class="fa-solid fa-certificate fa-3x text-warning"></i>
                        </div>
                        <h4 class="text-center mb-3">Dapatkan Sertifikasi BNSP</h4>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <i class="fa-solid fa-check text-success me-2"></i>
                                Ikuti uji kompetensi setelah menyelesaikan pelatihan
                            </li>
                            <li class="mb-2">
                                <i class="fa-solid fa-check text-success me-2"></i>
                                Dapatkan <strong>sertifikat BNSP</strong> sebagai bukti kelayakan
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="col-lg-4 mb-4">
                    <div class="step-card position-relative bg-white rounded-lg p-4 h-100 shadow-sm">
                        <div class="step-number position-absolute" style="top: -15px; left: -15px; width: 40px; height: 40px; background-color: #007bff; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">3</div>
                        <div class="step-icon text-center mb-3">
                            <i class="fa-solid fa-handshake fa-3x text-success"></i>
                        </div>
                        <h4 class="text-center mb-3">Mulai Kerja Sama sebagai Mitra</h4>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <i class="fa-solid fa-check text-success me-2"></i>
                                Daftar di website <strong>DEKAT</strong> dengan sertifikat yang telah dimiliki
                            </li>
                            <li class="mb-2">
                                <i class="fa-solid fa-check text-success me-2"></i>
                                Terima pesanan dan berikan layanan sesuai keahlian setelah verifikasi
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-5">
                <div class="col-lg-8 text-center">
                    <h3 class="mb-3">Siap Bergabung Dengan DEKAT?</h3>
                    <p class="mb-0">Mulai perjalanan Anda sebagai mitra profesional kami dan tingkatkan penghasilan Anda.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
