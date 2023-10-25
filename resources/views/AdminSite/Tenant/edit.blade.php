@extends('layouts.master')

@section('content')
<div class="card">
 
    <div class="p-5">
        <form method="post" action="{{ route('tenants.update', $tenant->id_tenant) }}">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card mb-3 btn-reveal-trigger">
                        <div class="card-header position-relative min-vh-25 mb-8">
                            <div class="avatar avatar-5xl avatar-profile shadow-sm img-thumbnail rounded-circle">
                                <div class="h-100 w-100 rounded-circle overflow-hidden position-relative">
                                    <div id="image-container">
                                        <img id="newavatar" src="{{ $tenant->profile_picture }}" width="400" alt="Upload Foto">
                                    </div>

                                    <input class="d-none" value="{{ $tenant->profile_picture }}" name="profile_picture" id="input-file" type="file">
                                    <label class="mb-0 overlay-icon d-flex flex-center" for="input-file">
                                        <span class="bg-holder overlay overlay-0"></span>
                                        <span class="z-1 text-white dark__text-white text-center fs--1">
                                            <svg class="svg-inline--fa fa-camera fa-w-16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="camera" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                <path fill="currentColor" d="M512 144v288c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V144c0-26.5 21.5-48 48-48h88l12.3-32.9c7-18.7 24.9-31.1 44.9-31.1h125.5c20 0 37.9 12.4 44.9 31.1L376 96h88c26.5 0 48 21.5 48 48zM376 288c0-66.2-53.8-120-120-120s-120 53.8-120 120 53.8 120 120 120 120-53.8 120-120zm-32 0c0 48.5-39.5 88-88 88s-88-39.5-88-88 39.5-88 88-88 88 39.5 88 88z">
                                                </path>
                                            </svg>
                                            <span class="d-block">Update</span></span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6 mb-4">
                    <label class="form-label">ID Site</label>
                    <input type="text" name="id_site" value="{{$tenant->id_site}}" class="form-control" readonly>
                </div>
                {{-- <div class="col-6 mb-4">
                    <label class="form-label">ID User</label>
                    <input type="text" name="id_user" value="{{$tenant->id_user}}" class="form-control">
            </div>
            <div class="col-6 mb-4">
                <label class="form-label">ID Pemilik</label>
                <input type="text" name="id_pemilik" value="{{$tenant->id_pemilik}}" class="form-control">
            </div> --}}
            <div class="col-6 mb-4">
                <label class="form-label">ID Card Tenant</label>
                <select class="form-control" name="id_card_type" required>
                    <option selected disabled>-- Ubah ID Card --</option>
                    @foreach ($idcards as $idcard)
                    <option value="{{ $idcard->id_card_type }}" {{$idcard->id_card_type == $tenant->id_card_type ? 'selected' : '' }}>{{ $idcard->card_id_name }} {{ $idcard->id_card_type }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 mb-4">
                <label class="form-label">NIK Tenant</label>
                <input type="text" name="nik_tenant" value="{{$tenant->nik_tenant}}" class="form-control" required>
            </div>
            <div class="col-6 mb-4">
                <label class="form-label">Nama Tenant</label>
                <input type="text" name="nama_tenant" value="{{$tenant->nama_tenant}}" class="form-control">
            </div>
            <div class="col-6 mb-4">
                <label class="form-label">Status Hunian Tenant</label>
                <select class="form-control" name="id_statushunian_tenant" required>
                    <option selected disabled>-- Ubah Status Hunian --</option>
                    @foreach ($statushunians as $statushunian)
                    <option value="{{ $statushunian->id_statushunian_tenant }}" {{$statushunian->id_statushunian_tenant == $tenant->id_statushunian_tenant ? 'selected' : '' }}>{{ $statushunian->status_hunian_tenant }} {{ $statushunian->id_statushunian_tenant }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 mb-4">
                <label class="form-label">Kewarganegaraan</label>
                <input type="text" name="kewarganegaraan" value="{{$tenant->kewarganegaraan}}" class="form-control">
            </div>
            <div class="col-6 mb-4">
                <label class="form-label">Masa Berlaku ID</label>
                <input type="date" name="masa_berlaku_id" value="{{$tenant->masa_berlaku_id}}" class="form-control">
            </div>

            <div class="col-6 mb-4">
                <label class="form-label">Alamat KTP Tenant</label>
                <input type="text" name="alamat_ktp_tenant" value="{{$tenant->alamat_ktp_tenant}}" class="form-control">
            </div>
            <div class="col-6 mb-4">
                <label class="form-label">Provinsi</label>
                <input type="text" name="provinsi" value="{{$tenant->provinsi}}" class="form-control">
            </div>
            <div class="col-6 mb-4">
                <label class="form-label">Kode Pos</label>
                <input type="text" name="kode_pos" value="{{$tenant->kode_pos}}" class="form-control">
            </div>
    </div>
    <div class="row">
        <div class="col-6 mb-4">
            <label class="form-label">Alamat Tinggal Tenant</label>
            <input type="text" name="alamat_tinggal_tenant" value="{{$tenant->alamat_tinggal_tenant}}" class="form-control">
        </div>
        <div class="col-6 mb-4">
            <label class="form-label">No Telp Tenant</label>
            <input type="text" name="no_telp_tenant" value="{{$tenant->no_telp_tenant}}" class="form-control">
        </div>
        <div class="col-6 mb-4">
            <label class="form-label">NIK Pasangan Penjamin</label>
            <input type="text" name="nik_pasangan_penjamin" value="{{$tenant->nik_pasangan_penjamin}}" class="form-control">
        </div>
        <div class="col-6 mb-4">
            <label class="form-label">Nama Pasangan Penjamin</label>
            <input type="text" name="nama_pasangan_penjamin" value="{{$tenant->nama_pasangan_penjamin}}" class="form-control">
        </div>
        <div class="col-6 mb-4">
            <label class="form-label">Alamat KTP Pasangan Penjamin</label>
            <input type="text" name="alamat_ktp_pasangan_penjamin" value="{{$tenant->alamat_ktp_pasangan_penjamin}}" class="form-control">
        </div>
        <div class="col-6 mb-4">
            <label class="form-label">Alamat Tinggal Pasangan Penjamin</label>
            <input type="text" name="alamat_tinggal_pasangan_penjamin" value="{{$tenant->alamat_tinggal_pasangan_penjamin}}" class="form-control">
        </div>
        <div class="col-6 mb-4">
            <label class="form-label">Hubungan Penjamin</label>
            <input type="text" name="hubungan_penjamin" value="{{$tenant->hubungan_penjamin}}" class="form-control">
        </div>
        <div class="col-6 mb-4">
            <label class="form-label">No Telp Penjamin</label>
            <input type="text" name="no_telp_penjamin" value="{{$tenant->no_telp_penjamin}}" class="form-control">
        </div>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
</div>
</div>
@endsection