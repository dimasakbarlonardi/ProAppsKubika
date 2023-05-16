@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Tambah Member Tenant</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('membertenants.store') }}">
                @csrf
                <div class="mb-3 col-10">
                    <div class="row">
                        <div class="col-5">
                            <label class="form-label">Unit</label>
                            <select class="form-control" name="id_unit" required>
                                <option selected disabled>-- Pilih Unit --</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id_unit }}">{{ $unit->nama_unit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-5">
                            <label class="form-label">Tenant</label>
                            <select class="form-control" name="id_tenant" required>
                                <option selected disabled>-- Pilih Tenant --</option>
                                @foreach ($tenants as $tenant)
                                    <option value="{{ $tenant->id_tenant }}">ID = {{ $tenant->id_tenant }} , Nama =
                                        {{ $tenant->nama_tenant }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-10 ">
                            {{-- buat auto tgl masuk dan keluar --}}
                            <div class="col-10 ">
                                <label class="form-label">Nik Tenant Member </label>
                                <input type="text" name="nik_tenant_member" class="form-control" required>
                            </div>
                            <div class="col-10 ">
                                <label class="form-label">Nama Tenant Member </label>
                                <input type="text" name="nama_tenant_member" class="form-control" required>
                            </div>
                            <div class="col-10 ">
                                <label class="form-label">Hubungan Tenant </label>
                                <input type="text" name="hubungan_tenant" class="form-control" required>
                            </div>
                            <div class="col-10 ">
                                <label class="form-label">No Telp Member </label>
                                <input type="text" name="no_telp_member" class="form-control" required>
                            </div>
                           -
                            <div class="col-6">
                                <label class="form-label">ID Status Tinggal</label>
                                <select class="form-control" name="id_status_tinggal" required>
                                      <option selected disabled>-- Pilih Status Tinggal --</option>
                                    @foreach ($statustinggals as $statustinggal)
                                            <option value="{{ $statustinggal->id_status_tinggal}}"> {{$statustinggal->status_tinggal}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
