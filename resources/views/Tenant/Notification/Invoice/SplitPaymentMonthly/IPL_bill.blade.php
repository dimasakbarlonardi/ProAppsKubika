<div class="card mb-3 mt-3">
    <div class="card-body">
        <div class="row justify-content-between align-items-center">
            <div class="col-md">
                <h5 class="mb-2 mb-md-0">Invoice #<span
                        id="no-invoice">{{ $transaction->IPLCashReceipt->no_invoice }}</span></h5>
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
<div class="row align-items-center mb-3">
    <div class="col-sm-6 text-sm-start">
        <img src="{{ $setting->company_logo ? $setting->company_logo : '/assets/img/icons/spot-illustrations/proapps.png' }}"
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
            {{ Auth::user()->Site->nama_site }},
            {{ $transaction->Unit->Tower->nama_tower }}
            {{ $transaction->Unit->nama_unit }}<br />
            {{ Auth::user()->Site->provinsi }}, {{ Auth::user()->Site->kode_pos }}
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
                        <th class="text-sm-end">Payment Due:</th>
                        <td>
                            {{ HumanDate($transaction->tgl_jt_invoice) }}
                        </td>
                    </tr>
                    <tr>
                        <th class="text-sm-end">Payment Status:</th>
                        <td id="payment-status">
                            @if ($transaction->IPLCashReceipt->transaction_status == 'PAID')
                                <span
                                    class="badge bg-success">{{ $transaction->IPLCashReceipt->transaction_status }}</span>
                            @else
                                <span class="badge bg-warning">PENDING</span>
                            @endif
                        </td>
                    </tr>
                    @if ($transaction->IPLCashReceipt->settlement_time)
                        <tr>
                            <th class="text-sm-end">Payment Date :</th>
                            <td id="payment-date">
                                {{ HumanDateTime($transaction->IPLCashReceipt->settlement_time) }}
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
                    <h6 class="mb-3 mt-3">Tagihan IPL</h6>
                    <p class="mb-0">Service Charge</p>
                    <hr>
                    <p class="mb-0">Sink Fund</p>
                </td>
                <td class="align-middle">
                    <h6 class="mb-3 mt-3 text-nowrap">Luas Unit</h6>
                    <span>{{ $transaction->MonthlyIPL->Unit->luas_unit }} m<sup>2</sup></span> <br>
                    <hr>
                    <span>{{ $transaction->MonthlyIPL->Unit->luas_unit }} m<sup>2</sup></span>
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
                    <span>{{ Rupiah($transaction->MonthlyIPL->ipl_service_charge) }}</span> <br>
                    <hr>
                    <span>{{ Rupiah($transaction->MonthlyIPL->ipl_sink_fund) }}</span>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div id="payment-utility" class="mt-5">
    @if ($transaction->IPLCashReceipt->transaction_status == 'PENDING')
        <form action="{{ route('generatePaymentMonthly', $transaction->IPLCashReceipt->id) }}" method="post">
            @csrf
            <div class="row g-3 mb-3">
                <div class="col-lg-8">
                    <div class="card h-100">
                        <div class="card-header">
                            <h6 class="mb-0">Payment Method</h6>
                        </div>
                        <div class="card-body bg-light">
                            <div class="form-check mb-4">
                                <input class="form-check-input select-payment-ipl-method" type="radio" name="billing"
                                    value="bca" />
                                <label class="form-check-label mb-0 d-block" for="paypal">
                                    <img src="{{ asset('assets/img/icons/bca_logo.png') }}" height="20"
                                        alt="" />
                                </label>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input select-payment-ipl-method" type="radio" name="billing"
                                    value="mandiri" />
                                <label class="form-check-label mb-0 d-block" for="paypal">
                                    <img src="{{ asset('assets/img/icons/mandiri_logo.png') }}" height="20"
                                        alt="" />
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input select-payment-ipl-method" type="radio" name="billing"
                                    value="bni" />
                                <label class="form-check-label mb-0 d-block" for="paypal">
                                    <img src="{{ asset('assets/img/icons/bni_logo.png') }}" height="20"
                                        alt="" />
                                </label>
                            </div>
                            <p class="fs--1 mb-4">Pay with PayPal, Apple Pay, PayPal Credit and
                                much more</p>
                            <div class="form-check mb-0">
                                <input class="form-check-input select-payment-ipl-method" type="radio"
                                    value="credit_card" id="credit-card" name="billing" />
                                <label class="form-check-label d-flex align-items-center mb-0" for="credit-card">
                                    <span class="fs-1 text-nowrap">Credit Card</span>
                                    <img class="d-none d-sm-inline-block ms-2 mt-lg-0"
                                        src="{{ asset('assets/img/icons/icon-payment-methods.png') }}" height="20"
                                        alt="" />
                                </label>
                                <div class="row gx-3 mb-3">
                                    <div id="cc_form_ipl">
                                        <div class="col-6 my-3">
                                            <label
                                                class="form-label ls text-uppercase text-600 fw-semi-bold mb-0 fs--1"
                                                for="cardNumber">Card Number
                                            </label>
                                            <input class="form-control" name="card_number"
                                                placeholder="XXXX XXXX XXXX XXXX" type="text" maxlength="16"
                                                pattern="[0-9]{16}" />
                                        </div>
                                        <div class="row gx-3">
                                            <div class="col-6 col-sm-3">
                                                <label
                                                    class="form-label ls text-uppercase text-600 fw-semi-bold mb-0 fs--1"
                                                    for="expDate">Exp Date
                                                </label>
                                                <input class="form-control" id="expDate" placeholder="15/2024"
                                                    type="text" name="expDate" />
                                            </div>
                                            <div class="col-6 col-sm-3">
                                                <label
                                                    class="form-label ls text-uppercase text-600 fw-semi-bold mb-0 fs--1"
                                                    for="cvv">CVV
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Card verification value">
                                                        <span class="fa fa-question-circle"></span>
                                                    </span>
                                                </label>
                                                <input class="form-control" id="cvv" placeholder="123"
                                                    maxlength="3" pattern="[0-9]{3}" name="card_cvv"
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
                                <p class="mb-0">Admin Fee Utility</p><span id="admin_fee_ipl">Rp
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
                            <button class="btn btn-primary d-block w-100" type="button"
                                onclick="onCreateTransaction({{ $transaction->IPLCashReceipt->id }})">
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
        <div class="text-center p-3">
            <a href="{{ route('paymentMonthly', [$transaction->id_monthly_ar_tenant, $transaction->IPLCashReceipt->id]) }}"
                class="btn btn-success">Lihat VA IPL</a>
        </div>
    @endif
</div>

<script>
    $('#cc_form_ipl').css('display', 'none');
    var subtotal = parseInt('{{ $transaction->total_tagihan_ipl }}')
    var ar = parseInt('{{ $transaction->id_monthly_ar_tenant }}')

    $(".select-payment-ipl-method").on('change', function() {
        if ($(this).is(':checked') && $(this).val() == 'credit_card') {
            admin_fee = Math.round(2000 + (0.029 * subtotal));
            admin_fee = admin_fee + (Math.round(admin_fee * 0.11));
            type = 'credit_card';
            bank = '';
            $('#cc_form_ipl').css('display', 'block')
        } else {
            type = 'bank_transfer';
            bank = $(this).val();
            admin_fee = 4000 + (4000 * admin_tax);
            $('#cc_form_ipl').css('display', 'none')
        }
        var grand_total = subtotal + admin_fee;
        $('#val_admin_fee_ipl').val(admin_fee);
        $('#admin_fee_ipl').html(`Rp ${formatRupiah(admin_fee.toString())}`)
        $('#grand_total_ipl').html(`Rp ${formatRupiah(grand_total.toString())}`)
    });

    // function onCreateTransaction(id) {
    //     console.log(admin_fee, type, bank);
    //     $.ajax({
    //         url: `/api/v1/create-transaction/${id}`,
    //         headers: {
    //             'Authorization': 'Bearer ' + token
    //         },
    //         type: 'POST',
    //         data: {
    //             admin_fee,
    //             type,
    //             bank
    //         },
    //         success: function(resp) {
    //             console.log(resp);
    //             if (resp.meta.code === 200) {
    //                 Swal.fire(
    //                     'Berhasil!',
    //                     'Berhasil mengupdate Work Order!',
    //                     'success'
    //                 ).then(() =>
    //                     window.location.replace(`/admin/payment-monthly-page/${ar}/${id}`)
    //                 )
    //             } else {
    //                 Swal.fire(
    //                     'Sorry!',
    //                     'Our server is busy',
    //                     'info'
    //                 ).then(() =>
    //                     window.location.reload()
    //                 )
    //             }
    //         }
    //     });
    // }
</script>
