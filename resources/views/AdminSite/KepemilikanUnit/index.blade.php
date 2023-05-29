@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-3">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="mb-0">List Kepemilikan Unit</h6>
                </div>
                <div class="col-auto d-flex">
                    <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('kepemilikans.create') }}">Tambah
                        Kepemilikan Unit</a>
                </div>
            </div>
        </div>
        <div class="p-5">
            <table class="table">
                <thead>
                    <tr>
                        <th class="sort" data-sort="">No</th>
                        <th class="sort" data-sort="">Owner</th>
                        <th class="sort" data-sort="">Kepemilikan Unit</th>
                        <th class="sort">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kepemilikans as $key => $kepemilikan)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $kepemilikan->nama_pemilik }}</td>
                            <td>
                                {{ $kepemilikan->Kepemilikan->count() }}
                            </td>
                            <td>
                                @if($kepemilikan->Kepemilikan->count() > 0)
                                    <a href="{{ route('kepemilikans.edit', $kepemilikan->id_pemilik) }}" class="btn btn-sm btn-warning">Edit</a>
                                @endif  
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
