@extends('layouts.master')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
@endsection

<style>
    #table-engineeringhistory tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #table-engineeringhistory tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }
</style>

@section('content')
<div class="card">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ route('checklistahus.index') }}" class="btn btn-falcon-default btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <div class="ml-3">List Inspection Engineering</div>
            </div>
        </div>
    </div>
    <div class="p-5">
        <div class="row">
            <table class="table table-striped alternating-rows" id="table-engineeringhistory">
                <thead>
                    <tr>
                        <th class="sort" data-sort="">No</th>
                        <th class="sort" data-sort="image">Image</th>
                        <th class="sort" data-sort="equipment">No. Equipment</th>
                        <th class="sort" data-sort="equipment">Equipment</th>
                        <th class="sort" data-sort="room">Location</th>
                        <th class="sort" data-sort="inspection">Inspection Engineering</th>
                        <th class="sort" data-sort="pic">CheckBy</th>
                        <th class="sort" data-sort="tgl_checklist">Check Date</th>
                        <th class="sort" data-sort="tgl_checklist">Status Checklist</th>
                    </tr>
                </thead>
                <tbody id="checklist_body">
                    @foreach ($equiqmentdetails as $key => $detail)
                    @php
                    $status = json_decode($detail->status);
                    @endphp
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>
                            <a href="{{ $detail->image ? asset($detail->image) : asset('/assets/img/team/3-thumb.png') }}" data-bs-toggle="modal" data-bs-target="#image-modal{{ $detail->id_equiqment_engineering_detail }}" data-image="{{ $detail->image ? asset($detail->image) : asset('/assets/img/team/3-thumb.png') }}">
                                <img src="{{ $detail->image ? asset($detail->image) : asset('/assets/img/team/3-thumb.png') }}" alt="{{ $detail->image }}" class="img-thumbnail rounded-circle" style="max-width: 50px; height: 50px">
                            </a>
                        </td>
                        <td>{{ $detail->Equipment->no_equiqment }}</td>
                        <td>{{ $detail->Equipment->equiqment }}</td>
                        <td>{{$detail->Room->Tower->nama_tower}} - {{$detail->Room->Floor->nama_lantai}} - {{ $detail->Room->nama_room }}</td>
                        <td scope="row">
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#status-modal{{ $detail->id_equiqment_engineering_detail }}">See Result</button>
                        </td>

                        <td>{{ $detail->CheckedBy->nama_user }}</td>
                        <td>
                            {{ HumanDate($detail->checklist_datetime) }}
                        </td>
                        <td>
                            {{ $detail->status_schedule }}
                        </td>
                    </tr>
                    <div class="modal fade" id="image-modal{{ $detail->id_equiqment_engineering_detail }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
                            <div class="modal-content position-relative">
                                <img id="modal-image" src="{{ $detail->image ? asset($detail->image) : asset('/assets/img/team/3-thumb.png') }}" alt="{{ $detail->image }}" class="img-thumbnail">
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="status-modal{{ $detail->id_equiqment_engineering_detail }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Inspection
                                        {{ $detail->Equipment->equiqment }} result
                                    </h5>
                                </div>
                                <div class="modal-body">
                                    @foreach ($status as $item)
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="form-label">Question</label>
                                                <input type="text" value="{{ $item->id_eq }}" class="form-control" readonly>
                                            </div>
                                            <div class=" col-6">
                                                <label class="form-label">Status</label>
                                                <div class="input-group">
                                                    <input type="text" value="{{ $item->status }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-3">
                                            <label class="form-label">Notes</label>
                                            <div class="input-group">
                                                <textarea name="" id="" cols="auto" rows="5" class="form-control" readonly>{{ $item->notes }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    @endforeach
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
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script>
        new DataTable('#table-engineeringhistory', {
            stripeClasses: ['even', 'odd'],
            paging: true
        });
    </script>
@endsection