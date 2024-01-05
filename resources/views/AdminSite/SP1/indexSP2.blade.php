@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-9">
            <div class="card">
                <div class="card-header py-2">
                    <div class="row flex-between-center">
                        <div class="my-3 col-auto">
                            <h6 class="mb-0 text-white">List Billing SP 2</h6>
                        </div>
                    </div>
                </div>
                <div class="p-3">
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
                                                    <option class="can-select" value="send">Blast SP2</option>
                                                </select>
                                                <button class="btn btn-falcon-success btn-sm ms-2" type="button"
                                                    id="applyBulk">Apply</button>
                                            </div>
                                        </div>
                                    </div>
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
                                <th class="align-middle">Unit</th>
                                <th class="align-middle">Period</th>
                                <th class="align-middle text-center">Status</th>
                                <th class="align-middle"></th>
                            </tr>
                        </thead>
                        <tbody id="bulk-select-body">
                            @foreach ($invoices as $key => $item)
                                <tr>
                                    <th class="align-middle white-space-nowrap">
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" name="bulk-elect" type="checkbox"
                                                id="{{ $item->id_monthly_ar_tenant }}"
                                                data-bulk-select-row="data-bulk-select-row" />
                                        </div>
                                    </th>
                                    <th class="align-middle">{{ $item->Unit->nama_unit }}</th>
                                    <th>{{ $item->periode_bulan }} - {{ $item->periode_tahun }}</th>
                                    <th class="align-middle text-center">
                                        {{ $item->NotifSP2($item->Unit->nama_unit) ? 'Sended' : 'Pending' }}
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                            <label class="mb-1">Towers</label>
                            <select class="form-control" id="id_tower">
                                <option value="all">All</option>
                                {{-- @foreach ($towers as $tower)
                                    <option value="{{ $tower->id_tower }}">{{ $tower->nama_tower }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1">Status</label>
                            <select class="form-control" id="select_status">
                                <option value="all">All</option>
                                <option value="0">Pending</option>
                                <option value="1">Approved</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1">Periode</label>
                            <div class="row">
                                <div class="col-6">
                                    <select class="form-control" id="select_period">
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <select class="form-control" id="select_year">
                                        <option value="2023">2023</option>
                                        <option value="2022">2022</option>
                                        <option value="2021">2021</option>
                                        <option value="2020">2020</option>
                                        <option value="2019">2019</option>
                                    </select>
                                </div>
                            </div>
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
            var tower = $('#id_tower').val();
            var status = $('#select_status').val();

            getData(tower, status);
        })
        $('#applyBulk').on('click', function() {
            $IDs = $("#tableData input:checkbox:checked").map(function() {
                return $(this).attr("id");
            }).get();
            console.log($IDs);

            $.ajax({
                url: '/admin/blast-sp-2',
                type: 'POST',
                data: {
                    'IDs': $IDs
                },
                success: function(resp) {
                    if (resp.status === 'ok') {
                        Swal.fire(
                            'Success!',
                            '',
                            'success'
                        ).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Failed!',
                            '',
                            'error'
                        ).then(() => {
                            window.location.reload();
                        });
                    }
                }
            })

        })

        $('.form-check-input').on('change', function() {
            $IDs = $("#tableData input:checkbox:checked").map(function() {
                return $(this).attr("id");
            }).get();
            $('#totalSelected').html($IDs.length)
        })

        $('#select_status').on('change', function() {
            var status = $(this).val();
            var tower = $('#id_tower').val();
            var period = $('#select_period').val();
            var year = $('#select_year').val();

            getData(tower, status, period, year);
        })

        $('#id_tower').on('change', function() {
            var tower = $(this).val();
            var status = $('#select_status').val();
            var period = $('#select_period').val();
            var year = $('#select_year').val();

            getData(tower, status, period, year);
        })

        $('#select_period').on('change', function() {
            var tower = $('#id_tower').val();
            var period = $(this).val();
            var status = $('#select_status').val();
            var year = $('#select_year').val();

            getData(tower, status, period, year);
        })

        $('#select_year').on('change', function() {
            var tower = $('#id_tower').val();
            var period = $('#select_period').val();
            var status = $('#select_status').val();
            var year = $(this).val();

            getData(tower, status, period, year);
        })

        function getData(tower, status, period, year) {
            $.ajax({
                url: '/admin/uus-electric-filtered',
                type: 'GET',
                data: {
                    tower,
                    status,
                    period,
                    year
                },
                success: function(resp) {
                    $('#uur-data').html(resp.html);
                }
            })
        }
    </script>
@endsection
