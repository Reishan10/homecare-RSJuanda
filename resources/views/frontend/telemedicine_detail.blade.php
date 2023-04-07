@extends('layouts.frontend_main')
@section('title', 'Detail Dokter')
@section('content')
    <!-- detail section -->
    <div class="section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-12 col-lg-4">
                    <img src="{{ asset('storage/users-avatar/' . $user->avatar) }}" alt=""><!-- Image source -->
                </div>
                <div class="col-12 col-lg-8">
                    <h6 class="font-family-tertiary font-small fw-normal uppercase">{{ $user->dokter->spesialis }} -
                        {{ $user->dokter->pengalaman_tahun }}Tahun</h6>
                    <h3>{{ $user->name }}</h3>
                    <p>{{ $user->dokter->deskripsi }}</p>
                    <a class="button button-reveal-right-dark button-lg margin-top-10 btn-"
                        href="{{ url('chat-RSJuanda/' . $user->id) }}"><i class="bi bi-arrow-right"></i><span>CHAT</span></a>

                </div>
            </div><!-- end row -->
        </div><!-- end container -->
    </div>
    <!-- end detail section -->
@endsection
