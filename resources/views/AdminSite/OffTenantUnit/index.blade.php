@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="my-3 col-auto">
                <h6 class="mb-0 text-light">List OffBoarding Tenant Unit</h6>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_tenant">Tenant</th>
                    <th class="sort" data-sort="id_unit">Unit</th>
                    <th class="sort" data-sort="tgl_masuk">Tanggal Masuk</th>
                    <th class="sort" data-sort="tgl_keluar">Tanggal Keluar</th>
                    <th class="sort" data-sort="keterangan">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($offtenant as $key => $offtenantunit)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $offtenantunit->Tenant->nama_tenant }}</td>
                        <td>{{ $offtenantunit->Unit->nama_unit }}</td>
                        <td>{{ HumanDate($offtenantunit->tgl_masuk) }}</td>
                        <td>{{ HumanDate($offtenantunit->tgl_keluar) }}</td>
                        <td>{{ $offtenantunit->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

