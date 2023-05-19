@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header bg-light py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Kepemilikan Unit</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-primary" href="{{ route('kepemilikans.create') }}">Tambah Kepemilikan Unit</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_kepemilikan_unit">ID Kepemilikan Unit</th>
                    <th class="sort" data-sort="id_pemilik">ID Pemilik</th>
                    <th class="sort" data-sort="id_unit">ID Unit</th>
                    <th class="sort" data-sort="id_status_hunian">Status Hunian</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kepemilikans as $key => $kepemilikan)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $kepemilikan->id_kepemilikan_unit }}</td>
                        <td>{{ $kepemilikan->Owner->nama_pemilik }}</td>
                        <td>{{ $kepemilikan->id_unit }}</td>
                        <td>{{ $kepemilikan->StatusHunianTenant->status_hunian_tenant }}</td>
                        <td>
                            <a href="{{ route('kepemilikans.edit', $kepemilikan->id_kepemilikan_unit) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('kepemilikans.destroy', $kepemilikan->id_kepemilikan_unit) }}" method="post">
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

