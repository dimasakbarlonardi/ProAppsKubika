@extends('layouts.master')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
@endsection

@section('content')
<div class="card">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ route('checklisttoilets.index') }}" class="btn btn-falcon-default btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <div class="ml-3">Create Schedule Inspection {{ $eq->equipment }}</div>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ url('/import_template/template_schedule_inspection_housekeeping.xlsx') }}" download>
                    <span class="fas fa-plus fs--2 me-1"></span>Download Template
                </a>
                <button class="btn btn-falcon-default text-600 btn-sm ml-3" type="button" class="fas fa-plus" data-bs-toggle="modal" data-bs-target="#modal-import">
                    + Import Schedule
                </button>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table" id="table-engineering">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="barcode_room">Schedule</th>
                    <th class="sort" data-sort="action">Action</th>
                </tr>
            </thead>
            <tbody id="checklist_body">
                @php
                $index = 0;
                @endphp
                <form action="{{ route('postSchedulesHK', $eq->id_equipment_housekeeping) }}" method="post">
                    @csrf
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <input name="schedule" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" type="date" class="form-control" required>
                        </td>
                        <td>
                            <button type="submit" class="btn btn-sm btn-success">Add</button>
                        </td>
                    </tr>
                </form>
                @foreach ($schedules as $key => $item)
                @php
                $index += 1;
                @endphp
                <tr>
                    <th scope="row">{{ $index }}</th>
                    <td>{{ HumanDate($item->schedule) }}</td>
                    <td>
                        <button type="submit" class="btn btn-sm btn-warning" onclick="onEdit({{ $item->id_equipment_housekeeping_detail }})">Edit</button>
                        <form action="{{ route('deleteSchedulesHK', $item->id_equipment_housekeeping_detail) }}" method="post" class="d-inline">
                            @csrf
                            <button type="submit" onclick="return confirm('are you sure?')" class="btn btn-sm btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
                <div class="modal fade" id="editSchedule" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md mt-6" role="document">
                        <div class="modal-content border-0">
                            <div class="position-absolute top-0 end-0 mt-3 me-3 z-1">
                                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body p-0">
                                <div class="bg-light rounded-top-3 py-3 ps-4 pe-6 text-center">
                                    <h4 class="mb-1" id="staticBackdropLabel">
                                        Edit Schedule
                                    </h4>
                                </div>
                                <div class="p-4">
                                    <div id="modalListErrors">
                                        <form action="{{ route('updateSchedulesHK', $item->id_equipment_housekeeping_detail) }}" method="post">
                                            @csrf
                                            <input name="schedule" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $item->schedule }}" type="date" class="form-control" required>

                                            <div class="text-center mt-4">
                                                <button class="btn btn-warning btn-sm" type="submit">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
        <div class="modal-content position-relative">
            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('importSchedulesHousekeeping') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-0">
                    <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                        <h4 class="mb-4" id="modalExampleDemoLabel">Upload Excel File </h4>
                        <div class="mb-3">
                            <input type="file" name="file_excel" class="form-control" required>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id_equipment_housekeeping" value="{{ $eq->id_equipment_housekeeping }}">
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    function onEdit(id) {
        $('#editSchedule').modal('show')
    }
</script>
@endsection