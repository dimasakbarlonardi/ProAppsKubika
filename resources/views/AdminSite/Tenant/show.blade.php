@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Detail Tenant</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            {{-- <form method="post" action="{{ route('tenants.update', $tenant->id_tenant) }}"> --}}
                @method('PUT')
                @csrf
                <div class="mb-3">
                @foreach ($tenants as $key => $tenant)
                <div class="row">
                <div class="col-3 mb-4">
                    <label class="form-label">ID Site</label>
                    <input type="text" value="{{$tenant->id_site}}" class="form-control" readonly>
                </div>
                {{-- <div class="col-3 mb-4">
                    <label class="form-label">ID User</label>
                    <input type="text" value="{{$tenant->id_user}}" class="form-control">
                </div>
                <div class="col-3 mb-4">
                    <label class="form-label">ID Pemilik</label>
                    <input type="text" value="{{$tenant->id_pemilik}}" class="form-control">
                </div> --}}
                <div class="col-3 mb-4">
                    <label class="form-label">ID Card Tenant</label>
                    <input type="text" value="{{$tenant->id_card_type}}" class="form-control" readonly>
                </div>
                </div>
                <div class="row">
                <div class="col-3 mb-4">
                    <label class="form-label">NIK Tenant</label>
                    <input type="text" value="{{$tenant->nik_tenant}}" class="form-control" readonly>
                </div>
                <div class="col-3 mb-4">
                    <label class="form-label">Nama Tenant</label>
                    <input type="text" value="{{$tenant->nama_tenant}}" class="form-control" readonly>
                </div>
                <div class="col-3 mb-4">
                    <label class="form-label">Status Hunian Tenant</label>
                    <input type="text" value="{{$tenant->id_statushunian_tenant}}" class="form-control" readonly>
                </div>
                <div class="col-3 mb-4">
                    <label class="form-label">Kewarganegaraan</label>
                    <input type="text" value="{{$tenant->kewarganegaraan}}" class="form-control" readonly>
                </div>
                </div>
                <div class="row">
                <div class="col-3 mb-4">
                    <label class="form-label">Masa Berlaku ID</label>
                    <input type="date" value="{{$tenant->masa_berlaku_id}}" class="form-control" readonly>
                </div>
                <div class="col-3 mb-4">
                    <label class="form-label">Alamat KTP Tenant</label>
                    <input type="text" value="{{$tenant->alamat_ktp_tenant}}" class="form-control" readonly>
                </div>
                <div class="col-3 mb-4">
                    <label class="form-label">Provinsi</label>
                    <input type="text" value="{{$tenant->provinsi}}" class="form-control" readonly>
                </div>
                <div class="col-3 mb-4">
                    <label class="form-label">Kode Pos</label>
                    <input type="text" value="{{$tenant->kode_pos}}" class="form-control" readonly>
                </div>
                </div>
                <div class="row">
                <div class="col-3 mb-4">
                    <label class="form-label">Alamat Tinggal Tenant</label>
                    <input type="text" value="{{$tenant->alamat_tinggal_tenant}}" class="form-control" readonly>
                </div>
                <div class="col-3 mb-4">
                    <label class="form-label">No Telp Tenant</label>
                    <input type="text" value="{{$tenant->no_telp_tenant}}" class="form-control" readonly>
                </div>
                <div class="col-3 mb-4">
                    <label class="form-label">NIK Pasangan Penjamin</label>
                    <input type="text" value="{{$tenant->nik_pasangan_penjamin}}" class="form-control" readonly>
                </div>
                <div class="col-3 mb-4">
                    <label class="form-label">Nama Pasangan Penjamin</label>
                    <input type="text" value="{{$tenant->nama_pasangan_penjamin}}" class="form-control" readonly>
                </div>
                </div>
                <div class="row">
                <div class="col-3 mb-4">
                    <label class="form-label">Alamat KTP Pasangan Penjamin</label>
                    <input type="text" value="{{$tenant->alamat_ktp_pasangan_penjamin}}" class="form-control" readonly>
                </div>
                <div class="col-3 mb-4">
                    <label class="form-label">Alamat Tinggal Pasangan Penjamin</label>
                    <input type="text" value="{{$tenant->alamat_tinggal_pasangan_penjamin}}" class="form-control" readonly>
                </div>
                <div class="col-3 mb-4">
                    <label class="form-label">Hubungan Penjamin</label>
                    <input type="text" value="{{$tenant->hubungan_penjamin}}" class="form-control" readonly>
                </div>
                <div class="col-3 mb-4">
                    <label class="form-label">No Telp Penjamin</label>
                    <input type="text" value="{{$tenant->no_telp_penjamin}}" class="form-control" readonly>
                </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            {{-- </form> --}}
        </div>
        <a href="{{ route('tenants.edit', $tenant->id_tenant) }}" class="btn btn-sm btn-warning">Edit</a>
        <form class="d-inline" action="{{ route('tenants.destroy', $tenant->id_tenant) }}" method="post">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-danger btn-sm"
                onclick="return confirm('are you sure?')">Hapus</button>
        </form>
            @endforeach
        </div>
    </div>
@endsection
