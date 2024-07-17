@extends('templates.main')
@section('title')
    Berita
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
    {{-- dropify --}}
    <link rel="stylesheet" href="{{ asset('assets/libs/dropify/dropify.min.css') }}">

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
                        <h2 class="text-white">Tabel Berita</h2>
                    </div>
                    <button type="button" class="btn btn-success waves-effect width-md waves-light rounded float-right" data-toggle="modal" data-target="#modalBerita">Tambah Berita</button>
                    <br><br><br>
                    <table id="tableBerita" class="table table-bordered dt-responsive nowrap table-striped" width="100%">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th class="align-middle" style="max-width: 5%;">No</th>
                                <th class="align-middle">Judul</th>
                                <th class="align-middle">Deskripsi</th>
                                <th class="align-middle">Tanggal</th>
                                <th class="align-middle">Link</th>
                                <th class="align-middle">Gambar</th>
                                <th class="align-middle">Status</th>
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
    <div class="modal fade" id="modalBerita" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalBeritaTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalBeritaTitle">Form Berita</h4>
                    <button type="button" id="cancel" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formBerita" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="judul">Judul</label>
                            <input type="hidden" name="id" id="id">
                            <input type="text" name="judul" id="judul" class="form-control" required placeholder="Masukkan Judul">
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" cols="30" rows="5" required placeholder="Masukkan Deskripsi"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="link">Link</label>
                            <input type="text" name="link" id="link" class="form-control" placeholder="Masukkan link berita" required>
                        </div>
                        <div class="form-group">
                            <label for="gambar">Gambar</label>
                            <input type="file" name="gambar" id="gambar" class="form-control dropify" data-allowed-file-extensions="jpg png jpeg" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="cancel" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" id="saveBerita" class="btn btn-success">Simpan</button>
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
    {{-- dropify --}}
    <script src="{{ asset('assets/libs/dropify/dropify.min.js') }}"></script>

    <script>
        // =================== methods ===================
        const resetForm = () => {
            $('#formBerita')[0].reset();
            $('#modalBeritaTitle').text('Form Berita');
            $('#id').val('');
            $('#judul').text('');
            $('#deskripsi').text('');
            $('#gambar').val('').trigger('change');
        }

        const tableBerita = (query = '') => {
            $('#tableBerita').DataTable({
                processing: true,
                info: true,
                responsive: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('berita.table') }}",
                    method: 'GET',
                    data: {
                        query: query,
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                    { data: 'judul',
                        render: function ( data, type, row ) {
                            return '<span style="text-wrap: wrap;">' + data + "</span>";
                        }
                    },
                    { data: 'deskripsi',
                        render: function ( data, type, row ) {
                            return '<span style="text-wrap: wrap;">' + data + "</span>";
                        }
                    },
                    { data: 'tanggal', name: 'tanggal' },
                    { data: 'link', name: 'link' },
                    { data: 'gambar', name: 'gambar' },
                    { data: 'status', name: 'status' },
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
            tableBerita();

            $('.dropify').dropify({
                messages: { default: "Drag and drop a file here or click", replace: 'Drag and drop or click to replace', remove: 'Remove', error: 'Ooops, something wrong happended.' }
            });
        });
        // =================== end initialization ===================

        // =================== actions ===================
        $(document).on('click', '#cancel', function() {
            resetForm();
        });

        $("#formBerita").submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('berita.storeOrUpdate') }}",
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
                            $('#tableBerita').DataTable().ajax.reload(null, false);
                            $('#modalBerita').modal('hide');
                            resetForm();
                        }
                    }
                }
            });
        });

        $(document).on('click', '#edit', function() {
            const id = $(this).data('id');
            $.ajax({
                url: `/admin/berita/edit/${id}`,
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
                        $('#judul').val(response.data.judul);
                        $('#deskripsi').val(response.data.deskripsi);
                        $('#tanggal').val(response.data.tanggal);
                        $('#link').val(response.data.link);
                        var lokasi_foto = "{{ asset('storage/berita/') }}"+'/'+response.data.gambar;
                        var dropify = $("#gambar").dropify({ messages: { default: "Drag and drop a your profile picture here or click", replace: "Drag and drop or click to replace", remove: "Remove", error: "Ooops, something wrong appended." }, error: { fileSize: "Ukuran foto terlalu besar (Maksimal 5MB)" }, });
                        dropify = dropify.data('dropify');
                        dropify.resetPreview();
                        dropify.clearElement();
                        dropify.settings['defaultFile'] = lokasi_foto;
                        dropify.destroy();
                        dropify.init();


                        $('#modalBeritaTitle').text('Form Edit Berita');
                        $('#modalBerita').modal('show');
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

        $(document).on('click', '#hapus', function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            Swal.fire({
                title: 'Konfirmasi!',
                html: '<p>Yakin ingin menghapus berita?</p>' +
                    '<p><b>'+nama+'</b></p>',
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus data!',
            }).then((result) => {
                if(result.value) {
                    $.ajax({
                        url: "{{ route('berita.hapus') }}",
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
                            $('#tableBerita').DataTable().ajax.reload(null, false);
                        }
                    });
                }
            });
        });

        $(document).on('click', '#status_aktif', function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            const status = $(this).data('status');
            Swal.fire({
                title: 'Konfirmasi!',
                html: '<p>Yakin ingin '+status+' berita?</p>' +
                    '<p><b>'+nama+'</b></p>',
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, '+status+'!',
            }).then((result) => {
                if(result.value) {
                    $.ajax({
                        url: "{{ route('berita.ubah_status') }}",
                        method: "POST",
                        data: {
                            id: id,
                            status: status,
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
                            $('#tableBerita').DataTable().ajax.reload(null, false);
                        }
                    });
                }
            });
        });
        // =================== end actions ===================
    </script>
@endsection