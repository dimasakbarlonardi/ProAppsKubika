@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-white">Tambah Tenant</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('tenants.store') }}">
                @csrf
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Nama Site</label>
                            <input type="text" value="Park Royale" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Nama Tenant</label>
                            <input type="text" value="{{ old('nama_tenant') }}" name="nama_tenant" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Email Tenant</label>
                            <input type="text" value="{{ old('email_tenant') }}" name="email_tenant" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Nik Tenant</label>
                            <input type="text" value="{{ old('nik_tenant') }}" maxlength="16" name="nik_tenant" class="form-control" required>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">ID Card Tenant</label>
                            <select class="form-control" name="id_card_type" required>
                                <option selected disabled>-- Pilih ID Card --</option>
                                @foreach ($idcards as $idcard)
                                    <option value="{{ $idcard->id_card_type }}" @if(old('id_card_type') == $idcard->id_card_type) selected @endif>{{ $idcard->card_id_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Status Hunian Tenant</label>
                            <select class="form-control" name="id_statushunian_tenant" required>
                                <option selected disabled>-- Pilih Status Hunian --</option>
                                @foreach ($statushunians as $statushunian)
                                    <option value="{{ $statushunian->id_statushunian_tenant }}" @if(old('id_statushunian_tenant') == $statushunian->id_statushunian_tenant) selected @endif>
                                        {{ $statushunian->status_hunian_tenant }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Kewarganegaraan</label>
                            <input type="text" value="{{ old('kewarganegaraan') }}" name="kewarganegaraan" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Masa Berlaku ID</label>
                            <input type="date" value="{{ old('masa_berlaku_id') }}" name="masa_berlaku_id" class="form-control" required>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Alamat KTP Tenant</label>
                            <textarea type="text" rows="10" name="alamat_ktp_tenant" class="form-control" required>
                                {{ old('alamat_ktp_tenant') }}
                            </textarea>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Provinsi</label>
                            <input type="text" value="{{ old('provinsi') }}" name="provinsi" class="form-control" required>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" value="{{ old('kode_pos') }}" name="kode_pos" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Alamat Tinggal Tenant</label>
                            <input type="text" value="{{ old('alamat_tinggal_tenant') }}" name="alamat_tinggal_tenant" class="form-control" required>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">No Telp Tenant </label>
                            <input type="text" value="{{ old('no_telp_tenant') }}" name="no_telp_tenant" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Nik Pasangan Penjamin</label>
                            <input type="text" value="{{ old('nik_pasangan_penjamin') }}" maxlength="16" name="nik_pasangan_penjamin" class="form-control" required>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Nama Pasangan Penjamin</label>
                            <input type="text" value="{{ old('nama_pasangan_penjamin') }}" name="nama_pasangan_penjamin" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Alamat KTP Pasangan Penjamin</label>
                            <input type="text" value="{{ old('alamat_ktp_pasangan_penjamin') }}" name="alamat_ktp_pasangan_penjamin" class="form-control" required>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Alamat Tinggal Pasangan Penjamin</label>
                            <input type="text" value="{{ old('alamat_tinggal_pasangan_penjamin') }}" name="alamat_tinggal_pasangan_penjamin" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Hubungan Penjamin</label>
                            <input type="text" value="{{ old('hubungan_penjamin') }}" name="hubungan_penjamin" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">No Telp Penjamin</label>
                            <input type="text" value="{{ old('no_telp_penjamin') }}" name="no_telp_penjamin" class="form-control" required>
                        </div>
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
            </form>
        </div>
    </div>
@endsection
