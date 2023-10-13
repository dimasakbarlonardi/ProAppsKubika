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
        <table class="table table-striped" id="table-housekeeping">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="equiqment">Equipment</th>
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
                            <div class="dropdown font-sans-serif position-static">
                                <button class="btn btn-sm btn-warning" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false">
                                    <span class=""></span>Inspection/schedule
                                </button>
                                <div class="dropdown-menu dropdown-menu-end border py-0">
                                    <div class="py-2">
                                            <a class="dropdown-item text"
                                                href="{{ route('checklisttoilet', $checklisttoilet->id_equipment_housekeeping) }}">
                                                Inspection Parameter
                                            </a>
                                            <a class="dropdown-item text"
                                                href="{{ route('inspectionSchedulesHK', $checklisttoilet->id_equipment_housekeeping) }}">
                                                Schedule
                                            </a>
                                            <a class="dropdown-item text"
                                            href="{{ route('checklisttoilets.edit', $checklisttoilet->id_equipment_housekeeping) }}">
                                                Edit Equipment
                                            </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <!-- Modal untuk memperbesar barcode -->
                    <div class="modal fade" id="barcodeModal{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="barcodeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="barcodeModalLabel">Barcode</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <img src="{{ asset('barcodes/' . $checklisttoilet->barcode_room) }}" alt="Barcode" class="img-fluid">
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
        new DataTable('#table-housekeeping');
    </script>
@endsection
