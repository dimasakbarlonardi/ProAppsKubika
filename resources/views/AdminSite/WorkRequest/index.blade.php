@extends('layouts.master')

@section('content')
    <div class="row gx-3">
        <div class="col-xxl-10 col-xl-9">
            <div class="card" id="ticketsTable"
                data-list='{"valueNames":["client","subject","status","priority","agent"],"page":7,"pagination":true,"fallback":"tickets-card-fallback"}'>
                <div class="card-header border-bottom border-200 px-0">
                    <div class="d-lg-flex justify-content-between">
                        <div class="row flex-between-center gy-2 px-x1">
                            <div class="col-auto pe-0">
                                <h6 class="mb-0">Work Requests</h6>
                            </div>
                            <div class="col-auto">
                                <form>
                                    <div class="input-group input-search-width"><input
                                            class="form-control form-control-sm shadow-none search" type="search"
                                            placeholder="Search by name" aria-label="search" />

                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="border-bottom border-200 my-3"></div>
                        <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
                            <button class="btn btn-sm btn-falcon-default d-xl-none" type="button"
                                data-bs-toggle="offcanvas" data-bs-target="#ticketOffcanvas"
                                aria-controls="ticketOffcanvas"><span class="fas fa-filter"
                                    data-fa-transform="shrink-4 down-1"></span><span
                                    class="ms-1 d-none d-sm-inline-block">Filter</span></button>
                            <div class="bg-300 mx-3 d-none d-lg-block d-xl-none" style="width:1px; height:29px">
                            </div>
                            <div class="d-flex align-items-center" id="table-ticket-replace-element">
                                <a href="{{ route('work-requests.create') }}" class="btn btn-falcon-default btn-sm mx-2"
                                    type="button">
                                    <span class="fas fa-plus" data-fa-transform="shrink-3"></span>
                                    <span class="d-none d-sm-inline-block d-xl-none d-xxl-inline-block ms-1">New</span>
                                    <span>
                                        Buat Work Request Baru</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @foreach ($work_requests as $wr)
                        <div class="list bg-light p-x1 d-flex flex-column gap-3" id="card-ticket-body">
                            <div
                                class="d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                                <div class="d-flex align-items-start align-items-sm-center">
                                    <a class="d-none d-sm-block" href="">
                                        <div class="avatar avatar-xl avatar-3xl">
                                            <div class="avatar-name rounded-circle">
                                                <img src="{{ $wr->Ticket->Tenant->profile_picture }}"
                                                    alt="{{ $wr->Ticket->Tenant->profile_picture }}" class="avatar-image" />
                                            </div>
                                        </div>
                                    </a>
                                    <div class="ms-1 ms-sm-3">
                                        <p class="fw-semi-bold mb-3 mb-sm-2">
                                            <a
                                                href="
                                            {{ $user->id_role_hdr != 8
                                                ? route('work-requests.show', $wr->id)
                                                : ($wr->status_request == 'ON WORK'
                                                    ? route('work-requests.show', $wr->id)
                                                    : route('open-tickets.show', $wr->Ticket->id)) }}
                                            ">Work
                                                Request
                                                #{{ $wr->no_work_request }}</a>
                                        </p>
                                        <div class="d-flex justify-content-between">
                                            <div class="">
                                                <h5>{{ $wr->judul_request }}</h5>
                                            </div>
                                        </div>
                                        <div class="row align-items-center gx-0 gy-2">
                                            <div class="col-auto me-2">
                                                <h6 class="client mb-0">
                                                    <a class="text-800 d-flex align-items-center gap-1" href="">
                                                        <span class="fas fa-user" data-fa-transform="shrink-3 up-1"></span>
                                                        <span>{{ $wr->Ticket->Tenant->nama_tenant }}</span>
                                                    </a>
                                                </h6>
                                            </div>
                                            <div class="col-auto">
                                                <h6 class="mb-0 text-500">{{ TimeAgo($wr->created_at) }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="">
                                        <h5>{{ $wr->judul_request }}</h5>
                                    </div>
                                    <div class="row text-right">
                                        <div class="">
                                            <span
                                                class="badge rounded-pill badge-subtle-primary">{{ $wr->workRelation->work_relation }}</span>
                                            @switch($wr->status_request)
                                                @case('PENDING')
                                                    <span
                                                        class="badge rounded bg-warning red__bg-1000">{{ $wr->status_request }}</span>
                                                @break
                                                @case('WORK ORDER')
                                                    <span
                                                        class="badge rounded bg-info red__bg-1000">{{ $wr->status_request }}</span>
                                                @break
                                                @case('DONE')
                                                    <span
                                                        class="badge rounded bg-success red__bg-1000">{{ $wr->status_request }}</span>
                                                @break

                                                @default
                                            @endswitch

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center"><button class="btn btn-sm btn-falcon-default me-1"
                            type="button" title="Previous" data-list-pagination="prev"><span
                                class="fas fa-chevron-left"></span></button>
                        <ul class="pagination mb-0"></ul><button class="btn btn-sm btn-falcon-default ms-1" type="button"
                            title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-2 col-xl-3">
            <div class="offcanvas offcanvas-end offcanvas-filter-sidebar border-0 dark__bg-card-dark h-auto rounded-xl-3"
                tabindex="-1" id="ticketOffcanvas" aria-labelledby="ticketOffcanvasLabelCard">
                <div class="offcanvas-header d-flex flex-between-center d-xl-none">
                    <h6 class="fs-0 mb-0 fw-semi-bold">Filter</h6><button class="btn-close text-reset d-xl-none shadow-none"
                        id="ticketOffcanvasLabelCard" type="button" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="card scrollbar shadow-none shadow-show-xl">
                    <div class="card-header d-none d-xl-block">
                        <h6 class="mb-0">Filter</h6>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-2 mt-n2"><label class="mb-1">Priority</label><select
                                    class="form-select form-select-sm">
                                    <option>None</option>
                                    <option>Urgent</option>
                                    <option>High</option>
                                    <option>Medium</option>
                                    <option>Low</option>
                                </select></div>
                        </form>
                    </div>
                    <div class="card-footer border-top border-200 py-x1"><button
                            class="btn btn-primary w-100">Search</button></div>
                </div>
            </div>
        </div>
    </div>
@endsection
