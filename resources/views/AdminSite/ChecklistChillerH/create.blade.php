@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Create Checklist Chiller</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('checklistchillers.store') }}">
                @csrf
                <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Barcode Room</label>
                    <input type="text" name="barcode_room" class="form-control" required>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Eng Chiller</label>
                    <select class="form-control" name="id_barcode_ahu" required>
                        <option selected disabled>-- Pilih Enggeneering Chiller --</option>
                        @foreach ($engchillers as $engchiller)
                        <option value="{{ $engchiller->id_eng_chiller }}">{{ $engchiller->nama_eng_chiller }} : {{$engchiller->subject}} </option>
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
                    <h6>ISI DETAIL CHECKLIST AHU <hr></h6>

                    <div class=" col-6 mb-3">
                        <label class="form-label">IN / OUT</label>
                        <input type="text" name="in_out" class="form-control" required>
                    </div>
                    <div class=" col-6 mb-3">
                        <label class="form-label">Check Point</label>
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