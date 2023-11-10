@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0 text-light">List Tower</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('towers.create') }}">Tambah Tower</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <div id="tableExample3" data-list='{"valueNames":["nama_tower", "jumlah_lantai", "email"],"page":10,"pagination":true}'>
            <div class="row justify-content-end g-0">
                <div class="col-auto col-sm-5 mb-3">
                    <form>
                        <div class="input-group"><input class="form-control form-control-sm shadow-none search" type="search" placeholder="Search..." aria-label="search" />
                            <div class="input-group-text bg-transparent"><span class="fa fa-search fs--1 text-600"></span></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive scrollbar">
                <table class="table table-bordered table-striped fs--1 mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Tower</th>
                            <th>Jumlah lantai</th>
                            <th>Jumlah Unit</th>
                            <th>Keterangan</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @foreach ($towers as $key => $tower)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td class="nama_tower">{{ $tower->nama_tower }}</td>
                            <td class="jumlah_lantai">{{ $tower->jumlah_lantai }}</td>
                            <td>{{ $tower->jumlah_unit }}</td>
                            <td>{{ $tower->keterangan }}</td>
                            <td>
                                <a href="{{ route('towers.edit', $tower->id_tower) }}" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3"><button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                <ul class="pagination mb-0"></ul><button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"> </span></button>
            </div>
        </div>
    </div>
</div>
@endsection