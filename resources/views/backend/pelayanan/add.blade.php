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
                <form action="{{ route('pelayanan.store') }}" method="post" id="form">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h5>Biodata Pasien</h5>
                            <hr>
                            <div class="row">
                                <div class="col-lg-4 col-md-12">
                                    <div class="mb-3">
                                        <label for="pasien" class="form-label">Pasien</label>
                                        <select class="form-control select2" data-toggle="select2" name="pasien"
                                            id="pasien">
                                            <option value="">-- Pilih Data --</option>
                                            @foreach ($pasien as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback errorPasien">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="mb-3">
                                        <label for="no_telepon" class="form-label">No Telepon</label>
                                        <input type="number" name="no_telepon" id="no_telepon" class="form-control">
                                        <div class="invalid-feedback errorNoTelepon">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea name="alamat" id="alamat" rows="1" class="form-control"></textarea>
                                        <div class="invalid-feedback errorAlamat">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="mb-3">
                                        <label for="riwayat_penyakit" class="form-label">Riwayat Penyakit</label>
                                        <textarea name="riwayat_penyakit" id="riwayat_penyakit" rows="2" class="form-control"></textarea>
                                        <div class="invalid-feedback errorRiwayatPenyakit">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5>Transaksi</h5>
                            <hr>
                            <div class="row">
                                <div class="col-lg-4 col-md-12">
                                    <div class="mb-3">
                                        <label for="dokter" class="form-label">Dokter</label>
                                        <select class="form-control select2" data-toggle="select2" name="dokter"
                                            id="dokter">
                                            <option value="">-- Pilih Data --</option>
                                            @foreach ($dokter as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback errorDokter">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="layanan" class="form-label">Layanan</label>
                                        <select class="form-control" name="layanan" id="layanan">
                                            <option value="">-- Pilih Layanan --</option>
                                            <option value="Perawat">Perawat</option>
                                            <option value="Fisioterapi">Fisioterapi</option>
                                            <option value="Telemedicine">Telemedicine</option>
                                        </select>
                                        <div class="invalid-feedback errorLayanan">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="paket" class="form-label">Paket</label>
                                        <select class="form-control" name="paket" id="paket">
                                            <option value="">-- Pilih Paket --</option>
                                            <option value="1x12">1x12</option>
                                            <option value="3x24">3x24</option>
                                            <option value="7x24">7x24</option>
                                        </select>
                                        <div class="invalid-feedback errorPaket">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="mb-3">
                                        <label for="kota" class="form-label">Kota</label>
                                        <select class="form-control select2" data-toggle="select2" name="kota"
                                            id="kota">
                                            <option value="">-- Pilih Data --</option>
                                            @foreach ($kota as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback errorKota">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                                        <input type="datetime-local" name="waktu_selesai" id="waktu_selesai"
                                            class="form-control">
                                        <div class="invalid-feedback errorWaktuSelesai">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <table style="width:100%;">
                                        <tr>
                                            <td>Kode Pelayanan</td>
                                            <td>:</td>
                                            <td>
                                                <h5 id="kode_pelayanan">{{ $LayananCode }}</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Harga</td>
                                            <td>:</td>
                                            <td>
                                                <h4 id="harga">Rp. 0</h4>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="button" class="btn btn-secondary mb-2"
                                        onclick="window.location='{{ route('pelayanan.index') }}'">Kembali</button>
                                    <button type="submit" class="btn btn-primary mb-2" id="simpan">Simpan</button>
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
        $(document).ready(function() {
            $('#pasien').change(function() {
                let id = $(this).val();
                $.ajax({
                    url: '/pelayanan/' + id,
                    type: 'GET',
                    success: function(response) {
                        $('#alamat').val(response.alamat);
                        $('#no_telepon').val(response.no_telepon);
                    }
                });
            });

            $('#paket, #layanan').change(function() {
                $.ajax({
                    url: "{{ route('pelayanan.hitung') }}",
                    method: "GET",
                    data: {
                        paket: $('#paket').val(),
                        layanan: $('#layanan').val(),
                    },
                    success: function(response) {
                        $("#harga").text(response.harga);
                    }
                });
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#form').submit(function(e) {
                e.preventDefault();

                let kode_pelayanan = document.getElementById('kode_pelayanan').innerHTML;
                let harga = document.getElementById('harga').innerHTML;
                var data = $(this).serialize();

                data += "&kode_pelayanan=" + kode_pelayanan;
                data += "&harga=" + harga;

                $.ajax({
                    data: data,
                    url: "{{ route('pelayanan.store') }}",
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
                            if (response.errors.pasien) {
                                $('#pasien').addClass('is-invalid');
                                $('.errorPasien').html(response.errors.pasien);
                            } else {
                                $('#pasien').removeClass('is-invalid');
                                $('.errorPasien').html('');
                            }

                            if (response.errors.no_telepon) {
                                $('#no_telepon').addClass('is-invalid');
                                $('.errorNoTelepon').html(response.errors.no_telepon);
                            } else {
                                $('#no_telepon').removeClass('is-invalid');
                                $('.errorNoTelepon').html('');
                            }

                            if (response.errors.alamat) {
                                $('#alamat').addClass('is-invalid');
                                $('.errorAlamat').html(response.errors.alamat);
                            } else {
                                $('#alamat').removeClass('is-invalid');
                                $('.errorAlamat').html('');
                            }

                            if (response.errors.riwayat_penyakit) {
                                $('#riwayat_penyakit').addClass('is-invalid');
                                $('.errorRiwayatPenyakit').html(response.errors
                                    .riwayat_penyakit);
                            } else {
                                $('#riwayat_penyakit').removeClass('is-invalid');
                                $('.errorRiwayatPenyakit').html('');
                            }

                            if (response.errors.dokter) {
                                $('#dokter').addClass('is-invalid');
                                $('.errorDokter').html(response.errors.dokter);
                            } else {
                                $('#dokter').removeClass('is-invalid');
                                $('.errorDokter').html('');
                            }

                            if (response.errors.layanan) {
                                $('#layanan').addClass('is-invalid');
                                $('.errorLayanan').html(response.errors.layanan);
                            } else {
                                $('#layanan').removeClass('is-invalid');
                                $('.errorLayanan').html('');
                            }

                            if (response.errors.paket) {
                                $('#paket').addClass('is-invalid');
                                $('.errorPaket').html(response.errors.paket);
                            } else {
                                $('#paket').removeClass('is-invalid');
                                $('.errorPaket').html('');
                            }

                            if (response.errors.kota) {
                                $('#kota').addClass('is-invalid');
                                $('.errorKota').html(response.errors.kota);
                            } else {
                                $('#kota').removeClass('is-invalid');
                                $('.errorKota').html('');
                            }

                            if (response.errors.waktu_selesai) {
                                $('#waktu_selesai').addClass('is-invalid');
                                $('.errorWaktuSelesai').html(response.errors.waktu_selesai);
                            } else {
                                $('#waktu_selesai').removeClass('is-invalid');
                                $('.errorWaktuSelesai').html('');
                            }
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses',
                                text: 'Data berhasil disimpan',
                            }).then(function() {
                                top.location.href = "{{ route('pelayanan.index') }}";
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
