<div class="card mb-3">
    <div class="card-body">
        <div class="row justify-content-between align-items-center">
            <div class="col-md">
                <h5 class="mb-2 mb-md-0">Invoice #{{ $transaction->no_invoice }}</h5>
            </div>
            <div class="col-auto"><button class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0" type="button"><span
                        class="fas fa-arrow-down me-1"> </span>Download (.pdf)</button><button
                    class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0" type="button"><span
                        class="fas fa-print me-1"> </span>Print</button><button
                    class="btn btn-falcon-success btn-sm mb-2 mb-sm-0" type="button"><span
                        class="fas fa-dollar-sign me-1"></span>Receive Payment</button></div>
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-body">
        <div class="row align-items-center text-center mb-3">
            <div class="col-sm-6 text-sm-start"><img src="/assets/img/icons/spot-illustrations/proapps.png"
                    alt="invoice" width="150" /></div>
            <div class="col text-sm-end mt-3 mt-sm-0">
                <h2 class="mb-3">Invoice</h2>
                <h5>Falcon Design Studio</h5>
                <p class="fs--1 mb-0">156 University Ave, Toronto<br />On, Canada, M5H 2H7</p>
            </div>
            <div class="col-12">
                <hr />
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col">
                <h6 class="text-500">Invoice to</h6>
                <h5>{{ $transaction->monthlyARTenant->Unit->TenantUnit->Tenant->nama_tenant }}</h5>
                <p class="fs--1">
                    {{ Auth::user()->Site->nama_site }},
                    {{ $transaction->monthlyARTenant->Unit->Tower->nama_tower }}
                    {{ $transaction->monthlyARTenant->Unit->nama_unit }}<br />
                    {{ Auth::user()->Site->provinsi }}, {{ Auth::user()->Site->kode_pos }}
                </p>
                <p class="fs--1"><a
                        href="mailto:{{ $transaction->monthlyARTenant->Unit->TenantUnit->Tenant->email_tenant }}">{{ $transaction->monthlyARTenant->Unit->TenantUnit->Tenant->email_tenant }}</a><br /><a
                        href="tel:444466667777">{{ $transaction->monthlyARTenant->Unit->TenantUnit->Tenant->no_telp_tenant }}</a></p>
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
                                    {{ HumanDate($transaction->monthlyARTenant->tgl_jt_invoice) }}
                                </td>
                            </tr>
                            <tr class="alert alert-success fw-bold">
                                <th class="text-sm-end">Amount Due:</th>
                                <td>{{ rupiah($transaction->sub_total) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="table-responsive scrollbar mt-4 fs--1">
            <table class="table border-bottom">
                <thead data-bs-theme="light">
                    <tr class="bg-primary text-white dark__bg-1000">
                        <th class="border-0">Products</th>
                        <th class="border-0 text-center">Quantity</th>
                        <th class="border-0 text-end">Rate</th>
                        <th class="border-0 text-end">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($transaction->MonthlyARTenant->PreviousMonthBill())
                        @foreach ($transaction->MonthlyARTenant->PreviousMonthBill() as $prevBill)
                            <tr class="alert alert-info my-3">
                                <td class="align-middle">
                                    <h6 class="mb-0 text-nowrap">Tagihan bulan {{ $prevBill->periode_bulan }},
                                        {{ $prevBill->periode_tahun }}</h6>
                                </td>
                                <td class="align-middle text-center">
                                </td>
                                <td class="align-middle text-end"></td>
                                <td class="align-middle text-end"></td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td class="align-middle">
                                    <h6 class="mb-0 text-nowrap">Tagihan Utility</h6>
                                    <p class="mb-0">Listrik</p>
                                    <p class="mb-0">Air</p>
                                </td>
                                <td class="align-middle text-center">
                                    <br>
                                    <span>Usage : {{ $prevBill->MonthlyUtility->ElectricUUS->usage }}</span> <br>
                                    <span>Usage : {{ $prevBill->MonthlyUtility->WaterUUS->usage }}</span>
                                </td>
                                <td class="align-middle text-end"></td>
                                <td class="align-middle text-end">
                                    {{ rupiah($prevBill->total_tagihan_utility) }}</td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td class="align-middle">
                                    <h6 class="mb-0 text-nowrap">Tagihan IPL</h6>
                                    <p class="mb-0">Service Charge</p>
                                    <p class="mb-0">Sink Fund</p>
                                </td>
                                <td class="align-middle text-center">
                                    <br>
                                    <span>{{ rupiah($prevBill->MonthlyIPL->ipl_service_charge) }}</span>
                                    <br>
                                    <span>{{ rupiah($prevBill->MonthlyIPL->ipl_sink_fund) }}</span>
                                </td>
                                <td class="align-middle text-end"></td>
                                <td class="align-middle text-end">
                                    {{ rupiah($prevBill->MonthlyIPL->total_tagihan_ipl) }}</td>
                            </tr>
                        @endforeach
                    @endif
                    <tr class="alert alert-info my-3">
                        <td class="align-middle">
                            <h6 class="mb-0 text-nowrap">Tagihan bulan
                                {{ $transaction->MonthlyARTenant->periode_bulan }},
                                {{ $transaction->MonthlyARTenant->periode_tahun }}</h6>
                        </td>
                        <td class="align-middle text-center">
                        </td>
                        <td class="align-middle text-end"></td>
                        <td class="align-middle text-end"></td>
                    </tr>
                    <tr>
                        <td class="align-middle">
                            <h6 class="mb-0 text-nowrap">Tagihan Utility</h6>
                            <p class="mb-0">Listrik</p>
                            <p class="mb-0">Air</p>
                        </td>
                        <td class="align-middle text-center">
                            <br>
                            <span>Usage : {{ $transaction->MonthlyARTenant->MonthlyUtility->ElectricUUS->usage }}</span> <br>
                            <span>Usage : {{ $transaction->MonthlyARTenant->MonthlyUtility->WaterUUS->usage }}</span>
                        </td>
                        <td class="align-middle text-end"></td>
                        <td class="align-middle text-end">
                            {{ rupiah($transaction->MonthlyARTenant->total_tagihan_utility) }}</td>
                    </tr>
                    <tr>
                        <td class="align-middle">
                            <h6 class="mb-0 text-nowrap">Tagihan IPL</h6>
                            <p class="mb-0">Service Charge</p>
                            <p class="mb-0">Sink Fund</p>
                        </td>
                        <td class="align-middle text-center">
                            <br>
                            <span>{{ rupiah($transaction->MonthlyARTenant->MonthlyIPL->ipl_service_charge) }}</span>
                            <br>
                            <span>{{ rupiah($transaction->MonthlyARTenant->MonthlyIPL->ipl_sink_fund) }}</span>
                        </td>
                        <td class="align-middle text-end"></td>
                        <td class="align-middle text-end">
                            {{ rupiah($transaction->MonthlyARTenant->MonthlyIPL->total_tagihan_ipl) }}</td>
                    </tr>
                    @if ($transaction->MonthlyARTenant->denda_bulan_sebelumnya != 0)
                        <tr class="alert alert-info">
                            <td class="align-middle">
                                <h6 class="mb-0 text-nowrap">Denda keterlambatan</h6>
                            </td>
                            <td class="align-middle text-center">

                            </td>
                            <td class="align-middle text-end"></td>
                            <td class="align-middle text-end"></td>
                        </tr>
                        <tbody id="exampleid">
                        </tbody>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="row justify-content-end">
            <div class="col-auto">
                <table class="table table-sm table-borderless fs--1 text-end">
                    <tr>
                        <th class="text-900">Subtotal:</th>
                        <td class="fw-semi-bold">$18,230.00 </td>
                    </tr>
                    <tr>
                        <th class="text-900">Tax 8%:</th>
                        <td class="fw-semi-bold">$1458.40</td>
                    </tr>
                    <tr class="border-top">
                        <th class="text-900">Total:</th>
                        <td class="fw-semi-bold">$19688.40</td>
                    </tr>
                    <tr class="border-top border-top-2 fw-bolder text-900">
                        <th>Amount Due:</th>
                        <td>$19688.40</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var token = '{{ $transaction->snap_token }}'
    var periode_bulan = "{{ $transaction->MonthlyARTenant->periode_bulan }}"
    var periode_tahun = '{{ $transaction->MonthlyARTenant->periode_tahun }}'
    // console.log(periode_bulan, periode_tahun);
    $.ajax({
        url: '/admin/get-montly-ar',
        type: 'POST',
        data: {
            token
        },
        success: function(resp) {
            resp[0].map((item) => {
                if (periode_bulan != item.periode_bulan) {
                    $('#exampleid').append(`<tr>
                        <td class="align-middle text-nowrap">Periode bulan ${item.periode_bulan}, ${item.periode_tahun}</td>
                        <td class="text-center">${item.jml_hari_jt} Hari</td>
                        <td></td>
                        <td class="text-end">Rp ${formatRupiah(item.total_denda)}</td>
                        </tr>`);
                }
            })
        }
    })

    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix) {
        var angka = angka.substring(0, angka.length - 3);

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