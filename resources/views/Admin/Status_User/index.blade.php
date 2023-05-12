@extends('layouts.master')

@section('header')
    <div class="d-flex justify-content-between">
        <div class="">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User
            </h2>
        </div>
        <div class="">
            <a class="btn btn-primary" href="{{ route('users.create') }}">
                Tambah
            </a>
        </div>
    </div>
@endsection

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Email</th>
                <th scope="col">Nama User</th>
                <th scope="col">Id Site</th>
                <th scope="col">Id Role</th>
                <th scope="col">Id Status User</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $key => $user)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->nama_user }}</td>
                    <td>{{ $user->id_site }}</td>
                    <td>{{ $user->id_role }}</td>
                    <td>{{ $user->id_status_user }}</td>
                    <td>
                        <a href="{{  route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                        <form class="d-inline" action="{{ route('users.destroy', $user->id) }}" method="post">
                            @method("DELETE")
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('are you sure?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
