@extends('layouts.master')

@section('css')
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}"> --}}
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css"> --}}
@endsection

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="mb-0 text-white">List Inspection HouseKeeping</h6>
                </div>
                <div class="col-auto d-flex">
                    <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('checklisttoilets.create') }}"><span
                            class="fas fa-plus fs--2 me-1"></span>Create Inspection HouseKeeping</a>
                </div>
            </div>
        </div>
        <div class="p-5">
            <a href="{{ route('toiletdetails.index') }}" class="btn btn-primary float-right mb-4">History Inspection</a>
            <table class="table" id="table-housekeeping">
                <thead>
                    <tr>
                        <th class="sort" data-sort="">No</th>
                        <th class="sort" data-sort="equiqment">Equiqment</th>
                        <th class="sort" data-sort="id_room">Lokasi</th>
                        <th class="sort" data-sort="action">Action</th>
                    </tr>
                </thead>
                <tbody id="checklist_body">
                    @foreach ($checklisttoilets as $key => $checklisttoilet)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $checklisttoilet->equipment }}</td>
                            <td>{{ $checklisttoilet->room->nama_room }}</td>
                            <td>
                                <div class="dropdown font-sans-serif position-static"><button
                                        class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal" type="button"
                                        id="order-dropdown-0" data-bs-toggle="dropdown" data-boundary="viewport"
                                        aria-haspopup="true" aria-expanded="false"><span
                                            class="fas fa-ellipsis-h fs--1"></span></button>
                                    <div class="dropdown-menu dropdown-menu-end border py-0"
                                        aria-labelledby="order-dropdown-0">
                                        <div class="py-2">
                                            <a class="dropdown-item text"
                                                href="{{ route('checklisttoilet', $checklisttoilet->id_equipment_housekeeping) }}">
                                                Inspection Parameter
                                            </a>
                                            <a class="dropdown-item text"
                                                href="{{ route('inspectionSchedulesHK', $checklisttoilet->id_equipment_housekeeping) }}">
                                                Schedule
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
