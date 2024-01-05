@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-9">
            <div class="card">
                <div class="card-header py-2">
                    <div class="row flex-between-center">
                        <div class="my-3 col-auto">
                            <h6 class="mb-0 text-white">Invoices</h6>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="card shadow-none">
                        <div class="card-body p-0 pb-3">
                            <div class="d-flex row mb-4">
                                <div class="col-4" id="bulk-action-menu">
                                    <div class="justify-content-end my-3">
                                        <div class="d-none ms-3" id="bulk-select-actions">
                                            <div class="d-flex">
                                                <select class="form-select form-select-sm" aria-label="Bulk actions"
                                                    id="valueAction">
                                                    {{-- @if ($user->id_role_hdr == $approve->approval_1 && $user->Karyawan->is_can_approve != null)
                                                        <option class="can-select" value="approve" selected="selected">
                                                            Approve</option>
                                                    @elseif ($user->id_role_hdr == $approve->approval_2)
                                                        <option class="can-select" value="calculate">Calculate Invoice
                                                        </option>
                                                        <option class="can-select" value="send">Send Invoice</option>
                                                    @else
                                                        <option disabled selected>No Action</option>
                                                    @endif --}}
                                                </select>
                                                <button class="btn btn-falcon-success btn-sm ms-2" type="button"
                                                    id="applyBulk">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive scrollbar">
                                <div id="data-invoice">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <form action="" method="post">
                    <div class="card-header">
                        <h6 class="mb-0">Filter</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="mb-1">Type</label>
                            <select name="invoice_type" class="form-control" id="invoice_type">
                                <option value="MonthlyBilling">Monthly Billing</option>
                                <option value="RequestBilling">Request Billing</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1">Unit</label>
                            <select name="unit_id" class="form-control" id="select_unit">
                                <option value="all">All</option>
                                @foreach ($units as $unit)
                                    <option {{ request()->get('id_unit') == $unit->id_unit ? 'selected' : '' }}
                                        value="{{ $unit->id_unit }}">{{ $unit->nama_unit }} - {{ $unit->Tower->nama_tower }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1">Status</label>
                            <select name="unit_id" class="form-control" id="select_status">
                                <option value="all">All</option>
                                <option value="PENDING">Pending</option>
                                <option value="VERIFYING">Verifying</option>
                                <option value="PAID">Paid</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script>
        $('document').ready(function() {
            getData('MonthlyBilling', 'all', 'all')
        })

        $('#select_unit').on('change', function() {
            var unit = $(this).val();
            var status = $('#select_status').val();
            var type = $('#invoice_type').val();

            getData(type, unit, status)
        });

        $('#select_status').on('change', function() {
            var unit = $('#select_unit').val();
            var status = $(this).val();
            var type = $('#invoice_type').val();

            getData(type, unit, status)
        });

        $('#invoice_type').on('change', function() {
            var type = $(this).val();
            var unit = $('#select_unit').val();
            var status = $('#select_status').val();

            getData(type, unit, status)
        });

        function getData(type, unit, status) {
            $.ajax({
                url: '/admin/invoice/get/filter-data',
                type: 'GET',
                data: {
                    type,
                    unit,
                    status
                },
                success: function(resp) {
                    $('#data-invoice').html(resp.html);
                }
            })
        }
    </script>
@endsection
