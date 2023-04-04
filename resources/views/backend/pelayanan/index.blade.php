@extends('layouts.backend_main')
@section('title', 'Pelayanan')
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">@yield('title')</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <div class="text-sm-end">
                                    <button type="button" class="btn btn-danger mb-2 btn-sm" id="btnHapusBanyak">
                                        <i class="mdi mdi-trash-can"></i> Hapus Banyak
                                    </button>
                                    <a href="{{ route('pelayanan.create') }}" class="btn btn-primary mb-2 btn-sm"><i
                                            class="mdi mdi-plus-circle"></i> Tambah Data</a>
                                </div>
                            </div><!-- end col-->
                        </div>

                        <div class="table-responsive">
                            <table id="datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="check_all"></th>
                                        <th>No</th>
                                        <th>Pasien</th>
                                        <th>No Telepon</th>
                                        <th>Waktu Selesai</th>
                                        <th>Sisa Waktu</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->

    </div> <!-- content -->

    <!-- Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Pelayanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm">
                        <tr>
                            <td>Kode Pelayanan</td>
                            <td>:</td>
                            <td id="kode_pelayanan"></td>
                        </tr>
                        <tr>
                            <td>Pasien</td>
                            <td>:</td>
                            <td id="pasien"></td>
                        </tr>
                        <tr>
                            <td>Dokter</td>
                            <td>:</td>
                            <td id="dokter"></td>
                        </tr>
                        <tr>
                            <td>Layanan</td>
                            <td>:</td>
                            <td id="layanan"></td>
                        </tr>
                        <tr>
                            <td>Paket</td>
                            <td>:</td>
                            <td id="paket"></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td id="alamat"></td>
                        </tr>
                        <tr>
                            <td>Riwayat Penyakit</td>
                            <td>:</td>
                            <td id="riwayat_penyakit"></td>
                        </tr>
                        <tr>
                            <td>No Telepon</td>
                            <td>:</td>
                            <td id="no_telepon"></td>
                        </tr>
                        <tr>
                            <td>Total Harga</td>
                            <td>:</td>
                            <td id="harga"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('body').on('click', '#btn-detail', function() {
                let id = $(this).data('id');
                $.ajax({
                    type: "POST",
                    url: "{{ url('/pelayanan/detail/"+id+"') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        let pelayanan = response.pelayanan;
                        let dokter = response.dokter;
                        $('#kode_pelayanan').text(pelayanan.kode_pelayanan);
                        $('#pasien').text(pelayanan.user.name);
                        $('#dokter').text(dokter.user.name);
                        $('#layanan').text(pelayanan.layanan);
                        $('#paket').text(pelayanan.paket);
                        $('#alamat').text(pelayanan.alamat);
                        $('#riwayat_penyakit').text(pelayanan.riwayat_penyakit);
                        $('#no_telepon').text(pelayanan.no_telepon);
                        $('#harga').text(pelayanan.harga);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" +
                            thrownError);
                    }
                })
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#datatable').DataTable({
                processing: true,
                serverside: true,
                ajax: "{{ route('pelayanan.index') }}",
                columns: [{
                    data: 'comboBox',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'name',
                    name: 'Nama'
                }, {
                    data: 'no_telepon',
                    name: 'No Telepon'
                }, {
                    data: 'waktu_selesai',
                    name: 'Waktu selesai'
                }, {
                    data: 'countdown',
                    name: 'countdown',
                }, {
                    data: 'status',
                    name: 'status',
                }, {
                    data: 'aksi',
                    name: 'Aksi'
                }],
                initComplete: function() {
                    // Calculate the countdown timer for each row
                    $('#datatable tbody tr').each(function() {
                        var countdown_id = $(this).find('td:first').text();
                        var countdown_time = $(this).find('td:eq(4)').text();

                        // Set the date we're counting down to
                        var countDownDate = new Date(countdown_time).getTime();

                        // Get the countdown element
                        var countdown_element = $(this).find('td:eq(5)');

                        // Update the count down every 1 second
                        var x = setInterval(function() {
                            // Get today's date and time
                            var now = new Date().getTime();

                            // Find the distance between now and the count down date
                            var distance = countDownDate - now;

                            // Time calculations for days, hours, minutes and seconds
                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) /
                                (1000 * 60 * 60));
                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (
                                1000 * 60));
                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                            // Format the output with leading zeros
                            days = ("0" + days).slice(-2);
                            hours = ("0" + hours).slice(-2);
                            minutes = ("0" + minutes).slice(-2);
                            seconds = ("0" + seconds).slice(-2);

                            // Output the result in the countdown element
                            countdown_element.text(days + ":" + hours + ":" +
                                minutes + ":" + seconds);

                            // If the count down is over, write some text
                            if (distance < 0) {
                                clearInterval(x);
                                countdown_element.text("Waktu Habis");
                            }
                        }, 1000);
                    });
                },
            });
        });

        // Nonaktif Data
        $('body').on('click', '#btnNonaktif', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Nonaktif',
                text: "Apakah anda yakin?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Nonaktif!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/pelayanan/nonaktif/"+id+"') }}",
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: response.success,
                                }).then(function() {
                                    top.location.href =
                                        "{{ route('pelayanan.index') }}";
                                });
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" +
                                thrownError);
                        }
                    })
                }
            })
        })

        // Hapus Data
        $('body').on('click', '#btnHapus', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Hapus',
                text: "Apakah anda yakin?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('pelayanan/"+id+"') }}",
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: response.success,
                                }).then(function() {
                                    top.location.href =
                                        "{{ route('pelayanan.index') }}";
                                });
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" +
                                thrownError);
                        }
                    })
                }
            })
        })

        // Ceklis Checkbox Hapus Banyak
        $('#check_all').on('click', function(e) {
            if ($(this).is(':checked', true)) {
                $(".checkbox").prop('checked', true);
            } else {
                $(".checkbox").prop('checked', false);
            }
        });

        $('#btnHapusBanyak').on('click', function(e) {
            let idArr = [];
            $(".checkbox:checked").each(function() {
                idArr.push($(this).attr('data-id'));
            });
            if (idArr.length <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Silakan pilih data terlebih dahulu untuk dihapus!',
                })
            } else {
                Swal.fire({
                    title: 'Hapus',
                    text: "Apakah anda yakin?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    let strId = idArr.join(",");
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('delete-multiple-pelayanan') }}",
                            type: 'POST',
                            data: 'id=' + strId,
                            success: function(response) {
                                console.log(response);
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sukses',
                                        text: response.success,
                                    }).then(function() {
                                        top.location.href =
                                            "{{ route('pelayanan.index') }}";
                                    });
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + "\n" + xhr.responseText + "\n" +
                                    thrownError);
                            }
                        })
                    }
                })
            }
        });
    </script>
@endsection
