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
    <script src="{{ url('assets/js/config.js') }}"></script>
    <script src="{{ url('assets/vendors/simplebar/simplebar.min.js') }}"></script>

    <meta name="theme-color" content="#ffffff">
    <script src="{{ url('assets/js/config.js') }}"></script>
    <script src="{{ url('assets/vendors/simplebar/simplebar.min.js') }}"></script>

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ url('assets/vendors/simplebar/simplebar.min.css') }}" rel="stylesheet">

    <link href="{{ url('assets/css/theme.min.css') }}" rel="stylesheet" id="style-default">
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
                <h5>Akmal</h5>
                <p class="fs--1">
                    Park royale,
                    Tower 1
                    unit 66<br />
                    JAwa Barat, 17124
                </p>
                <p class="fs--1">
                    <a>akmal@mail.com</a><br />
                    <a>08128812</a>
                </p>
            </div>
            <div class="col-sm-auto ms-auto">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless fs--1">
                        <tbody>
                            <tr>
                                <th class="text-sm-end">Invoice Date:</th>
                                <td>
                                    7 Desember 2023
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="table-responsive scrollbar mt-4 fs--1">
            <table class="table border-bottom">
                <tbody>
                    {{-- @foreach ($transaction->IPLCashReceipt->PreviousIPLBill($transaction->periode_bulan, $transaction->periode_tahun) as $bill)
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
                                <h6 class="mb-3 mt-3">Tagihan IPL</h6>
                                <p class="mb-0">Service Charge</p>
                                <hr>
                                <p class="mb-0">Sink Fund</p>
                            </td>
                            <td class="align-middle">
                                <h6 class="mb-3 mt-3 text-nowrap">Luas Unit</h6>
                                <span>{{ $bill->MonthlyARTenant->MonthlyIPL->Unit->luas_unit }} m<sup>2</sup></span>
                                <br>
                                <hr>
                                <span>{{ $bill->MonthlyARTenant->MonthlyIPL->Unit->luas_unit }} m<sup>2</sup></span>
                            </td>
                            <td class="align-middle" colspan="2">
                                <h6 class="mb-3 mt-3">Biaya Permeter / Biaya Procentage</h6>
                                <span>{{ $sc->biaya_procentage ? $sc->biaya_procentage . '%' : Rupiah($sc->biaya_permeter) }}</span>
                                <br>
                                <hr>
                                <span>{{ $sf->biaya_procentage ? $sf->biaya_procentage . '%' : Rupiah($sf->biaya_permeter) }}</span>
                            </td>
                            <td>
                            </td>
                            <td></td>
                            <td class="align-middle text-end" colspan="2">
                                <h6 class="mb-3 mt-3">Total</h6>
                                <span>{{ Rupiah($bill->MonthlyARTenant->MonthlyIPL->ipl_service_charge) }}</span> <br>
                                <hr>
                                <span>{{ Rupiah($bill->MonthlyARTenant->MonthlyIPL->ipl_sink_fund) }}</span>
                            </td>
                        </tr>
                    @endforeach --}}
                    @foreach ($transaction as $ar)
                        <tr class="alert alert-success my-3">
                            <td class="align-middle" colspan="7">
                                <h6 class="mb-0 text-nowrap">Tagihan Bulan {{ $ar->periode_bulan }},
                                    {{ $ar->periode_tahun }}
                                </h6>
                            </td>
                        </tr>
                        @foreach ($ar->CashReceipts as $cr)
                            <tr class="alert alert-success">
                                <td class="align-middle text-center" colspan="8">
                                    <h6 class="mb-3 text-nowrap">
                                        @if ($cr->transaction_type == 'MonthlyUtilityTenant')
                                            Tagihan Utility
                                        @endif
                                        @if ($cr->transaction_type == 'MonthlyIPLTenant')
                                            Tagihan IPL
                                        @endif
                                        @if ($cr->transaction_type == 'MonthlyOtherBillTenant')
                                            Tagihan Lainnya
                                        @endif
                                    </h6>
                                </td>
                            </tr>
                            @foreach ($ar->CashReceipts as $cr)
                                <tr>
                                    <td class="align-middle">
                                        <h6 class="mb-3 text-nowrap">Previous Usage</h6>
                                        <p class="mb-0">
                                            100 W
                                        </p>
                                        <hr>
                                        <p class="mb-0">
                                            300
                                            m<sup>3</sup>
                                        </p>
                                    </td>
                                    <td class="align-middle">
                                        <h6 class="mb-3 text-nowrap">Current Usage</h6>
                                        <p class="mb-0">
                                            120 W
                                        </p>
                                        <hr>
                                        <p class="mb-0">
                                            400
                                            m<sup>3</sup>
                                        </p>
                                    </td>
                                    <td class="align-middle">
                                        <h6 class="text-nowrap mb-3">Usage</h6>
                                        <span>100 W</span> <br>
                                        <hr>
                                        <span>150 m<sup>3</sup></span>
                                    </td>
                                    <td class="align-middle">
                                        <h6 class="text-nowrap mb-3">Price</h6>
                                        <span>Rp 14.0000 / KWh</span> <br>
                                        <hr>
                                        <span>Rp 2.000</span>
                                    </td>
                                    <td class="align-middle">
                                        <h6 class="text-nowrap mb-3">PPJ <small>(%)</small></h6>
                                        <span>Rp 2.000</span>
                                        <br>
                                        <hr>
                                        <span>-</span>
                                    </td>
                                    <td class="align-middle text-end">
                                        <h6 class="text-nowrap mb-3 text-end">Total</h6>
                                        <span>Rp 40.000</span>
                                        <br>
                                        <hr>
                                        <span>Rp 69.000</span>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                    {{--
                    <tr class="alert alert-success my-3">
                        <td class="align-middle">
                            <h6 class="mb-0 text-nowrap">Tagihan IPL
                            </h6>
                        </td>
                        <td class="align-middle">
                        </td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td class="align-middle" colspan="2">
                            <h6 class="mb-3 mt-3">Tagihan IPL</h6>
                            <p class="mb-0">Service Charge</p>
                            <hr>
                            <p class="mb-0">Sink Fund</p>
                        </td>
                        <td class="align-middle" colspan="2">
                            <h6 class="mb-3 mt-3 text-nowrap">Luas Unit</h6>
                            <span>100 m<sup>2</sup></span> <br>
                            <hr>
                            <span>100 m<sup>2</sup></span>
                        </td>
                        <td class="align-middle" colspan="2">
                            <h6 class="mb-3 mt-3">Biaya Permeter / Biaya Procentage</h6>
                            <span>4 %</span>
                            <br>
                            <hr>
                            <span>12.000</span>
                        </td>
                        <td class="align-middle text-end" colspan="4">
                            <h6 class="mb-3 mt-3">Total</h6>
                            <span>Rp 20.000</span> <br>
                            <hr>
                            <span>Rp 30.000</span>
                        </td>
                    </tr>
                    <tr class="alert alert-success my-3">
                        <td class="align-middle">
                            <h6 class="mb-0 text-nowrap">Tagihan Lainnya
                            </h6>
                        </td>
                        <td colspan="6"></td>
                    </tr>
                    <tr class="alert my-3">
                        <td class="align-middle">
                            <h6 class="mb-0 text-nowrap">Item
                            </h6>
                        </td>
                        <td class="align-middle text-end" colspan="7">
                            <h6 class="mb-0 text-nowrap">Total
                            </h6>
                        </td>
                    </tr>
                    <tr>
                        <td class="align-middle">
                            <p class="mb-0">Service Charge</p>
                        </td>
                        <td class="align-middle text-end" colspan="7">
                            <span>Rp 20.000</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="align-middle">
                            <p class="mb-0">Revitilasi</p>
                        </td>
                        <td class="align-middle text-end" colspan="7">
                            <span>Rp 20.000</span>
                        </td>
                    </tr> --}}
                    {{-- @if ($transaction->UtilityCashReceipt->denda_bulan_sebelumnya)
                        <tr class="alert alert-danger my-3">
                            <td class="align-middle">
                                <h6 class="mb-0 text-nowrap">Denda Bulan Sebelumnya
                                </h6>
                            </td>
                            <td class="align-middle">
                            </td>
                            <td colspan="6"></td>
                        </tr>
                        @foreach ($transaction->IPLCashReceipt->PreviousIPLBill($transaction->periode_bulan, $transaction->periode_tahun) as $bill)
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
                    @if ($transaction->IPLCashReceipt->Installment())
                        @php
                            $installment = $transaction->IPLCashReceipt->Installment();
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
                    @endif --}}
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let token = "{{ Request::session()->get('token') }}";

        $('document').ready(function() {
            SelectType('utility');
        })

        var admin_tax = 0.11;
        var admin_fee = 0;
        var type = '';
        var bank = '';
        var arID = 0;



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
                    if (resp.meta.code === 200) {
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
</body>

</html>
