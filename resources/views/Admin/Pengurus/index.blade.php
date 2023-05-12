@extends('layouts.master')

@section('header')
    <div class="d-flex justify-content-between">
        <div class="">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pengurus
            </h2>
        </div>
        <div class="">
            <a class="btn btn-primary" href="{{ route('penguruses.create') }}">
                Tambah
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="mb-0">List Pengurus</h6>
                </div>
                <div class="col-auto d-flex">
                    <a class="btn btn-primary" href="{{ route('penguruses.create') }}">Tambah Pengurus</a>
                </div>
            </div>
        </div>
        <div class="p-5">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Group</th>
                        <th scope="col">Nama pengurus</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Kode Pos</th>
                        <th scope="col">No Telp</th>
                        <th scope="col">Email</th>
                        <th scope="col">Provinsi</th>
                        <th scope="col">FB</th>
                        <th scope="col">Instagram</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penguruses as $key => $pengurus)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $pengurus->group->nama_group }}</td>
                            <td>{{ $pengurus->nama_pengurus }}</td>
                            <td>{{ $pengurus->alamat }}</td>
                            <td>{{ $pengurus->kode_pos }}</td>
                            <td>{{ $pengurus->no_telp1 }}</td>
                            <td>{{ $pengurus->email }}</td>
                            <td>{{ $pengurus->provinsi }}</td>
                            <td>{{ $pengurus->fb }}</td>
                            <td>{{ $pengurus->ig }}</td>
                            <td>
                                <a href="{{ route('penguruses.edit', $pengurus->id_pengurus) }}" class="btn btn-warning">Edit</a>
                                <form class="d-inline" action="{{ route('penguruses.destroy', $pengurus->id_pengurus) }}"
                                    method="post">
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
