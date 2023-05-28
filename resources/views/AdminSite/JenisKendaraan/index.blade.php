@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-3">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Jenis Kendaraan</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('jeniskendaraans.create') }}">Tambah Jenis Kendaraan</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="jenis_kendaraan">Jenis Kendaraan</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jeniskendaraans as $key => $jeniskendaraan)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $jeniskendaraan->jenis_kendaraan }}</td>
                        <td>
                            <a href="{{ route('jeniskendaraans.edit', $jeniskendaraan->id_jenis_kendaraan) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('jeniskendaraans.destroy', $jeniskendaraan->id_jenis_kendaraan) }}" method="post">
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

