@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-9">
        <div class="card mb-4">
            <div class="card-header py-2">
                <div class="row flex-between-center">
                    <div class="my-3 col-auto">
                        <h6 class="mb-0 text-white">List Utility Usage Recording Water</h6>
                    </div>
                    <div class="my-3 col-auto">
                        <div class="d-flex align-items-center" id="table-ticket-replace-element">
                            <a class="btn btn-falcon-default btn-sm text-600" href="{{ url('/import_template/template_water_usage.xlsx') }}" download>
                                <span class="fas fa-plus fs--2 me-1"></span>Download Template
                            </a>
                            <button class="btn btn-falcon-default text-600 btn-sm ml-3" type="button" class="fas fa-plus" data-bs-toggle="modal" data-bs-target="#modal-import">
                                + Import Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-3">
                <div class="card shadow-none">
                    <div class="uur-data">
                        <div class="card-body p-0 pb-3">
                            <div class="d-md-flex flex-md-row flex-column mb-4">
                                <div class="col-md-8">
                                    <div class="justify-content-start my-3">
                                        <h5 class="mb-3">Total invoices : <span>{{ count($all_invoices) }}</span></h5>
                                        <h5>Total selected : <span id="totalSelected">0</span></h5>
                                    </div>
                                </div>
                                <div class="col-4" id="bulk-action-menu">
                                    <div class="justify-content-end my-3">
                                        <div class="d-none ms-3" id="bulk-select-actions">
                                            <div class="d-flex">
                                                <select class="form-select form-select-sm" aria-label="Bulk actions" id="valueAction">
                                                    @if (Request::session()->get('work_relation_id') == $approve->approval_1 && $user->Karyawan->is_can_approve != null)
                                                    <option class="can-select" value="approve" selected="selected">
                                                        Approve</option>
                                                    @elseif (Request::session()->get('work_relation_id') == $approve->approval_2)
                                                    <option class="can-select" value="calculate">Calculate Invoice
                                                    </option>
                                                    <option class="can-select" value="send">Send Invoice</option>
                                                    @else
                                                    <option disabled selected>No Action</option>
                                                    @endif
                                                </select>
                                                <button class="btn btn-falcon-success btn-sm ms-2" type="button" id="applyBulk">Apply</button>
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
                                                    <input class="form-check-input" type="checkbox" data-bulk-select='{"body":"bulk-select-body","actions":"bulk-select-actions","replacedElement":"bulk-select-replace-element"}' />
                                                </div>
                                            </th>
                                            <th></th>
                                            <th class="align-middle">Unit</th>
                                            <th class="align-middle">Water </th>
                                            <th class="align-middle">Period</th>
                                            <th class="align-middle text-center">Status</th>
                                            <th class="align-middle"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="bulk-select-body">
                                        @foreach ($waterUSS as $key => $item)
                                        <tr>
                                            <th class="align-middle white-space-nowrap">
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" name="bulk-elect" type="checkbox" id="{{ $item->id }}" data-bulk-select-row="data-bulk-select-row" />
                                                </div>
                                            </th>
                                            <td>
                                                <a href="{{ $item->image ? url($item->image) : url('/assets/img/no_image.jpeg') }}" data-bs-toggle="modal" data-bs-target="#error-modal" data-image="{{ $item->image ? url($item->image) : url('/assets/img/no_image.jpeg') }}">
                                                    <img src="{{ $item->image ? url($item->image) : url('/assets/img/no_image.jpeg') }}" alt="{{ $item->image }}" style="max-width: 75px; height: 75px">
                                                </a>
                                            </td>


                                            <th class="align-middle">{{ $item->Unit->nama_unit }} -
                                                {{ $item->Unit->Tower->nama_tower }}</th>
                                            <th class="align-middle">
                                                Previous - <b>{{ $item->nomor_air_awal }}</b> <br>
                                                Current - <b>{{ $item->nomor_air_akhir }}</b> <br>
                                                Usage - <b>{{ $item->usage }}</b> <br>
                                                @if ($item->is_updated)
                                                <small class="text-danger">*Updated data, waiting BM to
                                                    approve</small>
                                                @endif
                                            </th>
                                            <th class="align-middle">{{ $item->periode_bulan }} -
                                                {{ $item->periode_tahun }}</th>
                                            <th class="align-middle text-center">
                                                @if (!$item->is_approve)
                                                <h6>
                                                    <span class="badge bg-warning">Pending</span>
                                                </h6>
                                                @endif
                                                @if ($item->is_approve && !$item->no_refrensi && !$item->MonthlyUtility)
                                                <h6>
                                                    <span class="badge bg-success">Approved</span>
                                                </h6>
                                                <br>
                                                @if ($item->ElecUUSrelation() ? !$item->ElecUUSrelation()->is_approve : false)
                                                <small>
                                                    *Menunggu tagihan air untuk di approve
                                                </small>
                                                @endif
                                                @endif
                                                @if ($item->MonthlyUtility)
                                                <h6>
                                                    @if ($setting->is_split_ar == 0)
                                                    <a class="badge bg-info" href="{{ route('showInvoices', $item->MonthlyUtility->MonthlyTenant->CashReceipt->id) }}">
                                                        <span class="fas fa-eye fs--2 me-1"></span>
                                                        Invoice
                                                    </a>
                                                    @else
                                                    <div class="mb-2">
                                                        <a class="badge bg-info" href="{{ route('showInvoices', $item->MonthlyUtility->MonthlyTenant->SplitCashReceipt(null, $item->MonthlyUtility->MonthlyTenant->id_monthly_ipl)->id) }}">
                                                            <span class="fas fa-eye fs--2 me-1"></span>
                                                            Invoice IPL
                                                        </a>
                                                    </div>
                                                    <div>
                                                        <a class="badge bg-info" href="{{ route('showInvoices', $item->MonthlyUtility->MonthlyTenant->SplitCashReceipt($item->MonthlyUtility->id, null)->id) }}">
                                                            <span class="fas fa-eye fs--2 me-1"></span>
                                                            Invoice Utility
                                                        </a>
                                                    </div>
                                                    @endif
                                                </h6>
                                                @endif
                                            </th>
                                            @if (Request::session()->get('work_relation_id') == $approve->approval_1 &&
                                            $user->Karyawan->is_can_approve != null &&
                                            !$item->is_approve)
                                            <td class="align-middle text-center">
                                                <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#edit-modal{{ $item->id }}">Edit
                                                </button>
                                            </td>
                                            @elseif($user->id_user == $approve->approval_3 && $item->is_updated)
                                            <td class="align-middle text-center">
                                                <button class="btn btn-success btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#approve-modal{{ $item->id }}">Approve
                                                </button>
                                            </td>
                                            @endif
                                            @if ($item->MonthlyUtility)
                                            @if (!$item->MonthlyUtility->MonthlyTenant->CashReceipt->tgl_jt_invoice)
                                            <td class="align-middle text-center">
                                                <span class="badge bg-info">
                                                    <span class="fas fa-check fs--2 me-1"></span>
                                                    Waiting to send
                                                </span>
                                            </td>
                                            @else
                                            <td class="align-middle text-center">
                                                <h6>
                                                    <span class="badge bg-success">
                                                        <span class="fas fa-check fs--2 me-1"></span>
                                                        Sended
                                                    </span>
                                                </h6>
                                            </td>
                                            @endif
                                            @endif
                                        </tr>

                                        <div class="modal fade" id="edit-modal{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
                                                <div class="modal-content position-relative">
                                                    <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                                                        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form method="post" action="{{ route('updateWater', $item->id) }}">
                                                        @csrf
                                                        <div class="modal-body p-0">
                                                            <div class="rounded-top-3 py-3 ps-4 pe-6 bg-light">
                                                                <h4 class="mb-1" id="modalExampleDemoLabel">Edit
                                                                    Record
                                                                </h4>
                                                            </div>
                                                            <div class="p-4 pb-0">
                                                                <div class="mb-3">
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <label class="col-form-label" for="recipient-name">Previous:</label>
                                                                            <input class="form-control" name="nomor_air_awal" value="{{ $item->nomor_air_awal }}" type="integer" />
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <label class="col-form-label" for="recipient-name">Current:</label>
                                                                            <input class="form-control" name="nomor_air_akhir" value="{{ $item->nomor_air_akhir }}" type="integer" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="col-form-label" for="message-text">Notes:</label>
                                                                    <textarea class="form-control" name="catatan" rows="8" id="message-text"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                                            <button class="btn btn-primary" type="submit" onclick="return confirm('are you sure?')">Edit Data
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="approve-modal{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
                                                <div class="modal-content position-relative">
                                                    <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                                                        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form method="post" action="{{ route('approveUpdateWater', $item->id) }}">
                                                        @csrf
                                                        <div class="modal-body p-0">
                                                            <div class="rounded-top-3 py-3 ps-4 pe-6 bg-light">
                                                                <h4 class="mb-1" id="modalExampleDemoLabel">
                                                                    Approve
                                                                    Record
                                                                </h4>
                                                            </div>
                                                            <div class="p-4 pb-0">
                                                                <div class="mb-3">
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <label class="col-form-label" for="recipient-name">Old
                                                                                previous:</label>
                                                                            <input class="form-control" value="{{ $item->old_nomor_air_awal }}" disabled />
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <label class="col-form-label" for="recipient-name">Old
                                                                                current:</label>
                                                                            <input class="form-control" value="{{ $item->old_nomor_air_akhir }}" disabled />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <div class="row text-center">
                                                                        <div class="col-6">
                                                                            <h4>
                                                                                <span class="text-success">
                                                                                    <i class="fas fa-chevron-down"></i>
                                                                                </span>
                                                                            </h4>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <h4>
                                                                                <span class="text-success">
                                                                                    <i class="fas fa-chevron-down"></i>
                                                                                </span>
                                                                            </h4>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <label class="col-form-label" for="recipient-name"> New
                                                                                previous:</label>
                                                                            <input class="form-control" value="{{ $item->nomor_air_awal }}" disabled />
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <label class="col-form-label" for="recipient-name">New
                                                                                current:</label>
                                                                            <input class="form-control" value="{{ $item->nomor_air_akhir }}" disabled />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="col-form-label" for="message-text">Notes:</label>
                                                                    <textarea class="form-control" name="catatan" rows="8" id="message-text" disabled>{{ $item->catatan }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                                            <button class="btn btn-primary" type="submit" onclick="return confirm('are you sure?')">Approve
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
                                                <div class="modal-content position-relative">
                                                    <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                                        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <img id="modal-image" alt="{{ $item->image }}" class="img-thumbnail">
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center my-5">
                                    {{ $waterUSS->appends([
                                                'id_tower' => Request::input('id_tower'),
                                                'select_status' => Request::input('select_status'),
                                                'select_period' => Request::input('select_period'),
                                                'select_year' => Request::input('select_year'),
                                            ])->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Properties</h6>
            </div>
            <form action="{{ route('uus-water') }}">
                @include('AdminSite.UtilityUsageRecording.usage_filter')
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
        <div class="modal-content position-relative">
            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('importWaterUsage') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-0">
                    <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                        <h4 class="mb-4" id="modalExampleDemoLabel">Upload Excel File </h4>
                        <div class="mb-4">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label" for="">Periode Bulan water</label>
                                    <select class="form-control" name="periode_bulan">
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
                                    <label for="">Periode Tahun</label>
                                    <select class="form-control" name="periode_tahun">
                                        <option value="2024">2024</option>
                                        <option value="2023">2023</option>
                                        <option value="2022">2022</option>
                                        <option value="2021">2021</option>
                                        <option value="2020">2020</option>
                                    </select>
                                </div>
                            </div>
                        </div>
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
<script>
    $('document').ready(function() {
        var optionMenu = $('option').hasClass('can-select');
        if (optionMenu == false) {
            $('#bulk-action-menu').css('display', 'none');
        }

        var status = $('#select_status').val();
        var tower = $('#id_tower').val();
        var period = $('#select_period').val();
        var year = $('#select_year').val();

        getData(tower, status, period, year);
    })
    $('#applyBulk').on('click', function() {
        if (confirm('Are you sure?')) {
            var url = '';

            $IDs = $("#tableData input:checkbox:checked").map(function() {
                return $(this).attr("id");
            }).get();

            var value = $('#valueAction').val();

            if (value === 'approve') {
                url = '/admin/approve/usr-water';
            } else if (value === 'calculate') {
                url = '/admin/generate-invoice';
            } else if (value === 'send') {
                url = '/admin/blast-invoice';
            }

            actionPost(url);
        }
    })

    function actionPost(url) {
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                'IDs': $IDs,
                'type': 'water'
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
                } else if (resp.status === 401) {
                    Swal.fire(
                        'Sorry!',
                        `Sorry this unit with name ${resp.unit} doesn't have user`,
                        'info'
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
    }

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
        console.log(tower, status, period, year)
        $('#uur-data').html("");
        $.ajax({
            url: '/admin/uus-water-filtered',
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


<script>
    const modal = new bootstrap.Modal(document.getElementById('error-modal'));
    const modalImage = document.getElementById('modal-image');

    document.querySelectorAll('[data-bs-toggle="modal"]').forEach((element) => {
        element.addEventListener('click', (event) => {
            event.preventDefault();
            const imageSrc = element.getAttribute('data-image');
            modalImage.src = imageSrc;
            modal.show();
        });
    });
</script>
@endsection