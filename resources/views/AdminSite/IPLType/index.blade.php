@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List IPL Type</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('ipltypes.create') }}">Tambah IPL Type</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_jabatan">ID IPL</th>
                    <th class="sort" data-sort="nama_jabatan">Nama IPL Type</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ipltypes as $key => $ipltype)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $ipltype->id_ipl_type }}</td>
                        <td>{{ $ipltype->nama_ipl_type }}</td>
                        <td>{{ $ipltype->biaya_permeter }}</td>
                        <td>{{ $ipltype->biaya_procentage }}</td>
                        <td>
                            <a href="{{ route('ipltypes.edit', $ipltype->id_ipl_type) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('ipltypes.destroy', $ipltype->id_ipl_type) }}" method="post">
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

