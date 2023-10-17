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
        <form action="{{ route('incidentalreport.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
            <div class="col-6 mb-3">
                <label for="reported_name" class="form-label">Reported By</label>
                <input type="text" class="form-control" id="reported_name" name="reported_name" required>
            </div>
            <div class="col-6 mb-3">
                <label for="incident_name" class="form-label">Incident Name</label>
                <input type="text" class="form-control" id="incident_name" name="incident_name" required>
            </div>
            <div class="col-6 mb-3">
                <label for="location" class="form-label">Incident Location</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>
            <div class="col-6 mb-3">
                <label for="date" class="form-label">Incident Date</label>
                <input type="date" class="form-control" id="incident_date" name="incident_date" required>
            </div>
            <div class="col-6 mb-3">
                <label for="time" class="form-label">Incident Time</label>
                <input type="time" class="form-control" id="incident_time" name="incident_time" required>
            </div>
            <div class="col-6 mb-3">
                <label for="keterangan" class="form-label">Description</label>
                <textarea class="form-control" id="desc" name="desc" rows="3" required></textarea>
            </div>
            <div class="col-6 mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="incident_image" name="incident_image" accept="image/*" required>
            </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Create</button>
        </form>
    </div>
</div>
@endsection


