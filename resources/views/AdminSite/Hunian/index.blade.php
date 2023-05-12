@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header bg-light py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Hunian</h6>
            </div>
            {{-- <div class="col-auto d-flex">
                <a class="btn btn-primary" href="{{ route('hunians.create') }}">Tambah Hunian</a>
            </div> --}}
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_hunian">ID Hunian</th>
                    <th class="sort" data-sort="nama_hunian">Nama Hunian</th>
                   
                </tr>
            </thead>
            <tbody>
                @foreach ($hunians as $key => $hunian)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $hunian->id_hunian }}</td>
                        <td>{{ $hunian->nama_hunian }}</td>
                        {{-- <td>
                            <a href="{{ route('hunians.edit', $hunian->id_lantai) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('hunians.destroy', $hunian->id_lantai) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('are you sure?')">Hapus</button>
                            </form>
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

