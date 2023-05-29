@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0 text-white">List Jenis Acara</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default text-600 btn-sm " href="{{ route('jenisacaras.create') }}">Tambah Jenis Acara</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="jenis_acara">Jenis Acara</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jenisacaras as $key => $jenisacara)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $jenisacara->jenis_acara }}</td>
                        <td>
                            <a href="{{ route('jenisacaras.edit', $jenisacara->id_jenis_acara) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('jenisacaras.destroy', $jenisacara->id_jenis_acara) }}" method="post">
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

