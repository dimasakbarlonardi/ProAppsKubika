@extends('layouts.master')

@section('css')
    <script src="https://cdn.tiny.cloud/1/zfyksst4gxwae7gxmgzef4p86481o6u0hqh00100y0xgkyts/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <link href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="card">

        <div class="card-body bg-light">
            <div class="row justify-content-center">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-8">
                            <div class="card">
                                <div class="card">
                                    <div class="card-header d-flex flex-between-center">
                                        <h6 class="mb-0">Work Order Detail</h6>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <textarea class="form-control" name="deskripsi_wr" id="deskripsi_wr" cols="10" rows="5" disabled>
                                                {!! $wo->WorkRequest->deskripsi_wr !!}
                                            </textarea>
                                </div>
                            </div>
                            <div class="card mt-2" id="detail_work_order">
                                <div class="card-body">
                                    <div class="card-body p-0">
                                        <div class="row gx-card mx-0 bg-200 text-900 fs--1 fw-semi-bold">
                                            <div class="col-9 col-md-8 py-2">Detil Pekerjaan</div>
                                            <div class="col-3 col-md-4 py-2 text-end">Detil Biaya Alat</div>
                                        </div>

                                        @foreach ($wo->WODetail as $wod)
                                            <div class="row gx-card mx-0 border-bottom border-200">
                                                <div class="col-9 py-3">
                                                    <input class="form-control" type="text"
                                                        value="{{ $wod->detil_pekerjaan }}" disabled>
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
                                                        {{ count($wo->WODetail) }}
                                                        ({{ count($wo->WODetail) > 1 ? 'Items' : 'Item' }})
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

                        <div class="col-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Status</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-4 mt-n2"><label class="mb-1">Work Relation</label>
                                        <input type="text" class="form-control" disabled value="{{ $wo->status_wo }}">
                                    </div>
                                    <div class="mb-4 mt-n2"><label class="mb-1">Status Berbayar WO</label>
                                        <input type="text" class="form-control" disabled
                                            value="{{ $wo->id_bayarnon == 1 ? 'Berbayar' : 'Non Berbayar' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Detail Pengerjaan</h6>
                                </div>
                                <div class="card-body">
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
                                        <input value="{{ $wo->jadwal_pengerjaan }}" disabled
                                            class="form-control datetimepicker" name="jadwal_pengerjaan"
                                            id="jadwal_pengerjaan" type="text" placeholder="d/m/y H:i"
                                            data-options='{"enableTime":true,"dateFormat":"Y-m-d H:i","disableMobile":true}' />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (
                        $user->id_user == $approve->approval_3 &&
                            $wo->sign_approve_2 &&
                            !$wo->sign_approve_3 &&
                            $user->Karyawan->is_can_approve)
                        <div class="text-center">
                            <button type="button" onclick="approve3" class="btn btn-success btn-lg my-4" type="button">
                                Approve
                            </button>
                        </div>
                    @endif
                    @if (!$wo->sign_approve_1 && $wo->status_wo != 'REJECTED')
                        <div class="">
                            <div class="row">
                                <div class="col-6 text-end">
                                    <form action="{{ route('acceptWO', $wo->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-lg my-4" type="button">
                                            Setujui WO
                                        </button>
                                    </form>
                                </div>
                                <div class="col-6 text-start">
                                    <form action="{{ route('rejectWO', $wo->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-lg my-4">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (
                        $wo->status_wo == 'APPROVED' &&
                            $wo->sign_approve_3 &&
                            $user->RoleH->work_relation_id == $wo->WorkRequest->id_work_relation)
                        <div class="text-center">
                            <button type="button" class="btn btn-success btn-lg my-4"
                                onclick="workDone({{ $wo->id }})">
                                PEKERJAAN SELESAI
                            </button>
                        </div>
                    @endif
                    @if ($wo->status_wo == 'WORK DONE' && $user->id_role_hdr == $approve->approval_1)
                        <div class="text-center">
                            <form action="{{ route('doneWO', $wo->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-success btn-lg my-4" type="button">
                                    Selesai
                                </button>
                            </form>
                        </div>
                    @endif
                    <small class="d-block">For any technical issues faced, please contact
                        <a href="#!">Customer Support</a>.</small>
                </div>
            </div>
        </div>
    </div>
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
            selector: 'textarea#deskripsi_wr',
            menubar: false,
            toolbar: false,
            readonly: true,
            height: "180"
        });

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
    </script>
@endsection
