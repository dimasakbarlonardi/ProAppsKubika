<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Pro Apps | Dashboard &amp; Web App Template</title>
    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Pro Apps | Dashboard &amp; Web App Template</title>

    <meta name="theme-color" content="#ffffff">
    <script src="https://dev.pro-apps.xyz/assets/js/config.js"></script>
    <script src="https://dev.pro-apps.xyz/assets/vendors/simplebar/simplebar.min.js"></script>

    <meta name="theme-color" content="#ffffff">
    <script src="https://dev.pro-apps.xyz/assets/js/config.js"></script>
    <script src="https://dev.pro-apps.xyz/assets/vendors/simplebar/simplebar.min.js"></script>

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="https://dev.pro-apps.xyz/assets/vendors/simplebar/simplebar.min.css" rel="stylesheet">

    <link href="https://dev.pro-apps.xyz/assets/css/theme.min.css" rel="stylesheet" id="style-default">
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('0861d580b79b849c276c', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            alert(JSON.stringify(data));
        });
    </script>
</head>

<body>
    <div class="container bg-white rounded" id="splitPaymentData">
        <div class="card mb-3 mt-3">
            <div class="card-body">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md">
                        <h5 class="mb-2 mb-md-0">Invoice #<span
                                id="no-invoice">{{ $transaction->CronOtherCashReceipt($db_name)->no_invoice }}</span></h5>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0" type="button">
                            <span class="fas fa-arrow-down me-1"> </span>Download (.pdf)
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center mb-3">
            <div class="col-sm-6 text-sm-start">
                <img src="https://dev.pro-apps.xyz{{ $setting->company_logo ? $setting->company_logo : '/assets/img/icons/spot-illustrations/proapps.png' }}"
                    alt="invoice" width="150" />
            </div>
            <div class="col text-sm-end mt-3 mt-sm-0">
                <h2 class="mb-3">Invoice</h2>
                <h5>{{ $setting->company_name }}</h5>
                <p class="fs--1 mb-0">
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
                <h5>{{ $transaction->Unit->TenantUnit->Tenant->nama_tenant }}</h5>
                <p class="fs--1">
                    {{ $site->nama_site }},
                    {{ $transaction->Unit->Tower->nama_tower }}
                    {{ $transaction->Unit->nama_unit }}<br />
                    {{ $site->provinsi }}, {{ $site->kode_pos }}
                </p>
                <p class="fs--1">
                    <a href="mailto:{{ $transaction->Unit->TenantUnit->Tenant->email_tenant }}">
                        {{ $transaction->Unit->TenantUnit->Tenant->email_tenant }}</a><br />
                    <a href="tel:444466667777">{{ $transaction->Unit->TenantUnit->Tenant->no_telp_tenant }}</a>
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
                                <th class="text-sm-end">Total:</th>
                                <td>
                                    {{ Rupiah($transaction->CronOtherCashReceipt($db_name)->sub_total) }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-sm-end">Payment Status:</th>
                                <td id="payment-status">
                                    @if ($transaction->CronOtherCashReceipt($db_name)->transaction_status == 'PAID')
                                        <span
                                            class="badge bg-success">{{ $transaction->CronOtherCashReceipt($db_name)->transaction_status }}</span>
                                    @else
                                        <span class="badge bg-warning">PENDING</span>
                                    @endif
                                </td>
                            </tr>
                            @if ($transaction->CronOtherCashReceipt($db_name)->settlement_time)
                                <tr>
                                    <th class="text-sm-end">Payment Date :</th>
                                    <td id="payment-date">
                                        {{ HumanDateTime($transaction->CronOtherCashReceipt($db_name)->settlement_time) }}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="table-responsive scrollbar mt-4 fs--1">
            <table class="table border-bottom">
                <tbody>
                    @foreach ($transaction->CronOtherCashReceipt($db_name)->CronPreviousOtherBill($transaction->periode_bulan, $transaction->periode_tahun, $db_name) as $bill)
                        <tr class="alert alert-success my-3">
                            <td class="align-middle">
                                <h6 class="mb-0 text-nowrap">Tagihan bulan
                                    {{ $bill->MonthlyARTenant->periode_bulan }},
                                    {{ $bill->MonthlyARTenant->periode_tahun }}
                                </h6>
                            </td>
                            <td class="align-middle">
                            </td>
                            <td colspan="6"></td>
                        </tr>
                        @php
                            $otherBills = json_decode($bill->MonthlyARTenant->biaya_lain);
                        @endphp
                        @foreach ($otherBills as $otherBill)
                            <tr>
                                <td class="align-middle">
                                    <p class="mb-0">{{ $otherBill->bill_name }}</p>
                                </td>

                                <td class="align-middle text-end" colspan="4">
                                    <h6 class="mb-3 mt-3">Total</h6>
                                    <span>{{ Rupiah($otherBill->bill_price) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                    <tr class="alert alert-success my-3">
                        <td class="align-middle">
                            <h6 class="mb-0 text-nowrap">Tagihan bulan
                                {{ $transaction->periode_bulan }},
                                {{ $transaction->periode_tahun }}
                            </h6>
                        </td>
                        <td class="align-middle">
                        </td>
                        <td colspan="6"></td>
                    </tr>
                    @php
                        $otherBills = json_decode($transaction->biaya_lain);
                    @endphp
                    @foreach ($otherBills as $otherBill)
                        <tr>
                            <td class="align-middle">
                                <p class="mb-0">{{ $otherBill->bill_name }}</p>
                            </td>

                            <td class="align-middle text-end" colspan="4">
                                <h6 class="mb-3 mt-3">Total</h6>
                                <span>{{ Rupiah($otherBill->bill_price) }}</span>
                            </td>
                        </tr>
                    @endforeach
                    @if ($transaction->CronOtherCashReceipt($db_name)->denda_bulan_sebelumnya)
                        <tr class="alert alert-danger my-3">
                            <td class="align-middle">
                                <h6 class="mb-0 text-nowrap">Denda Bulan Sebelumnya
                                </h6>
                            </td>
                            <td class="align-middle">
                            </td>
                            <td colspan="6"></td>
                        </tr>
                        @foreach ($transaction->CronOtherCashReceipt($db_name)->CronPreviousOtherBill($transaction->periode_bulan, $transaction->periode_tahun, $db_name) as $bill)
                            <tr>
                                <td class="align-middle">
                                    <h6 class="mb-3 text-nowrap">Periode</h6>
                                    <span>Bulan {{ $bill->MonthlyARTenant->periode_bulan }} /
                                        {{ $bill->MonthlyARTenant->periode_tahun }}</span>
                                </td>
                                <td class="align-middle text-end" colspan="6">
                                    <h6 class="text-nowrap mb-3 text-end">Total</h6>
                                    <span>{{ DecimalRupiahRP($bill->total_denda) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
