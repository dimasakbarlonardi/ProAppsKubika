@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-9">
                <div class="card" id="ticketsTable"
                    data-list='{"valueNames":["client","subject","status","priority","agent"],"page":7,"pagination":true,"fallback":"tickets-card-fallback"}'>
                    <div class="card-header border-bottom border-200 px-0">
                        <div class="d-lg-flex justify-content-between">
                            <div class="row flex-between-center gy-2 px-x1 text-light">
                                <div class="col-auto pe-0">
                                    <h6 class="mb-0 text-light">All Tenant</h6>
                                </div>
                                <div class="col-auto pe-0">
                                    <span class="nav-link-icon">
                                        <span class="fas fa-users"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="border-bottom border-200 my-3"></div>
                            <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
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
                                <div class="d-flex align-items-center" id="table-ticket-replace-element">
                                    <button class="btn btn-falcon-default text-600 btn-sm" type="button"
                                        class="fas fa-plus" data-bs-toggle="modal" data-bs-target="#modal-import-tenant">
                                        + Import Tenant
                                    </button>
                                    <a class="btn btn-falcon-default text-600 btn-sm ml-3"
                                        href="{{ route('tenants.create') }}">Create Tenant</a>
                                    <button class="btn btn-falcon-default text-600 btn-sm ml-3" type="button"
                                        class="fas fa-plus" data-bs-toggle="modal"
                                        data-bs-target="#modal-import-tenant-unit">
                                        + Import Tenant Unit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-4">
                        <div id="data-tenants">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="offcanvas offcanvas-end offcanvas-filter-sidebar border-0 dark__bg-card-dark h-auto rounded-xl-3"
                    tabindex="-1" id="ticketOffcanvas" aria-labelledby="ticketOffcanvasLabelCard">
                    <div class="offcanvas-header d-flex flex-between-center d-xl-none">
                        <h6 class="fs-0 mb-0 fw-semi-bold">Filter</h6><button
                            class="btn-close text-reset d-xl-none shadow-none" id="ticketOffcanvasLabelCard" type="button"
                            data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="card scrollbar shadow-none shadow-show-xl">
                        <div class="card-header d-none d-xl-block">
                            <h6 class="mb-0">Filter</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 mt-n2">
                                <label class="mb-1">Tower</label>
                                <select class="form-select form-select-sm" id="select-tower">
                                    <option value="all">All</option>
                                    @foreach ($towers as $tower)
                                        <option value="{{ $tower->id_tower }}">{{ $tower->nama_tower }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 mt-n2">
                                <label class="mb-1">Unit</label>
                                <select class="form-select form-select-sm" id="select-unit">
                                    <option value="all">All</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit[0]->nama_unit }}">{{ $unit[0]->nama_unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-import-tenant" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
            <div class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('import-tenants') }}" method="post" enctype="multipart/form-data">
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

    <div class="modal fade" id="modal-import-tenant-unit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
            <div class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('importTenantUnit') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-0">
                        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                            <h4 class="mb-4" id="modalExampleDemoLabel">Upload Tenant Unit</h4>
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
        new DataTable('#table-tenant');

        $('document').ready(function() {
            getData('all', 'all');
        })

        $('#select-tower').on('change', function() {
            var tower = $(this).val();
            var unit = $('#select-unit').val();

            getData(tower, unit)
        });

        $('#select-unit').on('change', function() {
            var unit = $(this).val();
            var tower = $('#select-tower').val();

            getData(tower, unit)
        });

        function getData(tower, unit) {
            $.ajax({
                url: '/admin/filter-tenants/get-filter-data',
                type: 'GET',
                data: {
                    tower,
                    unit
                },
                success: function(resp) {
                    $('#data-tenants').html(resp.html);
                }
            })
        }
    </script>
@endsection
