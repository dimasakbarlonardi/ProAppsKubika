@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header bg-light py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Tenant Unit</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-primary" href="{{ route('tenantunits.create') }}">Tambah Tenant Unit</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_tenant_unit">ID Tenant Unit</th>
                    <th class="sort" data-sort="id_tenant">ID Tenant</th>
                    <th class="sort" data-sort="id_unit">ID Unit</th>
                    <th class="sort" data-sort="id_periode_sewa">ID Periode Sewa</th>
                    <th class="sort" data-sort="tgl_masuk">Tanggal Masuk</th>
                    <th class="sort" data-sort="tgl_keluar">Tanggal Keluar</th>
                    <th class="sort" data-sort="tgl_jatuh_tempo_ipl">Taanggal Jatuh Tempo IPL</th>
                    <th class="sort" data-sort="tgl_jatuh_tempo_util">Taanggal Jatuh Tempo UTIL</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tenantunits as $key => $tenantunit)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $tenantunit->id_tenant_unit }}</td>
                        <td>{{ $tenantunit->id_tenant }}</td>
                        <td>{{ $tenantunit->id_unit }}</td>
                        <td>{{ $tenantunit->id_periode_sewa }}</td>
                        <td>{{ $tenantunit->tgl_masuk }}</td>
                        <td>{{ $tenantunit->tgl_keluar }}</td>
                        <td>{{ $tenantunit->tgl_jatuh_tempo_ipl }}</td>
                        <td>{{ $tenantunit->tgl_jatuh_tempo_util }}</td>
                        <td>
                            <a href="{{ route('tenantunits.edit', $tenantunit->id_tenant) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('tenantunits.destroy', $tenantunit->id_tenant) }}" method="post">
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

