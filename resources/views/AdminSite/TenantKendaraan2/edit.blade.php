@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Edit Kendaraan Tenant</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('kendaraans.update', $kendaraan->id_tenant_vehicle) }}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-3">
                        <label class="form-label">Tenant</label>
                        <input type="text" name="id_tenant" value="{{$kendaraan->id_tenant}}" class="form-control">
                    </div>
                    <div class="col-3">
                        <label class="form-label">Unit</label>
                        <input type="text" name="id_unit" value="{{ $kendaraan->id_unit}}" class="form-control">
                    </div>
                <div class="col-3">
                    <label class="form-label">Jenis Kendaraan</label>
                    <input type="text" name="id_jenis_kendaraan" value="{{$kendaraan->id_jenis_kendaraan}}" class="form-control">
                </div>
                <div class="col-3">
                    <label class="form-label">No Polisi</label>
                    <input type="text" name="no_polisi" value="{{$kendaraan->no_polisi}}" class="form-control">
                </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
        </div>
    </div>
@endsection
