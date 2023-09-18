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
                    <h6 class="mb-0 text-white">List Inspection Engineering</h6>
                    </div>
                    <div class="col-auto d-flex">
                        <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('checklistahus.create') }}"><span class="fas fa-plus fs--2 me-1"></span>Create Equiqment Engineering </a>
                    </div>
                        </div>
                        </div>
                    <div class="p-5">
                        <a href="{{ route('ahudetails.index') }}" class="btn btn-primary float-right mb-4">History Inspection</a>
                        <table class="table" id="table-engineering">
                            <thead>
                                <tr>
                                    <th class="sort" data-sort="">No</th>
                                    <th class="sort" data-sort="barcode_room">Equipment</th>
                                    <th class="sort" data-sort="id_room">Location</th>
                                    <th class="sort" data-sort="tgl_checklist">Schedule</th>
                                    <th class="sort" data-sort="status_schedule">Status Schedule</th>
                                    <th class="sort" data-sort="action">Action</th>
                                </tr>
                            </thead>
                            <tbody id="checklist_body">
                                @foreach ($checklistahus as $key => $checklistahu)
                                    <tr>
                                        <th scope="row">{{ $key + 1 }}</th>
                                        <td>{{ $checklistahu->equiqment}}</td>
                                        <td>{{ $checklistahu->room->nama_room }}</td>
                                        <td>{{\Carbon\Carbon::parse($checklistahu->tgl_checklist)->format(' d-M-Y') }}</td>
                                        <td>
                                            @if ($checklistahu->status_schedule == 'not done')
                                            <span class="badge rounded-pill badge-subtle-danger">Not Done</span>
                                            @elseif ($checklistahu->status_schedule == 'on time')
                                                <span class="badge rounded-pill badge-subtle-success">On Time</span>
                                            @elseif ($checklistahu->status_schedule == 'late not done')
                                                <span class="badge rounded-pill badge-subtle-danger">Late Not Done</span>
                                            @elseif ($checklistahu->status_schedule == 'late done')
                                                <span class="badge rounded-pill badge-subtle-warning">Late Done</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown font-sans-serif position-static"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal" type="button" id="order-dropdown-0" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                                <div class="dropdown-menu dropdown-menu-end border py-0" aria-labelledby="order-dropdown-0">
                                                  <div class="py-2"><a class="dropdown-item text" href="{{ route('checklistengineering', $checklistahu->id_equiqment_engineering) }}">Inspection Parameter</a>
                                            </div>
                                            </div>
                                        </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body p-0">
                        <div class="form-check d-none">
                            <input class="form-check-input" id="checkbox-bulk-card-tickets-select" type="checkbox"
                                data-bulk-select='{"body":"card-ticket-body","actions":"table-ticket-actions","replacedElement":"table-ticket-replace-element"}' />
                        </div>
                        <div class="list bg-light p-x1 d-flex flex-column gap-3" id="card-ticket-body">
                            <div id="all-units">

                            </div>
                        </div>
                        <div class="text-center d-none" id="tickets-card-fallback">
                            <p class="fw-bold fs-1 mt-3">No ticket found</p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous"
                                data-list-pagination="prev">
                                <span class="fas fa-chevron-left"></span>
                            </button>
                            <ul class="pagination mb-0"></ul>
                            <button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next"
                                data-list-pagination="next">
                                <span class="fas fa-chevron-right"></span>
                            </button>
                        </div>
                    </div>
                </div>
@endsection

@section('script')
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script>
    new DataTable('#table-engineering');
</script>
@endsection


{{-- @section('script')
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
    <script>
        $('document').ready(function() {

            $('#tgl_checklist').on('change', function() {
                var no_checklist_ahu = $('#no_checklist_ahu').val()
                var tgl_checklist = $('#tgl_checklist').val()
                var date_from = tgl_checklist.substr(0, 10)
                var date_to = tgl_checklist.substr(14, 23)

                console.log("date from : ", date_from)
                console.log("date to : ", date_to)

                index(no_checklist_ahu, date_from, date_to)
            })
            $('#no_checklist_ahu').on('change', function() {
                var no_checklist_ahu = $('#no_checklist_ahu').val()
                var tgl_checklist = $('#tgl_checklist').val()
                var date_from = tgl_checklist.substr(0, 10)
                var date_to = tgl_checklist.substr(14, 23)

                index(no_checklist_ahu, date_from, date_to)
            })
        })

        function index(no_checklist_ahu, date_from, date_to) {
            $.ajax({
                url: '/admin/checklist-filter-ahu',
                type: 'GET',
                data: {
                    no_checklist_ahu,
                    date_from,
                    date_to,
                },
                success: function(data) {
                    $('#checklist_body').html("")
                    data.checklists.map((item, i) => {
                        $('#checklist_body').append(`
                            <tr>
                                <th scope="row">${i + 1}</th>                           
                                <td>${item.tgl_checklist}</td>                            
                                <td>${item.no_checklist_ahu}</td>
                                <td>
                                    <div class="dropdown font-sans-serif position-static"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal" type="button" id="order-dropdown-0" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                        <div class="dropdown-menu dropdown-menu-end border py-0" aria-labelledby="order-dropdown-0">
                                            <a class="dropdown-item text" href="/admin/checklistahus/${item.no_checklist_ahu}">Detail ahu Inspection</a>
                                        </div>
                                    </div>                        
                                </td>
                            </tr>
                        `)
                    })
                    
                }
            })
        }
    </script>
@endsection --}}