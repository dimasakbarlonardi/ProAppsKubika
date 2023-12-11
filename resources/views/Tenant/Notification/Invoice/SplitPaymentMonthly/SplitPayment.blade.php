@extends('layouts.master')

@section('css')
    <script id="midtrans-script" type="text/javascript" src="https://api.midtrans.com/v2/assets/js/midtrans-new-3ds.min.js"
        data-environment="sandbox" data-client-key="SB-Mid-client-y5Egraipa_G9sOjU"></script>
@endsection

@section('content')
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
            <button class="nav-link btn-primary {{ Session::get('active') == 'member' ? 'active' : '' }} selectTypePayment"
                data-bs-toggle="pill" data-bs-target="#pill-tab-profile" type="button" role="tab" payment-type="ipl">
                <span class="fas fa-home me-2"></span>
                <span class="d-none d-md-inline-block fs--1">IPL</span>
            </button>
        </li>


        <li class="nav-item" role="presentation">
            <button class="nav-link {{ Session::get('active') == 'vehicle' ? 'active' : '' }} selectTypePayment"
                data-bs-toggle="pill" data-bs-target="#pill-tab-kendaraan" type="button" role="tab">
                <span class="fas fa-grip-horizontal me-2"></span>
                <span class="d-none d-md-inline-block fs--1">Other</span>
            </button>
        </li>
    </ul>

    <div class="container bg-white rounded">
        <div class="tab-content" id="pill-myTabContent">
            <div class="tab-pane fade {{ Session::get('active') == 'unit' || Session::get('active') == null ? 'show active' : '' }} select-type"
                id="pill-tab-home" role="tabpanel" aria-labelledby="home-tab">
                @include('Tenant.Notification.Invoice.SplitPaymentMonthly.Utility_bill')
                {{-- <div id="payment-ipl" style="display: none">
                        @if ($transaction->IPLCashReceipt->transaction_status == 'PENDING')
                            <form action="{{ route('generatePaymentMonthly', $transaction->IPLCashReceipt->id) }}"
                                method="post">
                                @csrf
                                <div class="row g-3 mb-3">
                                    <div class="col-lg-8">
                                        <div class="card h-100">
                                            <div class="card-header">
                                                <h6 class="mb-0">Payment Method</h6>
                                            </div>
                                            <div class="card-body bg-light">
                                                <div class="form-check mb-4">
                                                    <input class="form-check-input select-payment-ipl-method"
                                                        type="radio" name="billing" value="bank_transfer,bca" />
                                                    <label class="form-check-label mb-0 d-block" for="paypal">
                                                        <img src="{{ asset('assets/img/icons/bca_logo.png') }}"
                                                            height="20" alt="" />
                                                    </label>
                                                </div>
                                                <div class="form-check mb-4">
                                                    <input class="form-check-input select-payment-ipl-method"
                                                        type="radio" name="billing"
                                                        value="bank_transfer,mandiri" />
                                                    <label class="form-check-label mb-0 d-block" for="paypal">
                                                        <img src="{{ asset('assets/img/icons/mandiri_logo.png') }}"
                                                            height="20" alt="" />
                                                    </label>
                                                </div>
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input select-payment-ipl-method"
                                                        type="radio" name="billing" value="bank_transfer,bni" />
                                                    <label class="form-check-label mb-0 d-block" for="paypal">
                                                        <img src="{{ asset('assets/img/icons/bni_logo.png') }}"
                                                            height="20" alt="" />
                                                    </label>
                                                </div>
                                                <p class="fs--1 mb-4">Pay with PayPal, Apple Pay, PayPal Credit and
                                                    much more</p>
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input select-payment-ipl-method"
                                                        type="radio" value="credit_card" id="credit-card"
                                                        name="billing" />
                                                    <label class="form-check-label d-flex align-items-center mb-0"
                                                        for="credit-card">
                                                        <span class="fs-1 text-nowrap">Credit Card</span>
                                                        <img class="d-none d-sm-inline-block ms-2 mt-lg-0"
                                                            src="{{ asset('assets/img/icons/icon-payment-methods.png') }}"
                                                            height="20" alt="" />
                                                    </label>
                                                    <div class="row gx-3 mb-3">
                                                        <div id="cc_form_ipl">
                                                            <div class="col-6 my-3">
                                                                <label
                                                                    class="form-label ls text-uppercase text-600 fw-semi-bold mb-0 fs--1"
                                                                    for="cardNumber">Card Number
                                                                </label>
                                                                <input class="form-control" name="card_number"
                                                                    placeholder="XXXX XXXX XXXX XXXX" type="text"
                                                                    maxlength="16" pattern="[0-9]{16}" />
                                                            </div>
                                                            <div class="row gx-3">
                                                                <div class="col-6 col-sm-3">
                                                                    <label
                                                                        class="form-label ls text-uppercase text-600 fw-semi-bold mb-0 fs--1"
                                                                        for="expDate">Exp Date
                                                                    </label>
                                                                    <input class="form-control" id="expDate"
                                                                        placeholder="15/2024" type="text"
                                                                        name="expDate" />
                                                                </div>
                                                                <div class="col-6 col-sm-3">
                                                                    <label
                                                                        class="form-label ls text-uppercase text-600 fw-semi-bold mb-0 fs--1"
                                                                        for="cvv">CVV
                                                                        <span class="ms-1" data-bs-toggle="tooltip"
                                                                            data-bs-placement="top"
                                                                            title="Card verification value">
                                                                            <span class="fa fa-question-circle"></span>
                                                                        </span>
                                                                    </label>
                                                                    <input class="form-control" id="cvv"
                                                                        placeholder="123" maxlength="3"
                                                                        pattern="[0-9]{3}" name="card_cvv"
                                                                        type="text" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="fs--1 mb-4">Safe money transfer using your bank accounts.
                                                    Visa, maestro,
                                                    discover,
                                                    american express.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="card h-100">
                                            <div class="card-header">
                                                <h6 class="mb-0">Payment</h6>
                                            </div>
                                            <div class="card-body bg-light">
                                                <div class="d-flex justify-content-between fs--1 mb-1">
                                                    <p class="mb-0">Subtotal</p>
                                                    <span>{{ rupiah($transaction->IPLCashReceipt->sub_total) }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between fs--1 mb-1 text-success">
                                                    <p class="mb-0">Tax</p>
                                                    <span>{{ Rupiah($transaction->IPLCashReceipt->tax) }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between fs--1 mb-1 text-success">
                                                    <p class="mb-0">Admin Fee IPL</p><span id="admin_fee_ipl">Rp
                                                        0</span>
                                                </div>
                                                <hr />
                                                <h5 class="d-flex justify-content-between"><span>Grand
                                                        Total</span><span id="grand_total_ipl">Rp 0</span>
                                                </h5>
                                                <p class="fs--1 text-600">Once you start your trial, you will have 30
                                                    days to use
                                                    Falcon
                                                    Premium for free. After 30 days you’ll be charged based on your
                                                    selected plan.
                                                </p>
                                                <button class="btn btn-primary d-block w-100" type="submit">
                                                    <span class="fa fa-lock me-2"></span>Continue Payment
                                                </button>
                                                <div class="text-center mt-2">
                                                    <small class="d-inline-block">By continuing, you are
                                                        agreeing to
                                                        our subscriber <a href="#!">terms</a> and will be charged
                                                        at the end
                                                        of
                                                        the
                                                        trial.
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="val_admin_fee_ipl" name="admin_fee">
                            </form>
                        @elseif($transaction->IPLCashReceipt->transaction_status == 'VERIFYING')
                            <div class="text-center">
                                <a href="{{ route('paymentMonthly', [$transaction->id_monthly_ar_tenant, $transaction->IPLCashReceipt->id]) }}"
                                    class="btn btn-success">Lihat VA IPL</a>
                            </div>
                        @endif
                    </div> --}}
            </div>
            <div class="tab-pane fade {{ Session::get('active') == 'member' ? 'show active' : '' }}" id="pill-tab-profile"
                role="tabpanel" aria-labelledby="profile-tab">
                {{-- @include('AdminSite.TenantUnit.Member.member') --}}
            </div>
            <div class="tab-pane fade {{ Session::get('active') == 'vehicle' ? 'show active' : '' }}"
                id="pill-tab-kendaraan" role="tabpanel" aria-labelledby="contact-tab">
                {{-- @include('AdminSite.TenantUnit.Kendaraan.kendaraan') --}}
            </div>
        </div>
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('document').ready(function() {
            SelectType('utility');
            $('#cc_form_utility').css('display', 'none');
            $('#cc_form_ipl').css('display', 'none');

            $(".select-payment-utility-method").on('change', function() {
                if ($(this).is(':checked') && $(this).val() == 'credit_card') {
                    var admin_fee = Math.round(2000 + (0.029 * subtotal));
                    var admin_fee = admin_fee + (Math.round(admin_fee * 0.11));

                    $('#cc_form_utility').css('display', 'block')
                } else {
                    var admin_fee = 4000 + (4000 * admin_tax);
                    $('#cc_form_utility').css('display', 'none')
                }
                var grand_total = subtotal + admin_fee;
                $('#val_admin_fee_utility').val(admin_fee);
                $('#admin_fee_utility').html(`Rp ${formatRupiah(admin_fee.toString())}`)
                $('#grand_total_utility').html(`Rp ${formatRupiah(grand_total.toString())}`)
            });

            $(".select-payment-ipl-method").on('change', function() {
                if ($(this).is(':checked') && $(this).val() == 'credit_card') {
                    var admin_fee = Math.round(2000 + (0.029 * subtotal));
                    var admin_fee = admin_fee + (Math.round(admin_fee * 0.11));

                    $('#cc_form_ipl').css('display', 'block')
                } else {
                    var admin_fee = 4000 + (4000 * admin_tax);
                    $('#cc_form_ipl').css('display', 'none')
                }
                var grand_total = subtotal + admin_fee;
                $('#val_admin_fee_ipl').val(admin_fee);
                $('#admin_fee_ipl').html(`Rp ${formatRupiah(admin_fee.toString())}`)
                $('#grand_total_ipl').html(`Rp ${formatRupiah(grand_total.toString())}`)
            });
        })

        value = '';

        $('.selectTypePayment').on('click', function() {

            type = $(this).attr('payment-type');
            console.log(type)
            SelectType(type);
        })

        function SelectType(type) {
            type = $('.selectTypePayment').attr('payment-type');
            let token = "{{ Request::session()->get('token') }}";

            $.ajax({
                url: `/api/v1/get-splited-billing`,
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                data: {
                    type
                },
                type: 'GET',
                success: function(resp) {
                    console.log(resp)
                }
            })
        }

        $('.select-type').on('change', function() {
            value = $(this).val();
            crID = $(this).attr("cr-id")
            let token = "{{ Request::session()->get('token') }}";

            console.log('asd')
            $.ajax({
                url: `/api/v1/get-splited-billing/${crID}`,
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                type: 'GET',
                success: function(resp) {
                    console.log(resp)
                    // if (value == 'select-payment-ipl') {
                    //     data = resp.data.current_bill.monthly_i_p_l.monthly_i_p_l.cash_receipt;
                    //     console.log(data.transaction_status);
                    //     $('#payment-utility').css("display", "none")
                    //     $('#payment-ipl').css("display", "block")
                    // } else {
                    //     data = resp.data.current_bill.monthly_utility.monthly_utility.cash_receipt;
                    //     $('#payment-utility').css("display", "block")
                    //     $('#payment-ipl').css("display", "none")
                    //     console.log(data.transaction_status);
                    // }
                    // $('#no-invoice').html(data.no_invoice)
                    // $('#payment-date').html(data.settlement_time)
                    // console.log(data.transaction_status);
                    // if (data.transaction_status == 'PAID') {
                    //     $('#payment-status').html(`
                    //     <span class="badge bg-success">Payed</span>
                    // `)
                    // } else {
                    //     $('#payment-status').html(`
                    //     <span class="badge bg-warning">Pending</span>
                    // `)
                    // }
                }
            })
        })

        var admin_tax = 0.11;
        var subtotal = parseInt('{{ $transaction->SubTotal() }}')
        var isCCForm = false;

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

        var token = '{{ $transaction->snap_token }}'
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
    </script>
@endsection
