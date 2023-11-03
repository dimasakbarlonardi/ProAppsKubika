@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ route('tenants.index') }}" class="btn btn-falcon-default btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <div class="ml-3">Detail Tenant</div>
            </div>
            <a href="{{ route('tenants.edit', $tenant->id_tenant) }}" class="btn btn-sm btn-warning">Edit</a>
        </div>
    </div>

    <div class="p-5">
        <div class="col-12">
                <div class="card mb-3 btn-reveal-trigger">
                    <div class="card-header position-relative min-vh-25 mb-8">
                        <div class="avatar avatar-5xl avatar-profile shadow-sm img-thumbnail rounded-circle">
                            <div class="h-100 w-100 rounded-circle overflow-hidden position-relative">
                                <div id="image-container">
                                    <img id="newavatar" src="{{ $tenant->profile_picture }}" width="400" alt="Upload Foto">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Site</label>
                    <input type="text" value="Park Royale" class="form-control" readonly>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Nama Tenant</label>
                    <input type="text" value="{{ $tenant->nama_tenant }}" class="form-control" readonly>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Email Tenant</label>
                    <input type="text" value="{{ $tenant->email_tenant }}" class="form-control" readonly>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">NIK Tenant</label>
                    <input type="text" value="{{ $tenant->nik_tenant }}" class="form-control" readonly>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">ID Card Tenant</label>
                    <input type="text" value="{{ $tenant->IdCard->card_id_name }}" class="form-control" readonly>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Status Hunian Tenant</label>
                    <input type="text" value="{{ $tenant->StatusHunian->status_hunian_tenant }}" class="form-control" readonly>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Citizenship</label>
                    <input type="text" value="{{ $tenant->kewarganegaraan }}" class="form-control" readonly>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Province</label>
                    <input type="text" value="{{ $tenant->provinsi }}" class="form-control" readonly>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">KTP Address Tenant</label>
                    <input type="text" value="{{ $tenant->alamat_ktp_tenant }}" class="form-control" readonly>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Postal Code</label>
                    <input type="text" value="{{ $tenant->kode_pos }}" class="form-control" readonly>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">No Telp Tenant</label>
                    <input type="text" value="{{ $tenant->no_telp_tenant }}" class="form-control" readonly>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Marriage Status</label>
                    <input type="text" value="{{ $tenant->StatusKawin->status_kawin }}" class="form-control" readonly>
                </div>

                <div class="penjamin mt-5" id="penjamin">
                    <h5>Emergency Contact</h5>
                    <hr>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Contact Name</label>
                                <input type="text" value="{{ $tenant->nama_pasangan_penjamin }}" class="form-control" readonly>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">NIK Contact</label>
                                <input type="text" value="{{ $tenant->nik_pasangan_penjamin }}" class="form-control" readonly>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">KTP Address Contact</label>
                                <input type="text" value="{{ $tenant->alamat_ktp_pasangan_penjamin }}" class="form-control" readonly>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Contact Address</label>
                                <input type="text" value="{{ $tenant->alamat_tinggal_pasangan_penjamin }}" class="form-control" readonly>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Contact Relationship</label>
                                <input type="text" value="{{ $tenant->hubungan_penjamin }}" class="form-control" readonly>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Contact Phone</label>
                                <input type="text" value="{{ $tenant->no_telp_penjamin }}" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection