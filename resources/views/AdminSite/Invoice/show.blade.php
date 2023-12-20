@extends('layouts.master')

@section('content')
    @php
        $type = $transaction->transaction_type;

        switch ($type) {
            case 'TApproveWorkOrder':
                $type = 'TApproveWorkOrder';
                $data = $transaction->WorkOrder;
                $site = \App\Models\Site::find($data->Ticket->id_site);
                $tenant = $data->Ticket->Tenant;
                $unit = $data->Ticket->Unit;
                break;
            case 'MonthlyTenant':
                $type = 'MonthlyTenant';
                $data = $transaction->MonthlyARTenant;
                $site = \App\Models\Site::find($data->id_site);
                $tenant = $data->Unit->TenantUnit->Tenant;
                $unit = $data->Unit;
                break;

            case 'MonthlyUtilityTenant' || 'MonthlyIPLTenant':
                $type = 'SplitMonthlyTenant';
                $data = $transaction->MonthlyARTenant;
                $site = \App\Models\Site::find($data->id_site);
                $tenant = $data->Unit->TenantUnit->Tenant;
                $unit = $data->Unit;
                break;

            case 'WorkPermit':
                $type = 'WorkPermit';
                $data = $transaction->WorkPermit;
                $site = \App\Models\Site::find($data->Ticket->Unit->id_site);
                $tenant = $data->Ticket->Unit->TenantUnit->Tenant;
                $unit = $data->Ticket->Unit;
                break;

            case 'Reservation':
                $type = 'Reservation';
                $data = $transaction->Reservation;
                $site = \App\Models\Site::find($data->Ticket->Unit->id_site);
                $tenant = $data->Ticket->Unit->TenantUnit->Tenant;
                $unit = $data->Ticket->Unit;
                break;

            default:
                # code...
                break;
        }
    @endphp
    @if ($type == 'SplitMonthlyTenant')
        <ul class="nav nav-pills justify-content-around bg-white p-3 rounded mb-3" id="pill-myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link
                        {{ Session::get('active') == 'unit' || Session::get('active') == null ? 'active' : '' }} selectTypePayment"
                    data-bs-toggle="pill" data-bs-target="#pill-tab-home" type="button" role="tab" payment-type="utility">
                    <span class="fas fa-hand-holding-water me-2"></span>
                    <span class="fs--1">Utility</span>
                </button>
            </li>


            <li class="nav-item" role="presentation">
                <button
                    class="nav-link btn-primary {{ Session::get('active') == 'member' ? 'active' : '' }} selectTypePayment"
                    data-bs-toggle="pill" data-bs-target="#pill-tab-profile" type="button" role="tab"
                    payment-type="ipl">
                    <span class="fas fa-home me-2"></span>
                    <span class="d-none d-md-inline-block fs--1">IPL</span>
                </button>
            </li>


            <li class="nav-item" role="presentation">
                <button class="nav-link {{ Session::get('active') == 'vehicle' ? 'active' : '' }} selectTypePayment"
                    data-bs-toggle="pill" data-bs-target="#pill-tab-kendaraan" type="button" role="tab"
                    payment-type="other">
                    <span class="fas fa-grip-horizontal me-2"></span>
                    <span class="d-none d-md-inline-block fs--1">Other</span>
                </button>
            </li>
        </ul>
    @endif
    <div class="container bg-white rounded" id="splitPaymentData">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md">
                        <h5 class="mb-2 mb-md-0">Invoice #{{ $transaction->no_invoice }}</h5>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0" type="button">
                            <span class="fas fa-arrow-down me-1"> </span>Download (.pdf)
                        </button>
                        <button class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0" type="button">
                            <span class="fas fa-print me-1"> </span>Print
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="row align-items-center text-center mb-3">
                    <div class="col-sm-6 text-sm-start">
                        <img src="{{ $setting->company_logo ? url($setting->company_logo) : '/assets/img/icons/spot-illustrations/proapps.png' }}"
                            alt="invoice" width="150" />
                    </div>
                    <div class="col text-sm-end mt-3 mt-sm-0">
                        <h2 class="mb-3">Invoice</h2>
                        <h5>{{ $setting->company_name ? $setting->company_name : 'Proapps' }}</h5>
                        <p class="fs--1 mt-2">
                            {!! $setting->company_address !!}
                        </p>
                    </div>
                    <div class="col-12">
                        <hr />
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="text-500">Invoice to</h6>
                        <h5>{{ $unit->nama_unit }}</h5>
                        <p class="fs--1">
                            {{ $site->nama_site }},
                            {{ $unit->Tower->nama_tower }}
                            <br />
                            {{ $site->provinsi }}, {{ $site->kode_pos }}
                        </p>
                        @if ($type != 'MonthlyTenant' && $type != 'SplitMonthlyTenant')
                            @foreach ($transaction->Ticket->TenantUnit as $tu)
                                @if ($tu->is_owner == 1)
                                    <h6 class="text-500">Unit Owner</h6>
                                    <p class="fs--1">
                                        <a
                                            href="mailto:{{ $tu->Tenant->email_tenant }}">{{ $tu->Tenant->email_tenant }}</a><br />
                                        <a
                                            href="tel:{{ $tu->Tenant->no_telp_tenant }}">{{ $tu->Tenant->no_telp_tenant }}</a>
                                @endif
                            @endforeach
                            @foreach ($transaction->Ticket->TenantUnit as $tu)
                                @if ($tu->is_owner == 0)
                                    <h6 class="text-500">Tenant</h6>
                                    <p class="fs--1">
                                        <a
                                            href="mailto:{{ $tu->Tenant->email_tenant }}">{{ $tu->Tenant->email_tenant }}</a><br />
                                        <a
                                            href="tel:{{ $tu->Tenant->no_telp_tenant }}">{{ $tu->Tenant->no_telp_tenant }}</a>
                                @endif
                            @endforeach
                        @else
                            @foreach ($data->TenantUnit as $tu)
                                @if ($tu->is_owner == 1)
                                    <h6 class="text-500">Unit Owner</h6>
                                    <p class="fs--1">
                                        <a
                                            href="mailto:{{ $tu->Tenant->email_tenant }}">{{ $tu->Tenant->email_tenant }}</a><br />
                                        <a
                                            href="tel:{{ $tu->Tenant->no_telp_tenant }}">{{ $tu->Tenant->no_telp_tenant }}</a>
                                @endif
                            @endforeach
                            @foreach ($data->TenantUnit as $tu)
                                @if ($tu->is_owner == 0)
                                    <h6 class="text-500">Tenant</h6>
                                    <p class="fs--1">
                                        <a
                                            href="mailto:{{ $tu->Tenant->email_tenant }}">{{ $tu->Tenant->email_tenant }}</a><br />
                                        <a
                                            href="tel:{{ $tu->Tenant->no_telp_tenant }}">{{ $tu->Tenant->no_telp_tenant }}</a>
                                @endif
                            @endforeach
                        @endif
                        </p>
                    </div>
                    <div class="col-sm-auto ms-auto">
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless fs--1">
                                <tbody>
                                    <tr>
                                        <th class="text-sm-end">Invoice Date:</th>
                                        <td>
                                            {{ HumanDate($transaction->created_at) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php
                                                switch ($transaction->transaction_status) {
                                                    case 'PENDING':
                                                        echo '<span class="badge bg-warning">Pending</span>';
                                                        break;
                                                    case 'VERIFYING':
                                                        echo '<span class="badge bg-info">Verifying</span>';
                                                        break;
                                                    case 'PAID':
                                                        echo '<span class="badge bg-success">PAID</span>';
                                                        break;

                                                    default:
                                                        echo '<span class="badge bg-warning">Pending</span>';
                                                        break;
                                                }
                                            @endphp
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="table-responsive mt-4 fs--1">
                    @if ($type == 'TApproveWorkOrder')
                        <table class="table">
                            <tbody>
                                <tr class="alert alert-success my-3">
                                    <td class="align-middle">
                                        <h6 class="mb-0 text-nowrap">Tagihan Work Order</h6>
                                    </td>
                                    <td class="align-middle text-center">
                                    </td>
                                    <td class="align-middle text-end"></td>
                                    <td class="align-middle text-end"></td>
                                </tr>
                                @foreach ($data->WODetail as $wod)
                                    <tr>
                                        <td class="align-middle">
                                            <h6 class="mb-0 text-nowrap">Tagihan Work Order</h6>
                                            <p class="mb-0">
                                                {{ $wod->detil_pekerjaan }}
                                            </p>
                                            <p>
                                                {{ rupiah($wod->detil_biaya_alat) }}
                                            </p>
                                        </td>
                                        <td class="align-middle text-center">
                                        </td>
                                        <td class="align-middle text-end"></td>
                                        <td class="align-middle text-end"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    @if ($type == 'MonthlyTenant')
                        @include('AdminSite.Invoice.MonthlyTenant')
                    @endif
                    @if ($type == 'Reservation')
                        <table class="table">
                            <tbody>
                                <tr class="alert alert-success my-3">
                                    <td class="align-middle">
                                        <h6 class="mb-0 text-nowrap">Deposit Reservation</h6>
                                    </td>
                                    <td class="align-middle text-center">
                                    </td>
                                    <td class="align-middle text-end"></td>
                                    <td class="align-middle text-end"></td>
                                </tr>

                                <tr>
                                    <td class="align-middle">
                                        <p class="mb-0">
                                            <b>{{ Rupiah($data->jumlah_deposit) }}</b>
                                        </p>
                                    </td>
                                    <td class="align-middle text-center">
                                    </td>
                                    <td class="align-middle text-end"></td>
                                    <td class="align-middle text-end"></td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                    @if ($type == 'WorkPermit')
                        @include('AdminSite.Invoice.WorkPermit')
                    @endif
                    <div class="row g-3 mb-3">
                        <div class="col-lg-8">
                            @if ($type == 'MonthlyTenant')
                                <div class="row">
                                    <div class="col-4">
                                        <label for="">Electric meter photo : </label>
                                        <img class="img-fluid img-thumbnail rounded"
                                            src="{{ $data->MonthlyUtility->ElectricUUS->image ? url($data->MonthlyUtility->ElectricUUS->image) : url('/assets/img/icons/spot-illustrations/proapps.png') }}"
                                            width="200">
                                    </div>
                                    <div class="col-4">
                                        <label for="">Water meter photo : </label>
                                        <img class="img-fluid img-thumbnail rounded"
                                            src="{{ $data->MonthlyUtility->WaterUUS->image ? url($data->MonthlyUtility->WaterUUS->image) : url('/assets/img/icons/spot-illustrations/proapps.png') }}"
                                            width="200">
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body bg-light">
                                    <div class="d-flex mt-3 justify-content-between fs--1 mb-1">
                                        <p class="mb-0">Subtotal</p>
                                        <span>{{ rupiah($data->CashReceipt->SubTotal($transaction->periode_bulan, $transaction->periode_tahun)) }}</span>
                                    </div>
                                    @if ($transaction != 'PENDING')
                                        <div class="d-flex justify-content-between fs--1 mb-1 text-success">
                                            <p class="mb-0">Tax</p><span>Rp 0</span>
                                        </div>
                                        <div class="d-flex justify-content-between fs--1 mb-1 text-success">
                                            <p class="mb-0">Admin Fee</p><span
                                                id="admin_fee">{{ Rupiah($transaction->admin_fee) }}</span>
                                        </div>
                                        <hr />
                                        <h5 class="d-flex justify-content-between"><span>Grand Total</span><span
                                                id="grand_total">{{ $transaction->gross_amount ? Rupiah($transaction->gross_amount) : rupiah($transaction->SubTotal($transaction->MonthlyARTenant->periode_bulan, $transaction->MonthlyARTenant->periode_tahun)) }}</span>
                                        </h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-2">
                <img src="{{ url('/assets/img/icons/spot-illustrations/proapps.png') }}" alt="" width="80">
                <span class="small text-muted">*Invoice ini diterbitkan secara digital</span>
            </div>
        </div>
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var admin_tax = 0.11;
        let token = "{{ Request::session()->get('token') }}";
        var arID = "{{ $data->id_monthly_ar_tenant }}"
        var isCCForm = false;
        var id_user = '';

        $('#expDate').on('input', function() {
            var inputVal = $(this).val();

            // Remove all non-digit characters
            var cleanedVal = inputVal.replace(/\D/g, '');

            // Insert a slash after the first two characters
            if (cleanedVal.length > 2) {
                cleanedVal = cleanedVal.slice(0, 2) + '/' + cleanedVal.slice(2);
            }

            $(this).val(cleanedVal);
        })


        $('document').ready(function() {
            let is_split = '{{ $setting->is_split_ar }}'
            if (is_split == 1) {
                SelectType('utility');
            }
            $('#cc_form').css('display', 'none')
            $('.form-check-input').on('change', function() {
                if ($(this).is(':checked') && $(this).val() == 'credit_card') {
                    var admin_fee = Math.round(2000 + (0.029 * subtotal));
                    var admin_fee = admin_fee + (Math.round(admin_fee * 0.11));

                    $('#cc_form').css('display', 'block')
                } else {
                    var admin_fee = 4000 + (4000 * admin_tax);
                    $('#cc_form').css('display', 'none')
                }
                var grand_total = subtotal + admin_fee;
                $('#val_admin_fee').val(admin_fee);
                $('#admin_fee').html(`Rp ${formatRupiah(admin_fee.toString())}`)
                $('#grand_total').html(`Rp ${formatRupiah(grand_total.toString())}`)
            });
        })

        var periode_bulan = "{{ $transaction->periode_bulan }}"
        var periode_tahun = '{{ $transaction->periode_tahun }}'

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            // var angka = angka.substring(0, angka.length - 3);

            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        $('.selectTypePayment').on('click', function() {
            type = $(this).attr('payment-type');

            SelectType(type);
        })

        function SelectType(type) {
            $('#splitPaymentData').html("")

            $.ajax({
                url: `/api/v1/get-splited-billing`,
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                data: {
                    type,
                    arID
                },
                type: 'GET',
                success: function(resp) {
                    $('#splitPaymentData').html(resp.html)

                    if (resp.ar_user == resp.email_user) {
                        $('#selectPaymentForm').css('display', 'block');
                    }
                }
            });
        }

        function onCreateTransaction(id) {
            $.ajax({
                url: `/api/v1/create-transaction/${id}`,
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                type: 'POST',
                data: {
                    admin_fee,
                    type,
                    bank
                },
                success: function(resp) {
                    if (resp?.meta.code === 200) {
                        Swal.fire(
                            'Berhasil!',
                            'Berhasil membuat transaksi!',
                            'success'
                        ).then(() =>
                            window.location.replace(`/admin/payment-monthly-page/${ar}/${id}`)
                        )
                    } else {
                        Swal.fire(
                            'Sorry!',
                            'Our server is busy',
                            'info'
                        ).then(() =>
                            window.location.reload()
                        )
                    }
                }
            });
        }
    </script>
@endsection
