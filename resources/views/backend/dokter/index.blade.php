@extends('layouts.backend_main')
@section('title', 'Dokter')
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Dokter</h4>
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
                                    <a href="javascript:void(0);" class="btn btn-primary mb-2"><i
                                            class="mdi mdi-plus-circle me-2"></i> Tambah Dokter</a>
                                </div>
                            </div><!-- end col-->
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                id="basic-datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No Telepon</th>
                                        <th style="width: 75px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dokter as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->email }}</td>
                                            <td>{{ $row->no_telepon }}</td>
                                            <td>
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="fa-solid fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->

    </div> <!-- content -->

    <script>
        let table = new DataTable('#table');
    </script>
@endsection
