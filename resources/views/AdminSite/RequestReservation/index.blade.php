@extends('layouts.master')

@section('content')
    <div class="row gx-3">
        <div class="col-xxl-9 col-xl-9">
            <div class="card">
                <div class="card-header p-3 mb-3">
                    <div class="row flex-between-center">
                        <div class="col-auto">
                            <h6 class="mb-0">List Reservation</h6>
                        </div>
                        <div class="col-auto d-flex">
                            <a class="btn btn-falcon-default btn-sm text-600"
                                href="{{ route('request-reservations.create') }}">Tambah
                                Request</a>
                        </div>
                    </div>
                </div>
               <div id="data-requests">

               </div>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-3">
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
                            <label class="mb-1">Status</label>
                            <select class="form-select form-select-sm" id="select-status">
                                <option value="all">All</option>
                                <option value="PENDING">APPROVED</option>
                                <option value="PROSES">PROSES</option>
                                <option value="DONE">DONE</option>
                                <option value="COMPLETE">COMPLETE</option>
                                <option value="REJECTED">REJECTED</option>
                            </select>
                        </div>
                        <div class="mb-3 mt-n2">
                            <label class="mb-1">Status Bayar</label>
                            <select class="form-select form-select-sm" id="select-status-bayar">
                                <option value="all">All</option>
                                <option value="PENDING">PENDING</option>
                                <option value="RESPONDED">PAID</option>
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
        $('document').ready(function() {
            getData('all', 'all')
        })

        $('#select-status').on('change', function() {
            var status = $(this).val();
            var statusBayar = $('#select-status-bayar').val();

            getData(status, statusBayar)
        });
        $('#select-status-bayar').on('change', function() {
            var status = $('#select-status').val();
            var statusBayar = $(this).val();

            getData(status, statusBayar)
        });

        function getData(status, statusBayar) {
            $.ajax({
                url: '/admin/request-rsv/get-filter-data',
                type: 'GET',
                data: {
                    status,
                    statusBayar
                },
                success: function(resp) {
                    $('#data-requests').html(resp.html);
                }
            })
        }
    </script>
@endsection
