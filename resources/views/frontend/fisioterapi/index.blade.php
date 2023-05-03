@extends('layouts.frontend_main')
@section('title', 'Fisioterapi')
@section('content')
    <!-- Fisioterapi section -->
    <div class="section">
        <div class="container">
            <div class="row text-center">
                <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                    <h2>Fisioterapi</h2>
                    <div class="divider-width-50px">
                        <hr class="bg-black-06">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 offset-md-1 col-lg-4 offset-lg-4">
                <div class="border border-radius-025 padding-20 padding-md-30 padding-lg-40 text-center">
                    <div class="text-dark margin-bottom-10">
                        <img src="{{ asset('assets') }}/images/fisioterapi.png" alt="">
                    </div>
                    <p>Fisioterapi profesional yang akan memberikan tindakan rehabilitas untuk anda.</p>
                </div>
            </div>

            <div class="row text-center margin-top-40">
                <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                    <h2>Layanan tersedia</h2>
                    <div class="divider-width-50px">
                        <hr class="bg-black-06">
                    </div>
                </div>
            </div>
            <div class="row g-4 text-center icon-5xl margin-top-10">
                @forelse($fisioterapi as $row)
                    <div class="col-12 col-md-3">
                        <i class="bi bi-balloon-heart-fill text-dark"></i>
                        <h5 class="fw-normal margin-top-10">{{ $row->name }}</h5>
                        <p>{{ \Illuminate\Support\Str::limit($row->deskripsi, $limit = 100, $end = '...') }}</p>
                    </div>
                @empty
                    <div class="row text-center margin-top-40 fw-normal">
                        <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                            <h6>Tidak ada data yang tesedia</h6>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="row text-center margin-top-40">
                <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                    <h2>Perawat tersedia</h2>
                    <div class="divider-width-50px">
                        <hr class="bg-black-06">
                    </div>
                </div>
            </div>
            <div class="row g-2">
                @forelse($perawat as $row)
                    <div class="col-12 col-md-4">
                        <div class="border-radius-05 bg-white border-all padding-20 padding-lg-30">
                            <a href="{{ route('frontend.telemedicine.detail', $row->id) }}">
                                <img src="{{ asset('storage/users-avatar/' . $row->user->avatar) }}" alt=""
                                    class="img-preview">
                            </a>
                            <div class="d-lg-flex justify-content-between margin-bottom-10 margin-top-20">
                                <div class="d-block d-lg-inline-block margin-bottom-10">
                                    <a href="{{ route('frontend.telemedicine.detail', $row->id) }}">
                                        <h5 class="fw-normal line-height-140 margin-0">{{ $row->user->name }}</h5>
                                    </a>
                                    <span class="font-small fw-normal">{{ $row->jam_masuk }} -
                                        {{ $row->jam_pulang }}</span>
                                </div>
                            </div>
                            <p>{{ \Illuminate\Support\Str::limit($row->deskripsi, $limit = 100, $end = '...') }}
                            </p>
                            <a class="button button-reveal-right-dark button-lg margin-top-10"
                                href="{{ route('transaksi-fisioterapi.index') }}"><i
                                    class="bi bi-arrow-right"></i><span>Pesan</span></a>
                        </div>
                    </div>
                @empty
                    <div class="row text-center margin-top-40 fw-normal">
                        <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                            <h6>Tidak ada data yang tesedia</h6>
                        </div>
                    </div>
                @endforelse
                {{ $perawat->links('vendor.pagination.custom-pagination') }}
            </div>
        </div><!-- end container -->
    </div>
    <!-- end Perawat section -->
@endsection
