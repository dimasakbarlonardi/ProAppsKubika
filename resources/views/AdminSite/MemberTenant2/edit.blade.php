@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Edit Member Tenant</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('membertenants.update', $membertenant->id_tenant_member) }}">
                @method('PUT')
                @csrf
                <div class="row">
                <div class="col-3">
                    <label class="form-label">Unit</label>
                    <input type="text" name="id_unit" value="{{ $membertenant->id_unit}}" class="form-control">
                </div>
                <div class="col-3">
                    <label class="form-label">Tenant</label>
                    <input type="text" name="id_tenant" value="{{$membertenant->id_tenant}}" class="form-control">
                </div>
                <div class="col-3">
                    <label class="form-label">NIK Member Tenant</label>
                    <input type="text" name="nik_member_tenant" value="{{$membertenant->nik_tenant_member}}" class="form-control">
                </div>
                <div class="col-3">
                    <label class="form-label">Nama Tenant Member</label>
                    <input type="text" name="nama_tenant_member" value="{{$membertenant->nama_tenant_member}}" class="form-control">
                </div>
                </div>
                <div class="row">
                <div class="col-3">
                    <label class="form-label">Hubungan Tenant </label>
                    <input type="text" name="hubungan_tenant" value="{{$membertenant->hubungan_tenant}}" class="form-control">
                </div>
                <div class="col-3">
                    <label class="form-label">No Telp Member</label>
                    <input type="text" name="no_telp_member" value="{{$membertenant->no_telp_member}}" class="form-control">
                </div>
                <div class="col-3">
                    <label class="form-label">ID Status Tinggal</label>
                    <input type="text" name="id_status_tinggal" value="{{$membertenant->id_status_tinggal}}" class="form-control">
                </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
        </div>
    </div>
@endsection
