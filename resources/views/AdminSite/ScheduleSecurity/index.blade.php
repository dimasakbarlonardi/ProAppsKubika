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
                <h6 class="mb-0 text-white">List Schedule Security</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ url('/import_template/template_schedule_inspection_security.xlsx') }}" download>
                    <span class="fas fa-plus fs--2 me-1"></span>Download Template
                </a>
                <button class="btn btn-falcon-default text-600 btn-sm ml-3" type="button" class="fas fa-plus" data-bs-toggle="modal" data-bs-target="#modal-import">
                    + Import Inspection Security
                </button>
                <a class="btn btn-falcon-default btn-sm text-600 ml-3" href="{{ route('schedulesecurity.create') }}"><span class="fas fa-plus fs--2 me-1"></span>Create Schedule
                </a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <a href="{{ route('checklistsecurity.index') }}" class="btn btn-primary float-right mb-4">History Inspection</a>
        <table class="table table-striped" id="table-schedulesecurity">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort text-center" data-sort="id_room">Location</th>
                    <th class="sort text-center" data-sort="schedule">Schedule</th>
                    <th class="sort text-center" data-sort="shift">Shift</th>
                    <th class="sort text-center">Action</th>
                </tr>
            </thead>
            <tbody id="checklist_body">
                @foreach ($schedulesec as $key => $security)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td class="text-center">{{ $security->Room ? $security->Room->Tower->nama_tower : '' }} - {{ $security->Room ? $security->Room->Floor->nama_lantai : '' }}
                        - {{ $security->Room ? $security->Room->nama_room : '' }}</td>
                    <td class="text-center">{{ HumanDate($security->schedule) }}</td>
                    <td class="text-center">{{ $security->Shift ? $security->Shift->shift : '' }} - ( {{ $security->Shift ? HumanTime($security->Shift->start_time) : '' }}-{{ $security->Shift ? HumanTime($security->Shift->end_time) : '' }} ) </td>
                    <td class="text-center">
                        <a href="{{ route('schedulesecurity.show', $security->id) }}" class="btn btn-sm btn-warning"><span class="fas fa-pencil-alt fs--2 me-1"></span>Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-body p-0">
        <div class="form-check d-none">
            <input class="form-check-input" id="checkbox-bulk-card-tickets-select" type="checkbox" data-bulk-select='{"body":"card-ticket-body","actions":"table-ticket-actions","replacedElement":"table-ticket-replace-element"}' />
        </div>
        <div class="list bg-light p-x1 d-flex flex-column gap-3" id="card-ticket-body">
            <div id="all-units">

            </div>
        </div>
        <div class="text-center d-none" id="tickets-card-fallback">
            <p class="fw-bold fs-1 mt-3">No ticket found</p>
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-center">
            <button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous" data-list-pagination="prev">
                <span class="fas fa-chevron-left"></span>
            </button>
            <ul class="pagination mb-0"></ul>
            <button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next">
                <span class="fas fa-chevron-right"></span>
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
        <div class="modal-content position-relative">
            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('importSchedulesSecurity') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-0">
                    <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                        <h4 class="mb-4" id="modalExampleDemoLabel">Upload Exc File </h4>
                        <div class="mb-3">
                            <input type="file" name="file_excel" class="form-control" required>
                        </div>
                    </div>else
                </div>
                <input type="hidden" name="id_parameter_security" value="{{ $eq->id }}">
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
    new DataTable('#table-schedulesecurity');
</script>
@endsection