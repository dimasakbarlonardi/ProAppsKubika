@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header bg-light py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Jabatan</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-primary" href="{{ route('divisis.create') }}">Tambah Jabatan</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_divisi">ID Divisi</th>
                    <th class="sort" data-sort="nama_divisi">Nama Divisi</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($divisis as $key => $divisi)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $divisi->id_divisi }}</td>
                        <td>{{ $divisi->nama_divisi }}</td>
                        <td>
                            <a href="{{ route('divisis.edit', $divisi->id_divisi) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('divisis.destroy', $divisi->id_divisi) }}" method="post">
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

