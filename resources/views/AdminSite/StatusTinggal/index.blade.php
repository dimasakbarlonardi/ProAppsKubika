@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="my-3 col-auto">
                <h6 class="mb-0 text-white">List Status Tinggal</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default text-600 btn-sm" href="{{ route('statustinggals.create') }}"><span class="fas fa-plus fs--2 me-1"></span>Create Status Tinggal</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="status_tinggal">Status Tinggal</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($statustinggals as $key => $statustinggal)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $statustinggal->status_tinggal }}</td>
                        <td>
                            <a href="{{ route('statustinggals.edit', $statustinggal->id_status_tinggal) }}" class="btn btn-sm btn-warning"><span class="fas fa-pencil-alt fs--2 me-1"></span>Edit</a>
                            <form class="d-inline" action="{{ route('statustinggals.destroy', $statustinggal->id_status_tinggal) }}" method="post">
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

