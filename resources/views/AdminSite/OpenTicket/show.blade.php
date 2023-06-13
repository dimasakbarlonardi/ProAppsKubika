@extends('layouts.master')

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
                    <h5><span class="fas fa-envelope me-2"></span><span>Received a broken TV</span></h5>
                </div>
                <div class="card-body">
                    <div class="request border-bottom mb-5 pb-5">
                        <div
                            class="d-md-flex d-xl-inline-block d-xxl-flex align-items-center justify-content-between mb-x1">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-2xl">
                                    <img class="rounded-circle" src="/assets/img/team/1-thumb.png" alt="" />
                                </div>
                                <p class="mb-0"><a class="fw-semi-bold mb-0 text-800"
                                        href="../../app/support-desk/contact-details.html">Emma Waston</a><span
                                        class="fs--2 text-800 fw-normal mx-2">via email</span><a
                                        class="mb-0 fs--1 d-block text-500"
                                        href="mailto:emma@watson.com">emma@watson.com</a>
                                </p>
                            </div>
                            <p class="mb-0 fs--2 fs-sm--1 fw-semi-bold mt-2 mt-md-0 mt-xl-2 mt-xxl-0 ms-5">01 March,
                                2020<span class="mx-1">|</span><span class="fst-italic">8:40 AM (1 Day ago)</span><span
                                    class="fas fa-star ms-2 text-warning"></span></p>
                        </div>
                        <div>
                            <h6 class="mb-3 fw-semi-bold text-1000">Improve in A purposed Manner</h6>
                            <p>Hi</p>
                            <p>The television I ordered from your site was delivered with a cracked screen. I need some help
                                with a refund or a replacement.</p>
                            <p>Here is the order number FD07062010</p>
                            <p class="mb-0">Thanks</p>
                            <p class="mb-0">Emma Watson</p>
                            <div class="p-x1 bg-light rounded-3 mt-3">
                                <div class="d-inline-flex flex-column">
                                    <div class="border p-2 rounded-3 d-flex bg-white dark__bg-1000 fs--1 mb-2"><span
                                            class="fs-1 far fa-image"></span><span class="ms-2 me-3">broken_tv_solve.jpg
                                            (873kb)</span><a class="text-300 ms-auto" href="#!"
                                            data-bs-toggle="tooltip" data-bs-placement="right" title="Download"><span
                                                class="fas fa-arrow-down"></span></a></div>
                                </div>
                                <hr class="my-x1" />
                                <div class="row flex-between-center gx-4 gy-2">
                                    <div class="col-auto">
                                        <p class="fs--1 text-1000 mb-sm-0 font-sans-serif fw-medium mb-0"><span
                                                class="fas fa-link me-2"></span>1 files attached</p>
                                    </div>
                                    <div class="col-auto"><button class="btn btn-falcon-default btn-sm"><span
                                                class="fas fa-file-download me-2"></span>Download all</button></div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer text-end" id="preview-footer">
                            <button class="btn btn-falcon-default btn-sm fs--1" type="button" data-bs-toggle="collapse"
                                data-bs-target="#previewMailForm" aria-expanded="false" aria-controls="previewMailForm">
                                <span class="fas fa-reply"></span>
                                <span class="d-none d-sm-inline-block ms-1">Reply</span>
                            </button>
                        </div>
                    </div>
                    @if ($ticket->status_respon != null)
                        <div class="response">
                            <div
                                class="d-md-flex d-xl-inline-block d-xxl-flex align-items-center justify-content-between mb-x1">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar avatar-2xl">
                                        <img class="rounded-circle" src="/assets/img/team/1-thumb.png" alt="" />
                                    </div>
                                    <p class="mb-0"><a class="fw-semi-bold mb-0 text-800"
                                            href="../../app/support-desk/contact-details.html">Mike</a><span
                                            class="fs--2 text-800 fw-normal mx-2">replied</span><a
                                            class="mb-0 fs--1 d-block text-500"
                                            href="mailto:mike@support.com">mike@support.com</a></p>
                                </div>
                                <p class="mb-0 fs--2 fs-sm--1 fw-semi-bold mt-2 mt-md-0 mt-xl-2 mt-xxl-0 ms-5">01 March,
                                    2020<span class="mx-1">|</span><span class="fst-italic">8:40 AM (1 Day
                                        ago)</span><span class="fas fa-star ms-2 text-warning"></span></p>
                            </div>
                            <div class="border-bottom mb-5 pb-5">
                                <h6 class="mb-3 fw-semi-bold text-1000">Television with cracked screen</h6>
                                <p>Hi Emma Waston,</p>
                                <p>I am sorry to hear about your experience with our TV. It sounds like you received a
                                    damaged
                                    product. Please provide me with the order number and we will work to resolve this issue
                                    as
                                    quickly as possible.</p>
                                <p>We are here to help!</p>
                                <p class="mb-0">Thanks</p>
                                <p class="mb-0">Customer Support</p>
                            </div>
                        </div>
                    @endif
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
                                        <select name="id_jenis_request" class="form-select form-select-sm">
                                            <option disabled selected>--Pilih Jenis Request---</option>
                                            @foreach ($jenis_requests as $request)
                                                <option {{ $ticket->id_jenis_request == $request->id_jenis_request ? 'selected' : '' }} value="{{ $request->id_jenis_request }}">
                                                    {{ $request->jenis_request }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2"><label class="mb-1 mt-2">Status</label>
                                        <select name="status_request" class="form-select form-select-sm">
                                            <option disabled selected>--Pilih Status---</option>
                                            <option value="PENDING">Pending</option>
                                            <option value="RESPONDED">Responded</option>
                                            <option value="PROSES">Proses</option>
                                            <option value="CLOSED">CLosed</option>
                                            <option value="DONE">Done</option>
                                        </select>
                                    </div>
                                    <div class="mb-2"><label class="mb-1 mt-2">Work Priority</label>
                                        <select name="id_work_prior" class="form-select form-select-sm">
                                            <option disabled selected>--Pilih Work Priority---</option>
                                            @foreach ($work_priorities as $wp)
                                                <option value="{{ $wp->id_work_priority }}">
                                                    {{ $wp->work_priority }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2"><label class="mb-1 mt-2">Work Relation</label>
                                        <select name="id_work_relation" class="form-select form-select-sm">
                                            <option disabled selected>--Pilih Work Relation---</option>
                                            @foreach ($work_relations as $relation)
                                                <option value="{{ $relation->id_work_relation }}">
                                                    {{ $relation->work_relation }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="card-footer border-top border-200 py-x1">
                                    <button class="btn btn-primary w-100">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex flex-between-center py-3">
                                <h6 class="mb-0">Contact Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-0 border-bottom pb-x1 mb-x1 align-items-sm-center align-items-xl-start">
                                    <div class="col-12 col-sm-auto col-xl-12 me-sm-3 me-xl-0">
                                        <div class="avatar avatar-3xl">
                                            <img class="rounded-circle" src="../../assets/img/team/1.jpg"
                                                alt="" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-auto col-xl-12">
                                        <p class="fw-semi-bold text-800 mb-0">Emma Watson</p><a
                                            class="btn btn-link btn-sm p-0 fe-medium fs--1"
                                            href="../../app/support-desk/contact-details.html">View more details</a>
                                    </div>
                                </div>
                                <div class="row g-0 justify-content-lg-between">
                                    <div class="col-auto col-md-6 col-lg-auto">
                                        <div class="row">
                                            <div class="col-md-auto mb-4 mb-md-0 mb-xl-4">
                                                <h6 class="mb-1">Email</h6><a class="fs--1"
                                                    href="mailto:mattrogers@gmail.com">mattrogers@gmail.com</a>
                                            </div>
                                            <div class="col-md-auto mb-4 mb-md-0 mb-xl-4">
                                                <h6 class="mb-1">Phone Number</h6><a class="fs--1"
                                                    href="tel:+6(855)747677">+6(855) 747 677</a>
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
