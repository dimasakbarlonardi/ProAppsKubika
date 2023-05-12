@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header bg-light py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Tenant</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-primary" href="{{ route('tenants.create') }}">Tambah Tenant</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_tenant">ID Tenant</th>
                    <th class="sort" data-sort="id_site">ID Site</th>
                    <th class="sort" data-sort="id_user">ID User</th>
                    <th class="sort" data-sort="id_pemilik">ID Pemilik</th>
                    <th class="sort" data-sort="id_card_type">ID Card Type</th>
                    <th class="sort" data-sort="nik_tenant">Nik Tenant</th>
                    <th class="sort" data-sort="nama_tenant">Nama Tenant</th>
                    <th class="sort" data-sort="id_statushunian_tenant">ID Status Hunian Tenant</th>
                    <th class="sort" data-sort="kewarganegaraan">Kewarganegaraan</th>
                    <th class="sort" data-sort="masa_berlaku_id">Masa Berlaku ID</th>
                    <th class="sort" data-sort="alamat_ktp_tenant">Alamat KTP Tenant</th>
                    <th class="sort" data-sort="provinsi">Provinsi</th>
                    <th class="sort" data-sort="kode_pos">Kode Pos</th>
                    <th class="sort" data-sort="alamat_tinggal_tenant">Alamat Tinggal Tenant</th>
                    <th class="sort" data-sort="no_telp_tenant">No Telpon Tenant</th>
                    <th class="sort" data-sort="nik_pasangan_penjamin">NIK Pasangan Penjamin</th>
                    <th class="sort" data-sort="nama_pasangan_penjamin">Nama Pasangan Penjamin</th>
                    <th class="sort" data-sort="alamat_ktp_pasangan_penjamin">Alamat KTP Pasangan Penjamin</th>
                    <th class="sort" data-sort="alamat_tinggal_pasangan_penjamin">Alamat Tinggal Pasangan Penjamin</th>
                    <th class="sort" data-sort="hubungan_penjamin">Hubungan Penjamin</th>
                    <th class="sort" data-sort="no_telp_penjamin">No Telpon Penjamin</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tenants as $key => $tenant)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $tenant->id_tenant }}</td>
                        <td>{{ $tenant->id_site }}</td>
                        <td>{{ $tenant->id_user }}</td>
                        <td>{{ $tenant->id_pemilik }}</td>
                        <td>{{ $tenant->id_card_type }}</td>
                        <td>{{ $tenant->nik_tenant }}</td>
                        <td>{{ $tenant->nama_tenant  }}</td>
                        <td>{{ $tenant->id_statushunian_tenant }}</td>
                        <td>{{ $tenant->kewarganegaraan }}</td>
                        <td>{{ $tenant->masa_berlaku_id }}</td>
                        <td>{{ $tenant->alamat_ktp_tenant }}</td>
                        <td>{{ $tenant->provinsi }}</td>
                        <td>{{ $tenant->kode_pos }}</td>
                        <td>{{ $tenant->alamat_tinggal_tenant }}</td>
                        <td>{{ $tenant->no_telp_tenant }}</td>
                        <td>{{ $tenant->nik_pasangan_penjamin }}</td>
                        <td>{{ $tenant->nama_pasangan_penjamin }}</td>
                        <td>{{ $tenant->alamat_ktp_pasangan_penjamin }}</td>
                        <td>{{ $tenant->alamat_tinggal_pasangan_penjamin }}</td>
                        <td>{{ $tenant->hubungan_penjamin }}</td>
                        <td>{{ $tenant->no_telp_penjamin }}</td>
                        <td>
                            <a href="{{ route('getTenantUnit', $tenant->id_tenant) }}" class="btn btn-sm btn-primary">Tenant Unit</a>
                            <a href="{{ route('tenants.edit', $tenant->id_tenant) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('tenants.destroy', $tenant->id_tenant) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('are you sure?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

