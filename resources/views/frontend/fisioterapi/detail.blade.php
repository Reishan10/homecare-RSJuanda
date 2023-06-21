@extends('layouts.frontend_main')
@section('title', 'Detail Perawat')
@section('content')
    <!-- detail section -->
    <div class="section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-12 col-lg-4">
                    <img src="{{ asset('storage/users-avatar/' . $perawat->user->avatar) }}" alt="">
                    <!-- Image source -->
                </div>

                <div class="col-12 col-lg-8">
                    <h6 class="font-family-tertiary font-small fw-normal uppercase">Hari Kerja :
                        {{ $perawat->hari }}</h6>
                    <h3>{{ $perawat->user->name }}</h3>

                    <h6 class="font-family-tertiary font-small fw-normal uppercase">
                        Jam Kerja : {{ $perawat->jam_masuk }} -
                        {{ $perawat->jam_pulang }}</h6>
                    <div class="d-inline-block text-yellow">
                        <!-- Tampilkan bintang berdasarkan rata-rata rating -->
                        @php
                            $averageRating = $averageRatings; // Contoh nilai rata-rata rating
                            $fullStars = floor($averageRating);
                            $halfStar = false;
                            if ($averageRating - $fullStars >= 0.25 && $averageRating - $fullStars <= 0.75) {
                                $halfStar = true;
                            }
                            $extraStar = false;
                            if ($averageRating - $fullStars > 0.75) {
                                $extraStar = true;
                            }
                        @endphp

                        <!-- Tampilkan bintang sesuai dengan logika -->
                        @for ($i = 0; $i < $fullStars; $i++)
                            <i class="stars bi bi-star-fill"></i>
                        @endfor

                        @if ($halfStar)
                            <i class="stars bi bi-star-half"></i>
                        @endif

                        @if ($extraStar)
                            <i class="stars bi bi-star-fill"></i>
                        @endif
                    </div>
                    <p>{{ $perawat->deskripsi }}</p>
                    <a class="button button-reveal-right-dark button-lg margin-top-10"
                        href="{{ route('transaksi-fisioterapi.create') }}"><i class="bi bi-arrow-right"></i><span>pesan</span></a>

                </div>
            </div><!-- end row -->
        </div><!-- end container -->
    </div>
    <!-- end detail section -->
@endsection
