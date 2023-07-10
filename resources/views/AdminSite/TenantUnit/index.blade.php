@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0 text-white">List Tenant Unit</h6>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_tenant_unit">Tenant Unit</th>
                    <th class="sort" data-sort="id_tenant">Tenant</th>
                    <th class="sort" data-sort="id_unit">Unit</th>
                    <th class="sort" data-sort="id_periode_sewa">Periode Sewa</th>
                    <th class="sort" data-sort="tgl_masuk">Tanggal Masuk</th>
                    <th class="sort" data-sort="tgl_keluar">Tanggal Keluar</th>
                    <th class="sort" data-sort="tgl_jatuh_tempo_ipl">Taanggal Jatuh Tempo IPL</th>
                    <th class="sort" data-sort="tgl_jatuh_tempo_util">Taanggal Jatuh Tempo UTIL</th>
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
                     
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

