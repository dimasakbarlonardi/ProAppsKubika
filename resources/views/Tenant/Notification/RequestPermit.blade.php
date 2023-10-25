@extends('layouts.master')

@section('css')
    <script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <link href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md d-flex">
                    <div class="avatar avatar-2xl">
                        <img class="rounded-circle" src="../../assets/img/team/1.jpg" alt="" />
                    </div>
                    <div class="flex-1 ms-2">
                        <h5 class="mb-0 text-light">Women work wonders… on your marketing skills</h5><a
                            class="text-800 fs--1" href="#!"><span class="fw-semi-bold text-light">Emma
                                Watson</span>
                            <span class="ms-1 text-light">&lt;emma@watson.com&gt;</span>
                        </a>
                    </div>
                </div>
                <div class="col-md-auto ms-auto d-flex align-items-center ps-6 ps-md-3">
                    <small class="text-light">8:40 AM (9 hours
                        ago)</small><span class="fas fa-star text-warning fs--1 ms-2"></span>
                </div>
            </div>
        </div>
        <div class="card-body bg-light">
            <div class="row">
                <div class="col-8">
                    <div class="card" id="permit_detail">
                        <div class="card-header">
                            <h6 class="mb-0">Detail Request Permit</h6>
                        </div>
                        <div class="px-5">
                            <div class="my-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label">Nama Kontraktor</label>
                                        <input type="text" class="form-control" value="{{ $permit->nama_kontraktor }}"
                                            disabled>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Penanggung Jawab</label>
                                        <input type="text" class="form-control" value="{{ $permit->pic }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="mb-1">Mulai Pengerjaan</label>
                                        <input value="{{ HumanDateTime($permit->tgl_mulai) }}" type="text"
                                            class="form-control" disabled />
                                    </div>
                                    <div class="col-6">
                                        <label class="mb-1">Tanggal Akhir Pengerjaan</label>
                                        <input value="{{ HumanDateTime($permit->tgl_akhir) }}" type="text"
                                            class="form-control" disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan Pekerjaan</label>
                                <textarea class="form-control" id="keterangan_pekerjaan" cols="20" rows="5" disabled>{{ $permit->keterangan_pekerjaan }}</textarea>
                            </div>
                        </div>
                        <div id="ticket_permit" class="mt-3">
                            <div class="card mt-2">
                                <div class="card-body">
                                    <div class="card-body p-0">
                                        <div class="row gx-card mx-0 bg-200 text-900 fs--1 fw-semi-bold">
                                            <div class="col-9 col-md-8 py-2">Personil</div>
                                        </div>
                                        @if ($personels)
                                            @foreach ($personels as $personel)
                                                <div class="gx-card mx-0 border-bottom border-200">
                                                    <div
                                                        class='row gx-card mx-0 align-items-center border-bottom border-200'>
                                                        <div class='py-3'>
                                                            <div class='d-flex align-items-center'>
                                                                <div class='flex-1'>
                                                                    <h5 class='fs-0'>
                                                                        <span class='text-900' href=''>
                                                                            {{ $personel->nama_personil }}
                                                                        </span>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
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
                                        @if ($alats)
                                            @foreach ($alats as $alat)
                                                <div class="gx-card mx-0 border-bottom border-200">
                                                    <div
                                                        class='row gx-card mx-0 align-items-center border-bottom border-200'>
                                                        <div class='py-3'>
                                                            <div class='d-flex align-items-center'>
                                                                <div class='flex-1'>
                                                                    <h5 class='fs-0'>
                                                                        <span class='text-900' href=''>
                                                                            {{ $alat->nama_alat }}
                                                                        </span>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
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
                                        @if ($materials)
                                            @foreach ($materials as $material)
                                                <div class="gx-card mx-0 border-bottom border-200">
                                                    <div
                                                        class='row gx-card mx-0 align-items-center border-bottom border-200'>
                                                        <div class='py-3'>
                                                            <div class='d-flex align-items-center'>
                                                                <div class='flex-1'>
                                                                    <h5 class='fs-0'>
                                                                        <span class='text-900' href=''>
                                                                            {{ $material->material }}
                                                                        </span>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
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
                            <h6 class="mb-0">Status</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-4 mt-n2"><label class="mb-1">Status</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $permit->status_request }}">
                            </div>
                            <div class="mb-4 mt-n2"><label class="mb-1">Jenis Pekerjaan</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $permit->JenisPekerjaan->jenis_pekerjaan }}">
                            </div>
                        </div>
                    </div>
                    @if (
                        !$permit->sign_approval_1 &&
                            $sysApprove->approval_1 == Request::session()->get('user')->id_role_hdr &&
                            $permit->status_request != 'REJECTED')
                        <div class="card-footer border-top">
                            <div class="">
                                <form action="{{ route('approveRP1', $permit->id) }}" method="post">
                                    @csrf
                                    <button type="button" onclick="onAccept({{ $permit->id }})"
                                        class="btn btn-primary w-100">Approve</button>
                                </form>
                            </div>
                            <div class="mt-3">
                                <form action="{{ route('rejectRP', $permit->id) }}" method="post">
                                    @csrf
                                    <button type="button" onclick="onReject({{ $permit->id }})"
                                        class="btn btn-danger w-100">Reject</button>
                                </form>
                            </div>
                        </div>
                    @endif
                    @if (
                        $permit->sign_approval_1 &&
                            Request::session()->get('work_relation_id') == 1 &&
                            $permit->status_request != 'REJECTED' &&
                            !isset($permit->WorkPermit))
                        <div class="card-footer border-top">
                            <a href="{{ route('work-permits.create', ['id_rp' => $permit->id]) }}" type="button"
                                class="btn btn-primary w-100">Buat Work Permit</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
    <script>
        tinyMCE.init({
            selector: 'textarea#deskripsi_wr',
            menubar: false,
            toolbar: false,
            readonly: true,
            height: "180"
        });

        function onAccept(id) {
            $.ajax({
                url: '/admin/request-permits/approve1/' + id,
                type: 'POST',
                success: function(data) {
                    if (data.status == 'ok') {
                        Swal.fire(
                            'Success!',
                            'Success accept Request Permit!',
                            'success'
                        ).then(() => window.location.reload());
                    }
                }
            })
        }

        function onReject(id) {
            $.ajax({
                url: '/admin/request-permits/reject/' + id,
                type: 'POST',
                success: function(data) {
                    if (data.status == 'ok') {
                        Swal.fire(
                            'Success!',
                            'Success reject Request Permit!',
                            'success'
                        ).then(() => window.location.reload());
                    }
                }
            })
        }
    </script>
@endsection
