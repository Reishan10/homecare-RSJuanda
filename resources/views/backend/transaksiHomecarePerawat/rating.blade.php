@extends('layouts.backend_main')
@section('title', 'Rating')
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">@yield('title')</h4>
                </div>
                <form id="form">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <style>
                                    .rating-container {
                                        display: flex;
                                        justify-content: center;
                                    }

                                    .star {
                                        font-size: 40px;
                                        margin: 5px;
                                        margin-bottom: 20px;
                                    }

                                    .text-yellow {
                                        color: yellow;
                                    }
                                </style>
                                <div class="rating-container">
                                    <input type="hidden" name="id" id="id"
                                        value="{{ $transaksiHomecare->id }}">
                                    <input type="hidden" name="rating" id="rating" required>
                                    <i class="star bi bi-star-fill" data-star="1"></i>
                                    <i class="star bi bi-star-fill" data-star="2"></i>
                                    <i class="star bi bi-star-fill" data-star="3"></i>
                                    <i class="star bi bi-star-fill" data-star="4"></i>
                                    <i class="star bi bi-star-fill" data-star="5"></i>
                                </div>
                                <div class="mb-3">
                                    <label for="komen" class="form-label">Komen</label>
                                    <textarea name="komen" id="komen" class="form-control" rows="5" required></textarea>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="button" class="btn btn-secondary mb-2"
                                        onclick="window.location='{{ route('transaksi-homecare-perawat.index') }}'">Kembali</button>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/vfs_fonts.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let stars = document.querySelectorAll('.star');
            let ratingInput = document.getElementById('rating');
            let saveChangesBtn = document.getElementById('saveChanges');

            stars.forEach(star => {
                star.addEventListener('mouseover', function() {
                    let starValue = this.getAttribute('data-star');
                    for (let i = 0; i < stars.length; i++) {
                        if (i < starValue) {
                            stars[i].classList.add('text-yellow');
                        } else {
                            stars[i].classList.remove('text-yellow');
                        }
                    }
                });

                star.addEventListener('mouseout', function() {
                    stars.forEach(star => {
                        star.classList.remove('text-yellow');
                    });
                    let currentValue = ratingInput.value;
                    for (let i = 0; i < stars.length; i++) {
                        if (i < currentValue) {
                            stars[i].classList.add('text-yellow');
                        }
                    }
                });

                star.addEventListener('click', function() {
                    let starValue = this.getAttribute('data-star');
                    ratingInput.value = starValue;
                });
            });

            saveChangesBtn.addEventListener('click', function() {
                let rating = ratingInput.value;
                // Lakukan tindakan lain sesuai kebutuhan, seperti mengirim nilai penilaian ke server
                console.log('Rating:', rating);
                // Tutup modal
                let modal = document.getElementById('exampleModal');
                let bootstrapModal = bootstrap.Modal.getInstance(modal);
                bootstrapModal.hide();
            });
        });

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
                    url: "{{ route('transaksi-homecare-perawat.prosesRating') }}",
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
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: 'Data berhasil disimpan.',
                        }).then(function() {
                            top.location.href =
                                "{{ route('transaksi-homecare-perawat.index') }}";
                        });
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
