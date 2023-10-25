@extends('layouts.master')

@section('css')
<script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection

@section('content')
<div class="row g-3">
    <div class="col-9">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a href="{{ route('work-permits.index') }}" class="btn btn-falcon-default btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <div class="ml-3">Work Permit</div>
                </div>
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
        <div class="card mt-3" style="display: none" id="rp_detail">
            <div class="card-body">

                <div class="card mt-3" id="permit_detail">
                    <div class="card-header">
                        <h6 class="mb-0">Detail Request Permit</h6>
                    </div>
<<<<<<< HEAD
                    <div class="px-5">
                        <div class="my-3">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label">Nama Kontraktor</label>
                                    <input type="text" class="form-control" id="nama_kontraktor" disabled>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Penanggung Jawab</label>
                                    <input type="text" class="form-control" id="pic" disabled>
                                </div>
                            </div>
=======
                    <div class="card-body">
                        @csrf
                        <div class="mb-4 mt-n2"><label class="mb-1">Tickets</label>
                            <select name="id_rp" class="form-select form-select-sm" id="select_ticket">
                                <option disabled selected value="">--Pilih Request ---</option>
                                @foreach ($request_permits as $rp)
                                    <option {{ isset($id_rp) ? ($id_rp == $rp->id ? 'selected' : '') : '' }}
                                        value="{{ $rp->id }}">{{ $rp->no_request_permit }}</option>
                                @endforeach
                            </select>
>>>>>>> 121ce1783c6cc67a462a61f7a57989a5523bdd61
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" cols="20" rows="5" disabled></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label">No KTP</label>
                                    <input type="text" class="form-control" id="no_ktp" disabled>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">No Telp</label>
                                    <input type="text" class="form-control" id="no_telp" disabled>
                                </div>
                            </div>
                        </div>
<<<<<<< HEAD
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label class="mb-1">Mulai Pengerjaan</label>
                                    <input class="form-control" id="tgl_mulai" disabled />
                                </div>
                                <div class="col-6">
                                    <label class="mb-1">Tanggal Akhir Pengerjaan</label>
                                    <input class="form-control" id="tgl_akhir" disabled />
                                </div>
                            </div>
=======
                        <div class="mb-4 mt-n2"><label class="mb-1">Permit Berbayar</label>
                            <select name="id_bayarnon" id="id_bayarnon" class="form-select form-select-sm" required
                                disabled>
                                <option value="1" selected>Yes</option>
                                <option value="0">No</option>
                            </select>
>>>>>>> 121ce1783c6cc67a462a61f7a57989a5523bdd61
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan Pekerjaan</label>
                            <textarea class="form-control" id="keterangan_pekerjaan" cols="20" rows="5" disabled></textarea>
                        </div>
                    </div>
                    <div id="ticket_permit" class="mt-3">
                        <div class="card mt-2">
                            <div class="card-body">
                                <div class="card-body p-0">
                                    <div class="row gx-card mx-0 bg-200 text-900 fs--1 fw-semi-bold">
                                        <div class="col-9 col-md-8 py-2">Personil</div>
                                    </div>
                                    <div id="detailPersonels">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-2">
                            <div class="card-body">
                                <div class="card-body p-0">
                                    <div class="row gx-card mx-0 bg-200 text-900 fs--1 fw-semi-bold">
                                        <div class="col-9 col-md-8 py-2">Nama Alat</div>
                                    </div>
                                    <div id="detailItems">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-2">
                            <div class="card-body">
                                <div class="card-body p-0">
                                    <div class="row gx-card mx-0 bg-200 text-900 fs--1 fw-semi-bold">
                                        <div class="col-9 col-md-8 py-2">Material</div>
                                    </div>
                                    <div id="detailMaterials">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-3">
        <form action="{{ route('work-permits.store') }}" method="post" id="form-create-wp">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Properties</h6>
                </div>
                <div class="card-body">
                    @csrf
                    <div class="mb-4 mt-n2"><label class="mb-1">Tickets</label>
                        <select name="id_rp" class="form-select form-select-sm" id="select_ticket">
                            <option disabled selected value="">--Pilih Request ---</option>
                            @foreach ($request_permits as $rp)
                            <option value="{{ $rp->id }}">{{ $rp->no_request_permit }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4 mt-n2"><label class="mb-1">Nama Project</label>
                        <input type="text" class="form-control" name="nama_project" id="nama_project">
                    </div>
                    <div class="mb-4 mt-n2"><label class="mb-1">Work Relation</label>
                        <select name="id_work_relation" class="form-select form-select-sm" id="id_work_relation">
                            <option disabled selected value="">--Pilih Work Relation ---</option>
                            @foreach ($work_relations as $work_relation)
                            <option value="{{ $work_relation->id_work_relation }}">
                                {{ $work_relation->work_relation }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4 mt-n2"><label class="mb-1">Permit Berbayar</label>
                        <select name="id_bayarnon" id="id_bayarnon" class="form-select form-select-sm" required disabled>
                            <option value="1" selected>Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-4 mt-n2"><label class="mb-1">Jumlah Deposit</label>
                        <input type="text" class="form-control" name="jumlah_deposit" id="jumlah_deposit">
                    </div>
                </div>
            </div>
            <div class="card-footer border-top border-200 py-x1">
                <button type="button" onclick="onSubmit()" class="btn btn-primary w-100">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

<script>
    tinymce.init({
        selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
        plugins: 'code table lists',
        toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
    });
</script>
<script>
    function onSubmit() {
        var nama_project = $('#nama_project').val();
        var id_work_relation = $('#id_work_relation').val();
        var jumlah_deposit = $('#jumlah_deposit').val();
        var id_rp = $('#select_ticket').val();
        var id_bayarnon = $('#id_bayarnon').val();

<<<<<<< HEAD
        if (!nama_project || !id_work_relation || !jumlah_deposit || !select_ticket) {
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
                    nama_project,
                    id_work_relation,
                    jumlah_deposit,
                    id_rp,
                    id_bayarnon
                },
                success: function(data) {
                    if (data.status === 'ok') {
                        Swal.fire(
                            'Berhasil!',
                            'Berhasil membuat Request Permit!',
                            'success'
                        ).then(() => window.history.go(-1))
                    } else {
                        Swal.fire(
                            'Gagal!',
                            'Gagal membuat Request Permit!',
                            'failed'
                        )
=======
            if (!nama_project || !id_work_relation || !jumlah_deposit || !select_ticket) {
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
                        nama_project,
                        id_work_relation,
                        jumlah_deposit,
                        id_rp,
                        id_bayarnon
                    },
                    success: function(data) {
                        if (data.status === 'ok') {
                            Swal.fire(
                                'Berhasil!',
                                'Berhasil membuat Request Permit!',
                                'success'
                            ).then(() => window.location.href('/admin/work-permits'))
                        } else {
                            Swal.fire(
                                'Gagal!',
                                'Gagal membuat Request Permit!',
                                'failed'
                            )
                        }
>>>>>>> 121ce1783c6cc67a462a61f7a57989a5523bdd61
                    }
                }
            })
        }
    }


    $('document').ready(function() {
        $('#select_ticket').select2({
            theme: 'bootstrap-5'
        });

<<<<<<< HEAD
        $('#select_ticket').on('change', function() {
            var id = $(this).val()
=======
            var id = '{{ isset($id_rp) }}';
            if (id) {
                id = '{{ $id_rp }}'
                showPermit(id)
            }

            $('#select_ticket').on('change', function() {
                var id = $(this).val()
                showPermit(id);
            })
        })

        function showPermit(id) {
>>>>>>> 121ce1783c6cc67a462a61f7a57989a5523bdd61
            $.ajax({
                url: '/admin/work-permits/' + id,
                data: {
                    'data_type': 'json'
                },
                type: 'GET',
                success: function(resp) {
                    var rp = resp.data;
                    $('#ticket_detail').css('display', 'block')
                    $('#rp_detail').css('display', 'block')
                    $('#ticket_detail_desc').html(rp.ticket.deskripsi_request)
                    $('#ticket_detail_heading').html(rp.ticket.judul_request)
                    $('#nama_kontraktor').val(rp.nama_kontraktor)
                    $('#pic').val(rp.pic)
                    $('#alamat').val(rp.alamat)
                    $('#no_telp').val(rp.no_telp)
                    $('#no_ktp').val(rp.no_ktp)
                    $('#keterangan_pekerjaan').val(rp.keterangan_pekerjaan)
                    $('#tgl_mulai').val(new Date(rp.tgl_mulai).toDateString() + ' - ' +
                        new Date(rp.tgl_mulai).toLocaleTimeString())
                    $('#tgl_akhir').val(new Date(rp.tgl_akhir).toDateString() + ' - ' +
                        new Date(rp.tgl_akhir).toLocaleTimeString())
                    $('#no_ktp').val(rp.no_ktp)
                    $('#ticket_head').html(`
                            <div class="d-md-flex d-xl-inline-block d-xxl-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar avatar-2xl">
                                        <img class="rounded-circle" src="${rp.tenant.profile_picture}" alt="${rp.tenant.profile_picture}" />
                                    </div>
                                    <p class="mb-0"><a class="fw-semi-bold mb-0 text-800"
                                            href="#">${rp.tenant.nama_tenant}</a>
                                        <a class="mb-0 fs--1 d-block text-500"
                                            href="mailto:${rp.tenant.email_tenant}">${rp.tenant.email_tenant}</a>
                                    </p>
                                </div>
                                <p class="mb-0 fs--2 fs-sm--1 fw-semi-bold mt-2 mt-md-0 mt-xl-2 mt-xxl-0 ms-5">
                                    ${new Date(rp.ticket.created_at).toDateString()}
                                    <span class="mx-1">|</span><span class="fst-italic">${new Date(rp.ticket.created_at).toLocaleTimeString()} (${timeDifference(new Date(), new Date(rp.ticket.created_at))})</span></p>
                            </div>
                        `)
                    var data = JSON.parse(rp.rpdetail.data)
                    dataJSON = JSON.parse(data)
                    dataJSON.personels.map((item) => {
                        $('#detailPersonels').append(`
                                <input class="form-control my-3" type="text" value="${item.nama_personil}" disabled>
                            `)
                    })

                    dataJSON.alats.map((item) => {
                        $('#detailItems').append(`
                                <input class="form-control my-3" type="text" value="${item.nama_alat}" disabled>
                            `)
                    })
                    dataJSON.materials.map((item) => {
                        $('#detailMaterials').append(`
                                <input class="form-control my-3" type="text" value="${item.material}" disabled>
                            `)
                    })
                }
            })
<<<<<<< HEAD
        })
=======
        }
>>>>>>> 121ce1783c6cc67a462a61f7a57989a5523bdd61

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
<<<<<<< HEAD
    })
</script>
@endsection
=======
    </script>
@endsection
>>>>>>> 121ce1783c6cc67a462a61f7a57989a5523bdd61
