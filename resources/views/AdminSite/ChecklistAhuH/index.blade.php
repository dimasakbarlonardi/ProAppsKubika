@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="mb-0 text-white">List Inspection Engineering</h6>
                </div>
                <div class="col-auto d-flex">
                    <a class="btn btn-falcon-default btn-sm text-600"
                        href="{{ url('/import_template/template_equipment_engineering.xlsx') }}" download>
                        <span class="fas fa-plus fs--2 me-1"></span>Download Template
                    </a>
                    <button class="btn btn-falcon-default text-600 btn-sm ml-3" type="button" class="fas fa-plus"
                        data-bs-toggle="modal" data-bs-target="#modal-import">
                        + Import Equipment
                    </button>
                    <a class="btn btn-falcon-default btn-sm text-600 ml-3" href="{{ route('checklistahus.create') }}">
                        <span class="fas fa-plus fs--2 me-1"></span>Create Equipment Engineering </a>
                </div>
            </div>
        </div>
        <div class="p-5">
            <a href="{{ route('ahudetails.index') }}" class="btn btn-primary float-right mb-4">History Inspection</a>
            <table class="table" id="table-engineering">
                <thead>
                    <tr>
                        <th class="sort" data-sort="">No</th>
                        <th class="sort" data-sort="barcode_room">Equipment</th>
                        <th class="sort" data-sort="id_room">Room</th>
                        <th class="sort" data-sort="id_room">Barcode</th>
                        <th class="sort" data-sort="action">Action</th>
                    </tr>
                </thead>
                <tbody id="checklist_body">
                    @foreach ($checklistahus as $key => $checklistahu)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $checklistahu->equiqment }}</td>
                            <td>{{ $checklistahu->Room ? $checklistahu->Room->Tower->nama_tower : '' }} - {{ $checklistahu->Room ? $checklistahu->Room->Floor->nama_lantai : '' }}
                                - {{ $checklistahu->Room ? $checklistahu->Room->nama_room : '' }}</td>
                            <td>
                                <img width="150" src="{{ url($checklistahu->barcode_room ? $checklistahu->barcode_room : '') }}">
                            </td>
                            <td>
                                <div class="dropdown font-sans-serif position-static">
                                    <button class="btn btn-sm btn-warning" type="button" data-bs-toggle="dropdown"
                                        data-boundary="window" aria-haspopup="true" aria-expanded="false">
                                        <span class=""></span>Inspection/schedule
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end border py-0">
                                        <div class="py-2">
                                            <a class="dropdown-item text"
                                                href="{{ route('checklistengineering', $checklistahu->id_equiqment_engineering) }}">Inspection
                                                Parameter
                                            </a>
                                            <a class="dropdown-item text"
                                                href="{{ route('inspectionSchedules', $checklistahu->id_equiqment_engineering) }}">
                                                Schedules
                                            </a>
                                            <a class="dropdown-item text"
                                                href="{{ route('checklistahus.edit', $checklistahu->id_equiqment_engineering) }}">
                                                Edit Equipment
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-body p-0">
            <div class="form-check d-none">
                <input class="form-check-input" id="checkbox-bulk-card-tickets-select" type="checkbox"
                    data-bulk-select='{"body":"card-ticket-body","actions":"table-ticket-actions","replacedElement":"table-ticket-replace-element"}' />
            </div>
            <div class="list bg-light p-x1 d-flex flex-column gap-3" id="card-ticket-body">
                <div id="all-units">

                </div>
            </div>
            <div class="text-center d-none" id="tickets-card-fallback">
                <p class="fw-bold fs-1 mt-3">No request found</p>
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
                <form action="{{ route('importEquipmentEngineering') }}" method="post" enctype="multipart/form-data">
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

@section('script')
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script>
        new DataTable('#table-engineering');
    </script>
@endsection
