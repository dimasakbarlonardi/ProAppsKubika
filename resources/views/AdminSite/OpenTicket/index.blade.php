@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xxl-10 col-xl-9">
            <div class="card" id="ticketsTable">
                <div class="card-header border-bottom border-200 px-0">
                    <div class="d-lg-flex justify-content-between">
                        <div class="row flex-between-center gy-2 px-x1">
                            <div class="col-auto pe-0">
                                <h6 class="mb-0">All requests</h6>
                            </div>
                            <div class="col-auto">
                                <div class="input-group input-search-width">
                                    <input class="form-control form-control-sm shadow-none"
                                        placeholder="Search by name" id="search-request" aria-label="search" />
                                </div>
                            </div>
                        </div>
                        <div class="border-bottom border-200 my-3"></div>
                        <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
                            <button class="btn btn-sm btn-falcon-default d-xl-none" type="button"
                                data-bs-toggle="offcanvas" data-bs-target="#ticketOffcanvas"
                                aria-controls="ticketOffcanvas"><span class="fas fa-filter"
                                    data-fa-transform="shrink-4 down-1"></span><span
                                    class="ms-1 d-none d-sm-inline-block">Filter</span></button>
                            <div class="bg-300 mx-3 d-none d-lg-block d-xl-none" style="width:1px; height:29px">
                            </div>
                            <div class="d-flex align-items-center" id="table-ticket-replace-element">
                                <a href="{{ route('open-tickets.create') }}" class="btn btn-falcon-default btn-sm mx-2"
                                    type="button">
                                    <span rclass="fas fa-plus" data-fa-transform="shrink-3"></span>
                                    <span class="d-none d-sm-inline-block d-xl-none d-xxl-inline-block ms-1">New</span>
                                    <span>
                                       + Create Open Request</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="data-requests">

                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center"><button class="btn btn-sm btn-falcon-default me-1"
                            type="button" title="Previous" data-list-pagination="prev"><span
                                class="fas fa-chevron-left"></span></button>
                        <ul class="pagination mb-0"></ul><button class="btn btn-sm btn-falcon-default ms-1" type="button"
                            title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-2 col-xl-3">
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
                            <label class="mb-1">Type</label>
                            <select class="form-select form-select-sm" id="select-type">
                                <option value="all">All</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id_jenis_request }}">{{ $type->jenis_request }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 mt-n2">
                            <label class="mb-1">Status</label>
                            <select class="form-select form-select-sm" id="select-status">
                                <option value="all">All</option>
                                <option value="PENDING">PENDING</option>
                                <option value="RESPONDED">RESPONDED</option>
                                <option value="PROSES KE WR">PROSES KE WR</option>
                                <option value="PROSES KE RESERVASI">PROSES KE RESERVASI</option>
                            </select>
                        </div>
                        <div class="mb-3 mt-n2">
                            <label class="mb-1">Priority</label>
                            <select class="form-select form-select-sm" id="select-priority">
                                <option value="all">All</option>
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority->work_priority }}">{{ $priority->work_priority }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        @if (session()->has('success'))
            Swal.fire(
                'Success!',
                '{{ session('success') }}',
                'success'
            )
        @endif

        $('document').ready(function() {
            getData('all', 'all', 'all', '')
        })

        $('#select-type').on('change', function() {
            var type = $(this).val();
            var status = $('#select-status').val();
            var priority = $('#select-priority').val();
            var valueString = $('#search-request').val();

            getData(type, status, priority, valueString)
        });

        $('#select-status').on('change', function() {
            var type = $('#select-type').val();
            var status = $(this).val();
            var priority = $('#select-priority').val();
            var valueString = $('#search-request').val();

            getData(type, status, priority, valueString)
        });

        $('#select-priority').on('change', function() {
            var type = $('#select-type').val();
            var status = $('#select-status').val();
            var priority = $(this).val();
            var valueString = $('#search-request').val();

            getData(type, status, priority, valueString);
        });

        $('#search-request').keyup(function() {
            var type = $('#select-type').val();
            var status = $('#select-status').val();
            var priority = $('#select-priority').val();
            var valueString = $(this).val();

            if (valueString.length > 2) {
                getData(type, status, priority, valueString);
            } else if (valueString.length < 2) {
                getData(type, status, priority, '');
            }
        })

        function getData(type, status, priority, valueString) {
            $.ajax({
                url: '/admin/request/get-filter-data',
                type: 'GET',
                data: {
                    type,
                    status,
                    priority,
                    valueString
                },
                success: function(resp) {
                    $('#data-requests').html(resp.html);
                }
            })
        }
    </script>
@endsection
