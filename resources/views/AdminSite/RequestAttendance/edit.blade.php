@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('ruangreservations.index')}}" class="text-white"> List Ruang Reservation </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Ruang Reservation</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('requestattendance.update', $request->id) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="form-label">Request Attendance</label>
                    <input type="text" name="name_request" value="{{$request->name_request}}" class="form-control">
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('requestattendance.index')}}">Cancel</a></button>
                </div>
            </form> 
        </div>
    </div>
@endsection
