@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Detail Tenant</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <div class="mb-3">
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label">Site</label>
                        <input type="text" value="Park Royale" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">User</label>
                        @foreach ($idusers as $iduser)
                        <input type="text" value="{{ $iduser->name}}" class="form-control" readonly>
                        @endforeach
                    </div>
                {{-- <div class="col-6 mb-3">
                    <label class="form-label">ID Pemilik</label>
                    <input type="text" value="{{$tenant->id_pemilik}}" class="form-control">
                </div> --}} 
                    <div class="col-6 mb-3">
                        <label class="form-label">Card Tenant</label>
                        <input type="text" value="{{ $tenant->IdCard->card_id_name }}" class="form-control" readonly>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">NIK Tenant</label>
                        <input type="text" value="{{ $tenant->nik_tenant }}" class="form-control" readonly>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Nama Tenant</label>
                        <input type="text" value="{{ $tenant->nama_tenant }}" class="form-control" readonly>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Status Hunian Tenant</label>
                        <input type="text" value="{{ $tenant->StatusHunian->status_hunian_tenant }}" class="form-control" readonly>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Kewarganegaraan</label>
                        <input type="text" value="{{ $tenant->kewarganegaraan }}" class="form-control" readonly>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Masa Berlaku ID</label>
                        <input type="date" value="{{ $tenant->masa_berlaku_id }}" class="form-control" readonly>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Alamat KTP Tenant</label>
                        <input type="text" value="{{ $tenant->alamat_ktp_tenant }}" class="form-control" readonly>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Provinsi</label>
                        <input type="text" value="{{ $tenant->provinsi }}" class="form-control" readonly>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Kode Pos</label>
                        <input type="text" value="{{ $tenant->kode_pos }}" class="form-control" readonly>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Alamat Tinggal Tenant</label>
                        <input type="text" value="{{ $tenant->alamat_tinggal_tenant }}" class="form-control" readonly>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">No Telp Tenant</label>
                        <input type="text" value="{{ $tenant->no_telp_tenant }}" class="form-control" readonly>
                    </div>

                    <div class="penjamin mt-5" id="penjamin">
                        <h5>Penjamin</h5>
                        <hr>
                    <div class="mb-3">
                    <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label">NIK Penjamin</label>
                        <input type="text" value="{{ $tenant->nik_pasangan_penjamin }}" class="form-control" readonly>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Nama Penjamin</label>
                        <input type="text" value="{{ $tenant->nama_pasangan_penjamin }}" class="form-control" readonly>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Alamat KTP Penjamin</label>
                        <input type="text" value="{{ $tenant->alamat_ktp_pasangan_penjamin }}" class="form-control"
                            readonly>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Alamat Tinggal Penjamin</label>
                        <input type="text" value="{{ $tenant->alamat_tinggal_pasangan_penjamin }}" class="form-control"
                            readonly>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Hubungan Penjamin</label>
                        <input type="text" value="{{ $tenant->hubungan_penjamin }}" class="form-control" readonly>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">No Telp Penjamin</label>
                        <input type="text" value="{{ $tenant->no_telp_penjamin }}" class="form-control" readonly>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
                
            <a href="{{ route('tenants.edit', $tenant->id_tenant) }}" class="btn btn-sm btn-warning">Edit</a>
            {{-- <form class="d-inline" action="{{ route('tenants.destroy', $tenant->id_tenant) }}" method="post">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-danger btn-sm"
                onclick="return confirm('are you sure?')">Hapus</button>
            </form> --}}

        </div>
    </div>
@endsection
