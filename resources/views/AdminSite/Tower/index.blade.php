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
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="sort" data-sort="id_tower">No</th>
                    <th class="sort" data-sort="id_tower">Nama Tower</th>
                    <th class="sort" data-sort="jumlah_lantai">Jumlah lantai</th>
                    <th class="sort" data-sort="jumlah_unit">Jumlah Unit</th>
                    <th class="sort" data-sort="keterangan">Keterangan</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($towers as $key => $tower)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $tower->nama_tower }}</td>
                        <td>{{ $tower->jumlah_lantai }}</td>
                        <td>{{ $tower->jumlah_unit }}</td>
                        <td>{{ $tower->keterangan }}</td>
                        <td>
                            <a href="{{ route('towers.edit', $tower->id_tower) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('towers.destroy', $tower->id_tower) }}" method="post">
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

