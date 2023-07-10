@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="my-3 col-auto">
                <h6 class="mb-0 text-light">List OffBoarding Kepemilikan Unit</h6>
            </div>
            {{-- <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('offtenantunits.create') }}"><span class="fas fa-plus fs--2 me-1"></span>Tambah Departemen</a>
            </div> --}}
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_pemilik">Pemillik</th>
                    <th class="sort" data-sort="id_unit">Unit</th>
                    <th class="sort" data-sort="id_status_hunian">Status Hunian</th>
                    <th class="sort" data-sort="tgl_sys">Tanggal System</th>
                    <th class="sort" data-sort="tgl_masuk">Tanggal Masuk</th>
                    <th class="sort" data-sort="tgl_keluar">Tanggal Keluar</th>
                    <th class="sort" data-sort="no_bukti_milik">No Bukti Milik</th>
                    <th class="sort" data-sort="keterangan">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($offkepemilikanunits as $key => $offkepemilikanunit)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $offkepemilikanunit->id_pemilik }}</td>
                        <td>{{ $offkepemilikanunit->id_unit }}</td>
                        <td>{{ $offkepemilikanunit->id_status_hunian }}</td>
                        <td>{{ $offkepemilikanunit->tgl_sys }}</td>
                        <td>{{ $offkepemilikanunit->tgl_masuk }}</td>
                        <td>{{ $offkepemilikanunit->tgl_keluar }}</td>
                        <td>{{ $offkepemilikanunit->no_bukti_milik }}</td>
                        <td>{{ $offkepemilikanunit->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

