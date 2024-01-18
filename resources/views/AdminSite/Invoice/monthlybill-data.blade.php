<p>Total Invoice : {{ count($transactions) }}</p>
<hr>
<table class="table mb-0" id="tableData">
    <thead class="text-black bg-200">
        <tr>
            <th class="align-middle">Unit</th>
            <th class="align-middle">Trasaction Type</th>
            <th class="align-middle">Status</th>
            <th class="align-middle text-center">Action</th>
        </tr>
    </thead>
    <tbody id="bulk-select-body">
        @foreach ($transactions as $key => $item)
            <tr>
                <td class="align-middle">
                    {{ $item->Unit->nama_unit }}
                </td>
                <td class="align-middle">
                    Monthly Billing
                </td>
                <td class="align-middle">
                    @if ($item->status_payment)
                        <span class="badge bg-success">PAID</span>
                    @else
                        <span class="badge bg-warning">PENDING</span>
                    @endif
                </td>
                <td class="text-center">
                    <a href="{{ route('showInvoices', $item->UtilityCashReceipt->id) }}"
                        class="btn btn-outline-info btn-sm">View
                    </a>
                    <button class="btn btn-outline-success btn-sm verifyButton" type="button"
                        data-id="{{ $item->id_monthly_ar_tenant }}"
                        other-tr-status="{{ $item->OtherCashReceipt() ? $item->OtherCashReceipt()->transaction_status : '' }}"
                        utility-tr-status="{{ $item->UtilityCashReceipt ? $item->UtilityCashReceipt->transaction_status : '' }}"
                        ipl-tr-status="{{ $item->IPLCashReceipt ? $item->IPLCashReceipt->transaction_status : '' }}"
                        other-tr-image="{{ $item->OtherCashReceipt() ? $item->OtherCashReceipt()->payment_image : '' }}"
                        utility-tr-image="{{ $item->UtilityCashReceipt ? $item->UtilityCashReceipt->payment_image : '' }}"
                        ipl-tr-image="{{ $item->IPLCashReceipt ? $item->IPLCashReceipt->payment_image : '' }}"
                        data-bs-toggle="modal" data-bs-target="#modal-verify">Verify</button>
                    {{-- <a href="{{ route('installment', $item->id) }}" class="btn btn-outline-success btn-sm">Installment
                    </a> --}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="modal fade" id="modal-verify" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
        <form action="{{ route('manualVerifyPayment') }}" id="manualPaymentForm" method="post"
            enctype="multipart/form-data">
            @csrf
            {{ csrf_field() }}
            <div class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                    <button type="button" class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-header">
                    <h4 class="mb-4" id="modalExampleDemoLabel">Manual Verify Payment
                    </h4>
                </div>
                <div class="modal-body p-0">
                    <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                        @if ($system->is_split_ar)
                            <div id="uploadFileUtility">

                            </div>
                            <hr>
                            <div id="uploadFileIPL">

                            </div>
                        @else
                            <div class="mb-3">
                                <label class="form-label">
                                    Proof of payment
                                    @if ($item->CashReceipt->transaction_status == 'PAID')
                                        <small class="text-success">(Paid)</small>
                                    @else
                                        <small class="text-danger">(Unpaid)</small>
                                    @endif
                                </label>
                                <input type="file" name="cashreceipt" class="form-control"
                                    accept="image/png, image/jpg, image/jpeg">
                            </div>
                        @endif
                    </div>
                </div>
                <input type="hidden" name="ar_id" id="ar_id">
                <div class="modal-footer">
                    {{-- <button onclick="submitPayment()" type="button" class="btn btn-primary">Verify</button> --}}
                    <button type="submit" class="btn btn-primary"
                        onclick="return confirm('are you sure?')">Verify</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $('.verifyButton').on('click', function() {

        otherTrStatus = $(this).attr('other-tr-status')
        utilityTrStatus = $(this).attr('utility-tr-status')
        iplTrStatus = $(this).attr('ipl-tr-status')
        otherTrImage = $(this).attr('other-tr-image')
        utilityTrImage = $(this).attr('utility-tr-image')
        iplTrImage = $(this).attr('ipl-tr-image')

        $('#ar_id').val($(this).attr('data-id'))

        $('#uploadFileUtility').html(`
            <div class="mb-3">
                <label class="form-label">
                    Proof of payment Utility
                        ${utilityTrStatus == 'PAID' ? `
                            <small class="text-success">(Paid)</small>
                        ` : `
                            <small class="text-danger">(Unpaid)</small>
                        ` }
                </label>
                <input type="file" name="utility_cash_receipt" class="form-control"
                    accept="image/png, image/jpg, image/jpeg"
                        ${utilityTrStatus == 'PAID' ? `
                            disabled
                        ` : `` }>
                ${utilityTrImage ? `
                    <div class="d-inline-flex flex-column mt-3">
                        <div class="border p-2 rounded-3 d-flex bg-white dark__bg-1000 fs--1 mb-2">
                            <a class="ms-auto text-decoration-none" target="_blank" href="${utilityTrImage}">
                                <span class="fs-1 far fa-image"></span>
                                <span class="ms-2 me-3">Image</span>
                            </a>
                        </div>
                    </div>
                ` : ``}
            </div>
        `)

        $('#uploadFileIPL').html(`
            <div class="mb-3">
                <label class="form-label">
                    Proof of payment IPL
                        ${iplTrStatus == 'PAID' ? `
                            <small class="text-success">(Paid)</small>
                        ` : `
                            <small class="text-danger">(Unpaid)</small>
                        ` }
                </label>
                <input type="file" name="ipl_cash_receipt" class="form-control"
                    accept="image/png, image/jpg, image/jpeg"
                        ${iplTrStatus == 'PAID' ? `
                            disabled
                        ` : `` }
                    >
                ${iplTrImage ? `
                        <div class="d-inline-flex flex-column mt-3">
                            <div class="border p-2 rounded-3 d-flex bg-white dark__bg-1000 fs--1 mb-2">
                                <a class="ms-auto text-decoration-none" target="_blank" href="${iplTrImage}">
                                    <span class="fs-1 far fa-image"></span>
                                    <span class="ms-2 me-3">Image</span>
                                </a>
                            </div>
                        </div>
                    ` : ``}
            </div>
        `)
    })
</script>
