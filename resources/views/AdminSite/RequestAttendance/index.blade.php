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
                <h6 class="mb-0 text-white">List Request Attendance</h6>
            </div>
        </div>
    </div>
    <div class="p-5 justify-content-center">
        <table class="table" id="table-requestattendance">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="date">Date</th>
                    <th class="sort" data-sort="id_request_type">Request Type</th>
                    <th class="sort" data-sort="status">Status</th>
                </tr>
            </thead>
            <tbody id="checklist_body">
                @foreach ($requestattendance as $key => $request)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td> {{ \Carbon\Carbon::parse($request->date_in)->format(' d M Y') }} - {{ \Carbon\Carbon::parse($request->date_out)->format(' d M Y') }}</td>
                        <td>{{ $request->RequestType->name_request }}</td>
                        <td> 
                            @if ($request->status == 0)
                            <span class="badge rounded-pill badge-subtle-success">Approve</span>
                            @elseif ($request->status == 1)
                            <span class="badge rounded-pill badge-subtle-danger">Reject</span>
                            @endif
                        </td>
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
    new DataTable('#table-requestattendance');
</script>
@endsection