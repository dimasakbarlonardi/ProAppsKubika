@extends('layouts.master')

@section('css')
    <link href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
    <script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
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
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="mb-1">Jumlah deposit</label>
                                        <div class="input-group flex-nowrap">
                                            <span class="input-group-text" id="addon-wrapping">Rp</span>
                                            <input class="form-control" value="{{ $reservation->jumlah_deposit }}" name="jumlah_deposit" disabled/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-4">
                    <div class="row g-3 position-sticky top-0">
                        <div class="col-md-6 col-xl-12 rounded-3">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Ticket</h6>
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
                            @if (!$reservation->sign_approval_1)
                                <div class="card-footer border-top border-200 py-x1">
                                    <form action="{{ route('rsvApprove1', $reservation->id) }}" method="post">
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
    <script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
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
