@extends('layouts.master')

@section('css')
    <script src="https://cdn.tiny.cloud/1/zfyksst4gxwae7gxmgzef4p86481o6u0hqh00100y0xgkyts/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <link href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <form action="{{ route('work-orders.update', $wo->id) }}" method="post" id="form-send-to-tenant">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card">
                        <div class="card-header d-flex flex-between-center">
                            <h6 class="mb-0">Deskripsi Work Request</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control" name="deskripsi_wr" id="deskripsi_wr_tenant" disabled>
                            {!! $wo->Ticket->deskripsi_request !!}
                        </textarea>
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card">
                        <div class="card-header d-flex flex-between-center">
                            <h6 class="mb-0">Work Order Detail</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control" name="deskripsi_wr" id="deskripsi_wr" disabled>
                            {!! $wo->WorkRequest->deskripsi_wr !!}
                        </textarea>
                    </div>
                </div>
                <div class="card mt-2" id="detail_work_order">
                    <div class="card-body">
                        <div class="card-body p-0">
                            <div class="row gx-card mx-0 bg-200 text-900 fs--1 fw-semi-bold">
                                <div class="col-9 col-md-8 py-2">Detail Pekerjaan</div>
                                <div class="col-3 col-md-4 py-2 text-end">Detail Biaya Alat</div>
                            </div>
                            @foreach ($wo->WODetail as $wod)
                                <div class="row gx-card mx-0 border-bottom border-200">
                                    <div class="col-9 py-3">
                                        <input class="form-control" type="text" value="{{ $wod->detil_pekerjaan }}"
                                            disabled>
                                    </div>
                                    <div class="col-3 py-3 text-end">
                                        <input class="form-control" type="text"
                                            value="{{ Rupiah($wod->detil_biaya_alat) }}" disabled>
                                    </div>
                                </div>
                            @endforeach

                            <div class="row fw-bold gx-card mx-0">
                                <div class="col-12 col-md-4 py-2 text-end text-900">Total</div>
                                <div class="col px-0">
                                    <div class="row gx-card mx-0">
                                        <div class="col-md-8 py-2 d-none d-md-block text-center">
                                            {{ count($wo->WODetail) }} ({{ count($wo->WODetail) > 1 ? 'Items' : 'Item' }})
                                        </div>
                                        <div class="col-12 col-md-4 text-end py-2" id="totalServicePrice">
                                            {{ Rupiah($wo->jumlah_bayar_wo) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4 rounded-3">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Status</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-4 mt-n2"><label class="mb-1">Status</label>
                            <input type="text" class="form-control" disabled value="{{ $wo->status_wo }}" id="">
                        </div>
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-header d-flex flex-between-center py-3">
                        <h6 class="mb-0">Contact Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-0 border-bottom pb-x1 mb-x1 align-items-sm-center align-items-xl-start">
                            <div class="col-3">
                                <div class="avatar avatar-3xl">
                                    <img class="rounded-circle" src="{{ url($wo->Ticket->Tenant->profile_picture) }}"
                                        alt="" />
                                </div>
                            </div>
                            <div class="col-6">
                                <p class="fw-semi-bold text-800 mb-0">{{ $wo->Ticket->Tenant->nama_tenant }}</p>
                                <a class="btn btn-link btn-sm p-0 fe-medium fs--1" href="#">View more
                                    details
                                </a>
                            </div>
                        </div>
                        <div class="row g-0 justify-content-lg-between">
                            <div class="col-auto col-md-6 col-lg-auto">
                                <div class="row">
                                    <div class="col-md-auto mb-4 mb-md-0 mb-xl-4">
                                        <h6 class="mb-1">Email</h6>
                                        <a class="fs--1"
                                            href="mailto:mattrogers@gmail.com">{{ $wo->Ticket->Tenant->email_tenant }}
                                        </a>
                                    </div>
                                    <div class="col-md-auto mb-4 mb-md-0 mb-xl-4">
                                        <h6 class="mb-1">Phone Number</h6>
                                        <a class="fs--1"
                                            href="tel:+6(855)747677">{{ $wo->Ticket->Tenant->no_telp_tenant }}
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-auto mb-4 mb-md-0 mb-xl-4">
                                        <h6 class="mb-1">Unit</h6>
                                        <a class="fs--1" href="mailto:mattrogers@gmail.com">Lantai :
                                            {{ $wo->Ticket->Unit->floor->nama_lantai }},
                                            {{ $wo->Ticket->Unit->nama_unit }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto col-md-6 col-lg-auto ps-md-5 ps-xl-0">
                                <div class="border-start position-absolute start-50 d-none d-md-block d-xl-none"
                                    style="height: 72px"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-header">
                        <h6 class="mb-0">Detail Pengerjaan</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="mb-1">Work Order Type</label>
                            <div class="input-group">
                                <input class="form-control"
                                    value="{{ $wo->id_bayarnon == '1' ? 'Berbayar' : 'Tidak Berbayar' }}"
                                    {{ isset($wo->id_bayarnon) ? 'disabled' : '' }} type="text" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1">Estimasi Pengerjaan</label>
                            <div class="input-group">
                                <input class="form-control" value="{{ $wo->estimasi_pengerjaan }}"
                                    {{ $wo->estimasi_pengerjaan ? 'disabled' : '' }} type="text"
                                    name="estimasi_pengerjaan" id="estimasi_pengerjaan" />
                                <span class="input-group-text">Menit</span>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="mb-1">Jadwal Pengerjaan</label>
                            <input value="{{ $wo->jadwal_pengerjaan }}" {{ $user->id_role_hdr != 8 ? 'disabled' : '' }}
                                class="form-control datetimepicker" name="jadwal_pengerjaan" id="jadwal_pengerjaan"
                                type="text" placeholder="d/m/y H:i"
                                data-options='{"enableTime":true,"dateFormat":"Y-m-d H:i","disableMobile":true}' />
                        </div>
                    </div>
                </div>
                @if ($user->id_role_hdr == 8 && $wo->status_wo == 'PENDING')
                    <div class="card-footer border-top border-200 py-x1">
                        <button type="button" onclick="onSubmit()" class="btn btn-primary w-100" value="send">Send to
                            Tenant</button>
                    </div>
                @endif
                @if (
                    $wo->status_wo == 'APPROVED' &&
                        $user->RoleH->work_relation_id == $wo->WorkRequest->id_work_relation &&
                        !$wo->sign_approve_2)
                    <div class="card-footer border-top border-200 py-x1">
                        <button type="button" class="btn btn-primary w-100"
                            onclick="approve2({{ $wo->id }})">Approve</button>
                    </div>
                @endif

                {{-- Approve BM berbayar --}}
                @if (
                    $wo->status_wo == 'APPROVED' &&
                        $wo->id_bayarnon == 1 &&
                        $user->id_user == $approve->approval_4 &&
                        $wo->sign_approve_2 &&
                        $wo->status_wo != 'BM APPROVED')
                    <div class="card-footer border-top border-200 py-x1">
                        <button type="button" class="btn btn-primary w-100"
                            onclick="approveBM({{ $wo->id }})">Approve</button>
                    </div>
                @endif

                {{-- Approve BM tidak berbayar --}}
                @if (
                    $wo->status_wo == 'APPROVED' &&
                        $wo->id_bayarnon == 0 &&
                        $user->id_user == $approve->approval_4 &&
                        $wo->sign_approve_2 &&
                        $wo->status_wo != 'BM APPROVED')
                    <div class="card-footer border-top border-200 py-x1">
                        <button type="button" class="btn btn-primary w-100"
                            onclick="approveBM({{ $wo->id }})">Approve</button>
                    </div>
                @endif

                @if (
                    $wo->status_wo == 'BM APPROVED' &&
                        $user->id_user == $approve->approval_3 &&
                        $wo->sign_approve_2 &&
                        !$wo->sign_approve_3)
                    <div class="card-footer border-top border-200 py-x1">
                        <button type="button" class="btn btn-primary w-100"
                            onclick="approve3({{ $wo->id }})">Approve</button>
                    </div>
                @endif

                {{-- Work done berbayar --}}
                @if (
                    $wo->status_wo == 'APPROVED' &&
                        $wo->sign_approve_3 &&
                        $wo->sign_approve_2 &&
                        $wo->id_bayarnon == 1 &&
                        $user->RoleH->work_relation_id == $wo->WorkRequest->id_work_relation)
                    <div class="card-footer border-top border-200 py-x1">
                        <button type="button" class="btn btn-primary w-100"
                            onclick="workDone({{ $wo->id }})">PEKERJAAN SELESAI</button>
                    </div>
                @endif

                {{-- Work done tidak berbayar --}}
                @if (
                    $wo->status_wo == 'BM APPROVED' &&
                        $wo->sign_approve_2 &&
                        $wo->id_bayarnon == 0 &&
                        $user->RoleH->work_relation_id == $wo->WorkRequest->id_work_relation)
                    <div class="card-footer border-top border-200 py-x1">
                        <button type="button" class="btn btn-primary w-100"
                            onclick="workDone({{ $wo->id }})">PEKERJAAN SELESAI</button>
                    </div>
                @endif

                @if ($user->id_role_hdr == 8 && $wo->status_wo == 'WAITING APPROVE')
                    <div class="card-footer border-top border-200 py-x1">
                        <button type="button" onclick="onSubmit()" class="btn btn-primary w-100"
                            value="send">Update</button>
                    </div>
                @endif
                @if ($user->id_user == $approve->approval_4 && $wo->sign_approve_5 && !$wo->sign_approve_4 && $wo->status_wo == 'DONE')
                    <div class="card-footer border-top border-200 py-x1">
                        <button type="button" class="btn btn-primary w-100"
                            onclick="completeWO({{ $wo->id }})">COMPLETE</button>
                    </div>
                @endif
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script src="https://cdn.tiny.cloud/1/zfyksst4gxwae7gxmgzef4p86481o6u0hqh00100y0xgkyts/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
    <script>
        flatpickr("#jadwal_pengerjaan", {
            minDate: "today",
            enableTime: true,
            altInput: true,
            altFormat: "F j, Y - H:i"
        });

        tinyMCE.init({
            selector: 'textarea#deskripsi_wr_tenant',
            menubar: false,
            toolbar: false,
            height: "180",
            readonly: true
        });

        tinyMCE.init({
            selector: 'textarea#deskripsi_wr',
            menubar: false,
            toolbar: false,
            height: "180",
            readonly: true
        });

        function onSubmit() {
            var jadwal_pengerjaan = $('#jadwal_pengerjaan').val()
            if (!jadwal_pengerjaan) {
                Swal.fire(
                    'Failed!',
                    'Please insert work date',
                    'error'
                )
            } else {
                $('#form-send-to-tenant').submit()
            }
        }

        function workDone(id) {
            $.ajax({
                url: `/admin/work-done/work-order/${id}`,
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

        function approve2(id) {
            $.ajax({
                url: `/admin/approve2/work-order/${id}`,
                type: 'POST',
                success: function(data) {
                    console.log(data)
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

        function approveBM(id) {
            $.ajax({
                url: `/admin/approveBM/work-order/${id}`,
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
                url: `/admin/approve3/work-order/${id}`,
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

        function completeWO(id) {
            $.ajax({
                url: `/admin/complete/work-order/${id}`,
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
    </script>
@endsection
