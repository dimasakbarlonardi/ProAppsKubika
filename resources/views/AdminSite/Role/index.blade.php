@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="mb-0">List Role</h6>
                </div>
                <div class="col-auto d-flex">
                    <a class="btn btn-primary" href="{{ route('roles.create') }}">Tambah Role</a>
                </div>
            </div>
        </div>
        <div class="p-5">
            <div id="tableExample3" data-list='{"valueNames":["id_site", "nama_site", "email"],"page":5,"pagination":true}'>
                <div class="row justify-content-end g-0">
                    <div class="col-auto col-sm-5 mb-3">
                        <form>
                            <div class="input-group"><input class="form-control form-control-sm shadow-none search"
                                    type="search" placeholder="Search..." aria-label="search" />
                                <div class="input-group-text bg-transparent"><span
                                        class="fa fa-search fs--1 text-600"></span></div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive scrollbar">
                    <table class="table table-bordered table-striped fs--1 mb-0">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th class="sort">No</th>
                                <th class="sort">Nama Role</th>
                                <th class="sort">Action</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($roles as $key => $role)
                                <tr>
                                    <td class="id_site">{{ $key + 1 }}</td>
                                    <td class="id_site">{{ $role->nama_role }}</td>
                                    <td>
                                        <a href="{{ route('akses-form', $role->id) }}"
                                            class="btn btn-sm btn-primary">Access Role</a>
                                        <a href="{{ route('roles.edit', $role->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form class="d-inline" action="{{ route('roles.destroy', $role->id) }}"
                                            method="post">
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
                <div class="d-flex justify-content-center mt-3"><button class="btn btn-sm btn-falcon-default me-1"
                        type="button" title="Previous" data-list-pagination="prev"><span
                            class="fas fa-chevron-left"></span></button>
                    <ul class="pagination mb-0"></ul><button class="btn btn-sm btn-falcon-default ms-1" type="button"
                        title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"> </span></button>
                </div>
            </div>
        </div>
    </div>
@endsection
