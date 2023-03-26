@extends('layouts.backend_main')
@section('title', 'Edit Pasien')
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">@yield('title')</h4>
                </div>
                <form action="{{ route('pasien.update', $pasien->id) }}" method="post" id="form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="hidden" name="id" id="id" value="{{ $pasien->id }}">
                                        <input type="text" id="name" name="name" class="form-control"
                                            value={{ $pasien->name }}>
                                        <div class="invalid-feedback errorName">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" name="email" class="form-control"
                                            value={{ $pasien->email }}>
                                        <div class="invalid-feedback errorEmail">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_telepon" class="form-label">No Telepon</label>
                                        <input type="number" id="no_telepon" name="no_telepon" class="form-control"
                                            placeholder="6285...." value={{ $pasien->no_telepon }}>
                                        <div class="invalid-feedback errorNoTelepon">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Jenis Kelamin</label>
                                        <select name="gender" id="gender" class="form-control">
                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                            <option value="L" {{ $pasien->gender == 'L' ? 'selected' : '' }}>Laki-laki
                                            </option>
                                            <option value="P" {{ $pasien->gender == 'P' ? 'selected' : '' }}>Perempuan
                                            </option>
                                        </select>
                                        <div class="invalid-feedback errorGender">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="mb-3">
                                        <label for="address" class="form-label">ALamat</label>
                                        <textarea name="address" id="address" rows="5" class="form-control">{{ $pasien->address }}</textarea>
                                        <div class="invalid-feedback errorAddress">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <img src="{{ asset('storage/users-avatar/' . $pasien->avatar) }}"
                                                    alt=""class="img-thumbnail img-preview">
                                            </div>
                                            <div class="col-sm-8">
                                                <label class="form-label" for="avatar">Foto</label>
                                                <input type="file" name="avatar" id="avatar" class="form-control"
                                                    accept="image/*" onchange="previewImgFoto()">
                                                <div class="invalid-feedback errorAvatar">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="button" class="btn btn-secondary mb-3"
                                        onclick="window.location='{{ route('pasien.index') }}'">Kembali</button>
                                    <button type="submit" class="btn btn-primary mb-3" id="simpan">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- end page title -->
    </div>
    <script>
        function previewImgFoto() {
            const foto = document.querySelector('#avatar');
            const imgPreview = document.querySelector('.img-preview');
            const fileFoto = new FileReader();

            fileFoto.readAsDataURL(foto.files[0]);

            fileFoto.onload = function(e) {
                imgPreview.src = e.target.result;
            }
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#form').submit(function(e) {
                e.preventDefault();
                let id = $('#id').val();

                $.ajax({
                    data: new FormData(this),
                    url: "{{ url('pasien/"+id+"') }}",
                    type: "POST",
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function() {
                        $('#simpan').attr('disable', 'disabled');
                        $('#simpan').text('Proses...');
                    },
                    complete: function() {
                        $('#simpan').removeAttr('disable');
                        $('#simpan').html('Simpan');
                    },
                    success: function(response) {
                        if (response.errors) {
                            if (response.errors.name) {
                                $('#name').addClass('is-invalid');
                                $('.errorName').html(response.errors.name);
                            } else {
                                $('#name').removeClass('is-invalid');
                                $('.errorName').html('');
                            }

                            if (response.errors.email) {
                                $('#email').addClass('is-invalid');
                                $('.errorEmail').html(response.errors.email);
                            } else {
                                $('#email').removeClass('is-invalid');
                                $('.errorEmail').html('');
                            }

                            if (response.errors.no_telepon) {
                                $('#no_telepon').addClass('is-invalid');
                                $('.errorNoTelepon').html(response.errors.no_telepon);
                            } else {
                                $('#no_telepon').removeClass('is-invalid');
                                $('.errorNoTelepon').html('');
                            }

                            if (response.errors.gender) {
                                $('#gender').addClass('is-invalid');
                                $('.errorGender').html(response.errors.gender);
                            } else {
                                $('#gender').removeClass('is-invalid');
                                $('.errorGender').html('');
                            }

                            if (response.errors.address) {
                                $('#address').addClass('is-invalid');
                                $('.errorAddress').html(response.errors.address);
                            } else {
                                $('#address').removeClass('is-invalid');
                                $('.errorAddress').html('');
                            }

                            if (response.errors.avatar) {
                                $('#avatar').addClass('is-invalid');
                                $('.errorAvatar').html(response.errors.avatar);
                            } else {
                                $('#avatar').removeClass('is-invalid');
                                $('.errorAvatar').html('');
                            }
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses',
                                text: 'Data berhasil disimpan',
                            }).then(function() {
                                top.location.href = "{{ route('pasien.index') }}";
                            });
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.error(xhr.status + "\n" + xhr.responseText + "\n" +
                            thrownError);
                    }
                });
            });
        });
    </script>
@endsection
