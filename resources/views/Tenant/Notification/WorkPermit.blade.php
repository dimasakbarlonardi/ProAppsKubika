@extends('layouts.master')

@section('css')
    <script src="https://cdn.tiny.cloud/1/zfyksst4gxwae7gxmgzef4p86481o6u0hqh00100y0xgkyts/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <link href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="card">

        <div class="card-body bg-light">
            <div class="row">
                <div class="col-9">
                    <div class="card" id="permit_detail">
                        <div class="card-header">
                            <h6 class="mb-0">Detail Work Permit</h6>
                        </div>
                        <div class="px-5">
                            <div class="my-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label">Nama Kontraktor</label>
                                        <input type="text" class="form-control"
                                            value="{{ $permit->RequestPermit->nama_kontraktor }}" disabled>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Penanggung Jawab</label>
                                        <input type="text" class="form-control" value="{{ $permit->RequestPermit->pic }}"
                                            disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="mb-1">Mulai Pengerjaan</label>
                                        <input value="{{ HumanDateTime($permit->RequestPermit->tgl_mulai) }}" type="text"
                                            class="form-control" disabled />
                                    </div>
                                    <div class="col-6">
                                        <label class="mb-1">Tanggal Akhir Pengerjaan</label>
                                        <input value="{{ HumanDateTime($permit->RequestPermit->tgl_akhir) }}" type="text"
                                            class="form-control" disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan Pekerjaan</label>
                                <textarea class="form-control" id="keterangan_pekerjaan" cols="20" rows="5" disabled>{{ $permit->RequestPermit->keterangan_pekerjaan }}</textarea>
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
                                <input type="text" class="form-control" disabled value="{{ $permit->status_request }}">
                            </div>
                            <div class="mb-4 mt-n2"><label class="mb-1">Jenis Pekerjaan</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $permit->RequestPermit->JenisPekerjaan->jenis_pekerjaan }}">
                            </div>
                            <div class="mb-4 mt-n2"><label class="mb-1">Request</label>
                                <input class="form-control" type="text" value="{{ $permit->Ticket->no_tiket }}"
                                    disabled>
                            </div>
                            <div class="mb-4 mt-n2"><label class="mb-1">No Request Permit</label>
                                <input class="form-control" type="text"
                                    value="{{ $permit->RequestPermit->no_request_permit }}" disabled>
                            </div>
                            <div class="mb-4 mt-n2"><label class="mb-1">Work Relation</label>
                                <input type="text" value="{{ $permit->WorkRelation->work_relation }}"
                                    class="form-control" name="nama_project" required disabled>
                            </div>
                            <div class="mb-4 mt-n2"><label class="mb-1">Permit Berbayar</label>
                                <input type="text" value="{{ $permit->id_bayarnon == 1 ? 'Yes' : 'No' }}"
                                    class="form-control" name="nama_project" required disabled>
                            </div>
                            <div class="mb-4 mt-n2"><label class="mb-1">Jumlah Supervisi</label>
                                <input type="text" value="{{ Rupiah($permit->jumlah_supervisi) }}"
                                    class="form-control" name="jumlah_deposit" required disabled>
                            </div>
                            <div class="mb-4 mt-n2"><label class="mb-1">Jumlah Deposit</label>
                                <input type="text" value="{{ Rupiah($permit->jumlah_deposit) }}" class="form-control"
                                    name="jumlah_deposit" required disabled>
                            </div>
                        </div>
                    </div>
                    @if (!$permit->sign_approval_1 && $permit->Ticket->Tenant->User->id_user == Request::session()->get('user_id'))
                        <div class="card-footer border-top border-200 py-x1">
                            <form action="{{ route('approveWP1', $permit->id) }}" method="post">
                                @csrf
                                <button type="button" onclick="onApprove({{ $permit->id }})"
                                    class="btn btn-primary w-100">Approve</button>
                            </form>
                            <div class="mt-3">
                                <form action="{{ route('rejectWP', $permit->id) }}" method="post">
                                    @csrf
                                    <button type="button" onclick="onReject({{ $permit->id }})"
                                        class="btn btn-danger w-100">Reject</button>
                                </form>
                            </div>
                        </div>
                    @endif
                    @if (
                        $permit->id_work_relation == $user->RoleH->WorkRelation->id_work_relation &&
                            $user->Karyawan->is_can_approve &&
                            $permit->sign_approval_1 &&
                            !$permit->sign_approval_2)
                        <div class="card-footer border-top border-200 py-x1">
                            <button type="button" class="btn btn-primary w-100"
                                onclick="approve2({{ $permit->id }})">Approve</button>
                        </div>
                    @endif
                    @if ($sysApprove->approval_3 == $user->id_user && !$permit->sign_approval_3)
                        <div class="card-footer border-top border-200 py-x1">
                            <button type="button" class="btn btn-primary w-100"
                                onclick="approve3({{ $permit->id }})">Approve</button>
                        </div>
                    @endif
                    @if ($sysApprove->approval_4 == $user->id_user && $permit->sign_approval_3 && !$permit->sign_approval_4)
                        <div class="card-footer border-top border-200 py-x1">
                            <button type="button" class="btn btn-primary w-100"
                                onclick="approve4({{ $permit->id }})">Approve</button>
                        </div>
                    @endif
                    @if (
                        $permit->sign_approval_4 &&
                            $permit->status_request != 'DONE' &&
                            $permit->status_request != 'WORK DONE' &&
                            $permit->status_request != 'COMPLETE' &&
                            $permit->id_work_relation == Request::session()->get('work_relation_id'))
                        <div class="card-footer border-top border-200 py-x1">
                            <a href="{{ route('printWP', [$permit->id, Request::user()->id_site]) }}" target="_blank"
                                class="btn btn-warning w-100 mb-3">Print</a>
                            <button type="button" class="btn btn-primary w-100"
                                onclick="workDoneWP({{ $permit->id }})">Pekerjaan Selesai</button>
                        </div>
                    @endif
                    @if (
                        !$permit->BAPP &&
                            $permit->id_work_relation == Request::session()->get('work_relation_id') &&
                            $permit->status_request == 'WORK DONE')
                        <div class="card-footer border-top border-200 py-x1">
                            <a href="{{ route('bapp.create', ['id_wp' => $permit->id]) }}" target="_blank"
                                class="btn btn-info w-100 mb-3">Buat BAPP</a>
                        </div>
                    @endif
                    @if (Request::session()->get('user_id') == $permit->Ticket->Tenant->User->id_user &&
                            $permit->status_request == 'WORK DONE')
                        <div class="card-footer border-top border-200 py-x1">
                            <button type="button" class="btn btn-primary w-100"
                                onclick="doneWP({{ $permit->id }})">Done</button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- @if (
                $permit->CashReceipt &&
                    $permit->Ticket->Tenant->User->id_user == Request::session()->get('user_id') &&
                    !$permit->CashReceipt->payment_type)

            @elseif (
                $permit->CashReceipt &&
                    $permit->Ticket->Tenant->User->id_user == Request::session()->get('user_id') &&
                    $permit->CashReceipt->transaction_status == 'VERIFYING')
                <div class="text-center mt-5">
                    <a href="{{ route('paymentPO', $permit->CashReceipt->id) }}" class="btn btn-success">Lihat
                        VA</a>
                </div>
            @endif -->
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.tiny.cloud/1/zfyksst4gxwae7gxmgzef4p86481o6u0hqh00100y0xgkyts/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
    <script>
        tinyMCE.init({
            selector: 'textarea#deskripsi_wr',
            menubar: false,
            toolbar: false,
            readonly: true,
            height: "180"
        });

        function onPayment() {
            var billing = $('input[name="billing"]:checked').val();
            var card_number = $('#card_number').val();
            var expDate = $('#expDate').val();
            var cvv = $('#cvv').val();

            if (!billing) {
                if (billing == 'credit_card') {
                    Swal.fire(
                        'Oppps!',
                        'Please select payment method',
                        'info'
                    )
                }
            } else {
                if (billing == 'credit_card') {
                    if (!card_number || !expDate || !cvv) {
                        Swal.fire(
                            'Oppps!',
                            'Please fill all field',
                            'info'
                        )
                    } else {
                        $("#generatePaymentPO").submit();
                    }
                } else {
                    $("#generatePaymentPO").submit();
                }
            }
        }

        function onApprove(id) {
            Swal.fire({
                title: 'Are you sure?',
                icon: 'info',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result['isConfirmed']) {
                    $.ajax({
                        url: `/admin/work-permit/approve1/${id}`,
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
            })
        }

        function onReject(id) {
            Swal.fire({
                title: 'Are you sure?',
                icon: 'info',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result['isConfirmed']) {
                    $.ajax({
                        url: `/admin/work-permit/reject/${id}`,
                        type: 'POST',
                        success: function(data) {
                            if (data.status === 'ok') {
                                Swal.fire(
                                    'Success!',
                                    'Success reject Work Permit!',
                                    'success'
                                ).then(() => window.location.reload())
                            }
                        }
                    })
                }
            })
        }

        function approve2(id) {
            Swal.fire({
                title: 'Are you sure?',
                icon: 'info',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result['isConfirmed']) {
                    $.ajax({
                        url: `/admin/work-permit/approve2/${id}`,
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
            })
        }

        function approve3(id) {
            $.ajax({
                url: `/admin/work-permit/approve3/${id}`,
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

        function doneWP(id) {
            $.ajax({
                url: `/admin/work-permit/doneWP/${id}`,
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

        $('document').ready(function() {
            var admin_tax = 0.11;
            var subtotal = parseInt('{{ $permit->jumlah_deposit + $permit->jumlah_supervisi }}')

            $('#cc_form').css('display', 'none')
            $('.form-check-input').on('change', function() {
                if ($(this).is(':checked') && $(this).val() == 'credit_card') {
                    var admin_fee = Math.round(2000 + (0.029 * subtotal));
                    var admin_fee = admin_fee + (Math.round(admin_fee * 0.11));

                    $('#cc_form').css('display', 'block')
                } else {
                    var admin_fee = 4000 + (4000 * admin_tax);
                    $('#cc_form').css('display', 'none')
                }
                console.log(subtotal);
                var grand_total = subtotal + admin_fee;
                $('#val_admin_fee').val(admin_fee);
                $('#admin_fee').html(`Rp ${formatRupiah(admin_fee.toString())}`)
                $('#grand_total').html(`Rp ${formatRupiah(grand_total.toString())}`)
            });
        })
    </script>
@endsection
