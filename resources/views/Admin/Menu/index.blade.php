@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="mb-0">List Menu</h6>
                </div>
                <div class="col-auto d-flex">
                    <a class="btn btn-primary" href="{{ route('create-menu', $id) }}">Tambah Menu</a>
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
                                <th class="sort" data-sort="id_site">No</th>
                                <th class="sort" data-sort="nama_site">Caption</th>
                                <th class="sort" data-sort="nama_site">Route Name</th>
                                <th class="sort">Action</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($menus as $menu)
                                <tr>
                                    <td class="id_site">{{ $menu->id }}</td>
                                    <td class="nama_site">{{ $menu->caption }}</td>
                                    <td class="nama_site">{{ $menu->route_name }}</td>
                                    <td>
                                        <a href="{{ route('menus.show', $menu->id) }}" class="btn btn-sm btn-primary">Submenu</a>
                                        <a href="{{ route('sites.edit', $menu->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form class="d-inline" action="{{ route('sites.destroy', $menu->id) }}"
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
