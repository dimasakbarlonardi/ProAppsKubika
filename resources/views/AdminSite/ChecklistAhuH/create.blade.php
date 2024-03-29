@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ route('checklistahus.index') }}" class="btn btn-falcon-default btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <div class="ml-3">Create Equipment Engineering</div>
            </div>
        </div>
    </div>
    <div class="p-5">
        <form method="post" action="{{ route('checklistahus.store') }}">
            @csrf
            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">No. Equipment</label>
                    <input type="text" name="no_equiqment" class="form-control" required>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label">Nama Equipment</label>
                    <input type="text" name="equiqment" class="form-control" required>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Room</label>
                    <select class="form-control" name="id_room" required>
                        <option selected disabled>-- Select Location --</option>
                        @foreach ($rooms as $room)
                        <option value="{{ $room->id_room }}">{{ $room->Tower->nama_tower}} - {{ $room->floor->nama_lantai }} - {{ $room->nama_room }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection