@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header bg-light py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Work Relation</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-primary" href="{{ route('workrelations.create') }}">Tambah Work Relation</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_work_relation">ID Work Relation</th>
                    <th class="sort" data-sort="work_relation">Work Relation</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($workrelations as $key => $workrelation)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $workrelation->id_work_relation }}</td>
                        <td>{{ $workrelation->work_relation }}</td>
                        <td>
                            <a href="{{ route('workrelations.edit', $workrelation->id_work_relation) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('workrelations.destroy', $workrelation->id_work_relation) }}" method="post">
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

