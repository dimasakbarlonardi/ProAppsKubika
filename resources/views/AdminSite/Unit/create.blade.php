@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ route('units.index') }}" class="btn btn-falcon-default btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <div class="ml-3">Create Unit</div>
            </div>
        </div>
    </div>
    <div class="p-5">
        <form method="post" action="{{ route('units.store') }}">
            @csrf
            <div class="mb-3">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Site Name</label>
                        <input type="text" value="Park Royale" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Tower</label>
                        <select class="form-control" name="id_tower" required>
                            <option selected disable value="">-- Choose Tower --</option>
                            @foreach ($towers as $tower)
                            <option value="{{ $tower->id_tower }}">{{ $tower->nama_tower }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Lantai</label>
                        <select class="form-control" name="id_lantai" required>
                            <option selected disabled value="">-- Choose Lantai --</option>
                            @foreach ($floors as $floor)
                            <option value="{{ $floor->id_lantai }}">{{ $floor->nama_lantai }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Hunian</label>
                        <select class="form-control" name="id_hunian" required>
                            <option selected disabled value="">-- Choose Hunian --</option>
                            @foreach ($hunians as $hunian)
                            <option value="{{ $hunian->id_hunian }}">{{ $hunian->nama_hunian }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Unit Name</label>
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
                        <label class="form-label">Description</label>
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