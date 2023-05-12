@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header bg-light py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Kendaraan Tenant</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-primary" href="{{ route('kendaraans.create') }}">Tambah Kendaraan Tenant</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_tenant_vehicle">ID Member Tenant</th>
                    <th class="sort" data-sort="id_tenant">ID Tenant</th>
                    <th class="sort" data-sort="id_unit">ID Unit</th>
                    <th class="sort" data-sort="id_jenis_kendaraan">ID Jensi Kendaraan</th>
                    <th class="sort" data-sort="no_polisi">No Polisi</th>

                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kendaraans as $key => $kendaraan)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $kendaraan->id_tenant_vehicle }}</td>
                        <td>{{ $kendaraan->id_tenant }}</td>
                        <td>{{ $kendaraan->id_unit }}</td>
                        <td>{{ $kendaraan->id_jenis_kendaraan }}</td>
                        <td>{{ $kendaraan->no_polisi }}</td>
                        <td>
                            <a href="{{ route('kendaraans.edit', $kendaraan->id_tenant_vehicle) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('kendaraans.destroy', $kendaraan->id_tenant_vehicle) }}" method="post">
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

