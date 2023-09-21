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
                                <input name="schedule" type="date" class="form-control" required>
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
                                <button type="submit" class="btn btn-sm btn-warning">Edit</button>
                                <form action="{{ route('destroySchedules', $item->id_equipment_housekeeping) }}" method="post" class="d-inline">
                                    @csrf
                                    <button type="submit" onclick="return confirm('are you sure?')" class="btn btn-sm btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
@endsection
