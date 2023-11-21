@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('Parameter-Shift-Security.index')}}" class="text-white"> List Shift Security Parameter </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Shift Security Parameter</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('Parameter-Shift-Security.update', $ParameterShiftSecurity->id) }}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-6 mt-3">
                        <label class="form-label">Shift</label>
                        <input type="text" name="shift" value="{{ $ParameterShiftSecurity->shift}}" class="form-control" required>
                    </div>
                    <div class="col-6 mt-3">
                        <label class="form-label">Start Time</label>
                        <input type="text" name="start_time" value="{{ $ParameterShiftSecurity->start_time}}" class="form-control" required>
                    </div>
                    <div class="col-6 mt-3">
                        <label class="form-label">End Time</label>
                        <input type="text" name="end_time" value="{{ $ParameterShiftSecurity->end_time}}" class="form-control" required>
                    </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button class="btn btn-danger"><a class="text-white" href="{{ route('Parameter-Shift-Security.index')}}">Cancel</a></button>
                </div>
            </form>
        </div>
    </div>
@endsection
