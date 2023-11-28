@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="mb-0">List Engeneering Inspection Parameter</h6>
                </div>
                <div class="col-auto d-flex">
                    <a class="btn btn-falcon-default btn-sm text-600"
                        href="{{ url('/import_template/template_engineering_parameter.xlsx') }}" download>
                        <span class="fas fa-plus fs--2 me-1"></span>Download Template
                    </a>
                    <button class="btn btn-falcon-default text-600 btn-sm ml-3" type="button" class="fas fa-plus"
                        data-bs-toggle="modal" data-bs-target="#modal-import">
                        + Import Parameter
                    </button>
                    <a class="btn btn-falcon-default btn-sm text-600 ml-3" href="{{ route('engahus.create') }}"><span
                            class="fas fa-plus fs--2 me-1"></span>Create Parameter
                    </a>
                </div>
            </div>
        </div>
        <div class="p-5">
            <div id="tableExample3" data-list='{"valueNames":["nama_eng_ahu"],"page":10,"pagination":true}'>
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
                    <div class="table-responsive scrollbar">
                        <table class="table table-bordered table-striped fs--1 mb-0">
                            <thead>
                                <tr>
                                    <th class="sort" data-sort="">No</th>
                                    <th class="sort" data-sort="nama_eng_ahu">Engineering Inspection Parameter</th>
                                    <th class="sort">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($engahus as $key => $engahu)
                                    <tr>
                                        <th scope="row">{{ $engahus->firstItem() + $key }}</th>
                                        <td class="nama_eng_ahu">{{ $engahu->nama_eng_ahu }}</td>
                                        <td>
                                            <a href="{{ route('engahus.edit', $engahu->id_eng_ahu) }}"
                                                class="btn btn-sm btn-warning"><span
                                                    class="fas fa-pencil-alt fs--2 me-1"></span>Edit</a>
                                            <form class="d-inline"
                                                action="{{ route('engahus.destroy', $engahu->id_eng_ahu) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('are you sure?')">
                                                    <span class="fas fa-trash-alt fs--2 me-1"></span>Hapus
                                                </button>
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

        <div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
                <div class="modal-content position-relative">
                    <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('importEngParameter') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body p-0">
                            <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                <h4 class="mb-4" id="modalExampleDemoLabel">Upload Excel File </h4>
                                <div class="mb-3">
                                    <input type="file" name="file_excel" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
