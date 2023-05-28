@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-3">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Jenis Kelamin</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('genders.create') }}">Tambah Jenis Kelamin</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="jenis_kelamin">Jenis Kelamin</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($genders as $key => $gender)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $gender->jenis_kelamin }}</td>
                        <td>
                            <a href="{{ route('genders.edit', $gender->id_jenis_kelamin) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('genders.destroy', $gender->id_jenis_kelamin) }}" method="post">
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

