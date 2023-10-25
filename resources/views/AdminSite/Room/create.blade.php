@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ route('rooms.index') }}" class="btn btn-falcon-default btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <div class="ml-3">Create Room</div>
            </div>
        </div>
    </div>
    <div class="p-5">
        <form method="post" action="{{ route('rooms.store') }}">
            @csrf
            <div class="row">
                <div class="col-6">
                    <label class="form-label">Site</label>
                    <input type="text" value="park royale" class="form-control" disabled>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Tower</label>
                    <select class="form-control" name="id_tower" required>
                        <option selected disabled>-- Choose Tower --</option>
                        @foreach ($towers as $tower)
                        <option value="{{ $tower->id_tower }}">{{ $tower->nama_tower }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Floor</label>
                    <select class="form-control" name="id_lantai" required>
                        <option selected disabled>-- Choose Floor --</option>
                        @foreach ($floors as $floor)
                        <option value="{{ $floor->id_lantai }}">{{ $floor->nama_lantai }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Room Name</label>
                    <input type="text" name="nama_room" class="form-control" required>
                </div>
            </div>
            <div class="mt-5">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button class="btn btn-danger"><a class="text-white" href="{{ route('rooms.index') }}">Cancel</a></button>
            </div>
    </div>
    </form>
</div>
</div>
@endsection