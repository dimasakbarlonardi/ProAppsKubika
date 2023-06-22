@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Create Checklist GroundRoof</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('checklistgroundroofs.store') }}">
                @csrf
                <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Barcode Room</label>
                    <input type="text" name="barcode_room" class="form-control" required>
                </div>
                {{-- <div class=" col-6 mb-3">
                    <label class="form-label">Nomer Checklist AHU</label>
                    <input type="text" name="no_checklist_ahu" class="form-control" required>
                </div> --}}
                {{-- <div class=" col-6 mb-3">
                    <label class="form-label">Tanggal Checklist</label>
                    <input type="date" name="tgl_checklist" class="form-control" required>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label">Time Checklist</label>
                    <input type="time" name="time_checklist" class="form-control" required>
                </div> --}}
                <div class="col-6 mb-3">
                    <label class="form-label">Eng groundroof</label>
                    <select class="form-control" name="id_eng_groundrofftank" required>
                        <option selected disabled>-- Pilih Enggeneering groundroof --</option>
                        @foreach ($enggroundrooftanks as $enggroundrooftank)
                        <option value="{{ $enggroundrooftank->id_eng_groundrofftank }}">{{ $enggroundrooftank->nama_eng_groundrofftank }} : {{$enggroundrooftank->subject}} </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 mb-3">
                    <label class="form-label">Room</label>
                    <select class="form-control" name="id_room" required>
                        <option selected disabled>-- Pilih Room --</option>
                        @foreach ($rooms as $room)
                        <option value="{{ $room->id_room }}">{{ $room->nama_room }} </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="row mt-4">
                    <h6>ISI DETAIL CHECKLIST GroundRoof <hr></h6>

                    <div class=" col-6 mb-3">
                        <label class="form-label">CheckPoint 1</label>
                        <input type="text" name="check_point1" class="form-control" required>
                    </div>
                    <div class=" col-6 mb-3">
                        <label class="form-label">CheckPoint 2</label>
                        <input type="text" name="check_point2" class="form-control" required>
                    </div>
                    <div class=" col-6 mb-3">
                        <label class="form-label">CheckPoint 3</label>
                        <input type="text" name="check_point3" class="form-control" required>
                    </div>
                    <div class=" col-6 mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" required>
                    </div>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection
