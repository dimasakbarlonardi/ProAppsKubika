@extends('layouts.master')

@section('css')
    <script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection

@section('content')
    <div class="row">
        <div class="col-9">
            <div class="card" id="rp_detail">
                <div class="card-header d-flex flex-between-center">
                    <button class="btn btn-falcon-default btn-sm" type="button">
                        <span class="fas fa-arrow-left"></span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="card" id="permit_detail">
                        <div class="card-header">
                            <h6 class="mb-0">Detail Request Permit</h6>
                        </div>
                        <div class="px-5">
                            <div class="my-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label">Nama Kontraktor</label>
                                        <input type="text" value="{{ $wp->RequestPermit->nama_kontraktor }}"
                                            class="form-control" id="nama_kontraktor" disabled>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Penanggung Jawab</label>
                                        <input type="text" value="{{ $wp->RequestPermit->pic }}" class="form-control"
                                            id="pic" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" cols="20" rows="5" disabled>{!! $wp->RequestPermit->alamat !!}</textarea>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label">No KTP</label>
                                        <input type="text" value="{{ $wp->RequestPermit->no_ktp }}" class="form-control"
                                            id="no_ktp" disabled>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">No Telp</label>
                                        <input type="text" value="{{ $wp->RequestPermit->no_telp }}" class="form-control"
                                            id="no_telp" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="mb-1">Mulai Pengerjaan</label>
                                        <input class="form-control" value="{{ $wp->RequestPermit->tgl_mulai }}"
                                            id="tgl_mulai" disabled />
                                    </div>
                                    <div class="col-6">
                                        <label class="mb-1">Tanggal Akhir Pengerjaan</label>
                                        <input class="form-control" value="{{ $wp->RequestPermit->tgl_akhir }}"
                                            id="tgl_akhir" disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan Pekerjaan</label>
                                <textarea class="form-control" id="keterangan_pekerjaan" cols="20" rows="5" disabled>{{ $wp->RequestPermit->keterangan_pekerjaan }}</textarea>
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
                                            @foreach ($personels as $personel)
                                                <input class="form-control my-3" type="text"
                                                    value="{{ $personel->nama_personil }}" disabled>
                                            @endforeach
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
                                            @foreach ($alats as $alat)
                                                <input class="form-control my-3" type="text"
                                                    value="{{ $alat->nama_alat }}" disabled>
                                            @endforeach
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
                                            @foreach ($materials as $material)
                                                <input class="form-control my-3" type="text"
                                                    value="{{ $material->material }}" disabled>
                                            @endforeach
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
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Properties</h6>
                </div>
                <div class="card-body">
                    @csrf
                    <div class="mb-4 mt-n2"><label class="mb-1">Request</label>
                        <input class="form-control" type="text" value="{{ $wp->Ticket->no_tiket }}" disabled>
                    </div>
                    <div class="mb-4 mt-n2"><label class="mb-1">No Request Permit</label>
                        <input class="form-control" type="text" value="{{ $wp->RequestPermit->no_request_permit }}"
                            disabled>
                    </div>
                    <div class="mb-4 mt-n2"><label class="mb-1">Work Relation</label>
                        <select name="id_work_relation" class="form-select form-select-sm" required disabled>
                            <option disabled selected>--Pilih Work Relation ---</option>
                            @foreach ($work_relations as $work_relation)
                                <option {{ $wp->id_work_relation == $work_relation->id_work_relation ? 'selected' : '' }}
                                    value="{{ $work_relation->id_work_relation }}">
                                    {{ $work_relation->work_relation }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4 mt-n2"><label class="mb-1">Permit Berbayar</label>
                        <select name="id_bayarnon" class="form-select form-select-sm" required disabled>
                            <option {{ $wp->id_bayarnon == 1 ? 'selected' : '' }} value="1">Yes</option>
                            <option {{ $wp->id_bayarnon == 0 ? 'selected' : '' }} value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-4 mt-n2"><label class="mb-1">Jumlah Supervisi</label>
                        <input type="text" value="{{ Rupiah($wp->jumlah_supervisi) }}" class="form-control"
                            name="jumlah_deposit" required disabled>
                    </div>
                    <div class="mb-4 mt-n2"><label class="mb-1">Jumlah Deposit</label>
                        <input type="text" value="{{ Rupiah($wp->jumlah_deposit) }}" class="form-control"
                            name="jumlah_deposit" required disabled>
                    </div>
                </div>
            </div>
            @if ($wp->sign_approval_4 && $wp->status_request != 'COMPLETE' && Request::session()->get('work_relation_id') == 1)
                <div class="card-footer border-top border-200 py-x1">
                    <a href="{{ route('printWP', $wp->id) }}" target="_blank"
                        class="btn btn-warning w-100 mb-3">Print</a>
                </div>
            @endif
            @if (
                $wp->id_work_relation == $user->RoleH->WorkRelation->id_work_relation &&
                    $user->Karyawan->is_can_approve &&
                    $wp->sign_approval_1 &&
                    !$wp->sign_approval_2)
                <div class="card-footer border-top border-200 py-x1">
                    <button type="button" class="btn btn-primary w-100"
                        onclick="approve2({{ $wp->id }})">Approve</button>
                </div>
            @endif
            @if ($approve->approval_3 == $user->id_user && !$wp->sign_approval_3)
                <div class="card-footer border-top border-200 py-x1">
                    <button type="button" class="btn btn-primary w-100"
                        onclick="approve3({{ $wp->id }})">Approve</button>
                </div>
            @endif
            @if ($approve->approval_4 == $user->id_user && $wp->sign_approval_3 && !$wp->sign_approval_4)
                <div class="card-footer border-top border-200 py-x1">
                    <button type="button" class="btn btn-primary w-100"
                        onclick="approve4({{ $wp->id }})">Approve</button>
                </div>
            @endif
            @if (
                $wp->sign_approval_4 &&
                    $wp->status_request != 'WORK DONE' &&
                    $wp->status_request != 'DONE' &&
                    $wp->id_work_relation == Request::session()->get('work_relation_id'))
                <div class="card-footer border-top border-200 py-x1">
                    <a href="{{ route('printWP', $wp->id) }}" target="_blank"
                        class="btn btn-warning w-100 mb-3">Print</a>
                    <button type="button" class="btn btn-primary w-100"
                        onclick="workDoneWP({{ $wp->id }})">Pekerjaan Selesai</button>
                </div>
            @endif
            @if (!$wp->BAPP && $wp->id_work_relation == Request::session()->get('work_relation_id') && $wp->status_request == 'WORK DONE')
                <div class="card-footer border-top border-200 py-x1">
                    <a href="{{ route('bapp.create', ['id_wp' => $wp->id]) }}" target="_blank"
                        class="btn btn-info w-100 mb-3">Buat BAPP</a>
                </div>
            @endif
            @if ($approve->approval_3 == $user->id_user && $wp->status_request == 'WORK DONE')
                <div class="card-footer border-top border-200 py-x1">
                    <button type="button" class="btn btn-primary w-100" onclick="">Sudah
                        Transfer Depo</button>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <script>
        tinymce.init({
            selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'code table lists',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
        });
    </script>
    <script>
        function approve2(id) {
            $.ajax({
                url: `/admin/work-permit/approve2/${id}`,
                type: 'POST',
                success: function(data) {
                    if (data.status === 'ok') {
                        Swal.fire(
                            'Berhasil!',
                            'Berhasil mengupdate Work Order!',
                            'success'
                        ).then(() => window.location.reload())
                    }
                }
            })
        }

        function approve3(id) {
            $.ajax({
                url: `/admin/work-permit/approve3/${id}`,
                type: 'POST',
                success: function(data) {
                    if (data.status === 'ok') {
                        Swal.fire(
                            'Berhasil!',
                            'Berhasil mengupdate Work Order!',
                            'success'
                        ).then(() => window.location.reload())
                    }
                }
            })
        }

        function approve4(id) {
            $.ajax({
                url: `/admin/work-permit/approve4/${id}`,
                type: 'POST',
                success: function(data) {
                    if (data.status === 'ok') {
                        Swal.fire(
                            'Success!',
                            'Success approve Work Permit!',
                            'success'
                        ).then(() => window.location.reload())
                    }
                }
            })
        }

        function workDoneWP(id) {
            Swal.fire({
                title: 'Are you sure?',
                icon: 'info',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result['isConfirmed']) {
                    $.ajax({
                        url: `/admin/work-permit/workDoneWP/${id}`,
                        type: 'POST',
                        success: function(data) {
                            if (data.status === 'ok') {
                                Swal.fire(
                                    'Success!',
                                    'Success update Work Permit!',
                                    'success'
                                ).then(() => window.location.reload())
                            }
                        }
                    })
                }
            })
        }

        $('document').ready(function() {
            $('#select_ticket').select2({
                theme: 'bootstrap-5'
            });

            $('#select_ticket').on('change', function() {
                var id = $(this).val()
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
    </script>
@endsection
