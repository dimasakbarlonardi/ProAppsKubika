@extends('layouts.master')

@section('content')
    <div class="card">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ route('rooms.index') }}" class="btn btn-falcon-default btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <div class="ml-3">Edit Room</div>
            </div>
        </div>
    </div>
        <div class="p-5">
            <form method="post" action="{{ route('rooms.update', $room->id_room) }}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Site</label>
                        <input type="text" value="park royale" class="form-control" readonly>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Tower</label>
                        <select class="form-control" name="id_tower" required>
                            <option selected disabled>-- Choose Tower --</option>
                            @foreach ($towers as $tower)
                                <option value="{{ $tower->id_tower }}"
                                    {{ $tower->id_tower == $room->id_tower ? 'selected' : '' }}>{{ $tower->nama_tower }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Floor</label>
                        <select class="form-control" name="id_lantai" required>
                            <option selected disabled>-- Choose Floor --</option>
                            @foreach ($floors as $floor)
                                <option value="{{ $floor->id_lantai }}"
                                    {{ $floor->id_floor == $room->id_floor ? 'selected' : '' }}>{{ $floor->nama_lantai }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Room Name</label>
                        <input type="text" name="nama_room" value="{{ $room->nama_room }}" class="form-control" required>
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button class="btn btn-danger"><a class="text-white"
                                href="{{ route('rooms.index') }}">Cancel</a></button>
                    </div>
            </form>
        </div>
    </div>
@endsection
