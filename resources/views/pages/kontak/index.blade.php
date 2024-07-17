@extends('templates.main')
@section('title')
    Kontak
@endsection
@section('styles')
    {{-- Datatable --}}
    <link href="{{ asset('assets/libs/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />

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
                    <div class="card-header mb-3 bg-dark">
                        <h2 class="text-white">Tabel Kontak</h2>
                    </div>
                    <div class="add">
                        @php
                            $kontak = App\Models\Kontak::first();
                        @endphp
                        @if(!$kontak)
                            <button type="button" class="btn btn-success waves-effect width-md waves-light rounded float-right" data-toggle="modal" data-target="#modalKontak">Tambah Kontak</button>
                            <br><br><br>
                        @endif
                    </div>
                    <table id="tableKontak" class="table table-bordered dt-responsive nowrap table-striped" width="100%">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th class="align-middle" style="max-width: 5%;">No</th>
                                <th class="align-middle">Email</th>
                                <th class="align-middle">Telepon</th>
                                <th class="align-middle">Alamat</th>
                                <th class="align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- modals --}}
    <div class="modal fade" id="modalKontak" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalKontakTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalKontakTitle">Form Kontak</h4>
                    <button type="button" id="cancel" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formKontak" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="hidden" name="id" id="id">
                            <input type="email" name="email" id="email" class="form-control" required placeholder="Masukkan Email">
                        </div>
                        <div class="form-group">
                            <label for="telepon">Telepon</label>
                            <input type="text" name="telepon" id="telepon" class="form-control" required placeholder="Masukkan Nomor Telepon">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" name="alamat" id="alamat" class="form-control" required placeholder="Masukkan Alamat">
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="cancel" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" id="saveKontak" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    {{-- Datatable --}}
    <script src="{{ asset('assets/libs/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.select.min.js') }}"></script>

    {{-- select2 --}}
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}" defer></script>
    <!-- Sweet Alerts js -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        // =================== methods ===================
        const resetForm = () => {
            $('#formKontak')[0].reset();
            $('#modalKontakTitle').text('Form Kontak');
            $('#id').val('');
            $('#email').text('');
            $('#telepon').text('');
            $('#alamat').text('');
        }

        const tableKontak = (query = '') => {
            $('#tableKontak').DataTable({
                processing: true,
                info: true,
                responsive: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('kontak.table') }}",
                    method: 'GET',
                    data: {
                        query: query,
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'alamat', name: 'alamat' },
                    { data: 'action', name: 'action' },
                ],
                columnDefs: [
                    { className: 'text-center', targets: '_all' },
                ]
            });
        }
        // =================== end method ===================

        // =================== initialization ===================
        $(document).ready(function() {
            // init interceptor
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });

            // init table
            tableKontak();
        });
        // =================== end initialization ===================

        // =================== actions ===================
        $(document).on('click', '#cancel', function() {
            resetForm();
        });

        $("#formKontak").submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('kontak.storeOrUpdate') }}",
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    Swal.fire({
                        title: `<div style="width: 80px; height: 80px;" class="spinner-border text-info m-2" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>`,
                        text: 'Loading...',
                        customClass: 'swal-loading',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                    });
                },
                success: function(response) {
                    if(response.code == 422) {
                        const validateMessage = response.message; // object
                        let arrayMessage = "";
                        let counter = 1;
                        for(const field in validateMessage) {
                            const errMessage = validateMessage[field]; // array
                            for(const msg of errMessage) {
                                arrayMessage += `${counter}. ${msg}<br>`;
                                counter++;
                            }
                        }
                        Swal.fire({
                            title: 'Gagal!',
                            html: `${arrayMessage}`,
                            type: response.status,
                            confirmButtonText: 'Oke',
                        });
                    } 
                    else {
                        Swal.fire({
                            title: (response.code == 200) ? 'Berhasil!' : 'Gagal!',
                            text: response.message,
                            type: response.status,
                            confirmButtonText: 'Oke',
                        });
                        if(response.code == 200) {
                            $('#tableKontak').DataTable().ajax.reload(null, false);
                            $('#modalKontak').modal('hide');
                            $('.add').empty();
                            resetForm();
                        }
                    }
                }
            });
        });

        $(document).on('click', '#edit', function() {
            const id = $(this).data('id');
            $.ajax({
                url: `/admin/kontak/edit/${id}`,
                method: 'GET',
                beforeSend: function() {
                    Swal.fire({
                        title: `<div style="width: 80px; height: 80px;" class="spinner-border text-info m-2" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>`,
                        text: 'Loading...',
                        customClass: 'swal-loading',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                    });
                },
                success: function(response) {
                    if(response.code == 200) {
                        Swal.close();
                        resetForm();
                        $('#id').val(response.data.id);
                        $('#email').val(response.data.email);
                        $('#telepon').val(response.data.phone);
                        $('#alamat').val(response.data.alamat);

                        $('#modalKontakTitle').text('Form Edit Kontak');
                        $('#modalKontak').modal('show');
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: response.message,
                            type: response.status,
                            confirmButtonText: 'Oke',
                        });
                    }
                }
            });
        });
        // =================== end actions ===================
    </script>
@endsection