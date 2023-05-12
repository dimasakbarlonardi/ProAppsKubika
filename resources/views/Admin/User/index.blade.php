@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="mb-0">List Logins</h6>
                </div>
                <div class="col-auto d-flex">
                    <a class="btn btn-primary" href="{{ route('logins.create') }}">Tambah Akun</a>
                </div>
            </div>
        </div>
        <div class="p-5">
            <table class="table">
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
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->id_site }}</td>
                            <td>
                                <a href="{{ route('logins.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                                <form class="d-inline" action="{{ route('logins.destroy', $user->id) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger"
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
