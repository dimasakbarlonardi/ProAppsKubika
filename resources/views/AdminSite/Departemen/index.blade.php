@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header bg-light py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Departemen</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-primary" href="{{ route('departemens.create') }}">Tambah Departemen</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_departemen">ID Departemen</th>
                    <th class="sort" data-sort="nama_departemen">Nama Departemen</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($departemens as $key => $departemen)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $departemen->id_departemen }}</td>
                        <td>{{ $departemen->nama_departemen }}</td>
                        <td>
                            <a href="{{ route('departemens.edit', $departemen->id_departemen) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('departemens.destroy', $departemen->id_departemen) }}" method="post">
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

