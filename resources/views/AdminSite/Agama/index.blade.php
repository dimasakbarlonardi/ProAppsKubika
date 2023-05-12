@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header bg-light py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Agama</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-primary" href="{{ route('agamas.create') }}">Tambah Agama</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_agama">ID Agama</th>
                    <th class="sort" data-sort="nama_agama">Nama Agama</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($agamas as $key => $agama)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $agama->id_agama }}</td>
                        <td>{{ $agama->nama_agama }}</td>
                        <td>
                            <a href="{{ route('agamas.edit', $agama->id_agama) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('agamas.destroy', $agama->id_agama) }}" method="post">
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

