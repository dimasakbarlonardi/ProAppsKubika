@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-9">
            <div class="card">
                <div class="card-header py-2">
                    <div class="row flex-between-center">
                        <div class="my-3 col-auto">
                            <h6 class="mb-0 text-white">List Utility Usage Recording Electric</h6>
                        </div>
                    </div>
                </div>
                <div class="p-5">
                    {{-- <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Unit</th>
                                <th>Water</th>
                                <th>Listrik</th>
                                <th>Period</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($elecUSS as $key => $item)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{ $item->Unit->nama_unit }}</td>
                                    <td>
                                        @if ($item->WaterUUSrelation())
                                            Previous - <b>{{ $item->WaterUUSrelation()->nomor_air_awal }}</b> <br>
                                            Current - <b>{{ $item->WaterUUSrelation()->nomor_air_akhir }}</b> <br>
                                            Usage - <b>{{ $item->WaterUUSrelation()->usage }}</b> <br>
                                        @else
                                            <span class="badge bg-danger">Belum ada data</span>
                                        @endif
                                    </td>
                                    <td>
                                        Previous - <b>{{ $item->nomor_listrik_awal }}</b> <br>
                                        Current - <b>{{ $item->nomor_listrik_akhir }}</b> <br>
                                        Usage - <b>{{ $item->usage }}</b> <br>
                                    </td>
                                    <td>{{ $item->periode_bulan }} - {{ $item->periode_tahun }}</td>
                                    </td>
                                    <td>
                                        @if ($item->is_approve && $item->WaterUUSrelation()->is_approve)
                                            <span class="badge bg-success">Approved</span> <br>
                                            @if (!$item->MonthlyUtility)
                                                <form class="d-inline" action="{{ route('generateMonthlyInvoice') }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="periode_bulan" value="{{ $item->periode_bulan }}">
                                                    <input type="hidden" name="periode_tahun" value="{{ $item->periode_tahun }}">
                                                    <button type="submit" class="btn btn-info btn-sm mt-3"
                                                        onclick="return confirm('are you sure?')">
                                                        <span class="fas fa-check fs--2 me-1"></span>
                                                        Calculate Invoice
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('viewInvoice', $item->MonthlyUtility->MonthlyTenant->id_monthly_ar_tenant) }}"
                                                    class="btn btn-info btn-sm mt-3">
                                                    <span class="fas fa-check fs--2 me-1"></span>
                                                    Invoice
                                                </a>
                                                @if ($item->MonthlyUtility->MonthlyTenant->tgl_bayar_invoice)
                                                    <button class="btn btn-success btn-sm mt-3"
                                                        onclick="return confirm('are you sure?')">
                                                        <span class="fas fa-check fs--2 me-1"></span>
                                                        Payed
                                                    </button>
                                                @elseif (!$item->MonthlyUtility->MonthlyTenant->tgl_bayar_invoice && $item->MonthlyUtility->sign_approval_2)
                                                    <button class="btn btn-danger btn-sm mt-3">
                                                        <span class="fas fa-check fs--2 me-1"></span>
                                                        Not Payed
                                                    </button>
                                                @endif
                                                @if (!$item->MonthlyUtility->sign_approval_2)
                                                    <form class="d-inline"
                                                        action="{{ route('blastMonthlyInvoice', $item->MonthlyUtility->MonthlyTenant->id_monthly_ar_tenant) }}"
                                                        method="post">
                                                        @csrf
                                                        <button type="submit" class="btn btn-info btn-sm mt-3"
                                                            onclick="return confirm('are you sure?')">
                                                            <span class="fas fa-check fs--2 me-1"></span>
                                                            Kirim Invoice
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                        @elseif (!$item->is_approve)
                                            <form class="d-inline" action="{{ route('approve-usr-electric', $item->id) }}"
                                                method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm"
                                                    onclick="return confirm('are you sure?')">
                                                    <span class="fas fa-check fs--2 me-1"></span>
                                                    Approve
                                                </button>
                                            </form>
                                        @else
                                            <span class="badge bg-success">Approved</span> <br>
                                            <small>
                                                *Menunggu tagihan air untuk di approve
                                            </small>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> --}}
                    <div class="card shadow-none">
                        <div class="card-body p-0 pb-3">
                            <div class="d-flex row mb-4">
                                <div class="col">
                                    <div class="justify-content-start my-3">
                                        <h5>Total selected : <span id="totalSelected">0</span></h5>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="justify-content-end my-3">
                                        <div class="d-none ms-3" id="bulk-select-actions">
                                            <div class="d-flex">
                                                <select class="form-select form-select-sm" aria-label="Bulk actions"
                                                    id="valueAction">
                                                    <option value="approve" selected="selected">Approve</option>
                                                    <option value="calculate">Calculate Invoice</option>
                                                    <option value="send">Send Invoice</option>
                                                </select>
                                                <button class="btn btn-falcon-success btn-sm ms-2" type="button"
                                                    id="applyBulk">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive scrollbar">
                                <table class="table mb-0" id="tableData">
                                    <thead class="text-black bg-200">
                                        <tr>
                                            <th class="align-middle white-space-nowrap">
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox"
                                                        data-bulk-select='{"body":"bulk-select-body","actions":"bulk-select-actions","replacedElement":"bulk-select-replace-element"}' />
                                                </div>
                                            </th>
                                            <th class="align-middle"></th>
                                            <th class="align-middle">Unit</th>
                                            <th class="align-middle">Water </th>
                                            <th class="align-middle">Electric</th>
                                            <th class="align-middle">Period</th>
                                            <th class="align-middle">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bulk-select-body">

                                    </tbody>
                                </table>
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
                        <h6 class="mb-0">Properties</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="mb-1">Unit</label>
                            <select name="unit_id" class="form-control" id="">
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id_unit }}">{{ $unit->nama_unit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1">Status</label>
                            <select name="unit_id" class="form-control" id="select_status">
                                <option value="">All</option>
                                <option value="PENDING">PENDING</option>
                                <option value="APPROVED">APPROVED</option>
                                <option value="PAYED">PAYED</option>
                                <option value="NOT PAYED">NOT PAYED</option>
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
        $('#applyBulk').on('click', function() {
            $IDs = $("#tableData input:checkbox:checked").map(function() {
                return $(this).attr("id");
            }).get();
            var value = $('#valueAction').val();
            alert(value);
        })

        $('.form-check-input').on('change', function() {
            $IDs = $("#tableData input:checkbox:checked").map(function() {
                return $(this).attr("id");
            }).get();
            $('#totalSelected').html($IDs.length)
        })

        $('#select_status').on('change', function() {
            $('#bulk-select-body').html("")
            var value = $(this).val()

            console.log(value);
            $.ajax({
                url: '/admin/get/uss-electric',
                type: 'GET',
                data: {
                    'status': value
                },
                success: function(data) {
                    $('#bulk-select-body').html(data.table)
                }
            })
        })
    </script>
@endsection
