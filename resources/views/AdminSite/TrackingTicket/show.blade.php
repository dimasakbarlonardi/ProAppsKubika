@extends('layouts.master')

@section('css')
    <script src="https://cdn.tiny.cloud/1/zfyksst4gxwae7gxmgzef4p86481o6u0hqh00100y0xgkyts/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
@endsection

@section('content')
    <div class="row g-3">

        <div class="col-xxl-9 col-xl-8">
            <div class="card overflow-hidden">
                <div class="card-header p-0 scrollbar-overlay border-bottom">
                    <ul class="nav nav-tabs border-0 tab-contact-details flex-nowrap" id="contact-details-tab" role="tablist">
                        <li class="nav-item text-nowrap" role="presentation">
                            <a class="nav-link mb-0 d-flex align-items-center gap-1 py-3 px-x1 active"
                                id="contact-timeline-tab" data-bs-toggle="tab" href="#timeline" role="tab"
                                aria-controls="timeline" aria-selected="true">
                                <span class="fas fa-stream icon text-white"></span>
                                <h6 class="mb-0">Timeline</h6>
                            </a>
                        </li>
                        <li class="nav-item text-nowrap" role="presentation">
                            <a class="nav-link mb-0 d-flex align-items-center gap-1 py-3 px-x1" id="contact-tickets-tab"
                                data-bs-toggle="tab" href="#tickets" role="tab" aria-controls="tickets"
                                aria-selected="false">
                                <span class="fas fa-ticket-alt icon  text-white"></span>
                                <h6 class="mb-0">Detail Tickets</h6>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="card-body tab-pane active" id="timeline" role="tabpanel"
                        aria-labelledby="contact-timeline-tab">
                        <div class="timeline-vertical py-0">

                            <div id="tracking-data">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="card-body tab-pane" id="tickets" role="tabpanel"
                        aria-labelledby="contact-tickets-tab">
                        <div class="tickets-vertical py-0">
                            <div class="card mt-3">
                                <div class="card-header bg-light">
                                    <h5><span class="fas fa-ticket-alt me-2"></span><span> {{ $ticket->no_tiket }}</span>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="request">
                                        <div
                                            class="d-md-flex d-xl-inline-block d-xxl-flex align-items-center justify-content-between mb-x1">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="avatar avatar-2xl">
                                                    <img class="rounded-circle"
                                                        src="{{ url($ticket->Tenant->profile_picture) }}"
                                                        alt="" />
                                                </div>
                                                <p class="mb-0"><a class="fw-semi-bold mb-0 text-800"
                                                        href="../../app/support-desk/contact-details.html">{{ $ticket->Tenant->User->nama_user }}</a>
                                                    <a class="mb-0 fs--1 d-block text-500"
                                                        href="mailto:emma@watson.com">{{ $ticket->Tenant->User->login_user }}</a>
                                                </p>
                                            </div>
                                            <p class="mb-0 fs--2 fs-sm--1 fw-semi-bold mt-2 mt-md-0 mt-xl-2 mt-xxl-0 ms-5">
                                                {{ HumanDate($ticket->created_at) }}
                                                <span class="mx-1">|</span><span
                                                    class="fst-italic">{{ HumanTime($ticket->created_at) }}
                                                    ({{ TimeAgo($ticket->created_at) }})</span>
                                            </p>
                                        </div>
                                        <div>
                                            <h6 class="mb-3 fw-semi-bold text-1000">{{ $ticket->judul_request }}</h6>
                                            {!! $ticket->deskripsi_request !!}
                                            @if ($ticket->upload_image)
                                                <div class="px-x1 py-3 bg-light">
                                                    <div class="d-inline-flex flex-column">
                                                        <div
                                                            class="border p-2 rounded-3 d-flex bg-white dark__bg-1000 fs--1 mb-2">
                                                            <a class="ms-auto text-decoration-none" target="_blank"
                                                                href="{{ url($ticket->upload_image) }}">
                                                                <span class="fs-1 far fa-image"></span>
                                                                <span class="ms-2 me-3">Image</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
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
                                            <form action="{{ route('updateRequestTicket', $ticket->id) }}"
                                                method="post">
                                                @csrf
                                                <textarea class="form-control" name="deskripsi_respon" id="myeditorinstance" cols="30" rows="10"></textarea>
                                                <button type="submit" class="btn btn-success mt-5">Kirim</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-3 col-xl-4 position-sticky top-0">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Properties</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2 mt-n2"><label class="mb-1">Jenis Request</label>
                        <input type="text" class="form-control" value="{{ $ticket->JenisRequest->jenis_request }}"
                            disabled>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
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
                            <p class="fw-semi-bold text-800 mb-0">{{ $ticket->Tenant->User->nama_user }}</p><a
                                class="btn btn-link btn-sm p-0 fe-medium fs--1" href="#">View more
                                details</a>
                        </div>
                    </div>
                    <div class="row g-0 justify-content-lg-between">
                        <div class="col-auto col-md-6 col-lg-auto">
                            <div class="row">
                                <div class="col-md-auto mb-4 mb-md-0 mb-xl-4">
                                    <h6 class="mb-1">Email</h6><a class="fs--1"
                                        href="mailto:mattrogers@gmail.com">{{ $ticket->Tenant->User->login_user }}</a>
                                </div>
                                <div class="col-md-auto mb-4 mb-md-0 mb-xl-4">
                                    <h6 class="mb-1">Phone Number</h6><a class="fs--1"
                                        href="tel:+6(855)747677">{{ $ticket->no_hp }}</a>
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
@endsection

@section('script')
    <script src="https://cdn.tiny.cloud/1/zfyksst4gxwae7gxmgzef4p86481o6u0hqh00100y0xgkyts/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'code table lists',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
        });

        $('document').ready(function() {
            let id = '{{ $ticket->id }}';
            let token = "{{ Request::session()->get('token') }}";
            console.log(token);
            $.ajax({
                url: `/api/v1/track-ticket/${id}`,
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                type: 'GET',
                success: function(resp) {
                    $('#tracking-data').html(resp.html);
                    console.log(resp.objects);
                }
            })
        })
    </script>
    <script>
        function onReply() {
            $('#response').css('display', 'block')
            $('#btnReply').css('display', 'none')
        }
    </script>
@endsection
