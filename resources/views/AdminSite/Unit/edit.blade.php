@extends('layouts.master')

@section('content')
    <div class="card">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ route('units.index') }}" class="btn btn-falcon-default btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <div class="ml-3">Edit Unit</div>
            </div>
        </div>
    </div>
        <div class="p-5">
            <form method="post" action="{{ route('units.update', $unit->id_unit) }}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label">Tower</label>
                        <select class="form-control" name="id_tower" required>
                            <option selected disabled>-- Choose Tower --</option>
                            @foreach ($towers as $tower)
                                <option value="{{ $tower->id_tower }}" {{ $unit->id_tower == $unit->id_tower ? 'selected' : '' }}>{{ $tower->nama_tower }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Lantai</label>
                        <select class="form-control" name="id_lantai" required>
                            <option selected disabled>-- Choose Lantai --</option>
                            @foreach ($floors as $floor)
                                <option value="{{ $floor->id_lantai }}" {{ $unit->id_lantai == $floor->id_lantai ? 'selected' : ''}}>{{ $floor->nama_lantai }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Hunian</label>
                        <select class="form-control" name="id_hunian" required>
                            <option selected disabled>-- Choose Hunian --</option>
                            @foreach ($hunians as $hunian)
                                <option value="{{ $hunian->id_hunian }}" {{ $unit->id_hunian == $hunian->id_hunian ? 'selected' : ''}}>{{ $hunian->nama_hunian }}</option>
                            @endforeach
                        </select>
                    </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Unit Name</label>
                    <input type="text" name="nama_unit" value="{{ $unit->nama_unit }}" class="form-control" required>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Luas Unit</label>
                    <input type="text" name="luas_unit" value="{{$unit->luas_unit}}" class="form-control" >
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">No Meter Air</label>
                    <input type="text" name="no_meter_air" value="{{$unit->no_meter_air}}" class="form-control">
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">No Meter Listrik</label>
                    <input type="text" name="no_meter_listrik" value="{{$unit->no_meter_listrik}}" class="form-control">
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">No Meter Gas</label>
                    <input type="text" name="no_meter_gas" value="{{$unit->no_meter_gas}}" class="form-control">
                </div>
              
                <div class="col-6 mb-3">
                    <label class="form-label">Description</label>
                    <input type="text" name="keterangan" value="{{$unit->keterangan}}" class="form-control">
                </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
