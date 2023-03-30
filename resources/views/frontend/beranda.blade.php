@extends('layouts.frontend_main')
@section('title', 'Beranda')
@section('content')
    <!-- Hero section -->
    <div class="owl-carousel owl-nav-overlay owl-dots-overlay" data-owl-autoplay="true" data-owl-nav="true" data-owl-dots="true"
        data-owl-items="1">
        <!-- Slider Item 1 -->
        <div class="section-2xl bg-image" data-bg-src="{{ asset('assets') }}/images/header-juanda.jpg">
            <div class="bg-black-06">
                <div class="container text-center">
                    <h3 class="fw-normal uppercase margin-bottom-10">Selamat Datang</h3>
                    <h1 class="fw-bold">Rumah Sakit Juanda</h1>
                </div>
            </div>
        </div>
        <!-- Slider Item 2 -->
        <div class="section-2xl bg-image" data-bg-src="{{ asset('assets') }}/images/background.jpg">
            <div class="bg-black-06">
                <div class="container text-center">
                    <h6 class="font-small fw-normal uppercase margin-bottom-20">Travel, Nature</h6>
                    <h1>Hero Post with Image</h1>
                    <a class="button button-lg button-radius button-border-2 button-reveal-right-outline-white margin-top-20"
                        href="#"><i class="bi bi-arrow-right"></i><span>Read More</span></a>
                </div>
            </div>
        </div>
        <!-- Slider Item 3 -->
        <div class="section-2xl bg-image" data-bg-src="{{ asset('assets') }}/images/background.jpg">
            <div class="bg-black-06">
                <div class="container text-center">
                    <h6 class="font-small fw-normal uppercase margin-bottom-20">Travel, Nature</h6>
                    <h1>Hero Post with Image</h1>
                    <a class="button button-lg button-radius button-border-2 button-reveal-right-outline-white margin-top-20"
                        href="#"><i class="bi bi-arrow-right"></i><span>Read More</span></a>
                </div>
            </div>
        </div>
    </div><!-- end owl-carousel -->
    <!-- end Hero section -->

    <!-- About section -->
    <div class="section padding-bottom-0">
        <div class="container">
            <!-- Process box 1 -->
            <div class="row align-items-center g-5">
                <div class="col-12 col-md-6">
                    <img class="border-radius hover-shadow hover-float" src="{{ asset('assets') }}/images/col-2.jpg"
                        alt="">
                </div>
                <div class="col-12 col-md-6">
                    <h3>Kesembuhan dan Kepuasan Pasien Adalah Tujuan Utama Kami</h3>
                </div>
            </div>
        </div><!-- end container -->
    </div>
    <!-- end About section -->

    <!-- Layanan section -->
    <div class="section">
        <div class="container">
            <div class="margin-bottom-70">
                <div class="row text-center">
                    <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                        <h2 class="fw-bold" style="color: #033b22;">Daftar Layanan</h2>
                        <h5 class="fw-light">Carilah layanan terbaik yang anda butuhkan</h5>
                        <div class="divider-width-100px">
                            <hr class="bg-black-06">
                        </div>
                    </div>
                </div>
            </div>
            <div class="owl-carousel" data-owl-margin="10" data-owl-xs="1" data-owl-sm="2" data-owl-md="2" data-owl-lg="3"
                data-owl-xl="3">
                <!-- Slide box 1 -->
                <div class="border-all">
                    <div class="hoverbox-9">
                        <a href="#">
                            <img src="{{ asset('assets') }}/images/col-2.jpg" alt="">
                        </a>
                    </div>
                    <div class="padding-30">
                        <h5 class="fw-normal margin-0">Perawat</h5>
                        <p>Perawat profesional yang akan memenuhi kebutuhan anda</p>
                        <a class="button button-sm button-radius button-green margin-top-20" href="#">Lihat</a>
                    </div>
                </div>
                <!-- Slide box 2 -->
                <div class="border-all">
                    <div class="hoverbox-9">
                        <a href="#">
                            <img src="{{ asset('assets') }}/images/col-2.jpg" alt="">
                        </a>
                    </div>
                    <div class="padding-30">
                        <h5 class="fw-normal margin-0">Fisioterapi</h5>
                        <p>Fisioterapi profesional yang akan memberikan tindakan rehabilitas untuk anda</p>
                        <a class="button button-sm button-radius button-green margin-top-20" href="#">Lihat</a>
                    </div>
                </div>
                <!-- Slide box 3 -->
                <div class="border-all">
                    <div class="hoverbox-9">
                        <a href="#">
                            <img src="{{ asset('assets') }}/images/col-2.jpg" alt="">
                        </a>
                    </div>
                    <div class="padding-30">
                        <h5 class="fw-normal margin-0">Telemedicine</h5>
                        <p>Konsultasi mengenai kesehatan Lansia dengan dokter profesional</p>
                        <a class="button button-sm button-radius button-green margin-top-20" href="#">Lihat</a>
                    </div>
                </div>
            </div>
        </div><!-- end container -->
    </div>
    <!-- end Layanan section -->

    <!-- Profile section -->
    <div class="section">
        <div class="container">
            <div class="margin-bottom-50">
                <div class="row text-center">
                    <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                        <h4 class="fw-normal">Profile</h4>
                        <h2 class="fw-bold" style="color: #033b22;">Rumah Sakit Juanda Kuningan</h2>
                        <div class="divider-width-100px">
                            <hr class="bg-black-06">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row icon-5xl g-4 text-center">
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="border-all border-radius padding-40 hover-shadow">
                        <img class="img-circle-md margin-bottom-20" src="{{ asset('assets') }}/images/img-circle-medium.jpg"
                            alt="">
                        <h4 class="margin-top-10" style="color: #033b22;">Visi</h4>
                        <p>Menjadi Rumah Sakit Utama di Kabupaten Kuningan yang Berorientasi Pada Layanan Berkualitas,
                            Paripurna dan Berkesinambungan.
                        </p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="border-all border-radius padding-40 hover-shadow bg-dark">
                        <img class="img-circle-md margin-bottom-20"
                            src="{{ asset('assets') }}/images/img-circle-medium.jpg" alt="">
                        <h4 class="margin-top-10">Misi</h4>
                        <ul style="text-align: left;">
                            <li>Menyelenggarakan pelayanan kesehatan berkualitas sesuai standar nasional.</li>
                            <li>Melaksanakan pendidikan dan pelatihan sumber daya manusia sesuai standar nasional yang
                                berkesinambungan.</li>
                            <li>Meningkatkan sarana dan prasarana guna menunjang kualitas mutu layanan kesehatan.</li>
                            <li>Menciptakan hubungan kerjasama yang harmonis dengan institusi dan pelanggan.</li>
                            <li>Kendali mutu dan kendali biaya.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="border-all border-radius padding-40 hover-shadow">
                        <img class="img-circle-md margin-bottom-20"
                            src="{{ asset('assets') }}/images/img-circle-medium.jpg" alt="">
                        <h4 class="margin-top-10" style="color: #033b22;">Tujuan</h4>
                        <p>Melaksanakan pelayanan kesehatan yang paripurna dengan mengutamakan kesembuhan, dengan
                            berpedoman kepada usaha
                            promotive, preventive, curative, rehabilitative.
                        </p>
                    </div>
                </div>
            </div>
        </div><!-- end row -->
    </div><!-- end container -->
    </div>
    <!-- end Profile section -->

    <!-- Patnership section -->
    <div class="section">
        <div class="container">
            <div class="margin-bottom-70">
                <div class="row text-center">
                    <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                        <h2>PATNERSHIP</h2>
                        <div class="divider-width-50px">
                            <hr class="bg-black-06">
                        </div>
                    </div>
                </div>
            </div>
            <div class="owl-carousel" data-owl-nav="true" data-owl-dots="false" data-owl-margin="50"
                data-owl-autoplay="true" data-owl-xs="1" data-owl-sm="2" data-owl-md="3" data-owl-lg="4"
                data-owl-xl="5">
                <!-- Client box 1 -->
                <div class="client-box">
                    <a href="#">
                        <img src="{{ asset('assets') }}/images/admedika.png" alt="">
                    </a>
                </div>
                <!-- Client box 2 -->
                <div class="client-box">
                    <a href="#">
                        <img src="{{ asset('assets') }}/images/bpjs.png" alt="">
                    </a>
                </div>
                <!-- Client box 3 -->
                <div class="client-box">
                    <a href="#">
                        <img src="{{ asset('assets') }}/images/bri.png" alt="">
                    </a>
                </div>
                <!-- Client box 4 -->
                <div class="client-box">
                    <a href="#">
                        <img src="{{ asset('assets') }}/images/fullerton.png" alt="">
                    </a>
                </div>
                <!-- Client box 5 -->
                <div class="client-box">
                    <a href="#">
                        <img src="{{ asset('assets') }}/images/halodoc.png" alt="">
                    </a>
                </div>
                <!-- Client box 6 -->
                <div class="client-box">
                    <a href="#">
                        <img src="{{ asset('assets') }}/images/iziklaim.png" alt="">
                    </a>
                </div>
                <!-- Client box 7 -->
                <div class="client-box">
                    <a href="#">
                        <img src="{{ asset('assets') }}/images/mandiriinhealth.png" alt="">
                    </a>
                </div>
                <!-- Client box 7 -->
                <div class="client-box">
                    <a href="#">
                        <img src="{{ asset('assets') }}/images/owlexa.png" alt="">
                    </a>
                </div>
                <!-- Client box 7 -->
                <div class="client-box">
                    <a href="#">
                        <img src="{{ asset('assets') }}/images/pdamkuningan.png" alt="">
                    </a>
                </div>
                <!-- Client box 7 -->
                <div class="client-box">
                    <a href="#">
                        <img src="{{ asset('assets') }}/images/prudential.png" alt="">
                    </a>
                </div>
                <!-- Client box 7 -->
                <div class="client-box">
                    <a href="#">
                        <img src="{{ asset('assets') }}/images/ykkbi.png" alt="">
                    </a>
                </div>
                <!-- Client box 7 -->
                <div class="client-box">
                    <a href="#">
                        <img src="{{ asset('assets') }}/images/ykp.png" alt="">
                    </a>
                </div>
            </div><!-- end owl-carousel -->
        </div><!-- end container -->
    </div>
    <!-- end Patnership section -->

    <!-- Kontak kami section -->
    <div class="section-xl bg-image parallax" data-bg-src="{{ asset('assets') }}/images/background.jpg">
        <div class="bg-black-06">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-6">
                        <h4 class="fw-light margin-0">Kontak Kami</h4>
                        <h2 class="fw-normal margin-0">Layanan Home Care</h2>
                        <p class="fw-light">
                            Untuk informasi lebih lanjut mengenai home care rumah sakit juanda, dapat hubungi kontak
                            kami
                        </p>
                    </div>
                    <div class="col-12 col-lg-6 text-lg-end">
                        <a class="button button-xl button-radius button-white-3" href="#">Kontak Kami</a>
                    </div>
                </div><!-- end row -->
            </div><!-- end container -->
        </div>
    </div>
    <!-- end Kontak kami section -->
@endsection
