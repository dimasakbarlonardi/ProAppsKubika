<html>

<head>
    <title>Pro Apps | Dashboard &amp; Web App Template</title>
    <link href="{{ url('assets/css/theme.min.css') }}" rel="stylesheet" id="style-default">
</head>

<body>
    <div class="container">
        <div style="max-width: 1000px;" id="doc-target">
            <div class="card">
                <div class="d-flex align-items-center">
                    <div class="col text-sm-start">
                        <img src="{{ $setting->company_logo ? $setting->company_logo : '/assets/img/icons/spot-illustrations/proapps.png' }}"
                            alt="invoice" width="150" />
                    </div>
                    <div class="col text-sm-end">
                        <h4 class="">Invoice {{ $transaction->no_invoice }}</h4>
                        <h5>{{ $setting->company_name }}</h5>
                        <p class="fs--1">
                            {!! $setting->company_address !!}
                        </p>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col">
                        <p class="text-500">Invoice to</p>
                        <h5>{{ $transaction->Unit->TenantUnit->Tenant->nama_tenant }}</h5>
                        <p class="fs--1">
                            {{ Auth::user()->Site->nama_site }},
                            {{ $transaction->Unit->Tower->nama_tower }},
                            Unit {{ $transaction->Unit->nama_unit }}<br />
                            {{ Auth::user()->Site->provinsi }}, {{ Auth::user()->Site->kode_pos }}
                        </p>
                        <p class="fs--1">
                            <a href="mailto:{{ $transaction->Unit->TenantUnit->Tenant->email_tenant }}">
                                {{ $transaction->Unit->TenantUnit->Tenant->email_tenant }}</a><br />
                            <a href="tel:444466667777">{{ $transaction->Unit->TenantUnit->Tenant->no_telp_tenant }}</a>
                        </p>
                    </div>
                    <div class="col-auto ms-auto">
                        <table class="table table-responsive">
                            <tbody>
                                <tr>
                                    <th class="text-sm-end">Invoice Date:</th>
                                    <td class="fs--1">
                                        {{ HumanDate($transaction->created_at) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-sm-end">Payment Status:</th>
                                    <td id="payment-status">
                                        @if ($transaction->transaction_status == 'PAID')
                                            <span
                                                class="badge bg-success">{{ $transaction->transaction_status }}</span>
                                        @else
                                            <span class="badge bg-warning">PENDING</span>
                                        @endif
                                    </td>
                                </tr>
                                @if ($transaction->settlement_time)
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

                <div class="container">
                    <table class="table border-bottom table-responsive">
                        <thead>
                            <tr class="alert alert-success my-3 align-middle">
                                <td colspan="6">
                                    <p class="mb-0 text-nowrap">Tagihan bulan
                                        {{ $transaction->MonthlyARTenant->periode_bulan }},
                                        {{ $transaction->MonthlyARTenant->periode_tahun }}
                                    </p>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaction->MonthlyARTenant($transaction->MonthlyARTenant->periode_bulan, $transaction->MonthlyARTenant->periode_tahun) as $bill)
                                <tr class="alert alert-success my-3">
                                    <td class="align-middle" colspan="9">
                                        <p class="mb-0 text-nowrap">Tagihan bulan
                                            {{ $bill->MonthlyARTenant->periode_bulan }},
                                            {{ $bill->MonthlyARTenant->periode_tahun }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fs--1">
                                        <p class="text-nowrap fs--1">Item</p>
                                    </td>
                                    <td class="fs--1">
                                        <p class="text-nowrap">Previous Usage</p>
                                    </td>
                                    <td class="fs--1">
                                        <p class="text-nowrap">Current Usage</p>
                                    </td>
                                    <td class="fs--1">
                                        <p class="text-nowrap">Usage</p>
                                    </td>
                                    <td class="fs--1">
                                        <p class="text-nowrap">Price</p>
                                    </td>
                                    <td class="fs--1">
                                        <p class="text-nowrap text-end">Total</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fs--1">
                                        <p class="fs--1">
                                            PPJ <small>(%)</small>
                                        </p>
                                    </td>
                                    <td colspan="5">PPJ <small>({{ $electric->biaya_ppj }}%)</small></td>
                                    <td class="align-middle text-end">
                                        {{ DecimalRupiahRP($bill->MonthlyARTenant->MonthlyUtility->ElectricUUS->ppj) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fs--1">
                                        Listrik
                                        @if ($transaction->MonthlyARTenant->MonthlyUtility->ElectricUUS->is_abodemen)
                                            <br>
                                            (Pemakaian minimum listrik
                                            {{ $transaction->MonthlyARTenant->MonthlyUtility->ElectricUUS->abodemen_value }}
                                            KWh)
                                        @endif
                                    </td>
                                    <td class="fs--1">
                                        {{ $bill->MonthlyARTenant->MonthlyUtility->ElectricUUS->nomor_listrik_awal }}
                                        KWh
                                    </td>
                                    <td class="fs--1">
                                        {{ $bill->MonthlyARTenant->MonthlyUtility->ElectricUUS->nomor_listrik_akhir }}
                                        KWh
                                    </td>
                                    <td class="fs--1">
                                        @if (!$transaction->MonthlyARTenant->MonthlyUtility->ElectricUUS->is_abodemen)
                                            <span>{{ $bill->MonthlyARTenant->MonthlyUtility->ElectricUUS->usage }}
                                                KWh</span>
                                        @else
                                            <s>{{ $bill->MonthlyARTenant->MonthlyUtility->ElectricUUS->usage }}
                                                KWh</s>
                                        @endif
                                    </td>
                                    <td class="fs--1">
                                        <span>{{ DecimalRupiahRP($electric->biaya_m3) }} / KWh</span> <br>
                                    </td>
                                    <td class="fs--1">
                                        <span>{{ DecimalRupiahRP($bill->MonthlyARTenant->MonthlyUtility->ElectricUUS->ppj) }}</span>
                                    </td>
                                    <td class="align-middle text-end">
                                        <span>{{ DecimalRupiahRP($bill->MonthlyARTenant->MonthlyUtility->ElectricUUS->total - $bill->MonthlyARTenant->MonthlyUtility->ElectricUUS->ppj) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">
                                        <p class="mb-0">Air</p>
                                    </td>
                                    <td class="align-middle">
                                        <p class="mb-0">
                                            {{ $bill->MonthlyARTenant->MonthlyUtility->WaterUUS->nomor_air_awal }}
                                            m<sup>3</sup>
                                        </p>
                                    </td>
                                    <td class="align-middle">
                                        <p class="mb-0">
                                            {{ $bill->MonthlyARTenant->MonthlyUtility->WaterUUS->nomor_air_akhir }}
                                            m<sup>3</sup>
                                        </p>
                                    </td>
                                    <td class="align-middle">
                                        <span>{{ $bill->MonthlyARTenant->MonthlyUtility->WaterUUS->usage }}
                                            m<sup>3</sup></span>
                                    </td>
                                    <td class="align-middle">
                                        <span>{{ Rupiah($water->biaya_m3) }}</span>
                                    </td>
                                    <td class="align-middle text-end">
                                        <span>{{ Rupiah($bill->MonthlyARTenant->MonthlyUtility->WaterUUS->total) }}</span>
                                    </td>
                                </tr>
                            @endforeach


                            <tr class="fs--1">
                                <td>
                                    Item
                                </td>
                                <td>
                                    Previous Usage
                                </td>
                                <td>
                                    Current Usage
                                </td>
                                <td>
                                    Usage
                                </td>
                                <td>
                                    Price
                                </td>
                                <td>
                                    Total
                                </td>
                            </tr>

                            <tr>
                                <td class="fs--1">
                                    Listrik
                                    @if ($transaction->MonthlyARTenant->MonthlyUtility->ElectricUUS->is_abodemen)
                                        <br>
                                        (Pemakaian minimum listrik
                                        {{ $transaction->MonthlyARTenant->MonthlyUtility->ElectricUUS->abodemen_value }}
                                        KWh)
                                    @endif
                                </td>
                                <td class="fs--1">
                                    {{ $transaction->MonthlyARTenant->MonthlyUtility->ElectricUUS->nomor_listrik_awal }}
                                    KWh
                                </td>
                                <td class="fs--1">
                                    {{ $transaction->MonthlyARTenant->MonthlyUtility->ElectricUUS->nomor_listrik_akhir }}
                                    KWh
                                </td>
                                <td class="fs--1">
                                    @if (!$transaction->MonthlyARTenant->MonthlyUtility->ElectricUUS->is_abodemen)
                                        <span>{{ $transaction->MonthlyARTenant->MonthlyUtility->ElectricUUS->usage }}
                                            KWh</span>
                                    @else
                                        <s>{{ $transaction->MonthlyARTenant->MonthlyUtility->ElectricUUS->usage }}
                                            KWh</s>
                                    @endif
                                </td>
                                <td class="fs--1">
                                    <span>{{ DecimalRupiahRP($electric->biaya_m3) }} / KWh</span> <br>
                                </td>
                                <td class="fs--1 text-end">
                                    <span>{{ DecimalRupiahRP($transaction->MonthlyARTenant->MonthlyUtility->ElectricUUS->total - $transaction->MonthlyARTenant->MonthlyUtility->ElectricUUS->ppj) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fs--1" colspan="5">PPJ
                                    <small>({{ $electric->biaya_ppj }}%)</small>
                                </td>
                                <td class="fs--1 text-end">
                                    {{ DecimalRupiahRP($transaction->MonthlyARTenant->MonthlyUtility->ElectricUUS->ppj) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="fs--1">
                                    <p class="mb-0">Air</p>
                                </td>
                                <td class="fs--1">
                                    <p class="mb-0">
                                        {{ $transaction->MonthlyARTenant->MonthlyUtility->WaterUUS->nomor_air_awal }}
                                        m<sup>3</sup>
                                    </p>
                                </td>
                                <td class="fs--1">
                                    <p class="mb-0">
                                        {{ $transaction->MonthlyARTenant->MonthlyUtility->WaterUUS->nomor_air_akhir }}
                                        m<sup>3</sup>
                                    </p>
                                </td>
                                <td class="fs--1">
                                    <span>{{ $transaction->MonthlyARTenant->MonthlyUtility->WaterUUS->usage }}
                                        m<sup>3</sup></span>
                                </td>
                                <td class="fs--1">
                                    <span>{{ Rupiah($water->biaya_m3) }}</span>
                                </td>
                                <td class="fs--1 text-end">
                                    <span>{{ Rupiah($transaction->MonthlyARTenant->MonthlyUtility->WaterUUS->total) }}</span>
                                </td>
                            </tr>

                            @if ($transaction->MonthlyARTenant->UtilityCashReceipt->denda_bulan_sebelumnya)
                                <tr class="alert alert-danger my-3">
                                    <td class="fs--1">
                                        <p class="mb-0 text-nowrap">Denda Bulan Sebelumnya
                                        </p>
                                    </td>
                                    <td class="fs--1">
                                    </td>
                                    <td colspan="6"></td>
                                </tr>
                                @foreach ($transaction->UtilityCashReceipt->PreviousUtilityBill($transaction->periode_bulan, $transaction->periode_tahun) as $bill)
                                    <tr>
                                        <td class="align-middle">
                                            <p class="mb-3 text-nowrap">Periode</p>
                                            <span>Bulan {{ $bill->MonthlyARTenant->periode_bulan }} /
                                                {{ $bill->MonthlyARTenant->periode_tahun }}</span>
                                        </td>
                                        <td class="align-middle text-end fs--1" colspan="6">
                                            <p class="text-nowrap mb-3 text-end">Total</p>
                                            <span>{{ DecimalRupiahRP($bill->total_denda) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            @if ($transaction->MonthlyARTenant->UtilityCashReceipt->Installment())
                                @php
                                    $installment = $transaction->UtilityCashReceipt->Installment();
                                @endphp
                                <tr>
                                    <td class="align-middle">
                                        <p class="mb-3 text-nowrap">Installment</p>
                                        <p class="mb-0">{{ $installment->no_invoice }}
                                            ({{ $installment->rev }})</p>
                                    </td>
                                    <td class="align-middle text-end fs--1" colspan="6">
                                        <p class="text-nowrap mb-3 text-end">Total</p>
                                        <span>{{ DecimalRupiahRP($installment->amount) }}</span>
                                    </td>
                                </tr>
                            @endif
                            <tr class="border-top">
                                <td colspan="5">
                                    <h5>Grand Total</h5>
                                </td>
                                <td class="align-middle text-end">
                                    {{ DecimalRupiahRP($transaction->MonthlyARTenant->UtilityCashReceipt->sub_total) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-4">
                            <label for="">Electric meter photo : </label>
                            <img class="img-fluid img-thumbnail rounded"
                                src="{{ $transaction->MonthlyARTenant->MonthlyUtility->ElectricUUS->image ? url($transaction->MonthlyARTenant->MonthlyUtility->ElectricUUS->image) : url('/assets/img/no_image.jpeg') }}"
                                width="200">
                        </div>
                        <div class="col-4">
                            <label for="">Water meter photo : </label>
                            <img class="img-fluid img-thumbnail rounded"
                                src="{{ $transaction->MonthlyARTenant->MonthlyUtility->WaterUUS->image ? url($transaction->MonthlyARTenant->MonthlyUtility->WaterUUS->image) : url('/assets/img/no_image.jpeg') }}"
                                width="200">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="{{ url('/js/html2canvas.js') }}"></script>

    <script>
        $('document').ready(function() {
            generatePdf();
        })

        window.jsPDF = window.jspdf.jsPDF;

        function generatePdf() {
            let jsPdf = new jsPDF('l', 'pt', 'a4');
            var doc = document.getElementById('doc-target');

            const opt = {
                callback: function(jsPdf) {
                    jsPdf.save("Test.pdf");
                },
                margin: [10, 10, 10, 10],
                html2canvas: {
                    allowTaint: true,
                    dpi: 300,
                    letterRendering: true,
                    logging: false,
                    scale: .8
                }
            };

            jsPdf.html(doc, opt);
        }
    </script>
</body>

</html>
