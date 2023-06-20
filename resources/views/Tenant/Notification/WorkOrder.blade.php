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
            <div class="row justify-content-center">
                <div class="col-lg-12 col-xxl-6">
                    <div class="card shadow-none mb-3"><img class="card-img-top" src="" alt="" />
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-xxl-12 col-xl-8">
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
                                                                value="Rp {{ $wod->detil_biaya_alat }}" disabled>
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
                                                            <div class="col-12 col-md-4 text-end py-2"
                                                                id="totalServicePrice">
                                                                Rp {{ $wo->jumlah_bayar_wo }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xxl-3 col-xl-4">
                                    <div class="row g-3 position-sticky top-0">
                                        <div class="col-md-6 col-xl-12 rounded-3">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h6 class="mb-0">Status</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-4 mt-n2"><label class="mb-1">Work Relation</label>
                                                        <input type="text" class="form-control" disabled
                                                            value="{{ $wo->status_wo }}">
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
                                                            <input class="form-control"
                                                                value="{{ $wo->estimasi_pengerjaan }}"
                                                                {{ $wo->estimasi_pengerjaan ? 'disabled' : '' }}
                                                                type="text" name="estimasi_pengerjaan"
                                                                id="estimasi_pengerjaan" />
                                                            <span class="input-group-text">Jam</span>
                                                        </div>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="mb-1">Jadwal Pengerjaan</label>
                                                        <input value="{{ $wo->jadwal_pengerjaan }}" disabled
                                                            class="form-control datetimepicker" name="jadwal_pengerjaan"
                                                            id="datetimepicker" type="text" placeholder="d/m/y H:i"
                                                            data-options='{"enableTime":true,"dateFormat":"Y-m-d H:i","disableMobile":true}' />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (!$wo->sign_approve_acc_wo)
                                <div class="text-center">
                                    <form action="{{ route('acceptWO', $wo->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-lg my-4" type="button">
                                            Setujui WO
                                        </button>
                                    </form>
                                    <small class="d-block">For any technical issues faced, please contact
                                        <a href="#!">Customer Support</a>.</small>
                                </div>
                            @endif
                            @if ($wo->status_wo == 'WORK DONE')
                                <div class="text-center">
                                    <form action="{{ route('doneWO', $wo->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-lg my-4" type="button">
                                            Selesai
                                        </button>
                                    </form>
                                    <small class="d-block">For any technical issues faced, please contact
                                        <a href="#!">Customer Support</a>.</small>
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
            selector: 'textarea#deskripsi_wr',
            menubar: false,
            toolbar: false,
            readonly: true,
            height: "180"
        });
    </script>
@endsection
