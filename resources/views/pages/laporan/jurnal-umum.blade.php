@extends('templates.main')
@section('title')
    Laporan - Jurnal Umum
@endsection
@section('styles')
    <!-- Sweet Alert-->
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .information-icon {
            position: relative;
            top: -5px;
        }
        .swal-loading {
            width: 300px !important;
        }
        .select2-container .select2-selection--single, .select2-selection--single .select2-selection__arrow {
            display: flex;
            align-items: center;
            height: 38px !important;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="card-header mb-3 bg-dark text-center">
                        <h2 class="text-white">Jurnal Umum</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-5 mb-2">
                            <input type="date" class="form-control" id="startDate" name="startDate" required>
                        </div>
                        <div class="col-md-5 mb-2">
                            <input type="date" class="form-control" id="endDate" name="endDate" disabled required>
                        </div>
                        <div class="col-md-2 mb-2">
                            <button type="button" class="btn btn-success waves-effect w-100 waves-light rounded" id="btnCetak">Cetak</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- Sweet Alerts js -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        // =================== actions ===================
        $('#startDate').change(function() {
            if(!$(this).val() == '') {
                $('#endDate').attr('min', $(this).val());
                $('#endDate').prop('disabled', false);
            } else {
                $('#endDate').removeAttr('min', '');
                $('#endDate').val('');
                $('#endDate').prop('disabled', true);
            }
        });

        $(document).on('click', '#btnCetak', function() {
            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val();
            if(startDate && endDate) {
                if(startDate <= endDate) {
                    window.open(`/laporan/jurnal-umum/cetak?startDate=${startDate}&endDate=${endDate}`);
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Tanggal mulai tidak boleh lebih besar dari tanggal akhir.',
                        type: 'error',
                        confirmButtonText: 'Oke',
                    });
                }
            }
            else {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Tanggal mulai dan tanggal akhir harus diisi.',
                    type: 'error',
                    confirmButtonText: 'Oke',
                });
            }
        });
        // =================== end actions ===================
    </script>
@endsection