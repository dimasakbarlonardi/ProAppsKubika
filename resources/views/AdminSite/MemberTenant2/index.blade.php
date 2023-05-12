@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header bg-light py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Member Tenant</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-primary" href="{{ route('membertenants.create') }}">Tambah Member Tenant</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_member_tenant">ID Member Tenant</th>
                    <th class="sort" data-sort="id_unit">ID Unit</th>
                    <th class="sort" data-sort="id_tenant">ID Tenant</th>
                    <th class="sort" data-sort="nik_tenant_member">NIK Tenant Member</th>
                    <th class="sort" data-sort="nama_tenant_member">Nama Tenant Member</th>
                    <th class="sort" data-sort="hubungan_tenant">Hubungan Tenant</th>
                    <th class="sort" data-sort="no_telp_member">No Telp Member</th>
                    <th class="sort" data-sort="id_status_tinggal">ID Status Tinggal</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($membertenants as $key => $membertenant)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $membertenant->id_tenant_member }}</td>
                        <td>{{ $membertenant->id_unit }}</td>
                        <td>{{ $membertenant->id_tenant }}</td>
                        <td>{{ $membertenant->nik_tenant_member }}</td>
                        <td>{{ $membertenant->nama_tenant_member }}</td>
                        <td>{{ $membertenant->hubungan_tenant }}</td>
                        <td>{{ $membertenant->no_telp_member }}</td>
                        <td>{{ $membertenant->id_status_tinggal }}</td>
                        <td>
                            <a href="{{ route('membertenants.edit', $membertenant->id_tenant_member) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('membertenants.destroy', $membertenant->id_tenant_member) }}" method="post">
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

