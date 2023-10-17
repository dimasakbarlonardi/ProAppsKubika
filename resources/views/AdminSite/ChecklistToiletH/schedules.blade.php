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
                    <h6 class="mb-0 text-white">Create Schedule Inspection {{ $eq->equipment }}</h6>
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
                                <button type="submit" class="btn btn-sm btn-warning"
                                    onclick="onEdit({{ $item->id_equipment_housekeeping_detail }})">Edit</button>
                                <form action="{{ route('deleteSchedulesHK', $item->id_equipment_housekeeping_detail) }}"
                                    method="post" class="d-inline">
                                    @csrf
                                    <button type="submit" onclick="return confirm('are you sure?')"
                                        class="btn btn-sm btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                        <div class="modal fade" id="editSchedule" data-bs-keyboard="false" data-bs-backdrop="static"
                            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md mt-6" role="document">
                                <div class="modal-content border-0">
                                    <div class="position-absolute top-0 end-0 mt-3 me-3 z-1">
                                        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                            data-bs-dismiss="modal" aria-label="Close">
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
                                                <form
                                                    action="{{ route('updateSchedulesHK', $item->id_equipment_housekeeping_detail) }}"
                                                    method="post">
                                                    @csrf
                                                    <input name="schedule"
                                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                        value="{{ $item->schedule }}" type="date" class="form-control"
                                                        required>

                                                    <div class="text-center mt-4">
                                                        <button class="btn btn-warning btn-sm"
                                                            type="submit">Update</button>
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
@endsection
@section('script')
    <script>
        function onEdit(id) {
            $('#editSchedule').modal('show')
        }
    </script>
@endsection
