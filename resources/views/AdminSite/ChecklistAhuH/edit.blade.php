@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('checklistahus.index')}}" class="text-white"> List Check List AHU </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Equipment Engineering</li>
                        </ol>
                    </nav>
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
