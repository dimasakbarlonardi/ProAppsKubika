@extends('layouts.master')

@section('content')
    <div class="content">
        <div class="row gx-3">
            <div class="col-xxl-10 col-xl-9">
                <div class="card" id="ticketsTable"
                    data-list='{"valueNames":["client","subject","status","priority","agent"],"page":7,"pagination":true,"fallback":"tickets-card-fallback"}'>
                    <div class="card-header border-bottom border-200 px-0">
                        <div class="d-lg-flex justify-content-between">
                            <div class="row flex-between-center gy-2 px-x1 text-light">
                                <div class="col-auto pe-0">
                                    <h6 class="mb-0 text-light">List Check list AHU</h6>
                                </div>
                            </div>

                            <div class="border-bottom border-200 my-3"></div>
                            <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
                                <button class="btn btn-sm btn-falcon-default d-xl-none" type="button"
                                    data-bs-toggle="offcanvas" data-bs-target="#ticketOffcanvas"
                                    aria-controls="ticketOffcanvas">
                                    <span class="fas fa-filter" data-fa-transform="shrink-4 down-1"></span><span
                                        class="ms-1 d-none d-sm-inline-block">Filter</span>
                                </button>
                                <div class="bg-300 mx-3 d-none d-lg-block d-xl-none" style="width: 1px; height: 29px">
                                </div>
                                <div class="d-none" id="table-ticket-actions">
                                    <div class="d-flex">
                                        <select class="form-select form-select-sm" aria-label="Bulk actions">
                                            <option selected="">Bulk actions</option>
                                            <option value="Refund">Refund</option>
                                            <option value="Delete">Delete</option>
                                            <option value="Archive">Archive</option>
                                        </select><button class="btn btn-falcon-default btn-sm ms-2" type="button">
                                            Apply
                                        </button>
                                    </div>
                                </div>
                                <div class="col-auto d-flex">
                                    <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('checklistahus.create') }}"><span class="fas fa-plus fs--2 me-1"></span>Create Check list AHU</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-5">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="sort" data-sort="">No</th>
                                    {{-- <th class="sort" data-sort="barcode_room">Barcode Room</th> --}}
                                    {{-- <th class="sort" data-sort="id_room">Room</th> --}}
                                    <th class="sort" data-sort="tgl_checklist">Tanggal Checklist</th>
                                    {{-- <th class="sort" data-sort="time_checklist">Time Checklist</th> --}}
                                    {{-- <th class="sort" data-sort="id_user">User</th> --}}
                                    <th class="sort" data-sort="no_checklist_ahu">Nomer Check list AHU</th>
                                    <th class="sort">Action</th>
                                </tr>
                            </thead>
                            <tbody id="checklist_body">
                                @foreach ($checklistahus as $key => $checklistahu)
                                    <tr>
                                        <th scope="row">{{ $key + 1 }}</th>
                                        <td>{{ $checklistahu->tgl_checklist }}</td>
                                        <td>{{ $checklistahu->no_checklist_ahu }}</td>
                                        <td>
                                            <div class="dropdown font-sans-serif position-static"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal" type="button" id="order-dropdown-0" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                                <div class="dropdown-menu dropdown-menu-end border py-0" aria-labelledby="order-dropdown-0">
                                                  <div class="py-2"><a class="dropdown-item text" href="{{ route('checklistahus.show', $checklistahu->no_checklist_ahu) }}">Detail AHU Checklist</a>
                                                    <div class="dropdown-divider"></div> <form class="d-inline" action="{{ route('checklistahus.destroy', $checklistahu->no_checklist_ahu) }}" method="post">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('are you sure?')">Hapus</button>
                                                    </form>
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
            </div>
            <div class="col-xxl-2 col-xl-3">
                <div class="offcanvas offcanvas-end offcanvas-filter-sidebar border-0 dark__bg-card-dark h-auto rounded-xl-3"
                    tabindex="-1" id="ticketOffcanvas" aria-labelledby="ticketOffcanvasLabelCard">
                    <div class="card scrollbar shadow-none shadow-show-xl">
                        <div class="card-header d-none d-xl-block">
                            <h6 class="mb-0 text-light">Filter</h6>
                        </div>
                        <div class="card-body">
                            <form>
                                {{-- <div class="mb-3 mt-n2">
                                    <label class="mb-1">Tanggal Checklist AHU</label>
                                    <select class="form-select form-select-sm" name="tgl_checklist" required id="tgl_checklist">
                                        @foreach ($checklistahus as $checklistahu)
                                            <option value="{{ $checklistahu->tgl_checklist }}"> {{ $checklistahu->tgl_checklist }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="mb-3 mt-n2">
                                    <label class="mb-1">Nomer Checklist AHU</label>
                                    <select class="form-select form-select-sm" name="no_checklist_ahu" required id="no_checklist_ahu">
                                        @foreach ($checklistahus as $checklistahu)
                                            <option value="{{ $checklistahu->no_checklist_ahu }}"> {{ $checklistahu->no_checklist_ahu }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer border-top border-200 py-x1">
                            <button class="btn btn-primary w-100">Update</button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('document').ready(function() {
            var no_checklist_ahu = $('#no_checklist_ahu').val()

            $('#no_checklist_ahu').on('change', function() {
                var no_checklist_ahu = $('#no_checklist_ahu').val()

                console.log(no_checklist_ahu)

                index(no_checklist_ahu)
            })
        })

        function index(no_checklist_ahu) {
            $.ajax({
                url: '/admin/checklist-filter-ahu',
                type: 'GET',
                data: {
                    no_checklist_ahu
                },
                success: function(data) {
                    $('#checklist_body').html("")
                    console.log(data.checklists)
                    data.checklists.map((item, i) => {
                        $('#checklist_body').append(`
                            <tr>
                                <th scope="row">${i + 1}</th>                           
                                <td>${item.tgl_checklist}</td>                            
                                <td>${item.no_checklist_ahu}</td>
                                <td>
                                    <div class="dropdown font-sans-serif position-static"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal" type="button" id="order-dropdown-0" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                        <div class="dropdown-menu dropdown-menu-end border py-0" aria-labelledby="order-dropdown-0">
                                            <a class="dropdown-item text" href="/admin/checklistahus/${item.no_checklist_ahu}">Detail ahu Checklist</a>
                                            <div class="dropdown-divider"></div> <form class="d-inline" action="{{ route('checklistahus.destroy', $checklistahu->no_checklist_ahu) }}" method="post">
                                                @method('DELETE')
                                                @   srf
                                                <button type="submit" class="dropdown-item text-danger"
                                            onclick="return confirm('are you sure?')">Hapus</button>
                                            </form>
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
@endsection
