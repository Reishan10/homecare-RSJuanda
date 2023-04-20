@extends('layouts.backend_main')

@section('title', 'Rekam Medis')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">@yield('title')</h4>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane show active" id="basic-preview">
                                @if (auth()->user()->type == 'Dokter')
                                    <div class="text-sm-end">
                                        <button type="button" class="btn btn-danger mb-2 btn-sm" id="btnHapusBanyak">
                                            <i class="mdi mdi-trash-can"></i> Hapus Banyak
                                        </button>
                                        <a href="{{ route('rekam-medis.create') }}" class="btn btn-primary mb-2 btn-sm"><i
                                                class="mdi mdi-plus-circle"></i> Tambah Rekam Medis</a>
                                    </div>
                                @endif
                                <table id="datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th width="1px"><input type="checkbox" id="check_all"></th>
                                            <th>#</th>
                                            <th>Kode</th>
                                            <th>Pasien</th>
                                            <th>Tanggal</th>
                                            <th>Keluhan</th>
                                            <th>Diagnosa</th>
                                            <th width="10">Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div> <!-- end preview-->
                        </div> <!-- end tab-content-->
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div>
        </div>
        <!-- end page title -->
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Rekam Medis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm">
                        <tr>
                            <td>Kode Rekam Medis</td>
                            <td>:</td>
                            <td id="kode_rekam_medis"></td>
                        </tr>
                        <tr>
                            <th colspan="3">Detail Pasien</th>
                        </tr>
                        <tr>
                            <td>Nama Pasien</td>
                            <td>:</td>
                            <td id="name"></td>
                        </tr>
                        <tr>
                            <td>No Telepon</td>
                            <td>:</td>
                            <td id="no_telepon"></td>
                        </tr>
                        <tr>
                            <th colspan="3">Detail Rekam Medis</th>
                        </tr>
                        <tr>
                            <td>Dokter</td>
                            <td>:</td>
                            <td id="dokter"></td>
                        </tr>
                        <tr>
                            <td>Tanggal Kunjungan</td>
                            <td>:</td>
                            <td id="tanggal_kunjungan"></td>
                        </tr>
                        <tr>
                            <td>Keluhan</td>
                            <td>:</td>
                            <td id="keluhan"></td>
                        </tr>
                        <tr>
                            <td>Diagnosa</td>
                            <td>:</td>
                            <td id="diagnosa"></td>
                        </tr>
                        <tr>
                            <td>Resep Obat</td>
                            <td>:</td>
                            <td id="resep_obat"></td>
                        </tr>
                        <tr>
                            <td>Catatan Tambahan</td>
                            <td>:</td>
                            <td id="catatan_tambahan"></td>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('body').on('click', '#btn-detail', function() {
                let id = $(this).data('id');
                $.ajax({
                    type: "POST",
                    url: "{{ url('/rekam-medis/detail/"+id+"') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#kode_rekam_medis').text(response.rekam_medis.kode_rekam_medis);
                        $('#name').text(response.rekam_medis.user.name);
                        $('#no_telepon').text(response.rekam_medis.user.no_telepon);
                        $('#dokter').text(response.namaDokter);
                        $('#tanggal_kunjungan').text(response.rekam_medis.tanggal_kunjungan);
                        $('#keluhan').text(response.rekam_medis.keluhan);
                        $('#diagnosa').text(response.rekam_medis.diagnosa);
                        $('#resep_obat').text(response.rekam_medis.resep_obat);
                        $('#catatan_tambahan').text(response.rekam_medis.catatan_tambahan);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" +
                            thrownError);
                    }
                })
            });

            $('#datatable').DataTable({
                processing: true,
                serverside: true,
                ajax: "{{ url('rekam-medis') }}",
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
                        data: 'kode_rekam_medis',
                        name: 'kode_rekam_medis'
                    },
                    {
                        data: 'pasien',
                        name: 'pasien'
                    },
                    {
                        data: 'tanggal_kunjungan',
                        name: 'tanggal_kunjungan'
                    },
                    {
                        data: 'keluhan',
                        name: 'keluhan'
                    },
                    {
                        data: 'diagnosa',
                        name: 'diagnosa'
                    },
                    {
                        data: 'aksi',
                        name: 'Aksi'
                    }
                ]
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
                            url: "{{ url('rekam-medis/"+id+"') }}",
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

            // Hapus Data Banyak
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
                                url: "{{ route('delete-multiple-rekam-medis') }}",
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
        });
    </script>
@endsection
