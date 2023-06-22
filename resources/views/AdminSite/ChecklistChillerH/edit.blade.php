@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('engputrs.index')}}" class="text-white"> List Check List AHU </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Check List AHU</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('checklistchillers.update', $checklistchiller->id_eng_checklist_chiller) }}">
                @method('PUT')
                @csrf
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
                    <div class="row mt-4">
                        <h6>ISI DETAIL CHECKLIST AHU <hr></h6>
    
                        <div class=" col-6 mb-3">
                            <label class="form-label">IN / OUT</label>
                            <input type="text" name="in_out" value="{{$ahudetail->in_out}}" class="form-control" required>
                        </div>
                        <div class=" col-6 mb-3">
                            <label class="form-label">Check Point</label>
                            <input type="text" name="check_point" value="{{$ahudetail->check_point}}" class="form-control" required>
                        </div>
                        <div class=" col-6 mb-3">
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="keterangan" value="{{ $ahudetail->keterangan}}" class="form-control" required>
                        </div>
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button class="btn btn-danger"><a class="text-white" href="{{ route('checklistchillers.index')}}">Cancel</a></button>
                    </div>
            </form>
        </div>
    </div>
@endsection
