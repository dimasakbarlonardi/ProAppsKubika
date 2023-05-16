@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header bg-light py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Penempatan</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-primary" href="{{ route('penempatans.create') }}">Tambah Penempatan</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_penempatan">ID Penempatan</th>
                    <th class="sort" data-sort="lokasi_penempatan">Lokasi Penempatan</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penempatans as $key => $penempatan)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $penempatan->id_penempatan }}</td>
                        <td>{{ $penempatan->lokasi_penempatan }}</td>
                        <td>
                            <a href="{{ route('penempatans.edit', $penempatan->id_penempatan) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('penempatans.destroy', $penempatan->id_penempatan) }}" method="post">
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

