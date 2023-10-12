@extends('layouts.master')

@section('content')
    <div class="row gx-3">
        <div class="col-xxl-9 col-xl-9">
            <div class="card">
                <div class="card-header p-3 mb-3">
                    <div class="row flex-between-center">
                        <div class="col-auto">
                            <h6 class="mb-0">List Reservation</h6>
                        </div>
                        <div class="col-auto d-flex">
                            <a class="btn btn-falcon-default btn-sm text-600"
                                href="{{ route('request-reservations.create') }}">Tambah
                                Request</a>
                        </div>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Tiket</th>
                            <th>No Request Reservation</th>
                            <th>Tenant</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservations as $key => $req)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td class="align-middle">{{ $req->no_tiket }}</td>
                                <td class="align-middle">{{ $req->no_request_reservation }}</td>
                                <td class="align-middle">{{ $req->Ticket->Tenant->nama_tenant }}</td>
                                <td class="align-middle text-center">
                                    {{ $req->is_deposit == 1 ? 'Berbayar' : 'Tidak Berbayar' }} <br>
                                    @if ($req->CashReceipt && $req->CashReceipt->transaction_status == 'PAYED')
                                        <h6>
                                            <span
                                                class="badge bg-success mt-2">{{ $req->CashReceipt->transaction_status }}</span>
                                        </h6>
                                    @elseif ($req->CashReceipt && $req->CashReceipt->transaction_status == 'VERIFYING')
                                        <h6>
                                            <span
                                                class="badge bg-info mt-2">{{ $req->CashReceipt->transaction_status }}</span>
                                        </h6>
                                    @elseif ($req->CashReceipt && $req->CashReceipt->transaction_status == 'PENDING')
                                        <h6>
                                            <span
                                                class="badge bg-warning mt-2">{{ $req->CashReceipt->transaction_status }}</span>
                                        </h6>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('request-reservations.show', $req->id) }}"
                                        class="btn btn-sm btn-warning mb-2">View</a>
                                    @if (
                                        $req->sign_approval_3 &&
                                            $req->Ticket->status_request != 'DONE' &&
                                            $req->Ticket->status_request != 'COMPLETE' &&
                                            Request::session()->get('work_relation_id') == 1)
                                        <form action="{{ route('rsvDone', $req->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm w-100">Acara
                                                Selesai</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-3">
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
