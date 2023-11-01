@extends('layouts.master')

@section('content')
    @php
        $type = $transaction->transaction_type;

        switch ($type) {
            case 'WorkOrder':
                $type = 'WorkOrder';
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
                    <h5>Proapps</h5>
                    <p class="fs--1 mb-0">
                        Harton Tower Citihub, 6th floor <br>
                        Jl. Boulevard Artha Gading Blok D No. 3, <br>
                        Kelapa Gading Barat
                        Jakarta Utara, 14240
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
                    @foreach ($transaction->Ticket->TenantUnit as $tu)
                        @if ($tu->is_owner == 1)
                            <h6 class="text-500">Unit Owner</h6>
                            <p class="fs--1">
                                <a href="mailto:{{ $tu->Tenant->email_tenant }}">{{ $tu->Tenant->email_tenant }}</a><br />
                                <a href="tel:{{ $tu->Tenant->no_telp_tenant }}">{{ $tu->Tenant->no_telp_tenant }}</a>
                        @endif
                    @endforeach
                    @foreach ($transaction->Ticket->TenantUnit as $tu)
                        @if ($tu->is_owner == 0)
                            <h6 class="text-500">Tenant</h6>
                            <p class="fs--1">
                                <a href="mailto:{{ $tu->Tenant->email_tenant  }}">{{ $tu->Tenant->email_tenant  }}</a><br />
                                <a href="tel:{{ $tu->Tenant->no_telp_tenant }}">{{ $tu->Tenant->no_telp_tenant }}</a>
                        @endif
                    @endforeach
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
                @if ($type == 'WorkOrder')
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
                    <div class="table-responsive scrollbar mt-4 fs--1">
                        <table class="table">
                            <thead data-bs-theme="light">
                                <tr class="bg-primary text-white dark__bg-1000">
                                    <th class="border-0">Products</th>
                                    <th class="border-0 text-center">Quantity</th>
                                    <th class="border-0 text-end">Rate</th>
                                    <th class="border-0 text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($data->PreviousMonthBill())
                                    @foreach ($data->PreviousMonthBill() as $prevBill)
                                        <tr class="alert alert-success my-3">
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
                                                <span>Usage : {{ $prevBill->MonthlyUtility->ElectricUUS->usage }}</span>
                                                <br>
                                                <span>Usage : {{ $prevBill->MonthlyUtility->WaterUUS->usage }}</span>
                                            </td>
                                            <td class="align-middle text-end"></td>
                                            <td class="align-middle text-end">
                                                {{ Rupiah($prevBill->total_tagihan_utility) }}
                                            </td>
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
                                <tr class="alert alert-success my-3">
                                    <td class="align-middle">
                                        <h6 class="mb-0 text-nowrap">Tagihan bulan
                                            {{ $data->periode_bulan }},
                                            {{ $data->periode_tahun }}</h6>
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
                                        <span>Usage : {{ $data->MonthlyUtility->ElectricUUS->usage }}</span> <br>
                                        <span>Usage : {{ $data->MonthlyUtility->WaterUUS->usage }}</span>
                                    </td>
                                    <td class="align-middle text-end"></td>
                                    <td class="align-middle text-end">
                                        {{ rupiah($data->total_tagihan_utility) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">
                                        <h6 class="mb-0 text-nowrap">Tagihan IPL</h6>
                                        <p class="mb-0">Service Charge</p>
                                        <p class="mb-0">Sink Fund</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <br>
                                        <span>{{ rupiah($data->MonthlyIPL->ipl_service_charge) }}</span>
                                        <br>
                                        <span>{{ rupiah($data->MonthlyIPL->ipl_sink_fund) }}</span>
                                    </td>
                                    <td class="align-middle text-end"></td>
                                    <td class="align-middle text-end">
                                        {{ rupiah($data->MonthlyIPL->total_tagihan_ipl) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @if ($transaction->denda_bulan_sebelumnya != 0)
                        <div class="table-responsive scrollbar mt-4 fs--1">
                            <table class="table border-bottom">
                                <thead class="alert alert-danger">
                                    <th class="align-middle">
                                        <h6 class="mb-0 text-nowrap">Denda keterlambatan</h6>
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($transaction->PreviousMonthBill() as $prevBill)
                                        <tr>
                                            <td>
                                                Denda tagihan bulan {{ $prevBill->periode_bulan }}
                                            </td>
                                            <td class="align-middle">
                                                {{ $prevBill->jml_hari_jt }} Hari
                                            </td>
                                            <td class="align-middle text-end"></td>
                                            <td class="align-middle text-end">
                                                {{ rupiah($prevBill->total_denda) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                </tbody>
                            </table>
                        </div>
                    @endif
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
                    <table class="table">
                        <tbody>
                            <tr class="alert alert-success my-3">
                                <td class="align-middle">
                                    <h6 class="mb-0 text-nowrap">Deposit Fit Out Permit</h6>
                                </td>
                                <td class="align-middle text-center">
                                </td>
                                <td class="align-middle text-end"></td>
                                <td class="align-middle text-end"></td>
                            </tr>

                            <tr>
                                <td class="align-middle">
                                    <p class="mb-0">
                                        {{ Rupiah($data->jumlah_deposit) }}
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
                <form action="{{ route('generatePaymentWO', $transaction->id) }}" method="post">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-lg-8">

                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body bg-light">
                                    <div class="d-flex mt-3 justify-content-between fs--1 mb-1">
                                        <p class="mb-0">Subtotal</p>
                                        <span>{{ rupiah($transaction->sub_total) }}</span>
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
                                                id="grand_total">{{ $transaction->gross_amount ? Rupiah($transaction->gross_amount) : rupiah($transaction->sub_total) }}</span>
                                        </h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="val_admin_fee" name="admin_fee">
                </form>
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


        $('document').ready(function() {
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
