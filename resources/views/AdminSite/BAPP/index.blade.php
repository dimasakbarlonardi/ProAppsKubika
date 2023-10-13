@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="mb-0">Detail BAPP</h6>
                </div>
                <div class="col-auto d-flex">
                    <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('bapp.create') }}">Tambah BAPP</a>
                </div>
            </div>
        </div>
        <div class="p-5">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">No Tiket</th>
                        <th scope="col">No Request Permit</th>
                        <th scope="col">No Work Permit</th>
                        <th scope="col">No BAPP</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bapps as $key => $bapp)
                        @if ($user->id_user == $approve->approval_3 && ($bapp->WorkPermit->status_request == 'WORK DONE' || $bapp->WorkPermit->status_request == 'DONE'))
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $bapp->no_tiket }}</td>
                                <td>{{ $bapp->no_request_permit }}</td>
                                <td>{{ $bapp->no_work_permit }}</td>
                                <td>{{ $bapp->no_bapp }}</td>
                                <td>
                                    <a href="{{ route('bapp.edit', $bapp->id) }}" class="btn btn-sm btn-warning">View</a>
                                    @if (!$bapp->sign_approval_1)
                                        <form class="d-inline" action="{{ route('doneTF', $bapp->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-info btn-sm"
                                                onclick="return confirm('are you sure?')">Sudah Transfer</button>
                                        </form>
                                    @endif
                                    @if ($bapp->sign_approval_2 && !$bapp->sign_approval_3)
                                        <form class="d-inline" action="{{ route('bappApprove3', $bapp->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-info btn-sm"
                                                onclick="return confirm('are you sure?')">Approve</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @elseif ($user->id_user != $approve->approval_3)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $bapp->no_tiket }}</td>
                                <td>{{ $bapp->no_request_permit }}</td>
                                <td>{{ $bapp->no_work_permit }}</td>
                                <td>{{ $bapp->no_bapp }}</td>
                                <td>
                                    <a href="{{ route('bapp.edit', $bapp->id) }}" class="btn btn-sm btn-warning">View</a>
                                    @if (!$bapp->sign_approval_2 && $bapp->sign_approval_1 && $bapp->WorkPermit->id_work_relation == $user->RoleH->work_relation_id)
                                        <form class="d-inline" action="{{ route('bappApprove2', $bapp->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm"
                                                onclick="return confirm('are you sure?')">Approve</button>
                                        </form>
                                    @endif
                                    @if ($user->id_user == $approve->approval_4 && $bapp->sign_approval_3 && !$bapp->sign_approval_4)
                                        <form class="d-inline" action="{{ route('bappApprove4', $bapp->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-info btn-sm"
                                                onclick="return confirm('are you sure?')">Complete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
