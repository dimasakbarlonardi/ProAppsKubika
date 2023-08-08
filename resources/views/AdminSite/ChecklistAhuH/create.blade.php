@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Tambah Checklist AHU</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('checklistahus.store') }}">
                @csrf
                <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">No. Equiqment</label>
                    <input type="text" name="no_equiqment" class="form-control" required>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label">Nama Equiqment</label>
                    <input type="text" name="nama_equiqment" class="form-control" required>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label">PIC</label>
                    <input type="date" name="tgl_checklist" class="form-control" required>
                </div>
                {{-- <div class="col-6 mb-3">
                    <label class="form-label">Eng AHU</label>
                    <select class="form-control" name="id_barcode_ahu" required>
                        <option selected disabled>-- Pilih Enggeneering AHU --</option>
                        @foreach ($engahus as $engahu)
                        <option value="{{ $engahu->id_eng_ahu }}">{{ $engahu->nama_eng_ahu }} </option>
                        @endforeach
                    </select>
                </div> --}}

                <div class="col-6 mb-3">
                    <label class="form-label">Lokasi</label>
                    <select class="form-control" name="id_room" required>
                        <option selected disabled>-- Pilih Lokasi --</option>
                        @foreach ($rooms as $room)
                        <option value="{{ $room->id_room }}">{{ $room->nama_room }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection
