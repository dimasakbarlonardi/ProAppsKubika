@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-white">Edit Type Reservation</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('typereservations.update', $typereservation->id_type_reservation) }}">
                @method('PUT')
                @csrf
                <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Type Reservation</label>
                    <input type="text" name="type_reservation" value="{{$typereservation->type_reservation}}" class="form-control">
                </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
