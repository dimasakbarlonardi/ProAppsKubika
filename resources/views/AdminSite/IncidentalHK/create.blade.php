@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}">
@endsection

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="my-3 col-auto">
                <h6 class="mb-0 text-white">Create Incident Report</h6>
            </div>
        </div>
    </div>
    <div class="p-5">
        <form action="{{ route('incidentalreporthk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
            <div class="col-6 mb-3">
                <label for="reported_name" class="form-label">Reported By</label>
                <input type="text" class="form-control" id="reported_name" name="reported_name" required>
            </div>
            <div class="col-6 mb-3">
                <label for="incident_name" class="form-label">Incident</label>
                <input type="text" class="form-control" id="incident_name" name="incident_name" required>
            </div>
            <div class="col-6 mb-3">
                <label class="form-label">Location</label>
                <select class="form-control" name="id_room" required>
                    <option selected disabled>-- Select Location --</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id_room }}">{{ $room->nama_room }} </option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="col-6 mb-3">
                <label for="time" class="form-label">Time</label>
                <input type="time" class="form-control" id="time" name="time" required>
            </div>
            <div class="col-6 mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
            </div>
            <div class="col-6 mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Create</button>
        </form>
    </div>
</div>
@endsection


