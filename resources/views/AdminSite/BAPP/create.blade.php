@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Tambah Akun</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('bapp.store') }}">
                @csrf
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">No Work Permit</label>
                            <select name="no_work_permit" class="form-control" id="select-permit">
                                <option selected disabled value="">-- Select Work Permit ---</option>
                                @foreach ($wps as $wp)
                                    <option {{ isset($id_wp) ? ($id_wp == $wp->id ? 'selected' : '') : '' }} value="{{ $wp->id }}">{{ $wp->no_work_permit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Tanggal Penyelesaian</label>
                            <input type="date" class="form-control" name="tanggal_penyelesaian">
                        </div>
                    </div>
                </div>

                <div id="detail_bapp">
                    <h5 class="mt-5">Biaya perbaikan kerusakan</h5>
                    <hr>
                    <div class="mb-3">
                        <div class="card mt-2" id="detail_work_order">
                            <div class="card-body">
                                <div class="card-body p-0">
                                    <div class="row gx-card mx-0 bg-200 text-900 fs--1 fw-semi-bold">
                                        <div class="col-9 col-md-8 py-2">Detil perbaikan kerusakan</div>
                                    </div>
                                    <div id="detailBAPP">

                                    </div>
                                    <input type="hidden" name="detail_bapp" id="value_detail_bapp">
                                    <div class="row gx-card mx-0 border-bottom border-200 align-middle">
                                        <div class="col-6 py-3">
                                            <label for="label-form">Kerusakan</label>
                                            <input class="form-control" type="text" id="input_detil_bapp">
                                        </div>
                                        <div class="col-4 py-3">
                                            <label for="label-form">Notes</label>
                                            <textarea name="catatan" class="form-control" id="input_catatan_bapp" cols="40" rows="5"></textarea>
                                        </div>
                                        <div class="col-2 mt-5">
                                            <button type="button" class="btn btn-primary mt-3" id="btnAddDetailBAPP"
                                                onclick="addDetailBAPP()">Tambah</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h5 class="mt-5">Informasi Deposit</h5>
                <hr>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Jumlah deposit</label>
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text">Rp</span>
                                <input class="form-control" id="show_jumlah_deposit" type="string" name="jumlah_deposit"
                                    readonly />
                                <input type="hidden" id="jumlah_deposit">
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Jumlah Potongan</label>
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">Rp</span>
                                <input class="form-control" id="show_jumlah_potongan" type="string" />
                                <input type="hidden" name="jumlah_potongan" id="jumlah_potongan">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Jumlah kembali deposit</label>
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">Rp</span>
                                <input class="form-control" readonly type="string" id="show_jumlah_kembali_deposit" />
                                <input type="hidden" name="jumlah_kembali_deposit" id="jumlah_kembali_deposit">
                            </div>
                        </div>
                    </div>
                </div>
                <h5 class="mt-5">Informasi BANK</h5>
                <hr>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">BANK pemohon</label>
                            <input type="text" class="form-control" name="bank_pemohon">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Nama rekening pemohon</label>
                            <input type="text" class="form-control" name="nama_rek_pemohon">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">No rekening pemohon</label>
                            <input type="text" class="form-control" name="rek_pemohon">
                        </div>
                    </div>
                </div>
                <h5 class="mt-5">Keterangan</h5>
                <hr>
                <div class="mb-3">
                    <textarea type="text" class="form-control" name="keterangan"></textarea>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <script>
        $('#email').select2({
            theme: 'bootstrap-5'
        });

        $('document').ready(function() {
            var id = '{{ isset($id_wp) }}';
            if (id) {
                id = '{{ $id_wp }}'
                console.log(id);
                showPermit(id)
            }

            $('#select-permit').on('change', function() {
                id = $(this).val()

                console.log(id);
                showPermit(id);
            })
        })

        function showPermit(id) {
            $.ajax({
                url: `/admin/work-permit/show/${id}`,
                type: 'GET',
                success: function(resp) {
                    $('#jumlah_deposit').val(resp.wp.jumlah_deposit)

                    var jumlah_deposit = resp.wp.jumlah_deposit.toString();
                    jumlah_deposit = jumlah_deposit.slice(0, -3);
                    $('#show_jumlah_deposit').val(formatRupiah(jumlah_deposit))
                }
            })
        }

        var detail_bapp = []

        $('#show_jumlah_potongan').keyup(function() {
            var jumlah_deposit = $('#jumlah_deposit').val();
            var value = $(this).val();

            let potongan = $('#jumlah_potongan');
            potongan.val(value);

            let showPotongan = $('#show_jumlah_potongan');
            showPotongan.val(formatRupiah(value.toString()));

            var newValue = value.replace(".", "")

            let kembaliDeposit = jumlah_deposit - newValue

            $('#jumlah_kembali_deposit').val(kembaliDeposit);
            $('#show_jumlah_kembali_deposit').val(formatRupiah(kembaliDeposit.toString()));

            let newJumlahDeposit = jumlah_deposit.replace(".00", "");


            $('#jumlah_deposit').val(newJumlahDeposit)
            $('#jumlah_potongan').val(newValue)
        })

        function addDetailBAPP() {
            var value = $('#input_detil_bapp').val();
            var catatan = $('#input_catatan_bapp').val();

            var object = {
                'name': value,
                'catatan': catatan
            }

            detail_bapp.push(object);

            $('#detailBAPP').append(`
                <div class="row gx-card mx-0 border-bottom border-200">
                    <div class="col-9 py-3">
                        <input class="form-control" type="text" value="${value}">
                    </div>
                    <div class="col-3 py-3">
                        <textarea name="catatan" class="form-control" id="" cols="40" rows="5">${catatan}</textarea>
                    </div>
                </div>
            `)

            $('#input_detil_bapp').val("");
            $('#input_catatan_bapp').val("");
            $('#value_detail_bapp').val(JSON.stringify(detail_bapp));
        }
    </script>
@endsection
