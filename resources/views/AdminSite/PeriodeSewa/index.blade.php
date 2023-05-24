@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0 text-white">List Periode Sewa</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default text-600 btn-sm" href="{{ route('sewas.create') }}">Tambah Periode Sewa</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_periode_sewa">ID Periode Sewa</th>
                    <th class="sort" data-sort="periode_sewa">Periode Sewa</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sewas as $key => $sewa)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $sewa->id_periode_sewa }}</td>
                        <td>{{ $sewa->periode_sewa }}</td>
                        <td>
                            <a href="{{ route('sewas.edit', $sewa->id_periode_sewa) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('sewas.destroy', $sewa->id_periode_sewa) }}" method="post">
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

