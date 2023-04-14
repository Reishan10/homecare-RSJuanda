@extends('layouts.backend_main')
@section('title', 'Tambah Data')
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">@yield('title')</h4>
                </div>
                <form action="{{ route('perawat.store') }}" method="post" id="form">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 col-md-12">
                                    <label for="pasien" class="form-label">Pasien</label>
                                    <select class="form-control select2" data-toggle="select2" name="pasien"
                                        id="pasien">
                                        <option>-- Pilih Pasien --</option>
                                    </select>
                                    <div class="invalid-feedback errorPasien"></div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <label for="perawat" class="form-label">Perawat</label>
                                    <select class="form-control select2" data-toggle="select2" name="perawat"
                                        id="perawat">
                                        <option>-- Pilih Perawat --</option>
                                    </select>
                                    <div class="invalid-feedback errorPerawat"></div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <label for="dokter" class="form-label">Dokter</label>
                                    <select class="form-control select2" data-toggle="select2" name="dokter"
                                        id="dokter">
                                        <option>-- Pilih Dokter --</option>
                                    </select>
                                    <div class="invalid-feedback errorDokter"></div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-4 col-md-12">
                                    <label for="riwayat_penyakit" class="form-label">Riwayat Penyakit</label>
                                    <input type="text" name="riwayat_penyakit" id="riwayat_penyakit"
                                        class="form-control">
                                    <div class="invalid-feedback errorRiwayatPernyakit"></div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <label for="waktu" class="form-label">Waktu</label>
                                    <input type="datetime-local" name="waktu" id="waktu" class="form-control">
                                    <div class="invalid-feedback errorWaktu"></div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <label for="jarak" class="form-label">Jarak (KM)</label>
                                    <input type="text" name="jarak" id="jarak" class="form-control">
                                    <div class="invalid-feedback errorJarak"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <label for="homecare" class="form-label">Paket Homecare</label>
                                    <select class="form-control select2" data-toggle="select2" name="homecare"
                                        id="homecare">
                                        <option>-- Pilih Homecare --</option>
                                    </select>
                                    <div class="invalid-feedback errorHomecare"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control">
                                    <div class="invalid-feedback errorNama"></div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-4 col-md-12">
                                    <label for="biaya_dokter" class="form-label">Biaya Dokter</label>
                                    <input type="text" name="biaya_dokter" id="biaya_dokter" class="form-control">
                                    <div class="invalid-feedback errorBiayaDokter"></div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <label for="biaya_perawat" class="form-label">Biaya Perawat</label>
                                    <input type="text" name="biaya_perawat" id="biaya_perawat" class="form-control">
                                    <div class="invalid-feedback errorBiayaPerawat"></div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <label for="total_biaya" class="form-label">Total Biaya</label>
                                    <input type="text" name="total_biaya" id="total_biaya" class="form-control">
                                    <div class="invalid-feedback errorTotalBiaya"></div>
                                </div>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                                <button type="button" class="btn btn-secondary mb-2"
                                    onclick="window.location='{{ route('transaksi-homecare.index') }}'">Kembali</button>
                                <button type="submit" class="btn btn-primary mb-2" id="simpan">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- end page title -->
    </div>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    data: $(this).serialize(),
                    url: "{{ route('perawat.store') }}",
                    type: "POST",
                    dataType: 'json',
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
                            if (response.errors.nip) {
                                $('#nip').addClass('is-invalid');
                                $('.errorNIP').html(response.errors.nip);
                            } else {
                                $('#nip').removeClass('is-invalid');
                                $('.errorNIP').html('');
                            }

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

                            if (response.errors.jabatan) {
                                $('#jabatan').addClass('is-invalid');
                                $('.errorJabatan').html(response.errors.jabatan);
                            } else {
                                $('#jabatan').removeClass('is-invalid');
                                $('.errorJabatan').html('');
                            }
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses',
                                text: 'Data berhasil disimpan',
                            }).then(function() {
                                top.location.href = "{{ route('perawat.index') }}";
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
