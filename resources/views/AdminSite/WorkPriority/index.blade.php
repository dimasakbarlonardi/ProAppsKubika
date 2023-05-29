@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0 text-white">List Work Priority</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default text-600 btn-sm" href="{{ route('workprioritys.create') }}">Tambah Work Priority</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="work_priority">Work Priority</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($workprioritys as $key => $workpriority)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $workpriority->work_priority }}</td>
                        <td>
                            <a href="{{ route('workprioritys.edit', $workpriority->id_work_priority) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('workprioritys.destroy', $workpriority->id_work_priority) }}" method="post">
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

