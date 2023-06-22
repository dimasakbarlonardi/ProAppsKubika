@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('statusrequests.index')}}" class="text-white"> List Status Request </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Status Request</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('statusrequests.update', $statusrequest->id_status_request) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="form-label">Status Request</label>
                    <input type="text" name="status_request" value="{{$statusrequest->status_request}}" class="form-control">
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('statusrequests.index')}}">Cancel</a></button>
                </div>
            </form>
        </div>
    </div>
@endsection
