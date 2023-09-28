@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-3">
        <div class="row flex-between-center">
            <div class="my-3 col-auto">
                <h6 class="mb-0">List Jenis Pekerjaan</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('jenispekerjaans.create') }}"><span class="fas fa-plus fs--2 me-1"></span>Create Jenis Pekerjaan</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="jenis_pekerjaan">Jenis Pekerjaan</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jenispekerjaans as $key => $jenispekerjaan)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $jenispekerjaan->jenis_pekerjaan }}</td>
                        <td>
                            <a href="{{ route('jenispekerjaans.edit', $jenispekerjaan->id_jenis_pekerjaan) }}" class="btn btn-sm btn-warning"><span class="fas fa-pencil-alt fs--2 me-1"></span>Edit</a>
                            <form class="d-inline" action="{{ route('jenispekerjaans.destroy', $jenispekerjaan->id_jenis_pekerjaan) }}" method="post">
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

