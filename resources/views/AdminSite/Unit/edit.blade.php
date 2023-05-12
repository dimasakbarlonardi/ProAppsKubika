@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Edit Unit</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('units.update', $unit->id_unit) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="form-label">ID Unit</label>
                    <input type="text" name="id_unit" value="" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">ID Site</label>
                    <input type="text" name="id_site" value="" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">ID Tower</label>
                    <input type="text" name="id_tower" value="" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">ID Lantai</label>
                    <input type="text" name="id_lantai" value="" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Unit</label>
                    <input type="text" name="nama_unit" value="{{ $unit->nama_unit }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Luas Unit</label>
                    <input type="text" name="luas_unit" value="" class="form-control" >
                </div>
                <div class="mb-3">
                    <label class="form-label">No Meter Air</label>
                    <input type="text" name="no_meter_air" value="" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">No Meter Listrik</label>
                    <input type="text" name="no_meter_listrik" value="" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">No Meter Gas</label>
                    <input type="text" name="no_meter_gas" value="" class="form-control">
                </div>
              
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="keterangan" value="" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
