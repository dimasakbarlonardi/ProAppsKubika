@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="my-3">Tambah Unit</h6>
            </div>
        </div>
    </div>
    <div class="p-5">
        <form method="post" action="{{ route('units.store') }}">
            @csrf
            <div class="mb-3">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Nama Site</label>
                        <input type="text" value="Park Royale" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Tower</label>
                        <select class="form-control" name="id_tower" required>
                            <option selected disabled>-- Pilih Tower --</option>
                            @foreach ($towers as $tower)
                            <option value="{{ $tower->id_tower }}">{{ $tower->nama_tower }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Lantai</label>
                        <select class="form-control" name="id_lantai" required>
                            <option selected disabled>-- Pilih Lantai --</option>
                            @foreach ($floors as $floor)
                            <option value="{{ $floor->id_lantai }}">{{ $floor->nama_lantai }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Hunian</label>
                        <select class="form-control" name="id_hunian" required>
                            <option selected disabled>-- Pilih Hunian --</option>
                            @foreach ($hunians as $hunian)
                            <option value="{{ $hunian->id_hunian }}">{{ $hunian->nama_hunian }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Unit</label>
                        <input type="text" name="nama_unit" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Luas Unit</label>
                        <input type="text" name="luas_unit" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">No Meter Air</label>
                        <input type="text" name="no_meter_air" class="form-control" required>
                    </div>

                    <div class="col-6">
                        <label class="form-label">No Meter Listrik</label>
                        <input type="text" name="no_meter_listrik" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Meter Air Awal</label>
                        <input type="text" name="meter_air_awal" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Meter Listrik Awal</label>
                        <input type="text" name="meter_listrik_awal" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control">
                    </div>
                    <div class="text-end mt-5">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection