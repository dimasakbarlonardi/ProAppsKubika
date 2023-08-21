@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Create Checklist Toilet</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('checklisttoilets.store') }}">
                @csrf
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label">No. Equiqment</label>
                        <input type="text" name="no_equiqment" class="form-control" required>
                    </div>  
                    <div class=" col-6 mb-3">
                        <label class="form-label">Nama Equiqment</label>
                        <input type="text" name="equiqment" class="form-control" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">PIC</label>
                        <select class="form-control" name="id_role" required>
                            <option selected disabled>-- Pilih PIC --</option>
                            @foreach ($role as $role)
                            <option value="{{ $role->id }}">{{ $role->nama_role }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Lokasi</label>
                        <select class="form-control" name="id_room" required>
                            <option selected disabled>-- Pilih Lokasi --</option>
                            @foreach ($rooms as $room)
                            <option value="{{ $room->id_room }}">{{ $room->nama_room }} </option>
                            @endforeach
                        </select>
                    </div>
    
                    <div class="row mt-3">
                        <h6> Tanggal<hr></h6>
                        <div class=" col-6 mb-3">
                            <label class="form-label">Senin</label>
                            <input type="date" name="senin" class="form-control">
                        </div>
                        <div class=" col-6 mb-3">
                            <label class="form-label">Selasa</label>
                            <input type="date" name="selasa" class="form-control">
                        </div>
                        <div class=" col-6 mb-3">
                            <label class="form-label">Rabu</label>
                            <input type="date" name="rabu" class="form-control">
                        </div>
                        <div class=" col-6 mb-3">
                            <label class="form-label">Kamis</label>
                            <input type="date" name="kamis" class="form-control">
                        </div>
                        <div class=" col-6 mb-3">
                            <label class="form-label">Jumat</label>
                            <input type="date" name="jumat" class="form-control">
                        </div>
                        <div class=" col-6 mb-3">
                            <label class="form-label">Sabtu</label>
                            <input type="date" name="sabtu" class="form-control">
                        </div>
                        <div class=" col-6 mb-3">
                            <label class="form-label">Minggu</label>
                            <input type="date" name="minngu" class="form-control">
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
