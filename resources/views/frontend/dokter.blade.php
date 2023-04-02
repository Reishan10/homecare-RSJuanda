@extends('layouts.frontend_main')
@section('title', 'Dokter')
@section('content')
    <!-- Dokter section -->
    <div class="section">
        <div class="container">
            <div class="row text-center">
                <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                    <h2>Dokter</h2>
                    <div class="divider-width-50px">
                        <hr class="bg-black-06">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 offset-md-1 col-lg-4 offset-lg-4">
                <div class="border border-radius-025 padding-20 padding-md-30 padding-lg-40 text-center">
                    <div class="text-dark margin-bottom-10">
                        <img src="{{ asset('assets') }}/images/col-2.jpg" alt="">
                    </div>
                    <p>Konsultasi mengenai kesehatan Lansia dengan dokter profesional</p>
                </div>
            </div>


            <div class="row text-center margin-top-40">
                <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                    <h2>Cari Dokter Spesialis</h2>
                    <div class="divider-width-50px">
                        <hr class="bg-black-06">
                    </div>
                </div>
            </div>
            <div class="row g-4 text-center icon-5xl margin-top-10">
                <!-- Services box 1 -->
                <div class="col-12 col-md-3">
                    <i class="bi bi-chat-text text-dark"></i>
                    <h5 class="fw-normal margin-top-10">Consulting</h5>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
                        Aenean massa.</p>
                </div>
                <!-- Services box 2 -->
                <div class="col-12 col-md-3">
                    <i class="bi bi-star text-dark"></i>
                    <h5 class="fw-normal margin-top-10">Branding</h5>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
                        Aenean massa.</p>
                </div>
                <!-- Services box 3 -->
                <div class="col-12 col-md-3">
                    <i class="bi bi-bar-chart text-dark"></i>
                    <h5 class="fw-normal margin-top-10">Marketing</h5>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
                        Aenean massa.</p>
                </div>
                <!-- Services box 4 -->
                <div class="col-12 col-md-3">
                    <i class="bi bi-file-bar-graph text-dark"></i>
                    <h5 class="fw-normal margin-top-10">Marketing</h5>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
                        Aenean massa.</p>
                </div>

                <!-- Services box 1 -->
                <div class="col-12 col-md-3">
                    <i class="bi bi-chat-text text-dark"></i>
                    <h5 class="fw-normal margin-top-10">Consulting</h5>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
                        Aenean massa.</p>
                </div>
                <!-- Services box 2 -->
                <div class="col-12 col-md-3">
                    <i class="bi bi-star text-dark"></i>
                    <h5 class="fw-normal margin-top-10">Branding</h5>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
                        Aenean massa.</p>
                </div>
                <!-- Services box 3 -->
                <div class="col-12 col-md-3">
                    <i class="bi bi-bar-chart text-dark"></i>
                    <h5 class="fw-normal margin-top-10">Marketing</h5>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
                        Aenean massa.</p>
                </div>
                <!-- Services box 4 -->
                <div class="col-12 col-md-3">
                    <i class="bi bi-file-bar-graph text-dark"></i>
                    <h5 class="fw-normal margin-top-10">Marketing</h5>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
                        Aenean massa.</p>
                </div>

                <!-- Services box 1 -->
                <div class="col-12 col-md-3">
                    <i class="bi bi-chat-text text-dark"></i>
                    <h5 class="fw-normal margin-top-10">Consulting</h5>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
                        Aenean massa.</p>
                </div>
                <!-- Services box 2 -->
                <div class="col-12 col-md-3">
                    <i class="bi bi-star text-dark"></i>
                    <h5 class="fw-normal margin-top-10">Branding</h5>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
                        Aenean massa.</p>
                </div>
                <!-- Services box 3 -->
                <div class="col-12 col-md-3">
                    <i class="bi bi-bar-chart text-dark"></i>
                    <h5 class="fw-normal margin-top-10">Marketing</h5>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
                        Aenean massa.</p>
                </div>
                <!-- Services box 4 -->
                <div class="col-12 col-md-3">
                    <i class="bi bi-file-bar-graph text-dark"></i>
                    <h5 class="fw-normal margin-top-10">Marketing</h5>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
                        Aenean massa.</p>
                </div>
            </div><!-- end row -->

            <div class="row text-center margin-top-40">
                <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                    <h2>Rekomendasi Dokter</h2>
                    <div class="divider-width-50px">
                        <hr class="bg-black-06">
                    </div>
                </div>
            </div>

            <div class="row g-2">
                @forelse($user as $row)
                    <div class="col-12 col-md-4">
                        <div class="border-radius-05 bg-white border-all padding-20 padding-lg-30">
                            <a href="{{ route('frontend.dokter.detail', $row->id) }}">
                                <img src="{{ asset('storage/users-avatar/' . $row->avatar) }}" alt=""
                                    class="img-preview">
                            </a>
                            <div class="d-lg-flex justify-content-between margin-bottom-10 margin-top-20">
                                <div class="d-block d-lg-inline-block margin-bottom-10">
                                    <a href="{{ route('frontend.dokter.detail', $row->id) }}">
                                        <h5 class="fw-normal line-height-140 margin-0">{{ $row->name }}</h5>
                                    </a>
                                    <span class="font-small fw-normal">{{ $row->dokter->spesialis }} -
                                        {{ $row->dokter->pengalaman_tahun }}
                                        Tahun</span>
                                </div>
                                {{-- <div class="d-inline-block text-yellow">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div> --}}
                            </div>
                            <p>{{ \Illuminate\Support\Str::limit($row->dokter->deskripsi, $limit = 100, $end = '...') }}</p>
                            <a class="button button-reveal-right-dark button-lg margin-top-10"
                                href="{{ url('chat-RSJuanda/' . $row->id) }}" target="_blank"><i
                                    class="bi bi-arrow-right"></i><span>CHAT</span></a>
                        </div>

                    </div>
                @empty
                    <div class="row text-center margin-top-40 fw-normal">
                        <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                            <h6>Tidak ada data yang tesedia</h6>
                        </div>
                    </div>
                @endforelse
                {{ $user->links('vendor.pagination.custom-pagination') }}
            </div>
        </div><!-- end container -->
    </div>
    <!-- end Dokter section -->
@endsection
