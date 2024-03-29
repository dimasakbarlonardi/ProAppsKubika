@extends('layouts.master')

@section('css')
    <link href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
    <script src="https://cdn.tiny.cloud/1/zfyksst4gxwae7gxmgzef4p86481o6u0hqh00100y0xgkyts/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
@endsection

@section('content')
    <div class="card">

        <div class="card-body bg-light">
            <div class="row">
                <div class="col-8">
                    <div class="card" id="permit_detail">
                        <div class="card-header">
                            <h6 class="mb-0">Detail Work Permit</h6>
                        </div>
                        <div class="px-5">
                            <div class="my-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="mb-1">Tanggal request reservation</label>
                                        <input type="text" class="form-control" disabled
                                            value="{{ HumanDate($reservation->tgl_request_reservation) }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="mb-1">Durasi Acata</label>
                                        <input type="text" class="form-control" disabled
                                            value="{{ $reservation->durasi_acara }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="mb-1">Tipe reservasi</label>
                                        <input type="text" class="form-control" disabled
                                            value="{{ HumanDateTime($reservation->waktu_mulai) }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="mb-1">Waktu acara berakhir</label>
                                        <input type="text" class="form-control" disabled
                                            value="{{ HumanDateTime($reservation->waktu_akhir) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="mb-1">Ruang reservasi</label>
                                        <input type="text" class="form-control" disabled
                                            value="{{ $reservation->RuangReservation->ruang_reservation }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="mb-1">Jenis acara</label>
                                        <input type="text" class="form-control" disabled
                                            value="{{ $reservation->JenisAcara->jenis_acara }}">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="mb-1">Keterangan</label>
                                <textarea class="form-control" name="keterangan" id="keterangan_reservation">
                                    {{ $reservation->keterangan }}
                                </textarea>
                            </div>
                            @if ($reservation->is_deposit)
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="mb-1">Jumlah pembayaran</label>
                                            <div class="input-group flex-nowrap">
                                                <span class="input-group-text" id="addon-wrapping">Rp</span>
                                                <input style="text-align: right" class="form-control"
                                                    value="{{ number_format($reservation->jumlah_deposit, 0, ',', '.') }}"
                                                    name="jumlah_deposit" disabled />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($reservation->status_bayar == 'PAID' && $reservation->is_deposit)
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="mb-1">Admin Fee</label>
                                            <div class="input-group flex-nowrap">
                                                <span class="input-group-text" id="addon-wrapping">Rp</span>
                                                <input style="text-align: right" class="form-control"
                                                    value="{{ number_format($reservation->CashReceipt->admin_fee, 0, ',', '.') }}"
                                                    name="jumlah_deposit" disabled />
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="mb-1">Grand Total</label>
                                            <div class="input-group flex-nowrap">
                                                <span class="input-group-text" id="addon-wrapping">Rp</span>
                                                <input style="text-align: right" class="form-control"
                                                    value="{{ number_format($reservation->CashReceipt->gross_amount, 0, ',', '.') }}"
                                                    name="jumlah_deposit" disabled />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Request</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-4 mt-n2"><label class="mb-1">No Tiket</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $reservation->no_tiket }}">
                            </div>
                            <div class="mb-4 mt-n2"><label class="mb-1">No request reservation</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $reservation->no_request_reservation }}">
                            </div>
                            <div class="mb-4 mt-n2"><label class="mb-1">Status</label>
                                <input class="form-control" type="text"
                                    value="{{ $reservation->Ticket->status_request }}" disabled>
                            </div>
                        </div>
                    </div>
                    @if (
                        !$reservation->sign_approval_1 &&
                            $notif->receiver == Session::get('user_id') &&
                            $reservation->Ticket->status_request != 'REJECTED')
                        <div class="card-footer border-top border-200 py-x1">
                            <div class="row">
                                <div class="col">
                                    <form action="{{ route('rsvReject', $reservation->id) }}" method="post">
                                        @csrf
                                        <button type="submit" onclick="return confirm('are you sure?')"
                                            class="btn btn-danger w-100">Reject</button>
                                    </form>
                                </div>
                                <div class="col">
                                    <form action="{{ route('rsvApprove1', $reservation->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-primary w-100">Approve</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    @endif
                    @if (
                        $reservation->sign_approval_1 &&
                            !$reservation->sign_approval_2 &&
                            $notif->division_receiver == Session::get('work_relation_id') &&
                            $reservation->Ticket->status_request != 'REJECTED')
                        <div class="card-footer border-top border-200 py-x1">
                            <form action="{{ route('rsvApprove2', $reservation->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100">Approve</button>
                            </form>
                        </div>
                    @endif
                    @if (
                        $reservation->sign_approval_2 &&
                            !$reservation->sign_approval_3 &&
                            $notif->receiver == Session::get('user_id') &&
                            $reservation->Ticket->status_request != 'REJECTED')
                        <div class="card-footer border-top border-200 py-x1">
                            <form action="{{ route('rsvApprove3', $reservation->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100">Approve</button>
                            </form>
                        </div>
                    @endif
                    @if (
                        $notif->receiver == Session::get('user_id') &&
                            $reservation->Ticket->status_request == 'DONE' &&
                            !$reservation->sign_approval_4 &&
                            $reservation->Ticket->status_request != 'REJECTED')
                        <div class="card-footer border-top border-200 py-x1">
                            <form action="{{ route('rsvComplete', $reservation->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100">Complete</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>


        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.tiny.cloud/1/zfyksst4gxwae7gxmgzef4p86481o6u0hqh00100y0xgkyts/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
    <script>
        tinyMCE.init({
            selector: 'textarea#keterangan_reservation',
            menubar: false,
            toolbar: false,
            readonly: true,
            height: "280"
        });
    </script>
@endsection
