@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Tambah Kendaraan Tenant</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('kendaraans.store') }}">
                @csrf
                <div class="mb-3 col-10">
                <div class="row">
                    <div class="col-4">
                        <label class="form-label">Tenant</label>
                        <select class="form-control" name="id_tenant" required>
                            <option selected disabled>-- Pilih Tenant --</option>
                            @foreach ($tenants as $tenant)
                            <option value="{{ $tenant->id_tenant }}">ID = {{ $tenant->id_tenant }} , Nama = {{ $tenant->nama_tenant }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        <label class="form-label">Unit</label>
                        <select class="form-control" name="id_unit" required>
                            <option selected disabled>-- Pilih Unit --</option>
                            @foreach ($units as $unit)
                            <option value="{{ $unit->id_unit }}">{{ $unit->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        <label class="form-label">Jenis Kendaraan</label>
                        <select class="form-control" name="id_jenis_kendaraan" required>
                            <option selected disabled>-- Pilih Jenis Kendaraan --</option>
                            @foreach ($jeniskendaraans as $jeniskendaraan)
                            <option value="{{ $jeniskendaraan->id_jenis_kendaraan }}">{{ $jeniskendaraan->jenis_kendaraan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                <div class="col-10 ">
                <div class="col-10 ">
                    <label class="form-label">No Polisi </label>
                    <input type="text" name="no_polisi" class="form-control" required>
                </div>
                </div>
                </div>
            </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
