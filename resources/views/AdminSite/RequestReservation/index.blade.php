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
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">No Tiket</th>
                            <th scope="col">No Request Reservation</th>
                            <th scope="col">Tenant</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservations as $key => $req)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $req->no_tiket }}</td>
                                <td>{{ $req->no_request_reservation }}</td>
                                <td>{{ $req->Ticket->Tenant->nama_tenant }}</td>
                                <td>
                                    <a href="{{ route('bapp.edit', $req->id) }}" class="btn btn-sm btn-warning">View</a>
                                    @if (
                                        $approve->approval_2 == $user->RoleH->WorkRelation->id_work_relation &&
                                            $user->Karyawan->is_can_approve &&
                                            !$req->sign_approval_2)
                                        <form action="{{ route('rsvApprove2', $req->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm w-100">Approve</button>
                                        </form>
                                    @endif
                                    @if ($approve->approval_3 == $user->id_user && !$req->sign_approval_3)
                                        <form action="{{ route('rsvApprove3', $req->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm w-100">Approve</button>
                                        </form>
                                    @endif
                                    @if ($req->sign_approval_3 && $req->Ticket->status_request != 'DONE' && $req->Ticket->status_request != 'COMPLETE')
                                        <form action="{{ route('rsvDone', $req->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm w-100">Acara Selesai</button>
                                        </form>
                                    @endif
                                    @if ($approve->approval_4 == $user->id_user && $req->Ticket->status_request == 'DONE' && !$req->sign_approval_4)
                                        <form action="{{ route('rsvComplete', $req->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm w-100">Complete</button>
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
