@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="mb-0">List Users</h6>
                </div>
                <div class="col-auto d-flex">
                    <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('users.create') }}">Tambah User</a>
                </div>
            </div>
        </div>
        <div class="p-5">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Email</th>
                        <th scope="col">Nama User</th>
                        <th scope="col">ID Site</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $user->login_user }}</td>
                            <td>{{ $user->nama_user }}</td>
                            <td>{{ $user->id_site }}</td>
                            <td>
                                <a href="{{ route('users.edit', $user->id_user) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form class="d-inline" action="{{ route('users.destroy', $user->id_user) }}" method="post">
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
