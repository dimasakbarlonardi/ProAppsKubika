@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="my-3 col-auto">
                <h6 class="mb-0 text-light">List OffBoarding Tenant Unit</h6>
            </div>
            {{-- <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('offtenantunits.create') }}"><span class="fas fa-plus fs--2 me-1"></span>Tambah Departemen</a>
            </div> --}}
        </div>
    </div>
    <div class="p-5">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_tenant">Tenant</th>
                    <th class="sort" data-sort="id_unit">Unit</th>
                    <th class="sort" data-sort="id_periode_sewa">Periode Sewa</th>
                    <th class="sort" data-sort="tgl_masuk">Tanggal Masuk</th>
                    <th class="sort" data-sort="tgl_keluar">Tanggal Keluar</th>
                    <!-- <th class="sort" data-sort="id_pemilik">Owner</th> -->
                    <th class="sort" data-sort="sewa_ke">Sewa Ke</th>
                    <th class="sort" data-sort="keterangan">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($offtenantunits as $key => $offtenantunit)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $offtenantunit->Tenant->nama_tenant }}</td>
                        <td>{{ $offtenantunit->Unit->nama_unit }}</td>
                        <td>{{ $offtenantunit->id_periode_sewa }}</td>
                        <td>{{ $offtenantunit->tgl_masuk }}</td>
                        <td>{{ $offtenantunit->tgl_keluar }}</td>
                        <!-- <td>{{ $offtenantunit->id_pemilik }}</td> -->
                        <td>{{ $offtenantunit->sewa_ke }}</td>
                        <td>{{ $offtenantunit->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

