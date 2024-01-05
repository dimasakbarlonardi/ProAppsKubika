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

    <link href="https://dev.pro-apps.xyz/assets/css/theme.min.css" rel="stylesheet" id="style-default">
</head>

<body>
    <div class="container bg-white rounded" id="splitPaymentData">
        <div class="card mb-3 mt-3">
            <div class="card-body">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md">
                        <h5 class="mb-2 mb-md-0">Invoice #<span
                                id="no-invoice">{{ $transaction->UtilityCashReceipt->no_invoice }}</span></h5>
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
                <img src="{{ $message->embed($setting->company_logo ? public_path($setting->company_logo) : '/assets/img/icons/spot-illustrations/proapps.png') }}"
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
                                    {{ Rupiah($transaction->UtilityCashReceipt->sub_total) }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-sm-end">Payment Status:</th>
                                <td id="payment-status">
                                    @if ($transaction->UtilityCashReceipt->transaction_status == 'PAID')
                                        <span
                                            class="badge bg-success">{{ $transaction->UtilityCashReceipt->transaction_status }}</span>
                                    @else
                                        <span class="badge bg-warning">PENDING</span>
                                    @endif
                                </td>
                            </tr>
                            @if ($transaction->UtilityCashReceipt->settlement_time)
                                <tr>
                                    <th class="text-sm-end">Payment Date :</th>
                                    <td id="payment-date">
                                        {{ HumanDateTime($transaction->UtilityCashReceipt->settlement_time) }}
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
                    @foreach ($transaction->UtilityCashReceipt->CronPreviousUtilityBill($transaction->periode_bulan, $transaction->periode_tahun, $db_name) as $bill)
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
                        <tr>
                            <td class="align-middle">
                                <h6 class="mb-3 text-nowrap">Tagihan Utility</h6>
                                <p class="mb-0">Listrik</p>
                                <hr>
                                <p class="mb-0">Air</p>
                            </td>
                            <td class="align-middle">
                                <h6 class="mb-3 text-nowrap">Previous Usage</h6>
                                <p class="mb-0">
                                    {{ $bill->MonthlyARTenant->MonthlyUtility->ElectricUUS->nomor_listrik_awal }} W
                                </p>
                                <hr>
                                <p class="mb-0">
                                    {{ $bill->MonthlyARTenant->MonthlyUtility->WaterUUS->nomor_air_awal }}
                                    m<sup>3</sup>
                                </p>
                            </td>
                            <td class="align-middle">
                                <h6 class="mb-3 text-nowrap">Current Usage</h6>
                                <p class="mb-0">
                                    {{ $bill->MonthlyARTenant->MonthlyUtility->ElectricUUS->nomor_listrik_akhir }} W
                                </p>
                                <hr>
                                <p class="mb-0">
                                    {{ $bill->MonthlyARTenant->MonthlyUtility->WaterUUS->nomor_air_akhir }}
                                    m<sup>3</sup>
                                </p>
                            </td>
                            <td class="align-middle">
                                <h6 class="text-nowrap mb-3">Usage</h6>
                                <span>{{ $bill->MonthlyARTenant->MonthlyUtility->ElectricUUS->usage }} W</span> <br>
                                <hr>
                                <span>{{ $bill->MonthlyARTenant->MonthlyUtility->WaterUUS->usage }} m<sup>3</sup></span>
                            </td>
                            <td class="align-middle">
                                <h6 class="text-nowrap mb-3">Price</h6>
                                <span>{{ DecimalRupiahRP($electric->biaya_m3) }} / KWh</span> <br>
                                <hr>
                                <span>{{ Rupiah($water->biaya_m3) }}</span>
                            </td>
                            <td class="align-middle">
                                <h6 class="text-nowrap mb-3">PPJ <small>(%)</small></h6>
                                <span>{{ DecimalRupiahRP($bill->MonthlyARTenant->MonthlyUtility->ElectricUUS->ppj) }}</span>
                                <br>
                                <hr>
                                <span>-</span>
                            </td>
                            <td class="align-middle text-end">
                                <h6 class="text-nowrap mb-3 text-end">Total</h6>
                                <span>{{ DecimalRupiahRP($bill->MonthlyARTenant->MonthlyUtility->ElectricUUS->total) }}</span>
                                <br>
                                <hr>
                                <span>{{ Rupiah($bill->MonthlyARTenant->MonthlyUtility->WaterUUS->total) }}</span>
                            </td>
                        </tr>
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
                    <tr>
                        <td class="align-middle">
                            <h6 class="mb-3 text-nowrap">Tagihan Utility</h6>
                            <p class="mb-0">Listrik</p>
                            <hr>
                            <p class="mb-0">Air</p>
                        </td>
                        <td class="align-middle">
                            <h6 class="mb-3 text-nowrap">Previous Usage</h6>
                            <p class="mb-0">
                                {{ $transaction->MonthlyUtility->ElectricUUS->nomor_listrik_awal }} W
                            </p>
                            <hr>
                            <p class="mb-0">
                                {{ $transaction->MonthlyUtility->WaterUUS->nomor_air_awal }}
                                m<sup>3</sup>
                            </p>
                        </td>
                        <td class="align-middle">
                            <h6 class="mb-3 text-nowrap">Current Usage</h6>
                            <p class="mb-0">
                                {{ $transaction->MonthlyUtility->ElectricUUS->nomor_listrik_akhir }} W
                            </p>
                            <hr>
                            <p class="mb-0">
                                {{ $transaction->MonthlyUtility->WaterUUS->nomor_air_akhir }}
                                m<sup>3</sup>
                            </p>
                        </td>
                        <td class="align-middle">
                            <h6 class="text-nowrap mb-3">Usage</h6>
                            <span>{{ $transaction->MonthlyUtility->ElectricUUS->usage }} W</span> <br>
                            <hr>
                            <span>{{ $transaction->MonthlyUtility->WaterUUS->usage }} m<sup>3</sup></span>
                        </td>
                        <td class="align-middle">
                            <h6 class="text-nowrap mb-3">Price</h6>
                            <span>{{ DecimalRupiahRP($electric->biaya_m3) }} / KWh</span> <br>
                            <hr>
                            <span>{{ Rupiah($water->biaya_m3) }}</span>
                        </td>
                        <td class="align-middle">
                            <h6 class="text-nowrap mb-3">PPJ <small>(%)</small></h6>
                            <span>{{ DecimalRupiahRP($transaction->MonthlyUtility->ElectricUUS->ppj) }}</span>
                            <br>
                            <hr>
                            <span>-</span>
                        </td>
                        <td class="align-middle text-end">
                            <h6 class="text-nowrap mb-3 text-end">Total</h6>
                            <span>{{ DecimalRupiahRP($transaction->MonthlyUtility->ElectricUUS->total) }}</span>
                            <br>
                            <hr>
                            <span>{{ Rupiah($transaction->MonthlyUtility->WaterUUS->total) }}</span>
                        </td>
                    </tr>
                    @if ($transaction->UtilityCashReceipt->denda_bulan_sebelumnya)
                        <tr class="alert alert-danger my-3">
                            <td class="align-middle">
                                <h6 class="mb-0 text-nowrap">Denda Bulan Sebelumnya
                                </h6>
                            </td>
                            <td class="align-middle">
                            </td>
                            <td colspan="6"></td>
                        </tr>
                        @foreach ($transaction->UtilityCashReceipt->CronPreviousUtilityBill($transaction->periode_bulan, $transaction->periode_tahun, $db_name) as $bill)
                            <tr>
                                <td class="align-middle">
                                    <h6 class="mb-3 text-nowrap">Periode</h6>
                                    <span>Bulan {{ $bill->MonthlyARTenant->periode_bulan }} / {{ $bill->MonthlyARTenant->periode_tahun }}</span>
                                </td>
                                <td class="align-middle text-end" colspan="6">
                                    <h6 class="text-nowrap mb-3 text-end">Total</h6>
                                    <span>{{ DecimalRupiahRP($bill->total_denda) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    @if ($transaction->UtilityCashReceipt->CronInstallment($db_name))
                        @php
                            $installment = $transaction->UtilityCashReceipt->CronInstallment();
                        @endphp
                        <tr>
                            <td class="align-middle">
                                <h6 class="mb-3 text-nowrap">Installment</h6>
                                <p class="mb-0">{{ $installment->no_invoice }} ({{ $installment->rev }})</p>
                            </td>
                            <td class="align-middle text-end" colspan="6">
                                <h6 class="text-nowrap mb-3 text-end">Total</h6>
                                <span>{{ DecimalRupiahRP($installment->amount) }}</span>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="container p-4">
            <div class="row">
                <div class="col-4">
                    <label for="">Electric meter photo : </label>
                    <img class="img-fluid img-thumbnail rounded"
                        src="{{ $transaction->MonthlyUtility->ElectricUUS->image ? url($transaction->MonthlyUtility->ElectricUUS->image) : url('/assets/img/no_image.jpeg') }}"
                        width="200">
                </div>
                <div class="col-4">
                    <label for="">Water meter photo : </label>
                    <img class="img-fluid img-thumbnail rounded"
                        src="{{ $transaction->MonthlyUtility->WaterUUS->image ? url($transaction->MonthlyUtility->WaterUUS->image) : url('/assets/img/no_image.jpeg') }}"
                        width="200">
                </div>
            </div>
        </div>
    </div>
</body>

</html>
