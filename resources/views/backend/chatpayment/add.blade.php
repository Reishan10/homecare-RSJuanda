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
                <form action="{{ route('chatpayment.store') }}" method="post" id="form">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="mb-3">
                                        <label for="pasien" class="form-label">Pasien</label>
                                        <select name="pasien" id="pasien" class="form-control select2"
                                            data-toggle="select2">
                                            <option value="">-- Pilih Pasien --</option>
                                            @foreach ($pasien as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback errorPasien">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="mb-3">
                                        <label for="dokter" class="form-label">Dokter</label>
                                        <select name="dokter" id="dokter" class="form-control select2"
                                            data-toggle="select2">
                                            <option value="">-- Pilih Dokter --</option>
                                            @foreach ($dokter as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback errorDokter">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="mb-3">
                                        <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                        <input type="datetime-local" name="waktu_mulai" id="waktu_mulai"
                                            class="form-control">
                                        <div class="invalid-feedback errorWaktuMulai">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="mb-3">
                                        <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                                        <input type="datetime-local" name="waktu_selesai" id="waktu_selesai"
                                            class="form-control">
                                        <div class="invalid-feedback errorWaktuSelesai">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="mb-3">
                                        <label for="biaya_chat" class="form-label">Total Biaya</label>
                                        <input type="text" name="biaya_chat" id="biaya_chat" class="form-control"
                                            readonly>
                                        <div class="invalid-feedback errorBiayaChat">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="button" class="btn btn-secondary mb-2"
                                        onclick="window.location='{{ route('chatpayment.index') }}'">Kembali</button>
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
            $('#waktu_mulai, #waktu_selesai').change(function() {
                let waktu_mulai = new Date($('#waktu_mulai').val()).getTime();
                let waktu_selesai = new Date($('#waktu_selesai').val()).getTime();

                if (waktu_mulai && waktu_selesai) {
                    let selisih_waktu = waktu_selesai - waktu_mulai;
                    if (selisih_waktu < 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Waktu selesai tidak bisa lebih awal dari waktu mulai!'
                        });
                        $('#waktu_selesai').val('');
                        $('#biaya_chat').val('');
                        return;
                    }
                    let biaya_per_menit = 800;
                    let biaya_chat = Math.ceil(selisih_waktu / 60000) * biaya_per_menit;
                    $('#biaya_chat').val(biaya_chat);
                }
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    data: $(this).serialize(),
                    url: "{{ route('chatpayment.store') }}",
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
                            if (response.errors.dokter) {
                                $('#dokter').addClass('is-invalid');
                                $('.errorDokter').html(response.errors.dokter);
                            } else {
                                $('#dokter').removeClass('is-invalid');
                                $('.errorDokter').html('');
                            }
                            if (response.errors.waktu_mulai) {
                                $('#waktu_mulai').addClass('is-invalid');
                                $('.errorWaktuMulai').html(response.errors.waktu_mulai);
                            } else {
                                $('#waktu_mulai').removeClass('is-invalid');
                                $('.errorWaktuMulai').html('');
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
                                text: 'Silakan upload bukti pembayaran.',
                            }).then(function() {
                                top.location.href = "{{ route('chatpayment.index') }}";
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
