@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Create Checklist Floor</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('checklistfloors.store') }}">
                @csrf
                <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Barcode Room</label>
                    <input type="text" name="barcode_room" class="form-control" required>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Eng Floor</label>
                    <select class="form-control" name="id_eng_floor" required>
                        <option selected disabled>-- Pilih HK Floor --</option>
                        @foreach ($engfloor as $engfloor)
                        <option value="{{ $engfloor->id_hk_floor }}">{{ $engfloor->nama_hk_floor }} : {{$engfloor->subject}} </option>
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
                <div class="col-6 mb-3">
                    <label class="form-label">Periode</label>
                    <input type="text" name="periode" class="form-control" required>
                </div>
                
                <div class="row mt-4">
                    <h6>ISI DETAIL CHECKLIST FLOOR <hr></h6>

                    <div class=" col-6 mb-3">
                        <label class="form-label">CheckPoint</label>
                        <input type="text" name="check_point" class="form-control" required>
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
