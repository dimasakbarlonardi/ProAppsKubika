@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header bg-light py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Jenis Pekerjaan</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-primary" href="{{ route('jenispekerjaans.create') }}">Tambah Jenis Pekerjaan</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_jenis_pekerjaan">ID Jenis Pekerjaan</th>
                    <th class="sort" data-sort="jenis_pekerjaan">Jenis Pekerjaan</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jenispekerjaans as $key => $jenispekerjaan)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $gender->id_jenis_pekerjaan }}</td>
                        <td>{{ $gender->jenis_pekerjaan }}</td>
                        <td>
                            <a href="{{ route('jenispekerjaans.edit', $jenispekerjaan->id_jenis_pekerjaan) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('jenispekerjaans.destroy', $jenispekerjaan->id_jenis_pekerjaan) }}" method="post">
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

