@extends('layouts.master')

@section('css')
    <script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
@endsection

@section('content')
    <div class="row g-3">
        <div class="col {{ $user->user_category == 2 ? '-xxl-12 col-xl-8' : '' }}">
            <div class="card">
                <div class="card-header d-flex flex-between-center">
                    <button class="btn btn-falcon-default btn-sm" type="button">
                        <span class="fas fa-arrow-left"></span>
                    </button>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header bg-light">
                    <h5><span class="fas fa-ticket-alt me-2"></span><span> {{ $ticket->no_tiket }}</span></h5>
                </div>
                <div class="card-body">
                    <div class="request">
                        <div
                            class="d-md-flex d-xl-inline-block d-xxl-flex align-items-center justify-content-between mb-x1">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-2xl">
                                    <img class="rounded-circle" src="{{ url($ticket->Tenant->profile_picture) }}"
                                        alt="" />
                                </div>
                                <p class="mb-0"><a class="fw-semi-bold mb-0 text-800"
                                        href="../../app/support-desk/contact-details.html">{{ $ticket->Tenant->nama_tenant }}</a>
                                    <a class="mb-0 fs--1 d-block text-500"
                                        href="mailto:emma@watson.com">{{ $ticket->Tenant->email_tenant }}</a>
                                </p>
                            </div>
                            <p class="mb-0 fs--2 fs-sm--1 fw-semi-bold mt-2 mt-md-0 mt-xl-2 mt-xxl-0 ms-5">
                                {{ HumanDate($ticket->created_at) }}
                                <span class="mx-1">|</span><span class="fst-italic">{{ HumanTime($ticket->created_at) }}
                                    ({{ TimeAgo($ticket->created_at) }})</span>
                            </p>
                        </div>
                        <div>
                            <h6 class="mb-3 fw-semi-bold text-1000">{{ $ticket->judul_request }}</h6>
                            {!! $ticket->deskripsi_request !!}
                            @if ($ticket->upload_image)
                                <div class="px-x1 py-3 bg-light">
                                    <div class="d-inline-flex flex-column">
                                        <div class="border p-2 rounded-3 d-flex bg-white dark__bg-1000 fs--1 mb-2">
                                            <a class="ms-auto text-decoration-none" target="_blank"
                                                href="/uploads/image/ticket/{{ $ticket->upload_image }}">
                                                <span class="fs-1 far fa-image"></span>
                                                <span class="ms-2 me-3">{{ $ticket->upload_image }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @if ($user->user_category == 2 && $ticket->status_respon == null)
                            <div class="card-footer text-end" id="preview-footer">
                                <button class="btn btn-falcon-default btn-sm fs--1" type="button" onclick="onReply()"
                                    id="btnReply">
                                    <span class="fas fa-reply"></span>
                                    <span class="d-none d-sm-inline-block ms-1">Reply</span>
                                </button>
                            </div>
                        @endif
                    </div>
                    @if ($ticket->status_respon != null)
                        <div class="my-5 position-relative text-center">
                            <hr class="position-absolute top-50 border-300 w-100 my-0" />
                            <span class="position-relative bg-white dark__bg-card-dark px-3 z-index-1">
                                <button
                                    class="btn btn-sm btn-outline-secondary rounded-pill border-300 px-lg-5">Reply</button>
                            </span>
                        </div>
                        <div
                            class="d-md-flex d-xl-inline-block d-xxl-flex align-items-center justify-content-between mb-x1">
                            {{-- <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-2xl">
                                    <img class="rounded-circle"
                                        src="{{ $ticket->TenantRelation->Karyawan->profile_picture }}" alt="" />
                                </div>
                                <p class="mb-0"><a class="fw-semi-bold mb-0 text-800"
                                        href="../../app/support-desk/contact-details.html">{{ $ticket->TenantRelation->Karyawan->nama_karyawan }}</a>
                                    <a class="mb-0 fs--1 d-block text-500"
                                        href="mailto:{{ $ticket->TenantRelation->Karyawan->email_karyawan }}">{{ $ticket->TenantRelation->Karyawan->email_karyawan }}</a>
                                </p>
                            </div> --}}
                            <p class="mb-0 fs--2 fs-sm--1 fw-semi-bold mt-2 mt-md-0 mt-xl-2 mt-xxl-0 ms-5">
                                {{ HumanDate($ticket->tgl_respon_tiket) }}
                                <span class="mx-1">|</span>
                                <span class="fst-italic">{{ HumanTime($ticket->jam_respon) }}
                                    ({{ TimeAgo($ticket->tgl_respon_tiket . ' ' . $ticket->jam_respon) }})</span>
                            </p>
                        </div>
                        <div>
                            <h6 class="mb-3 fw-semi-bold text-1000">{{ $ticket->judul_request }}</h6>
                            {!! $ticket->deskripsi_respon !!}
                        </div>
                    @endif
                    <div class="response" style="display: none" id="response">
                        <div class="my-5 position-relative text-center">
                            <hr class="position-absolute top-50 border-300 w-100 my-0" />
                            <span class="position-relative bg-white dark__bg-card-dark px-3 z-index-1">
                                <button
                                    class="btn btn-sm btn-outline-secondary rounded-pill border-300 px-lg-5">Reply</button>
                            </span>
                        </div>
                        <div class="border-bottom mb-5 pb-5 text-right">
                            <form action="{{ route('updateRequestTicket', $ticket->id) }}" method="post">
                                @csrf
                                <textarea class="form-control" name="deskripsi_respon" id="myeditorinstance" cols="30" rows="10"></textarea>
                                <button type="submit" class="btn btn-success mt-5">Kirim</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($user->user_category == 2)
            <div class="col-xxl-3 col-xl-4">
                <div class="row g-3 position-sticky top-0">
                    <div class="col-md-6 col-xl-12">
                        <div class="card">
                            <form action="{{ route('open-tickets.update', $ticket->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="card-header">
                                    <h6 class="mb-0">Properties</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2 mt-n2"><label class="mb-1">Jenis Request</label>
                                        <select name="id_jenis_request" class="form-select form-select-sm"
                                            {{ $ticket->status_request != 'RESPONDED' ? 'disabled' : '' }}>
                                            <option disabled selected>--Pilih Jenis Request---</option>
                                            @foreach ($jenis_requests as $request)
                                                <option
                                                    {{ $ticket->id_jenis_request == $request->id_jenis_request ? 'selected' : '' }}
                                                    value="{{ $request->id_jenis_request }}">
                                                    {{ $request->jenis_request }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if (
                                        ($ticket->status_request != 'PENDING' || $ticket->status_request == 'RESPONDED') &&
                                            $ticket->status_request != 'COMPLETE')
                                        <div class="mb-2"><label class="mb-1 mt-2">Status</label>
                                            <select name="status_request" class="form-select form-select-sm"
                                                {{ $ticket->status_request != 'RESPONDED' ? 'disabled' : '' }}>
                                                <option disabled selected>--Pilih Status---</option>
                                                <option {{ $ticket->status_request == 'PROSES KE WR' ? 'selected' : '' }}
                                                    value="PROSES KE WR">Proses ke WR</option>
                                                <option {{ $ticket->status_request == 'PROSES KE PERMIT' ? 'selected' : '' }}
                                                    value="PROSES KE PERMIT">Proses ke Permit</option>
                                                <option {{ $ticket->status_request == 'PROSES KE RESERVASI' ? 'selected' : '' }}
                                                    value="PROSES KE RESERVASI">Proses ke Reservasi</option>
                                                <option {{ $ticket->status_request == 'PROSES KE GIGO' ? 'selected' : '' }}
                                                    value="PROSES KE GIGO">Proses ke GIGO</option>
                                                <option {{ $ticket->status_request == 'DONE' ? 'selected' : '' }}
                                                    value="DONE">DONE</option>
                                            </select>
                                        </div>
                                    @elseif ($ticket->status_request == 'COMPLETE')
                                        <div class="mb-3">
                                            <div class="mb-2"><label class="mb-1 mt-2">Status</label>
                                                <input type="text" value="{{ $ticket->status_request }}"
                                                    class="form-control" disabled>
                                            </div>
                                    @endif
                                </div>
                                @if ($ticket->status_request == 'RESPONDED')
                                    <div class="card-footer border-top border-200 py-x1">
                                        <button class="btn btn-primary w-100">Update</button>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="card">
                            <div class="card-header d-flex flex-between-center py-3">
                                <h6 class="mb-0">Contact Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-0 border-bottom pb-x1 mb-x1 align-items-sm-center align-items-xl-start">
                                    <div class="col-12 col-sm-auto col-xl-12 me-sm-3 me-xl-0">
                                        <div class="avatar avatar-3xl">
                                            <img class="rounded-circle" src="{{ url($ticket->Tenant->profile_picture) }}"
                                                alt="" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-auto col-xl-12">
                                        <p class="fw-semi-bold text-800 mb-0">{{ $ticket->Tenant->nama_tenant }}</p><a
                                            class="btn btn-link btn-sm p-0 fe-medium fs--1" href="#">View more
                                            details</a>
                                    </div>
                                </div>
                                <div class="row g-0 justify-content-lg-between">
                                    <div class="col-auto col-md-6 col-lg-auto">
                                        <div class="row">
                                            <div class="col-md-auto mb-4 mb-md-0 mb-xl-4">
                                                <h6 class="mb-1">Email</h6><a class="fs--1"
                                                    href="mailto:mattrogers@gmail.com">{{ $ticket->Tenant->email_tenant }}</a>
                                            </div>
                                            <div class="col-md-auto mb-4 mb-md-0 mb-xl-4">
                                                <h6 class="mb-1">Phone Number</h6><a class="fs--1"
                                                    href="tel:+6(855)747677">{{ $ticket->Tenant->no_telp_tenant }}</a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto mb-4 mb-md-0 mb-xl-4">
                                                <h6 class="mb-1">Unit</h6><a class="fs--1"
                                                    href="mailto:mattrogers@gmail.com">Lantai :
                                                    {{ $ticket->Unit->floor->nama_lantai }},
                                                    {{ $ticket->Unit->nama_unit }}</a>
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
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('script')
    <script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'code table lists',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
        });
    </script>
    <script>
        function onReply() {
            $('#response').css('display', 'block')
            $('#btnReply').css('display', 'none')
        }
    </script>
@endsection
