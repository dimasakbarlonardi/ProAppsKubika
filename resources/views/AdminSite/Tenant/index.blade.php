@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
@endsection

@section('content')
<div class="content">
    <div class="row">
        <div class="col-9">
            <div class="card" id="ticketsTable" data-list='{"valueNames":["client","subject","status","priority","agent"],"page":7,"pagination":true,"fallback":"tickets-card-fallback"}'>
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
                            <button class="btn btn-sm btn-falcon-default d-xl-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#ticketOffcanvas" aria-controls="ticketOffcanvas">
                                <span class="fas fa-filter" data-fa-transform="shrink-4 down-1"></span><span class="ms-1 d-none d-sm-inline-block">Filter</span>
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
                            <div class="d-flex align-items-center" id="table-ticket-replace-element">
                                <a class="btn btn-falcon-default text-600 btn-sm" href="{{ route('tenants.create') }}">Create Tenant</a>
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
                    <h6 class="fs-0 mb-0 fw-semi-bold">Filter</h6><button class="btn-close text-reset d-xl-none shadow-none"
                        id="ticketOffcanvasLabelCard" type="button" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
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
                            <label class="mb-1">Status</label>
                            <select class="form-select form-select-sm" id="select-status">
                                <option value="all">All</option>
                                <option value="1">PEMILIK</option>
                                <option value="0">PENYEWA</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script>
        new DataTable('#table-tenant');

        $('document').ready(function() {
            getData('all', 'all')
        })

        $('#select-tower').on('change', function() {
            var tower = $(this).val();
            var status = $('#select_status').val();

            getData(tower, status)
        });

        $('#select-status').on('change', function() {
            var status = $(this).val();
            var tower = $('#select_tower').val();

            getData(tower, status)
        });

        function getData(tower, status) {
            $.ajax({
                url: '/admin/filter-tenants/get-filter-data',
                type: 'GET',
                data: {
                    tower,
                    status
                },
                success: function(resp) {
                    $('#data-tenants').html(resp.html);
                }
            })
        }
    </script>
@endsection
