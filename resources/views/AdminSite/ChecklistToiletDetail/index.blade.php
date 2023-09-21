@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="my-3 text-light">List Inspection HouseKeeping</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('checklistahus.store') }}">
                @csrf
                <div class="row">
                    <div class="p-5">
                        <table class="table table-striped" id="table-housekeepinghistory">
                            <thead>
                                <tr>
                                    <th class="align-baseline" data-sort="">No</th>
                                    <th class="align-baseline" data-sort="image">Image</th>
                                    <th class="align-baseline" data-sort="equipment">Equipment</th>
                                    <th class="align-baseline" data-sort="room">Location</th>
                                    <th class="align-baseline" data-sort="inspection">Inspection HouseKeeping</th>
                                    <th class="align-baseline" data-sort="status">Status</th>
                                    <th class="align-baseline" data-sort="user">CheckBy</th>
                                    <th class="align-baseline" data-sort="tgl_checklist">Check Date</th>
                                    <th class="align-baseline" data-sort="keterangan">Status Checklist</th>
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
                                            <a href="{{ $detail->image ? asset($detail->image) : asset('/assets/img/team/3-thumb.png') }}"
                                                data-bs-toggle="modal" data-bs-target="#error-modal"
                                                data-image="{{ $detail->image ? asset($detail->image) : asset('/assets/img/team/3-thumb.png') }}">
                                                <img src="{{ $detail->image ? asset($detail->image) : asset('/assets/img/team/3-thumb.png') }}"
                                                    alt="{{ $detail->image }}" class="img-thumbnail rounded-circle"
                                                    style="max-width: 50px; height: 50px">
                                            </a>
                                        </td>
                                        <td>{{ $detail->equipment->equipment }}</td>
                                        <td>{{ $detail->Room->nama_room }}</td>
                                        <td scope="row">
                                            @foreach ($status as $item)
                                                <span>{{ $item->id_eq }}</span> <br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($status as $item)
                                                <span>{{ $item->status }}</span> <br>
                                            @endforeach
                                        </td>
                                        <td>{{ $detail->CheckedBy->nama_user }}</td>
                                        <td>
                                            {{ HumanDate($detail->checklist_datetime) }}
                                        </td>
                                        <td>{{ $detail->status_schedule }}</td>
                                    </tr>
                                    <div class="modal fade" id="error-modal" tabindex="-1" role="dialog"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document"
                                            style="max-width: 500px">
                                            <div class="modal-content position-relative">
                                                <img id="modal-image"
                                                    src="{{ $detail->image ? asset($detail->image) : asset('/assets/img/team/3-thumb.png') }}"
                                                    alt="{{ $detail->image }}" class="img-thumbnail">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
            </form>
        </div>
    </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script>
        new DataTable('#table-housekeepinghistory');
    </script>
@endsection
