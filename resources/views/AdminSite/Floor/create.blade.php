@extends('layouts.master')

@section('content')
<div class="card">
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a href="{{ route('floors.index') }}" class="btn btn-falcon-default btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <div class="ml-3">Create Floor</div>
        </div>
    </div>
</div>
    <div class="p-5">
        <form method="post" action="{{ route('floors.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Floor Name</label>
                <input type="text" name="nama_lantai" class="form-control" required>
            </div>
            <div class="mt-5">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection