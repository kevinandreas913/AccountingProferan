@extends('templates.main')
@section('title')
    Laporan - Perubahan Modal
@endsection
@section('styles')
    {{-- select2 --}}
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}" defer>
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
                        <h2 class="text-white">Perubahan Modal</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-5 mb-2">
                            <select name="tahun" class="form-control select2" id="tahun">
                                <option value="">-- Pilih Tahun --</option>
                            </select>
                        </div>
                        <div class="col-md-5 mb-2 bulan">
                            {{-- <select name="bulan" class="form-control" id="bulan">
                                <option value="">-- Pilih Bulan --</option>
                            </select> --}}
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
    {{-- select2 --}}
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}" defer></script>
    <!-- Sweet Alerts js -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        const joinYear = ("{{ $tahun }}");
        const joinMonth = ("{{ $bulan }}");
        const date = new Date();
        const thisYear = date.getFullYear();
        const thisMonth = date.getMonth() + 1;
        const MONTH = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $(document).ready(function() {
            // init select2
            $('.select2').select2();
            
            for(let i = thisYear; i >= joinYear; i--) {
                $('#tahun').append(`<option value="${i}">${i}</option>`);
            }
        });

        // =================== actions ===================
        $('#tahun').change(function() {
            $('.bulan').empty();
            $('.bulan').append(`
                <select name="bulan" id="bulan" class="form-control select2">
                    <option value="">-- Pilih Bulan --</option>
                </select>
            `);
            $('#bulan').select2();

            if ($(this).val() == '') {
                $('.bulan').empty();
            }
            else if ($(this).val() == thisYear) {
                if (joinMonth == thisMonth) {
                    for (let i = joinMonth; i <= thisMonth; i++) {
                        $("#bulan").append(`<option value="${i}">${MONTH[i-1]}</option>`);
                    }
                }
                else {
                    for (let i = 0; i < thisMonth; i++) {
                        $("#bulan").append(`<option value="${i+1}">${MONTH[i]}</option>`);
                    }
                }
            }
            else if ($(this).val() == joinYear) {
                for (let i = joinMonth; i <= 12; i++) {
                    $("#bulan").append(`<option value="${i}">${MONTH[i-1]}</option>`);
                }
            }
            else {
                for (let i = 0; i < 12; i++) {
                    $("#bulan").append(`<option value="${i+1}">${MONTH[i]}</option>`);
                }
            }
        });

        $(document).on('click', '#btnCetak', function() {
            const tahun = $('#tahun').val();
            const bulan = $('#bulan').val();
            if(tahun && bulan) {
                window.open(`/laporan/perubahan-modal/cetak?tahun=${tahun}&bulan=${bulan}`);
            }
            else {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Harap memilih tahun dan bulan terlebih dahulu.',
                    type: 'error',
                    confirmButtonText: 'Oke',
                });
            }
        });
        // =================== end actions ===================
    </script>
@endsection