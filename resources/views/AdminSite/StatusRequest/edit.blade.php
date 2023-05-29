@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-white">Edit Status Request</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('statusrequests.update', $statusrequest->id_status_request) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="form-label">ID Status Request</label>
                    <input type="text" name="" value="{{$statusrequest->id_status_request}}" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status Request</label>
                    <input type="text" name="status_request" value="{{$statusrequest->status_request}}" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
