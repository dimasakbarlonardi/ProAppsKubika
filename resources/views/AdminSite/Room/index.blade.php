@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="mb-0">List Room</h6>
                </div>
                <div class="col-auto d-flex">
                    <a class="btn btn-falcon-default btn-sm text-600" href="{{ url('/import_template/template_room.xlsx') }}"
                        download>
                        <span class="fas fa-plus fs--2 me-1"></span>Download Template
                    </a>
                    <button class="btn btn-falcon-default text-600 btn-sm ml-3" type="button" class="fas fa-plus"
                        data-bs-toggle="modal" data-bs-target="#modal-import">
                        + Import Excel
                    </button>
                    <a class="btn btn-falcon-default btn-sm text-600 ml-3" href="{{ route('rooms.create') }}">
                        <span class="fas fa-plus fs--2 me-1"></span>Create Room</a>
                </div>
            </div>
        </div>
        <div class="p-5">
            <div id="tableExample3" data-list='{"valueNames":["nama_tower", "nama_lantai", "nama_room"]'>
                <div class="row justify-content-end g-0">
                    <div class="col-auto col-sm-5 mb-3">
                        <form>
                            <div class="input-group">
                                <input class="form-control form-control-sm shadow-none search" type="search"
                                    placeholder="Search..." aria-label="search" />
                                <div class="input-group-text bg-transparent"><span
                                        class="fa fa-search fs--1 text-600"></span></div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive scrollbar">
                    <table class="table table-bordered table-striped fs--1 mb-0">
                        <thead>
                            <tr>
                                <th class="sort" data-sort="">No</th>
                                <th class="sort" data-sort="nama_tower">Tower</th>
                                <th class="sort" data-sort="nama_lantai">Floor</th>
                                <th class="sort">Barcode Room</th>
                                <th class="sort" data-sort="nama_room">Room Name</th>
                                <th class="sort">Action</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($rooms as $key => $room)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td class="nama_tower">{{ $room->tower->nama_tower }}</td>
                                    <td class="nama_lantai">{{ $room->floor->nama_lantai }}</td>
                                    <td>
                                        <img src="{{ url($room->barcode_room) }}" width="80">
                                    </td>
                                    <td class="nama_room">{{ $room->nama_room }}</td>
                                    <td>
                                        <a href="{{ route('rooms.edit', $room->id_room) }}"
                                            class="btn btn-sm btn-warning"><span
                                                class="fas fa-pencil-alt fs--2 me-1"></span>Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $rooms->links('vendor.pagination.bootstrap-4') }}
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
                <form action="{{ route('import-rooms') }}" method="post" enctype="multipart/form-data">
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
