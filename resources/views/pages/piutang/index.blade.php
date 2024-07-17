@extends('templates.main')
@section('title')
Piutang
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

    .select2-container .select2-selection--single,
    .select2-selection--single .select2-selection__arrow {
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
                    <h2 class="text-white">Tabel Piutang</h2>
                </div>
                <button type="button" class="btn btn-success waves-effect width-md waves-light rounded float-right"
                    data-toggle="modal" data-target="#modalPiutang">Tambah Piutang</button>
                <br><br><br>
                <table id="tablePiutang" class="table table-bordered dt-responsive nowrap table-striped"
                    width="100%">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th class="align-middle" style="max-width: 5%;">No</th>
                            <th class="align-middle">Tanggal</th>
                            <th class="align-middle">No Akun (D)</th>
                            <th class="align-middle">Nominal (D)</th>
                            <th class="align-middle">No Akun (K)</th>
                            <th class="align-middle">Nominal (K)</th>
                            <th class="align-middle">Keterangan</th>
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
<div class="modal fade" id="modalPiutang" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="modalPiutangTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalPiutangTitle">Form Piutang</h4>
                <button type="button" id="cancel" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formPiutang" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="jenis_transaksi">Jenis Transaksi</label>
                        <i class="fas fa-question-circle information-icon"
                            info="Kondisi piutang pada usaha, yang paling mendekati berdasarkan dengan keterangan yang telah disediakan."></i>
                        <input type="hidden" name="id" id="id">
                        <select name="jenis_transaksi" id="jenis_transaksi" class="form-control" required>
                            <option value="">-- Pilih Jenis Transaksi --</option>
                            <option value="411">Piutang Usaha</option>
                            <option value="422">Pendapatan Beban Angkut Penjualan Kredit</option>
                            <option value="112">Retur Penjualan Kredit</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tgl">Tanggal</label>
                        <i class="fas fa-question-circle information-icon" info="Tanggal terjadinya transaksi."></i>
                        <input type="date" class="form-control" id="tgl" name="tgl" required>
                    </div>
                    <div class="form-group">
                        <label for="nominalTransaksi">Nominal</label>
                        <i class="fas fa-question-circle information-icon"
                            info="Nominal (Rp) dari transaksi yang terjadi."></i>
                        <input type="hidden" id="nominal" name="nominal">
                        <input type="text" class="form-control" id="nominalTransaksi" oninput="formatCurrency(this)"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <i class="fas fa-question-circle information-icon"
                            info="Rincian keterangan dari transaksi."></i>
                        <textarea class="form-control" id="keterangan" name="keterangan"
                            placeholder="Masukkan rincian keterangan transaksi." required></textarea>
                    </div>
                    <div class="sl-potongan"></div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="checkPotongan">
                        <label class="form-check-label" for="checkPotongan">Potongan</label>
                        <i class="fas fa-question-circle information-icon"
                            info="Diisi ketika memperoleh potongan atas piutang."></i>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cancel" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" id="savePiutang" class="btn btn-success">Simpan</button>
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
        const formatCurrency = (input) => {
            let id = input.id.replace('Transaksi', '');
            let nominal = document.getElementById(id);
            let value = parseInt(input.value.replace(/[^\d]/g, ''));

            if (!value && value !== '0') {
                value = 0;
            }
            nominal.value = value;

            let formattedValue = "Rp " + new Intl.NumberFormat('id-ID').format(value);

            input.value = formattedValue;
        }
        const resetForm = () => {
            $('#formPiutang')[0].reset();
            $('#modalPiutangTitle').text('Form Piutang');
            $('#jenis_transaksi').val('').trigger('change');
            $('#keterangan').text('');
            // init currency format
            let inpNominal = document.getElementById('nominalTransaksi');
            formatCurrency(inpNominal);
            $('.sl-potongan').empty();
        }

        const tablePiutang = (query = '') => {
            $('#tablePiutang').DataTable({
                processing: true,
                info: true,
                responsive: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('piutang.table') }}",
                    method: 'GET',
                    data: {
                        query: query,
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                    { data: 'tgl', name: 'tgl' },
                    { data: 'nomor_akun_debit', name: 'nomor_akun_debit' },
                    { data: 'nominal_debit', name: 'nominal_debit' },
                    { data: 'nomor_akun_kredit', name: 'nomor_akun_kredit' },
                    { data: 'nominal_kredit', name: 'nominal_kredit' },
                    { data: 'keterangan', name: 'keterangan' },
                    { data: 'action', name: 'action' },
                ],
                columnDefs: [
                    {
                        render: function(data, type, full, meta) {
                            return `<div class='text-wrap'>`+data+`</div>`;
                        },
                        targets: [2, 4, 6]
                    },
                    { className: 'text-center', targets: [0, 1, 2, 4, 7] },
                    { className: 'text-right', targets: [3, 5] },
                    { className: 'align-middle', targets: [0, 7] }
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
            
            // init currency format
            let inpNominal = document.getElementById('nominalTransaksi');
            formatCurrency(inpNominal);

            // init table
            tablePiutang();

            // init select2
            $('#jenis_transaksi').select2();
        });
        // =================== end initialization ===================

        // =================== actions ===================
        $(document).on('click', '#cancel', function() {
            resetForm();
        });

        $(document).on('click', '.information-icon', function() {
            Swal.fire({
                title: 'Information',
                html: $(this).attr('info'),
                type: 'info',
                showConfirmButton: false,
                showCloseButton: true,
                allowOutsideClick: false,
            });
        });

        $(document).on('change', '#checkPotongan', function() {
            if($(this).is(':checked')) {
                $('.sl-potongan').append(`
                    <div class="form-group">
                        <label for="potonganTransaksi">Nominal Potongan</label>
                        <i class="fas fa-question-circle information-icon" info="Contoh:<br>Menjual barang dagang sejumlah Rp 100.000 secara kredit dan diberikan potongan Rp 20.000. Maka input di nominal adalah Rp 100.000 dan input di nominal potongan adalah Rp 20.000."></i>
                        <input type="hidden" id="potongan" name="potongan">
                        <input type="text" class="form-control" id="potonganTransaksi" oninput="formatCurrency(this)" required>
                    </div>
                `);

                let inpPotongan = document.getElementById('potonganTransaksi');
                formatCurrency(inpPotongan);
            } else {
                $('.sl-potongan').empty();
            }
        });

        $("#formPiutang").submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('piutang.createUpdate') }}",
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
                            $('#tablePiutang').DataTable().ajax.reload(null, false);
                            $('#modalPiutang').modal('hide');
                            resetForm();
                        }
                    }
                }
            });
        });

        $(document).on('click', '.btnEdit', function() {
            const id = $(this).attr('id');
            $.ajax({
                url: `/piutang/edit/${id}`,
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
                        $('#jenis_transaksi').val(response.data.nomor_akun_kredit).trigger('change');
                        $('#tgl').val(response.data.tgl);
                        $('#nominalTransaksi').val(response.data.nominal_kredit);
                        $('#keterangan').text(response.data.keterangan);
                        // formatting
                        let inpNominal = document.getElementById('nominalTransaksi');
                        formatCurrency(inpNominal);

                        if(response.data.potongan) {
                            $('.sl-potongan').append(`
                            <div class="form-group">
                                <label for="potonganTransaksi">Nominal Potongan</label>
                                <i class="fas fa-question-circle information-icon"
                                    info="Contoh:<br>Menjual barang dagang sejumlah Rp 100.000 secara kredit dan diberikan potongan Rp 20.000. Maka input di nominal adalah Rp 100.000 dan input di nominal potongan adalah Rp 20.000."></i>
                                <input type="hidden" id="potongan" name="potongan">
                                <input type="text" class="form-control" id="potonganTransaksi" oninput="formatCurrency(this)" required>
                            </div>
                            `);
                            $('#potonganTransaksi').val(response.data.potongan.nominal_debit);
                            let inpPotongan = document.getElementById('potonganTransaksi');
                            formatCurrency(inpPotongan);
                            $('#checkPotongan').prop('checked', true);
                        } else {
                            $('.sl-potongan').empty();
                        }

                        $('#modalPiutangTitle').text('Form Edit Piutang');
                        $('#modalPiutang').modal('show');
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

        $(document).on('click', '.btnDel', function() {
            const id = $(this).attr('id');
            Swal.fire({
                title: 'Konfirmasi!',
                text: 'Yakin ingin menghapus data piutang?',
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus data!',
            }).then((result) => {
                if(result.value) {
                    $.ajax({
                        url: "{{ route('piutang.destroy') }}",
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
                            $('#tablePiutang').DataTable().ajax.reload(null, false);
                        }
                    });
                }
            });
        });
        // =================== end actions ===================
</script>
@endsection