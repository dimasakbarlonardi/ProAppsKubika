@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header bg-light py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Status Request</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-primary" href="{{ route('statusrequests.create') }}">Tambah Status Request</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_status_request">ID Status Request</th>
                    <th class="sort" data-sort="status_request">Status Request</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($statusrequests as $key => $statusrequest  )
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $statusrequest->id_status_request }}</td>
                        <td>{{ $statusrequest->status_request }}</td>
                        <td>
                            <a href="{{ route('statusrequests.edit', $statusrequest->id_status_request) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('statusrequests.destroy', $statusrequest->id_status_request) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('are you sure?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

