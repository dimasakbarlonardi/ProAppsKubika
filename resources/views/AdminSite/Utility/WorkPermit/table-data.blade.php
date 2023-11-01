@foreach ($work_permits as $wp)
    <div class="list bg-light p-x1 d-flex flex-column gap-3" id="card-ticket-body">
        <div class="d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
            <div class="d-flex align-items-start align-items-sm-center">
                <a class="d-none d-sm-block" href="">
                    <div class="avatar avatar-xl avatar-3xl">
                        <div class="avatar-name rounded-circle">
                            <img src="{{ $wp->Ticket->Tenant->profile_picture }}"
                                alt="{{ $wp->Ticket->Tenant->profile_picture }}" class="avatar-image" />
                        </div>
                    </div>
                </a>
                <div class="ms-1 ms-sm-3">
                    <p class="fw-semi-bold mb-3 mb-sm-2">
                        <a href="{{ route('work-permits.show', $wp->id) }}">Work Permit
                            #{{ $wp->no_work_permit }}</a>
                    </p>
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <h5>{{ $wp->judul_request }}</h5>
                        </div>
                    </div>
                    <div class="row align-items-center gx-0 gy-2">
                        <div class="col-auto me-2">
                            <h6 class="client mb-0">
                                <a class="text-800 d-flex align-items-center gap-1" href="">
                                    <span class="fas fa-user" data-fa-transform="shrink-3 up-1"></span>
                                    <span>{{ $wp->Ticket->Tenant->nama_tenant }}</span>
                                </a>
                            </h6>
                        </div>
                        <div class="col-auto">
                            <h6 class="mb-0 text-500">{{ TimeAgo($wp->created_at) }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between text-end">
                <div class="">
                    <h5>{{ $wp->judul_request }}</h5>
                </div>
                <div class="row text-right">
                    <div class="">
                        <span
                            class="badge rounded-pill badge-subtle-primary">{{ $wp->workRelation->work_relation }}</span>
                        @switch($wp->status_request)
                            @case('PENDING')
                                <span class="badge rounded bg-warning red__bg-1000">{{ $wp->status_request }}</span>
                            @break

                            @case('REJECTED')
                                <span class="badge rounded bg-danger red__bg-1000">{{ $wp->status_request }}</span>
                            @break

                            @case('APPROVED')
                                <span class="badge rounded bg-success red__bg-1000">{{ $wp->status_request }}</span>
                            @break

                            @default
                        @endswitch
                        @if ($wp->status_bayar == 'PAID')
                            <span class="badge rounded bg-success">{{ $wp->status_bayar }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
