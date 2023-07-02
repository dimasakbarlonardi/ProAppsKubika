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
                                <h6 class="mb-0">All tickets</h6>
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
                                <a href="{{ route('open-tickets.create') }}" class="btn btn-falcon-default btn-sm mx-2"
                                    type="button">
                                    <span class="fas fa-plus" data-fa-transform="shrink-3"></span>
                                    <span class="d-none d-sm-inline-block d-xl-none d-xxl-inline-block ms-1">New</span>
                                    <span>
                                        Buat Tiket Baru</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @foreach ($tickets as $ticket)
                        <div class="list bg-light p-x1 d-flex flex-column gap-3" id="card-ticket-body">
                            <div
                                class="d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                                <div class="d-flex align-items-start align-items-sm-center">
                                    <a class="d-none d-sm-block" href="">
                                        <div class="avatar avatar-xl avatar-3xl">
                                            <div class="avatar-name rounded-circle">
                                                <img src="{{ $ticket->Tenant->profile_picture ? url($ticket->Tenant->profile_picture) : '/assets/img/icons/spot-illustrations/proapps.png' }}"
                                                    alt="{{ $ticket->Tenant->profile_picture }}" class="avatar-image" />
                                            </div>
                                        </div>
                                    </a>
                                    <div class="ms-1 ms-sm-3">
                                        <p class="fw-semi-bold mb-3 mb-sm-2">
                                            <a href="{{ route('open-tickets.show', $ticket->id) }}" class="mr-5">Ticket
                                                #{{ $ticket->no_tiket }}</a>
                                            <span class="badge bg-info ml-">
                                                {{ $ticket->jenisRequest->jenis_request }}
                                            </span>
                                        </p>
                                        <div class="d-flex justify-content-between">
                                            <div class="my-1">
                                                <h5>{{ $ticket->judul_request }}</h5>
                                            </div>
                                        </div>
                                        <div class="row align-items-center gx-0 gy-2">
                                            <div class="col-auto me-2">
                                                <h6 class="client mb-0">
                                                    <a class="text-800 d-flex align-items-center gap-1" href="">
                                                        <span class="fas fa-user" data-fa-transform="shrink-3 up-1"></span>
                                                        <span>{{ $ticket->Tenant->nama_tenant }}</span>
                                                    </a>
                                                </h6>
                                            </div>
                                            <div class="col-auto lh-1 me-3">
                                                @switch($ticket->status_request)
                                                    @case('PENDING')
                                                        <small
                                                            class="badge rounded bg-warning dark__bg-1000">{{ $ticket->status_request }}</small>
                                                    @break

                                                    @case('RESPONDED')
                                                        <small
                                                            class="badge rounded bg-info dark__bg-1000">{{ $ticket->status_request }}</small>
                                                    @break

                                                    @case('PROSES')
                                                        <small
                                                            class="badge rounded bg-info dark__bg-1000">{{ $ticket->status_request }}</small>
                                                    @break
                                                    @case('PROSES KE WR' || 'PROSES KE PERMIT')
                                                        <small
                                                            class="badge rounded bg-info dark__bg-1000">{{ $ticket->status_request }}</small>
                                                    @break

                                                    @case('ON WORK')
                                                        <small
                                                            class="badge rounded bg-info dark__bg-1000">{{ $ticket->status_request }}</small>
                                                    @break

                                                    @case('DONE')
                                                        <small
                                                            class="badge rounded bg-success dark__bg-1000">{{ $ticket->status_request }}</small>
                                                    @break

                                                    @case('COMPLETE')
                                                        <small
                                                            class="badge rounded bg-success dark__bg-1000">{{ $ticket->status_request }}</small>
                                                    @break
                                                @endswitch
                                            </div>
                                            <div class="col-auto">
                                                <h6 class="mb-0 text-500">
                                                    {{ \Carbon\Carbon::createFromTimeStamp(strtotime($ticket->created_at))->diffForHumans() }}
                                                </h6>
                                            </div>
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
                            class="btn btn-primary w-100">Update</button></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('document').ready(function() {
            $('#time_difference').html('asd')
        })
    </script>
@endsection
