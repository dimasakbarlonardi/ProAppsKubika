@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="my-3 col-auto">
                <h6 class="mb-0 text-light">List Jabatan</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('divisis.create') }}"><span class="fas fa-plus fs--2 me-1"></span>Tambah Jabatan</a>
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
                            <a href="{{ route('divisis.edit', $divisi->id) }}" class="btn btn-sm btn-warning"><span class="fas fa-pencil-alt fs--2 me-1"></span>Edit</a>
                            <form class="d-inline" action="{{ route('divisis.destroy', $divisi->id) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('are you sure?')"><span class="fas fa-trash-alt fs--2 me-1"></span>Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

