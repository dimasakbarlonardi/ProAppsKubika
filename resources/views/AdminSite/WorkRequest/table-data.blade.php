@foreach ($work_requests as $wr)
<div class="list bg-light p-x1 d-flex flex-column gap-3" id="card-ticket-body">
    <div class="d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
        <div class="d-flex align-items-start align-items-sm-center">
            <a class="d-none d-sm-block" href="">
                <div class="avatar avatar-xl avatar-3xl">
                    <div class="avatar-name rounded-circle">
                        <img src="{{ $wr->Ticket->Tenant->profile_picture }}" alt="{{ $wr->Ticket->Tenant->profile_picture }}" class="avatar-image" />
                    </div>
                </div>
            </a>
            <div class="ms-1 ms-sm-3">
                <p class="fw-semi-bold mb-3 mb-sm-2">
                    <a href="
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
        <div class="d-flex justify-content-between text-end">
            <div class="">
                <h5>{{ $wr->judul_request }}</h5>
            </div>

            <span class="badge rounded-pill badge-subtle-primary">
                {{ $wr->workRelation->work_relation }}
            </span>
            <h6 class="ml-3">
                <span class="badge rounded bg-warning red__bg-1000">
                    {{ $wr->Ticket->priority }}
                </span>
                @switch($wr->status_request)
                @case('PENDING')
                <span class="badge rounded bg-warning red__bg-1000">{{ $wr->status_request }}</span>
                @break

                @case('WORK DONE')
                <span class="badge rounded bg-success red__bg-1000">{{ $wr->status_request }}</span>
                @break

                @case('COMPLETE')
                <span class="badge rounded bg-success red__bg-1000">{{ $wr->status_request }}</span>
                @break

                @case('WORK ORDER')
                <span class="badge rounded bg-info red__bg-1000">{{ $wr->status_request }}</span>
                @break

                @case('ON WORK')
                <span class="badge rounded bg-info red__bg-1000">{{ $wr->status_request }}</span>
                @break

                @case('DONE')
                <span class="badge rounded bg-success red__bg-1000">{{ $wr->status_request }}</span>
                @break

                @default
                @endswitch
            </h6>

        </div>
    </div>
</div>
@endforeach