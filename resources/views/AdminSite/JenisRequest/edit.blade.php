@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('jenisrequests.index')}}" class="text-white"> List Jenis Request </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Jenis Request</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('jenisrequests.update', $jenisrequest->id_jenis_request) }}">
                @method('PUT')
                @csrf
              
                <div class="mb-3">
                    <label class="form-label">Jenis Request</label>
                    <input type="text" name="jenis_request" value="{{$jenisrequest->jenis_request}}" class="form-control">
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('jenisrequests.index')}}">Cancel</a></button>
                </div>
            </form>
        </div>
    </div>
@endsection
