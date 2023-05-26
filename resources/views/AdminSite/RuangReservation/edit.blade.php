@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-white">Edit Ruang Reservation</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('ruangreservations.update', $ruangreservation->id_ruang_reservation) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="form-label">ID Ruang Reservation</label>
                    <input type="text" value="{{$ruangreservation->id_ruang_reservation}}" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ruang Reservation</label>
                    <input type="text" name="ruang_reservation" value="{{$ruangreservation->ruang_reservation}}" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
