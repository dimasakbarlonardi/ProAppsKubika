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
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('checklistahus.index') }}"
                                    class="text-white"> List Inspection Engineering </a></li>
                            <li class="breadcrumb-item active" aria-current="page">List Inspection Engineering</li>
                        </ol>
                    </nav>
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
                            <th class="sort" data-sort="equipment">Equipment</th>
                            <th class="sort" data-sort="room">Location</th>
                            <th class="sort" data-sort="inspection">Inspection Engineering</th>
                            <th class="sort" data-sort="pic">Status</th>
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
                                    <a href="{{ $detail->image ? asset($detail->image) : asset('/assets/img/team/3-thumb.png') }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#image-modal{{ $detail->id_equiqment_engineering_detail }}"
                                        data-image="{{ $detail->image ? asset($detail->image) : asset('/assets/img/team/3-thumb.png') }}">
                                        <img src="{{ $detail->image ? asset($detail->image) : asset('/assets/img/team/3-thumb.png') }}"
                                            alt="{{ $detail->image }}" class="img-thumbnail rounded-circle"
                                            style="max-width: 50px; height: 50px">
                                    </a>
                                </td>
                                <td>{{ $detail->Equipment->equiqment }}</td>
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
                                <td>
                                    {{ $detail->status_schedule }}
                                </td>
                            </tr>
                            <div class="modal fade" id="image-modal{{ $detail->id_equiqment_engineering_detail }}"
                                tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
                                    <div class="modal-content position-relative">
                                        <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                            <button
                                                class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
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
