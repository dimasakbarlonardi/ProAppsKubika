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
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ url('/import_template/template_equipment_housekeeping.xlsx') }}" download>
                    <span class="fas fa-plus fs--2 me-1"></span>Download Template
                </a>
                <button class="btn btn-falcon-default text-600 btn-sm ml-3" type="button" class="fas fa-plus" data-bs-toggle="modal" data-bs-target="#modal-import">
                    + Import Equipment
                </button>
                <a class="btn btn-falcon-default btn-sm text-600 ml-3" href="{{ route('checklisttoilets.create') }}">
                    <span class="fas fa-plus fs--2 me-1"></span>Create Equipment Engineering </a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <a href="{{ route('toiletdetails.index') }}" class="btn btn-primary float-right mb-4">History Inspection</a>
        <table class="table table-striped" id="table-housekeeping">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="equiqment">Area Inspection</th>
                    <th class="sort" data-sort="id_room">Floor</th>
                    <th class="sort" data-sort="action">Action</th>
                </tr>
            </thead>
            <tbody id="checklist_body">
                @foreach ($checklisttoilets as $key => $checklisttoilet)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $checklisttoilet->Room ? $checklisttoilet->Room->nama_room : '' }}</td>
                    <td>{{ $checklisttoilet->Room ?  $checklisttoilet->Room->Floor->nama_lantai : '' }}</td>
                    <td>
                        <div class="dropdown font-sans-serif position-static">
                            <button class="btn btn-sm btn-warning" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false">
                                <span class=""></span>Inspection/schedule
                            </button>
                            <div class="dropdown-menu dropdown-menu-end border py-0">
                                <div class="py-2">
                                    <a class="dropdown-item text" href="{{ route('checklisttoilet', $checklisttoilet->id_equipment_housekeeping) }}">
                                        Inspection Parameter
                                    </a>
                                    <a class="dropdown-item text" href="{{ route('inspectionSchedulesHK', $checklisttoilet->id_equipment_housekeeping) }}">
                                        Schedule
                                    </a>
                                    <a class="dropdown-item text" href="{{ route('checklisttoilets.edit', $checklisttoilet->id_equipment_housekeeping) }}">
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

<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
            <div class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('importEquipmentHousekeeping') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-0">
                        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                            <h4 class="mb-4" id="modalExampleDemoLabel">Upload Excel File </h4>
                            <div class="mb-3">
                                <input type="file" name="file_excel" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script>
    new DataTable('#table-housekeeping');
</script>
@endsection