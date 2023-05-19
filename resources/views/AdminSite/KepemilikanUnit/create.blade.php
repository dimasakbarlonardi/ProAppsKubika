@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Tambah Kepemilikan Unit</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('kepemilikans.store') }}">
                @csrf
                <div class="mb-3 col-10">
                <div class="row">
                <div class="col-4">
                    <label class="form-label">ID Pemilik</label>
                    <select class="form-control" name="id_pemilik" required>
                        <option selected disabled>-- Pilih ID Pemilik --</option>
                        @foreach ($owners as $owner)
                        <option value="{{ $owner->id_pemilik }}">{{ $owner->nama_pemilik }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4">
                    <label class="form-label">ID Unit</label>
                    <select class="form-control" name="id_unit" required>
                        <option selected disabled>-- Pilih ID Unit --</option>
                        @foreach ($units as $unit)
                        <option value="{{ $unit->id_unit }}">{{ $unit->nama_unit }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4">
                    <label class="form-label">ID Status Hunian</label>
                    <select class="form-control" name="id_status_hunian" required>
                        <option selected disabled>-- Pilih Status Hunian --</option>
                        @foreach ($statushunians as $statushunian)
                        <option value="{{ $statushunian->id_statushunian_tenant }}">{{ $statushunian->status_hunian_tenant }}</option>
                        @endforeach
                    </select>
                </div>
                </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection