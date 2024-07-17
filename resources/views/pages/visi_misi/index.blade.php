@extends('templates.main')
@section('title')
    Visi & Misi
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
                        <h2 class="text-white">Tabel Visi & Misi</h2>
                    </div>
                    <div class="add">
                        @php
                            $visi_misi = App\Models\VisiMisi::first();
                        @endphp
                        @if(!$visi_misi)
                            <button type="button" class="btn btn-success waves-effect width-md waves-light rounded float-right" data-toggle="modal" data-target="#modalVisiMisi">Tambah Visi & Misi</button>
                            <br><br><br>
                        @endif
                    </div>
                    <table id="tableVisiMisi" class="table table-bordered dt-responsive nowrap table-striped" width="100%">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th class="align-middle" style="max-width: 5%;">No</th>
                                <th class="align-middle">Visi</th>
                                <th class="align-middle">Misi</th>
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
    <div class="modal fade" id="modalVisiMisi" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalVisiMisiTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalPemasukanTitle">Form Visi & Misi</h4>
                    <button type="button" id="cancel" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formVisiMisi" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="visi">Visi</label>
                            <input type="hidden" name="id" id="id">
                            <textarea name="visi" id="visi" class="form-control" cols="30" rows="5" required placeholder="Masukkan Visi"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="misi">Misi</label>
                            <textarea name="misi" id="misi" class="form-control" cols="30" rows="5" required placeholder="Masukkan Misi"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="cancel" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" id="saveVisiMisi" class="btn btn-success">Simpan</button>
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
            $('#formVisiMisi')[0].reset();
            $('#modalVisiMisiTitle').text('Form Visi & Misi');
            $('#id').val('');
            $('#visi').text('');
            $('#misi').text('');
        }

        const tableVisiMisi = (query = '') => {
            $('#tableVisiMisi').DataTable({
                processing: true,
                info: true,
                responsive: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('visi_misi.table') }}",
                    method: 'GET',
                    data: {
                        query: query,
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                    { data: 'visi',
                        render: function ( data, type, row ) {
                            return '<span style="text-wrap: wrap;">' + data + "</span>";
                        }
                    },
                    { data: 'misi',
                        render: function ( data, type, row ) {
                            return '<span style="text-wrap: wrap;">' + data + "</span>";
                        }
                    },
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
            tableVisiMisi();
        });
        // =================== end initialization ===================

        // =================== actions ===================
        $(document).on('click', '#cancel', function() {
            resetForm();
        });

        $("#formVisiMisi").submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('visi_misi.storeOrUpdate') }}",
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
                            $('#tableVisiMisi').DataTable().ajax.reload(null, false);
                            $('#modalVisiMisi').modal('hide');
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
                url: `/admin/visi-misi/edit/${id}`,
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
                        $('#visi').val(response.data.visi);
                        $('#misi').val(response.data.misi);

                        $('#modalVisiMisiTitle').text('Form Edit Visi & Misi');
                        $('#modalVisiMisi').modal('show');
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

        $(document).on('click', '#delete', function() {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Konfirmasi!',
                text: 'Yakin ingin menghapus data visi misi?',
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus data!',
            }).then((result) => {
                if(result.value) {
                    $.ajax({
                        url: "{{ route('visi_misi.hapus') }}",
                        method: "POST",
                        data: {
                            id: id,
                        },
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
                            Swal.fire({
                                title: (response.code == 200) ? 'Berhasil!' : 'Gagal!',
                                text: response.message,
                                type: response.status,
                                confirmButtonText: 'Oke',
                            });
                            $('.add').html(`
                                <button type="button" class="btn btn-success waves-effect width-md waves-light rounded float-right" data-toggle="modal" data-target="#modalVisiMisi">Tambah Visi & Misi</button>
                                <br><br><br>
                            `);
                            $('#tableVisiMisi').DataTable().ajax.reload(null, false);
                        }
                    });
                }
            });
        });
        // =================== end actions ===================
    </script>
@endsection