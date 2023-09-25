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
                    <h6 class="mb-0 text-white">List Visitor</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <table class="table table-striped" id="table-visitor">
                <thead>
                    <tr>
                        <th class="sort" data-sort="">No</th>
                        <th class="sort" data-sort="name_visitor">Name Visitor</th>
                        <th class="sort" data-sort="arrival_date">Arrival Time</th>
                        <th class="sort" data-sort="heading_to">Meet with</th>
                        <th class="sort" data-sort="unit">Unit</th>
                        <th class="sort" data-sort="desc">Purpose</th>
                        <th class="sort" data-sort="desc">Leave Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($visitors as $key => $visitor)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $visitor->name_visitor}}</td>
                            <td>{{ $visitor->arrival_date }} - {{ $visitor->arrival_time}}</td>
                            <td>{{ $visitor->heading_to }}</td>
                            <td>{{ $visitor->Unit->nama_unit }}</td>
                            <td>{{ $visitor->desc }}</td>
                            <td>{{ $visitor->arrival_date }} - {{ $visitor->leave_time}}</td>
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
    new DataTable('#table-visitor');
</script>
@endsection