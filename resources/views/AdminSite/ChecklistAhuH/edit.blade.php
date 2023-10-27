@extends('layouts.master')

@section('content')
    <div class="card">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ route('checklistahus.index') }}" class="btn btn-falcon-default btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <div class="ml-3">Edit Equipment Engineering</div>
            </div>
        </div>
    </div>
        <div class="p-5">
            <form method="post" action="{{ route('checklistahus.update', $equipmentengineering->id_equiqment_engineering) }}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-6 mt-3">
                        <label class="form-label">No. Equipment</label>
                        <input type="text" name="no_equipment" value="{{ $equipmentengineering->no_equiqment}}" class="form-control" required>
                    </div>
                    <div class="col-6 mt-3">
                        <label class="form-label">Nama Equipment</label>
                        <input type="text" name="equipment" value="{{$equipmentengineering->equiqment}}" class="form-control" required>
                    </div>
                    <div class="col-6 mt-3">
                        <label class="form-label">Room</label>
                        <select class="form-control" name="id_room" required>
                            <option selected disabled>-- Pilih Room --</option>
                            @foreach ($rooms as $room)
                            <option value="{{ $room->id_room }}" {{ $room->id_room == $equipmentengineering->id_room ? 'selected' : ''}}>{{ $room->nama_room }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button class="btn btn-danger"><a class="text-white" href="{{ route('checklistahus.index')}}">Cancel</a></button>
                    </div>
            </form>
        </div>
    </div>
@endsection
