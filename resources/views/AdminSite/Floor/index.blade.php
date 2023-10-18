@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0 text-light">List Floor</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('floors.create') }}">Tambah Lantai</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="nama_lantai">Nama Lantai</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($floors as $key => $floor)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $floor->nama_lantai }}</td>
                        <td>
                            <a href="{{ route('floors.edit', $floor->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('floors.destroy', $floor->id) }}" method="post">
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

