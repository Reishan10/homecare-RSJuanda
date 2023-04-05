@extends('layouts.auth_app')
@section('title', 'Registrasi')
@section('content')

    {{-- @if (session('message'))
        <div class="alert alert-danger">{{ session('message') }}</div>
    @endif --}}

    <!-- Logo -->
    <div class="card-header pt-3 pb-3 text-center bg-rs">
        <a href="index.html">
            <span><img src="{{ asset('assets') }}/images/juanda_header.png" alt="" height="40"></span>
        </a>
    </div>

    <div class="card-body p-3">
        <div class="text-center w-75 m-auto">
            <h4 class="text-dark-50 text-center pb-0 fw-bold">@yield('title')</h4>
        </div>

        @if (session('message'))
            <div class="alert alert-danger">{{ session('message') }}</div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name"
                    value="{{ old('name') }}" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input class="form-control @error('email') is-invalid @enderror" type="email" id="email"
                    name="email" value="{{ old('email') }}">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="no_telepon" class="form-label">No Telepon</label>
                <input class="form-control @error('no_telepon') is-invalid @enderror" type="number" id="no_telepon"
                    name="no_telepon" value="{{ old('no_telepon') }}">
                @error('no_telepon')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password"
                    class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
            </div>

            <div class="mb-0 text-center">
                <button class="btn btn-primary" type="submit"> Register </button>
            </div>
        </form>
    </div>
    <!-- end card-body -->
    <div class="row">
        <div class="col-12 text-center">
            <p class="text-muted">Punya akun? <a href="{{ route('login') }}" class="text-muted ms-1"><b>Login</b></a></p>
        </div> <!-- end col -->
    </div>
    <!-- end row -->
@endsection
