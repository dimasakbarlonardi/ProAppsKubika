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
                <th scope="row" class="align-middle">{{ $key + 1 }}</th>
                <td class="align-middle">{{ $req->no_tiket }}</td>
                <td class="align-middle">{{ $req->no_request_reservation }}</td>
                <td class="align-middle">{{ $req->Ticket->Tenant->nama_tenant }}</td>
                <td class="align-middle text-center">
                    Status Request : {{ $req->Ticket->status_request }} <br>
                    {{ $req->is_deposit == 1 ? 'Berbayar' : 'Tidak Berbayar' }} <br>
                    @if ($req->status_bayar == 'PAID')
                        <h6>
                            <span
                                class="badge bg-success mt-2">PAID</span>
                        </h6>
                    @elseif ($req->CashReceipt && $req->CashReceipt->transaction_status == 'VERIFYING' && $req->Ticket->status_request != 'REJECTED')
                        <h6>
                            <span
                                class="badge bg-info mt-2">{{ $req->CashReceipt->transaction_status }}</span>
                        </h6>
                    @elseif ($req->status_bayar == 'PENDING' && $req->Ticket->status_request != 'REJECTED')
                        <h6>
                            <span
                                class="badge bg-warning mt-2">PENDING</span>
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
                        Request::session()->get('work_relation_id') == 1
                        )
                        @if ($req->is_deposit && $req->status_bayar == 'PAID' || !$req->is_deposit && $req->status_bayar == 'PAID')
                            <form action="{{ route('rsvDone', $req->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm w-100">Acara
                                    Selesai</button>
                            </form>
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
