@extends('layouts.backend_main')
@section('title', 'Chat Payment')
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
                                    <a href="{{ route('chatpayment.create') }}" class="btn btn-primary mb-2 btn-sm"><i
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
                                        <th>Dokter</th>
                                        <th>Waktu Selesai</th>
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
                            <td>Kode Homecare</td>
                            <td>:</td>
                            <td id="kode_homecare"></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td id="name"></td>
                        </tr>
                        <tr>
                            <td>Bayar</td>
                            <td>:</td>
                            <td id="bayar"></td>
                        </tr>
                        <tr>
                            <td>Kategori</td>
                            <td>:</td>
                            <td id="kategori"></td>
                        </tr>
                        <tr>
                            <td>Poli</td>
                            <td>:</td>
                            <td id="poli"></td>
                        </tr>
                        <tr>
                            <td>Paket Obat</td>
                            <td>:</td>
                            <td id="paket_obat"></td>
                        </tr>
                        <tr>
                            <td>K.S.O</td>
                            <td>:</td>
                            <td id="kso"></td>
                        </tr>
                        <tr>
                            <td>Jasa Rumah Sakit</td>
                            <td>:</td>
                            <td id="jasa_rumah_sakit"></td>
                        </tr>
                        <tr>
                            <td>Jasa Medis Dokter</td>
                            <td>:</td>
                            <td id="jasa_medis_dokter"></td>
                        </tr>
                        <tr>
                            <td>Jasa Medis Perawat</td>
                            <td>:</td>
                            <td id="jasa_medis_perawat"></td>
                        </tr>
                        <tr>
                            <td>Menejemen</td>
                            <td>:</td>
                            <td id="menejemen"></td>
                        </tr>
                        <tr>
                            <td>Total Biaya Dokter</td>
                            <td>:</td>
                            <td id="total_biaya_dokter"></td>
                        </tr>
                        <tr>
                            <td>Total Biaya Perawat</td>
                            <td>:</td>
                            <td id="total_biaya_perawat"></td>
                        </tr>
                        <tr>
                            <td>Total Biaya Dokter & Perawat</td>
                            <td>:</td>
                            <td id="total_biaya_perawat_dokter"></td>
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
                    url: "{{ url('/homecare/detail/"+id+"') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#kode_homecare').text(response.homecare.kode_homecare);
                        $('#name').text(response.homecare.name);
                        $('#bayar').text(response.homecare.bayar.name);
                        $('#kategori').text(response.homecare.kategori.name);
                        $('#poli').text(response.homecare.poli.name);
                        $('#paket_obat').text(response.homecare.paket_obat);
                        $('#kso').text(response.homecare.kso);
                        $('#jasa_rumah_sakit').text(response.homecare.jasa_rumah_sakit);
                        $('#jasa_medis_dokter').text(response.homecare.jasa_medis_dokter);
                        $('#jasa_medis_perawat').text(response.homecare.jasa_medis_perawat);
                        $('#menejemen').text(response.homecare.menejemen);
                        $('#total_biaya_dokter').text(response.homecare.total_biaya_dokter);
                        $('#total_biaya_perawat').text(response.homecare.total_biaya_perawat);
                        $('#total_biaya_perawat_dokter').text(response.homecare
                            .total_biaya_perawat_dokter);
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
                ajax: "{{ route('homecare.index') }}",
                columns: [{
                        data: 'comboBox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'pasien',
                        name: 'pasien'
                    }, {
                        data: 'dokter',
                        name: 'dokter'
                    }, {
                        data: 'waktu_selesai',
                        name: 'waktu selesai'
                    }, {
                        data: 'status',
                        name: 'status'
                    }, {
                        data: 'aksi',
                        name: 'Aksi'
                    }
                ]
            });
        });

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
                        url: "{{ url('homecare/"+id+"') }}",
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
                                });
                                $('#datatable').DataTable().ajax.reload()
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
                            url: "{{ route('delete-multiple-homecare') }}",
                            type: 'POST',
                            data: 'id=' + strId,
                            success: function(response) {
                                console.log(response);
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sukses',
                                        text: response.success,
                                    });
                                    $('#datatable').DataTable().ajax.reload();
                                    $("#check_all").prop('checked', false);
                                    $(".checkbox").prop('checked', false);
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
