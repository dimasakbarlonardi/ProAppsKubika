@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Create Checklist Pompa Sumpit</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('checklistpompasumpits.store') }}">
                @csrf
                <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Barcode Room</label>
                    <input type="text" name="barcode_room" class="form-control" required>
                </div>
                {{-- <div class=" col-6 mb-3">
                    <label class="form-label">Nomer Checklist Pompa Sumpit</label>
                    <input type="text" name="no_checklist_pompa_sumpit" class="form-control" required>
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
                    <label class="form-label">Eng Pompa Sumpit</label>
                    <select class="form-control" name="id_barcode_pompasumpit" required>
                        <option selected disabled>-- Pilih Enggeneering Pompa Sumpit --</option>
                        @foreach ($engpompasumpits as $engpompasumpit)
                        <option value="{{ $engpompasumpit->id_eng_pompasumpit }}">{{ $engpompasumpit->nama_eng_pompasumpit }} : {{$engpompasumpit->subject}} </option>
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
                    <h6>ISI DETAIL CHECKLIST Pompa Sumpit <hr></h6>

                    <div class=" col-6 mb-3">
                        <label class="form-label">CheckPoint 1</label>
                        <input type="text" name="check_point1" class="form-control" required>
                    </div>
                    <div class=" col-6 mb-3">
                        <label class="form-label">Check Point 2</label>
                        <input type="text" name="check_point2" class="form-control" required>
                    </div>
                    <div class=" col-6 mb-3">
                        <label class="form-label">CheckPoint 3</label>
                        <input type="text" name="check_point3" class="form-control" required>
                    </div>
                    <div class=" col-6 mb-3">
                        <label class="form-label">Check Point 4</label>
                        <input type="text" name="check_point4" class="form-control" required>
                    </div>
                    <div class=" col-6 mb-3">
                        <label class="form-label">CheckPoint 5</label>
                        <input type="text" name="check_point5" class="form-control" required>
                    </div>
                    <div class=" col-6 mb-3">
                        <label class="form-label">Check Point 6</label>
                        <input type="text" name="check_point6" class="form-control" required>
                    </div>
                    <div class=" col-6 mb-3">
                        <label class="form-label">Check Point 7</label>
                        <input type="text" name="check_point7" class="form-control" required>
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
