@extends('layouts.master')

@section('content')
    <div class="card">
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
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Nama Site</label>
                            <input type="text" value="Park Royale" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Nama Tenant</label>
                            <input type="text" name="nama_tenant" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Nik Tenant</label>
                            <input type="text" name="nik_tenant" class="form-control" required>
                        </div>

                        {{-- note id user --}}
                        {{-- <div class="col-6 ">
                            <label class="form-label">ID User</label>
                            <input type="text" value="ID : {{ $idusers->id }} Nama : {{ $idusers->name }}" class="form-control" readonly>
                        </div> --}}

                        {{-- pinda tenant unit --}}
                        {{-- <div class="col-5">
                            <label class="form-label">ID Pemilik</label>
                            <select class="form-control" name="id_pemilik" required>
                                <option selected disabled>-- Pilih ID Pemilik --</option>
                                @foreach ($idpemiliks as $idpemilik)
                                <option value="{{ $idpemilik->id_pemilik }}">{{ $idpemilik->nama_pemilik }} {{ $idcard->id_card_type }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="col-6">
                            <label class="form-label">ID Card Tenant</label>
                            <select class="form-control" name="id_card_type" required>
                                <option selected disabled>-- Pilih ID Card --</option>
                                @foreach ($idcards as $idcard)
                                <option value="{{ $idcard->id_card_type }}">{{ $idcard->card_id_name }} {{ $idcard->id_card_type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                        {{-- note edit --}}
                        <div class="row">
                        <div class="col-6">
                            <label class="form-label">Status Hunian Tenant</label>
                            <select class="form-control" name="id_statushunian_tenant" required>
                                <option selected disabled>-- Pilih Status Hunian --</option>
                                @foreach ($statushunians as $statushunian)
                                <option value="{{ $statushunian->id_statushunian_tenant }}">{{ $statushunian->status_hunian_tenant }} {{ $statushunian->id_statushunian_tenant }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Kewarganegaraan</label>
                            <input type="text" name="kewarganegaraan" class="form-control" required>
                        </div>
                        </div>

                        <div class="row">
                        <div class="col-6">
                            <label class="form-label">Masa Berlaku ID</label>
                            <input type="date" name="masa_berlaku_id" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Alamat KTP Tenant</label>
                           <input type="text" rows ="10" name="alamat_ktp_tenant" class="form-control" required>
                        </div>
                        </div>

                        <div class="row">
                        <div class="col-6">
                            <label class="form-label">Provinsi</label>
                            <input type="text" name="provinsi" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" name="kode_pos" class="form-control" required>
                        </div>
                        </div>

                        <div class="row">
                        <div class="col-6">
                            <label class="form-label">Alamat Tinggal Tenant</label>
                            <input type="text" name="alamat_tinggal_tenant" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">No Telp Tenant </label>
                            <input type="text" name="no_telp_tenant" class="form-control" required>
                        </div>
                        </div>

                        <div class="row">
                        <div class="col-6">
                            <label class="form-label">Nik Pasangan Penjamin</label>
                            <input type="text" name="nik_pasangan_penjamin" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Nama Pasangan Penjamin</label>
                            <input type="text" name="nama_pasangan_penjamin" class="form-control" required>
                        </div>
                        </div>

                        <div class="row">
                        <div class="col-6">
                            <label class="form-label">Alamat KTP Pasangan Penjamin</label>
                            <input type="text" name="alamat_ktp_pasangan_penjamin" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Alamat Tinggal Pasangan Penjamin</label>
                            <input type="text" name="alamat_tinggal_pasangan_penjamin" class="form-control" required>
                        </div>
                        </div>

                        <div class="row">
                        <div class="col-6">
                            <label class="form-label">Hubungan Penjamin</label>
                            <input type="text" name="hubungan_penjamin" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">No Telp Penjamin</label>
                            <input type="text" name="no_telp_penjamin" class="form-control" required>
                        </div>
                        </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
