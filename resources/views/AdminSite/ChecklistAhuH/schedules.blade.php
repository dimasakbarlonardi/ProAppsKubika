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
                <a href="{{ route('checklistahus.index') }}" class="btn btn-falcon-default btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <div class="ml-3">Create Schedule Inspection {{ $eq->equiqment }}</div>
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
                <form action="{{ route('postSchedules', $eq->id_equiqment_engineering) }}" method="post">
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
                        <button type="submit" class="btn btn-sm btn-warning" onclick="onEdit({{ $item->id_equiqment_engineering_detail }})">Edit</button>
                        <form action="{{ route('destroySchedules', $item->id_equiqment_engineering_detail) }}" method="post" class="d-inline">
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
                                        <form action="{{ route('updateSchedulesENG', $item->id_equiqment_engineering_detail) }}" method="post">
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
    <div class="card-body p-0">
        <div class="form-check d-none">
            <input class="form-check-input" id="checkbox-bulk-card-tickets-select" type="checkbox" data-bulk-select='{"body":"card-ticket-body","actions":"table-ticket-actions","replacedElement":"table-ticket-replace-element"}' />
        </div>
        <div class="list bg-light p-x1 d-flex flex-column gap-3" id="card-ticket-body">
            <div id="all-units">

            </div>
        </div>
        <div class="text-center d-none" id="tickets-card-fallback">
            <p class="fw-bold fs-1 mt-3">No request found</p>
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
@endsection

@section('script')
<script>
    function onEdit(id) {
        $('#editSchedule').modal('show')
    }
</script>
@endsection