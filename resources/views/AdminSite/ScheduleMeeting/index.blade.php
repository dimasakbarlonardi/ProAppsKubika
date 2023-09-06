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
                <h6 class="mb-0 text-white">List Schedule Meeting</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default text-600 btn-sm" href="{{ route('schedulemeeting.create') }}"><span class="fas fa-plus fs--2 me-1"></span>Create Schedule Meeting</a>
            </div>
        </div>
    </div>
    <div class="p-5 justify-content-center">
        <table class="table" id="table-schedulemeeting">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="meeting">Meeting</th>
                    <th class="sort" data-sort="date">Date</th>
                    <th class="sort" data-sort="id_room">Room</th>
                    <th class="sort" data-sort="time">Time</th>
                    {{-- <th class="sort" data-sort="action">Action</th> --}}
                </tr>
            </thead>
            <tbody id="checklist_body">
                @foreach ($schedulemeeting as $key => $meeting)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $meeting->meeting }}</td>
                        <td> {{ \Carbon\Carbon::parse($meeting->date)->format(' d M Y') }}</td>
                        <td>{{ $meeting->Room->nama_room }}</td>
                        <td> {{ \Carbon\Carbon::parse($meeting->time_in)->format(' h:i') }} - {{ \Carbon\Carbon::parse($meeting->time_out)->format(' h:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script>
    new DataTable('#table-schedulemeeting');
</script>
@endsection