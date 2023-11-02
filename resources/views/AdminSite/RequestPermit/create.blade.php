@extends('layouts.master')

@section('css')
    <script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    @if ($tiket)
        @php
            $rp = json_decode($tiket->RequestPermit->RPDetail->data);
            $data = json_decode($rp);

            foreach ($data->personels as $personel) {
                // dd($personel);
            }
        @endphp
    @endif

    <div class="row g-3">
        <div class="col-9">
            <div class="card">
                <div class="card-header d-flex flex-between-center">
                    <button class="btn btn-falcon-default btn-sm" type="button">
                        <span class="fas fa-arrow-left"></span>
                    </button>
                </div>
            </div>
            <div class="card mt-3" style="display: none" id="ticket_detail">
                <div class="card-body">
                    <div class="request" id="ticket_head">

                    </div>
                    <div class="pt-4">
                        <h6 class="mb-3 fw-semi-bold text-1000" id="ticket_detail_heading"></h6>
                        <div id="ticket_detail_desc">

                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3" style="display: none" id="permit_detail">
                <div class="card-header">
                    <h6 class="mb-0">Detail Request Permit</h6>
                </div>
                <div class="px-5">
                    <div class="my-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Nama Kontraktor</label>
                                <input type="text" class="form-control" id="nama_kontraktor" readonly>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Penanggung Jawab</label>
                                <input type="text" class="form-control" id="pic" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 p-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" cols="20" rows="5" readonly></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">No KTP</label>
                                <input type="text" class="form-control" id="no_ktp" maxlength="16" readonly>
                            </div>
                            <div class="col-6">
                                <label class="form-label">No Telp</label>
                                <input type="text" class="form-control" id="no_telp" maxlength="13" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="mb-1">Mulai Pengerjaan</label>
                                <input class="form-control" id="tanggal_mulai" type="text" readonly />
                            </div>
                            <div class="col-6">
                                <label class="mb-1">Tanggal Akhir Pengerjaan</label>
                                <input class="form-control" id="tanggal_akhir" type="text" readonly />
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan Pekerjaan</label>
                        <textarea class="form-control" id="keterangan_pekerjaan" cols="20" rows="5" readonly></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Paid Permit</label>
                                <select name="" class="form-control" id="" disabled>
                                    <option value="Yes">Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="ticket_permit" class="mt-3">
                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="card-body p-0">
                                <div class="row gx-card mx-0 bg-200 text-900 fs--1 fw-semi-bold">
                                    <div class="col-9 col-md-8 py-2">Personil</div>
                                </div>
                                @if ($tiket)
                                    @foreach ($data->personels as $personel)
                                        <div class='row gx-card mx-0 align-items-center border-bottom border-200'>
                                            <div class='col-8 py-3'>
                                                <div class='d-flex align-items-center'>
                                                    <div class='flex-1'>
                                                        <h5 class='fs-0'>
                                                            <h5 class='fs-0'>
                                                                <span class='text-900' href=''>
                                                                    {{ $personel->nama_personil }}
                                                                </span>
                                                            </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div id="detailPersonels">

                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="card-body p-0">
                                <div class="row gx-card mx-0 bg-200 text-900 fs--1 fw-semi-bold">
                                    <div class="col-9 col-md-8 py-2">Nama Alat</div>
                                </div>
                                @if ($tiket)
                                    @foreach ($data->alats as $alat)
                                        <div class='row gx-card mx-0 align-items-center border-bottom border-200'>
                                            <div class='col-8 py-3'>
                                                <div class='d-flex align-items-center'>
                                                    <div class='flex-1'>
                                                        <h5 class='fs-0'>
                                                            <h5 class='fs-0'>
                                                                <span class='text-900' href=''>
                                                                    {{ $alat->nama_alat }}
                                                                </span>
                                                            </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div id="detailAlats">

                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="card-body p-0">
                                <div class="row gx-card mx-0 bg-200 text-900 fs--1 fw-semi-bold">
                                    <div class="col-9 col-md-8 py-2">Material</div>
                                </div>
                                @if ($tiket)
                                    @foreach ($data->materials as $material)
                                        <div class='row gx-card mx-0 align-items-center border-bottom border-200'>
                                            <div class='col-8 py-3'>
                                                <div class='d-flex align-items-center'>
                                                    <div class='flex-1'>
                                                        <h5 class='fs-0'>
                                                            <h5 class='fs-0'>
                                                                <span class='text-900' href=''>
                                                                    {{ $material->material }}
                                                                </span>
                                                            </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div id="detailMaterials">

                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Properties</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4 mt-n2"><label class="mb-1">Request</label>
                        <select name="no_tiket" class="form-select form-select-sm" id="select_ticket">
                            <option disabled selected>-- Select request ---</option>
                            @foreach ($tickets as $ticket)
                                <option {{ isset($id_tiket) ? ($id_tiket == $ticket->id ? 'selected' : '') : '' }}
                                    value="{{ $ticket->id }}">{{ $ticket->no_tiket }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 mt-n2"><label class="mb-1">Jenis Pekerjaan</label>
                        <select name="id_jenis_pekerjaan" class="form-select form-select-sm" id="id_jenis_pekerjaan">
                            <option disabled selected>--Pilih Jenis Pekerjaan ---</option>
                            @foreach ($jenis_pekerjaan as $item)
                                <option
                                    {{ $tiket ? ($ticket->RequestPermit->id_jenis_pekerjaan == $item->id_jenis_pekerjaan ? 'selected' : '') : '' }}
                                    value="{{ $item->id_jenis_pekerjaan }}" disabled>
                                    {{ $item->jenis_pekerjaan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="mb-1">Supervisi</label>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text">Rp</span>
                            <input style="text-align: right" type="text" class="form-control"
                                id="show_jumlah_supervisi" />
                            <input type="hidden" id="jumlah_supervisi" name="jumlah_supervisi" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="mb-1">Deposit</label>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text">Rp</span>
                            <input style="text-align: right" class="form-control" id="show_jumlah_deposit" />
                            <input type="hidden" id="jumlah_deposit" name="jumlah_deposit" />
                        </div>
                    </div>
                    <div class="mb-4 mt-n2"><label class="mb-1">Work Relation</label>
                        @if (isset($request_permit->WorkPermit))
                            <select name="id_work_relation" class="form-select form-select-sm" id="id_work_relation" disabled>
                                @foreach ($work_relations as $work_relation)
                                    <option {{ $request_permit->WorkPermit->id_work_relation == $work_relation->id_work_relation ? 'selected' : '' }} value="{{ $work_relation->id_work_relation }}">
                                        {{ $work_relation->work_relation }}</option>
                                @endforeach
                            </select>
                        @else
                            <select name="id_work_relation" class="form-select form-select-sm" id="id_work_relation">
                                <option disabled selected value="">--Pilih Work Relation ---</option>
                                @foreach ($work_relations as $work_relation)
                                    <option value="{{ $work_relation->id_work_relation }}">
                                        {{ $work_relation->work_relation }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer border-top border-200 py-x1">
                <button type="button" class="btn btn-primary w-100" onclick="submitWorkPermit()">Submit</button>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <script>
        $('#show_jumlah_supervisi').keyup(function() {
            var value = $(this).val();
            var jumlah_supervisi = $('#jumlah_supervisi');

            var newJumlahSupervisi = value.replace(".", "")
            $('#jumlah_supervisi').val(newJumlahSupervisi);

            $(this).val(formatRupiah(value.toString()));
        })

        $('#show_jumlah_deposit').keyup(function() {
            var value = $(this).val();
            var jumlah_deposit = $('#jumlah_deposit');

            var newJumlahDeposit = value.replace(".", "")
            $('#jumlah_deposit').val(newJumlahDeposit);

            $(this).val(formatRupiah(value.toString()));
        })
    </script>

    <script>
        var personels = [];
        var idPersonel = 0;
        var alats = [];
        var idAlat = 0;
        var materials = [];
        var idMaterial = 0;

        var id = '{{ isset($id_tiket) }}';
        if (id) {
            id = '{{ $id_tiket }}'
            showTicket(id)
        }

        function submitWorkPermit() {
            tinyMCE.triggerSave();

            var no_tiket = $('#select_ticket').val();
            var jumlah_supervisi = $('#jumlah_supervisi').val();
            var jumlah_deposit = $('#jumlah_deposit').val();
            var id_work_relation = $('#id_work_relation').val();

            if (!no_tiket || !jumlah_supervisi || !jumlah_deposit || !id_work_relation) {
                Swal.fire(
                    'Fail!',
                    'Please fill all field',
                    'error'
                )
            } else {
                $.ajax({
                    url: '/admin/work-permits',
                    type: 'POST',
                    data: {
                        no_tiket,
                        jumlah_supervisi,
                        jumlah_deposit,
                        id_work_relation
                    },
                    success: function(data) {
                        if (data.status === 'ok') {
                            Swal.fire(
                                'Success!',
                                'Success approve Request Permit!',
                                'success'
                            ).then(() => window.location.replace('/admin/work-permits'))
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Fail approve Request Permit!',
                                'failed'
                            )
                        }
                    }
                })
            }
        }

        $('document').ready(function() {
            $('#select_ticket').select2({
                theme: 'bootstrap-5'
            });

            $('#select_ticket').on('change', function() {
                var id = $(this).val()
                showTicket(id);
            })

            function timeDifference(current, previous) {
                var msPerMinute = 60 * 1000;
                var msPerHour = msPerMinute * 60;
                var msPerDay = msPerHour * 24;
                var msPerMonth = msPerDay * 30;
                var msPerYear = msPerDay * 365;

                var elapsed = current - previous;

                if (elapsed < msPerMinute) {
                    return Math.round(elapsed / 1000) + ' seconds ago';
                } else if (elapsed < msPerHour) {
                    return Math.round(elapsed / msPerMinute) + ' minutes ago';
                } else if (elapsed < msPerDay) {
                    return Math.round(elapsed / msPerHour) + ' hours ago';
                } else if (elapsed < msPerMonth) {
                    return Math.round(elapsed / msPerDay) + ' days ago';
                } else if (elapsed < msPerYear) {
                    return Math.round(elapsed / msPerMonth) + ' months ago';
                } else {
                    return Math.round(elapsed / msPerYear) + ' years ago';
                }
            }
        })

        function showTicket(id) {
            $.ajax({
                url: '/admin/open-ticket-rp/' + id,
                data: {
                    'data_type': 'json'
                },
                type: 'GET',
                success: function(data) {
                    var rp = data.data.request_permit;
                    var descRp = rp.keterangan_pekerjaan
                    var rpDetail = rp.r_p_detail.data;

                    var dataDetail = JSON.parse(rpDetail);
                    personelsData = JSON.parse(dataDetail);
                    alatsData = JSON.parse(dataDetail);
                    materialsData = JSON.parse(dataDetail);

                    personels = personelsData.personels;
                    alats = alatsData.alats;
                    materials = materialsData.materials;

                    $('#detailPersonels').html("")
                    $('#detailAlats').html("")
                    $('#detailMaterials').html("")

                    detailPersonels();
                    detailAlats();
                    detailMaterials();

                    $('#nama_kontraktor').val(rp.nama_kontraktor);
                    $('#pic').val(rp.pic);
                    $('#alamat').val(rp.alamat);
                    $('#no_ktp').val(rp.no_ktp);
                    $('#no_telp').val(rp.no_telp);
                    $('#keterangan_pekerjaan').val(rp.keterangan_pekerjaan);
                    $('#id_jenis_pekerjaan').val(rp.id_jenis_pekerjaan);
                    $('#id_jenis_pekerjaan').attr("disabled", true);
                    $('#tanggal_mulai').val(rp.tgl_mulai);
                    $('#tanggal_akhir').val(rp.tgl_akhir);

                    $('#ticket_detail').css('display', 'block')
                    $('#permit_detail').css('display', 'block')
                    if (descRp) {
                        $('#ticket_detail_desc').html(descRp);
                    } else {
                        $('#ticket_detail_desc').html(data.data.deskripsi_request);
                    }
                    $('#ticket_detail_heading').html(data.data.judul_request)
                    $('#ticket_head').html(`
                            <div class="d-md-flex d-xl-inline-block d-xxl-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar avatar-2xl">
                                        <img class="rounded-circle" src="${data.data.tenant.profile_picture}" alt="${data.data.tenant.profile_picture}" />
                                    </div>
                                    <p class="mb-0"><a class="fw-semi-bold mb-0 text-800"
                                            href="#">${data.data.tenant.nama_tenant}</a>
                                        <a class="mb-0 fs--1 d-block text-500"
                                            href="mailto:${data.data.tenant.email_tenant}">${data.data.tenant.email_tenant}</a>
                                    </p>
                                </div>
                                <p class="mb-0 fs--2 fs-sm--1 fw-semi-bold mt-2 mt-md-0 mt-xl-2 mt-xxl-0 ms-5">
                                    ${new Date(data.data.created_at).toDateString()}
                                    <span class="mx-1">|</span><span class="fst-italic">${new Date(data.data.created_at).toLocaleTimeString()} (${timeDifference(new Date(), new Date(data.data.created_at))})</span></p>
                            </div>
                        `)
                }
            })
        }

        function detailPersonels() {
            $('#detailPersonels').html('');
            personels.map((item, i) => {
                $('#detailPersonels').append(
                    `<div class='row gx-card mx-0 align-items-center border-bottom border-200'>
                    <div class='col-8 py-3'>
                        <div class='d-flex align-items-center'>
                            <div class='flex-1'>
                                <h5 class='fs-0'>
                                    <span class='text-900' href=''>
                                        ${item.nama_personil}
                                    </span>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>`
                )
            })
        }

        function detailAlats() {
            $('#detailAlats').html('');
            alats.map((item, i) => {
                $('#detailAlats').append(
                    `<div class='row gx-card mx-0 align-items-center border-bottom border-200'>
                    <div class='col-8 py-3'>
                        <div class='d-flex align-items-center'>
                            <div class='flex-1'><h5 class='fs-0'>
                                <h5 class='fs-0'>
                                    <span class='text-900' href=''>
                                        ${item.nama_alat}
                                    </span>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>`
                )
            })
        }

        function detailMaterials() {
            $('#detailMaterials').html('');
            materials.map((item, i) => {
                $('#detailMaterials').append(
                    `<div class='row gx-card mx-0 align-items-center border-bottom border-200'>
                    <div class='col-8 py-3'>
                        <div class='d-flex align-items-center'>
                            <div class='flex-1'><h5 class='fs-0'>
                                <h5 class='fs-0'>
                                    <span class='text-900' href=''>
                                        ${item.material}
                                    </span>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>`
                )
            })
        }
    </script>
@endsection
