@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Edit Checklist AHU</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('checklistahus.update', $checklistahu->id_checklist_ahu_h) }}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-3">
                        <label class="form-label"><b>ID Checklist AHU</label>
                        <input type="text" value="{{$checklistahu->id_checklist_ahu_h}}" class="form-control" readonly></b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mt-3">
                        <label class="form-label">Barcode Room</label>
                        <input type="text" name="barcode_room" value="{{$checklistahu->barcode_room}}" class="form-control" required>
                    </div>
                    <div class="col-6 mt-3">
                        <label class="form-label">Room</label>
                        <select class="form-control" name="id_room" required>
                            <option selected disabled>-- Pilih Room --</option>
                            @foreach ($rooms as $room)
                            <option value="{{ $room->id_room }}" {{ $room->id_room == $checklistahu->id_room ? 'selected' : ''}}>{{ $room->nama_room }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class=" col-6 mt-3">
                        <label class="form-label">Tanggal Checklist</label>
                        <input type="date" name="tgl_checklist" value="{{$checklistahu->tgl_checklist}}" class="form-control" required>
                    </div>
                    <div class=" col-6 mt-3">
                        <label class="form-label">Time Checklist</label>
                        <input type="time" name="time_checklist" value="{{$checklistahu->time_checklist}}" class="form-control" required>
                    </div>
                    <div class="col-6 mt-3">
                    <label class="form-label">User</label>
                    <select class="form-control" name="id_user" required>
                        <option selected disabled>-- Pilih User --</option>
                        @foreach ($idusers as $iduser)
                        <option value="{{ $iduser->id }}" {{ $iduser->id == $checklistahu->id_user ? 'selected' : ''}}>{{ $iduser->name }} </option>
                        @endforeach
                    </select>
                </div>
                    <div class=" col-6 mt-3">
                        <label class="form-label">Nomer Checklist AHU</label>
                        <input type="text" name="no_checklist_ahu" value="{{$checklistahu->no_checklist_ahu}}" class="form-control" required>
                    </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
