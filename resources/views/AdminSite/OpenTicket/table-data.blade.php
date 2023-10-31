@foreach ($tickets as $ticket)
    <div class="list bg-light p-x1 d-flex flex-column gap-3" id="card-ticket-body">
        <div class="d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
            <div class="d-flex align-items-start align-items-sm-center">
                <div class="avatar avatar-xl avatar-3xl">
                    <div class="avatar-name rounded-circle">
                        <img src="{{ url($ticket->Tenant->profile_picture) }}" alt="image" class="avatar-image" />
                    </div>
                </div>

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
                                    <small class="badge rounded bg-warning dark__bg-1000">{{ $ticket->status_request }}</small>
                                @break

                                @case('APPROVED')
                                    <small class="badge rounded bg-success dark__bg-1000">{{ $ticket->status_request }}</small>
                                @break

                                @case('RESPONDED')
                                    <small class="badge rounded bg-info dark__bg-1000">{{ $ticket->status_request }}</small>
                                @break

                                @case('PROSES')
                                    <small class="badge rounded bg-info dark__bg-1000">{{ $ticket->status_request }}</small>
                                @break

                                @case('PROSES KE WR')
                                    <small class="badge rounded bg-info dark__bg-1000">{{ $ticket->status_request }}</small>
                                @break

                                @case('PROSES KE PERMIT')
                                    <small class="badge rounded bg-info dark__bg-1000">{{ $ticket->status_request }}</small>
                                @break

                                @case('WORK DONE')
                                    <small class="badge rounded bg-info dark__bg-1000">{{ $ticket->status_request }}</small>
                                @break

                                @case('ON WORK')
                                    <small class="badge rounded bg-info dark__bg-1000">{{ $ticket->status_request }}</small>
                                @break

                                @case('DONE')
                                    <small class="badge rounded bg-success dark__bg-1000">{{ $ticket->status_request }}</small>
                                @break

                                @case('REJECTED')
                                    <small class="badge rounded bg-danger">{{ $ticket->status_request }}</small>
                                @break

                                @case('COMPLETE')
                                    <small class="badge rounded bg-success dark__bg-1000">{{ $ticket->status_request }}</small>
                                @break
                            @endswitch
                            <small class="badge rounded bg-warning dark__bg-1000">{{ $ticket->priority }}</small>
                        </div>
                        <div class="col-auto">
                            <h6 class="mb-0 text-500">
                                <!-- {{ \Carbon\Carbon::createFromTimeStamp(strtotime($ticket->created_at))->diffForHumans() }} -->
                            </h6>
                        </div>
                        <div class="col-auto">
                            @if ($ticket->CashReceipt)
                                Status payment :
                                <a class="mb-0" href="{{ route('showInvoices', $ticket->CashReceipt->id) }}">
                                    <span
                                        class="badge bg-{{ $ticket->CashReceipt->transaction_status == 'PAID' ? 'success' : 'warning' }}">{{ $ticket->CashReceipt->transaction_status }}</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
