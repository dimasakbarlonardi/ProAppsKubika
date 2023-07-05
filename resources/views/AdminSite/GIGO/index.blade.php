@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0 text-white">List Agama</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default text-600 btn-sm" href="{{ route('agamas.create') }}">Tambah Agama</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="nama_agama">No GIGO</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($gigos as $key => $gigo)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $gigo->no_request_gigo }}</td>
                        <td>
                            <a href="{{ route('agamas.edit', $gigo->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            @if (!$gigo->sign_approval_1 && $approve->approval_1 == $user->RoleH->WorkRelation->id_work_relation && $user->Karyawan->is_can_approve)
                                <form action="{{ route('gigoApprove1', $gigo->id) }}" class="d-inline" method="post">
                                    @csrf
                                    <button class="btn btn-sm btn-success" type="submit">Approve</button>
                                </form>
                            @endif
                            @if ($gigo->sign_approval_1 && !$gigo->sign_approval_2 && $approve->approval_2 == $user->RoleH->WorkRelation->id_work_relation && $user->Karyawan->is_can_approve)
                                <form action="{{ route('gigoApprove2', $gigo->id) }}" class="d-inline" method="post">
                                    @csrf
                                    <button class="btn btn-sm btn-success" type="submit">Approve</button>
                                </form>
                            @endif
                            @if ($gigo->sign_approval_2 && $gigo->status_request != 'DONE' && $approve->approval_2 == $user->RoleH->WorkRelation->id_work_relation && $user->Karyawan->is_can_approve)
                                <form action="{{ route('gigoDone', $gigo->id) }}" class="d-inline" method="post">
                                    @csrf
                                    <button class="btn btn-sm btn-success" type="submit">Done</button>
                                </form>
                            @endif
                            @if ($gigo->status_request == 'DONE' && $approve->approval_3 == $user->id_user)
                                <form action="{{ route('gigoComplete', $gigo->id) }}" class="d-inline" method="post">
                                    @csrf
                                    <button class="btn btn-sm btn-success" type="submit">Complete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

