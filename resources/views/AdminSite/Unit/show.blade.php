@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ route('units.index') }}" class="btn btn-falcon-default btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <div class="ml-3">Detail Unit</div>
            </div>
        </div>
    </div>
    <div class="p-5">
        <div class="mb-3">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tower</label>
                    <input type="text" value="{{ $units->tower->nama_tower }}" class="form-control" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Lantai</label>
                    <input type="text" value="{{ $units->floor->nama_lantai }}" class="form-control" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Unit</label>
                    <input type="text" value="{{ $units->nama_unit }}" class="form-control" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Luas Unit</label>
                    <input type="text" value="{{ $units->luas_unit }}" class="form-control" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">No Meter Air</label>
                    <input type="text" value="{{ $units->no_meter_air }}" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">No Meter Listrik</label>
                    <input type="text" value="{{ $units->no_meter_listrik }}" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Meter Air Awal</label>
                    <input type="text" value="{{ $units->meter_air_awal }}" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Meter Listrik Awal</label>
                    <input type="text" value="{{ $units->meter_listrik_awal }}" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Deskripsi</label>
                    <input type="text" value="{{ $units->keterangan }}" class="form-control">
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Barcode Meter Air</label>
                    <div class="text-center">
                        <img src="{{ url($units->barcode_meter_air) }}" alt="barcode" width="250" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <label class="form-label">Barcode Meter Listrik</label>
                    <div class="text-center">
                        <img src="{{ url($units->barcode_meter_listrik) }}" alt="barcode" width="250" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <a class="btn btn-sm btn-warning" href="{{ route('units.edit', $units->id_unit) }}">Edit</a>
        </div>
    </div>
</div>
</div>
@endsection