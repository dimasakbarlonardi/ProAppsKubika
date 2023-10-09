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
                                <div class="col-auto">
                                    <h5 class="mb-0 text-white">Tracking Request
                                        <span class=" fas fa-ticket-alt"></span>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="border-bottom border-200 my-3"></div>
                        <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
                            <div class="search-box">
                                <form class="position-relative">
                                    <input class="form-control search-input fuzzy-search" type="search"
                                        placeholder="Search ticket by no ticket" aria-label="Search" id="search_form" />
                                    <span class="fas fa-search search-box-icon"></span>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0" id="list_tickets">
                    @foreach ($tickets as $ticket)
                        <div class="list bg-light p-x1 d-flex flex-column gap-3">
                            <div
                                class="d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                                <div class="d-flex align-items-start align-items-sm-center">
                                    <a class="d-none d-sm-block" href="">
                                        <div class="avatar avatar-xl avatar-3xl">
                                            <div class="avatar-name rounded-circle">
                                                <img src="{{ $ticket->Tenant->User->profile_picture ? url($ticket->Tenant->User->profile_picture) : '/assets/img/icons/spot-illustrations/proapps.png' }}"
                                                    alt="{{ $ticket->Tenant->User->profile_picture }}" class="avatar-image" />
                                            </div>
                                        </div>
                                    </a>
                                    <div class="ms-1 ms-sm-3">
                                        <p class="fw-semi-bold mb-3 mb-sm-2">
                                            <a href="{{ route('trackingTicketShow', $ticket->id) }}" class="mr-5">Ticket
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
                                                        <span>{{ $ticket->Tenant->User->nama_user }}</span>
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

                                                    @case('WORK DONE')
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
        var tickets = [];

        $('#search_form').on('input', function() {
            var tickets = [];
            var input = $(this).val();

            $('#list_tickets').html("");

            $.ajax({
                url: '/admin/tracking-tickets',
                type: 'GET',
                dataType: 'json',
                data: {
                    input
                },
                success: function(resp) {
                    tickets.push(resp.data)
                }
            })
        })

        $('document').on('ready', function() {
            tickets.map((ticket, i) => {
                // $('#list_tickets').html(`
                //     <div class="list bg-light p-x1 d-flex flex-column gap-3">
                //         <div
                //             class="d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                //             <div class="d-flex align-items-start align-items-sm-center">
                //                 <a class="d-none d-sm-block" href="">
                //                     <div class="avatar avatar-xl avatar-3xl">
                //                         <div class="avatar-name rounded-circle">
                //                             <img src=""
                //                                 alt="" class="avatar-image" />
                //                         </div>
                //                     </div>
                //                 </a>
                //                 <div class="ms-1 ms-sm-3">
                //                     <p class="fw-semi-bold mb-3 mb-sm-2">
                //                         <a href="" class="mr-5">Ticket
                //                             #${ticket.no_tiket}</a>
                //                         <span class="badge bg-info ml-">
                //                             Pendahuluan
                //                         </span>
                //                     </p>
                //                     <div class="d-flex justify-content-between">
                //                         <div class="my-1">
                //                             <h5>Asyik</h5>
                //                         </div>
                //                     </div>
                //                     <div class="row align-items-center gx-0 gy-2">
                //                         <div class="col-auto me-2">
                //                             <h6 class="client mb-0">
                //                                 <a class="text-800 d-flex align-items-center gap-1" href="">
                //                                     <span class="fas fa-user" data-fa-transform="shrink-3 up-1"></span>
                //                                     <span>Rahasia</span>
                //                                 </a>
                //                             </h6>
                //                         </div>
                //                         <div class="col-auto lh-1 me-3">
                //                                 <small class="badge rounded bg-warning dark__bg-1000">Pending</small>
                //                         </div>
                //                         <div class="col-auto">
                //                             <h6 class="mb-0 text-500">

                //                             </h6>
                //                         </div>
                //                     </div>
                //                 </div>
                //             </div>
                //         </div>
                //     </div>
                // `);
            })
        })
    </script>
@endsection
