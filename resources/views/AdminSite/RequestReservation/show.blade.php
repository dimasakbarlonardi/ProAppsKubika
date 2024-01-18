@extends('layouts.master')

@section('css')
    <link href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
    <script src="https://cdn.tiny.cloud/1/zfyksst4gxwae7gxmgzef4p86481o6u0hqh00100y0xgkyts/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body bg-light">
                <div class="row">
                    <div class="col-md-8">
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
                                            <label class="mb-1">Durasi Acara</label>
                                            <input type="text" class="form-control" disabled
                                                value="{{ $reservation->durasi_acara }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="mb-1">Waktu acara awal</label>
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
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="mb-1">Jumlah pembayaran</label>
                                            <div class="input-group flex-nowrap">
                                                <span class="input-group-text" id="addon-wrapping">Rp</span>
                                                <input class="form-control" style="text-align: right" value="{{ number_format($reservation->jumlah_deposit, '0', ',', '.') }}"
                                                    name="jumlah_deposit" disabled />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($reservation->status_bayar == 'PAID' && $reservation->is_deposit)
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="mb-1">Admin Fee</label>
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text" id="addon-wrapping">Rp</span>
                                                    <input class="form-control"
                                                        value="{{ $reservation->CashReceipt->admin_fee }}" name="jumlah_deposit"
                                                        disabled />
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label class="mb-1">Grand Total</label>
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text" id="addon-wrapping">Rp</span>
                                                    <input class="form-control"
                                                        value="{{ $reservation->CashReceipt->gross_amount }}"
                                                        name="jumlah_deposit" disabled />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mt-4 mt-md-0">
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
                            @if (
                                $reservation->sign_approval_1 &&
                                !$reservation->sign_approval_2 &&
                                $reservation->Ticket->status_request != 'REJECTED'
                            )
                                <div class="card-footer border-top border-200 py-x1">
                                    <form action="{{ route('rsvApprove2', $reservation->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-primary w-100">Approve</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
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
