@extends('Tenant.stand-alone-index')

@section('content')
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <div class="content mt-3">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md">
                                <h5 class="mb-2 mb-md-0">Invoice #{{ $cr->no_invoice }}</h5>
                            </div>
                            <div class="col-auto"><button class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0"
                                    type="button"><span class="fas fa-arrow-down me-1"> </span>Download
                                    (.pdf)</button><button class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0"
                                    type="button"><span class="fas fa-print me-1"> </span>Print</button><button
                                    class="btn btn-falcon-success btn-sm mb-2 mb-sm-0" type="button"><span
                                        class="fas fa-dollar-sign me-1"></span>Receive Payment</button></div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row align-items-center text-center mb-3">
                            <div class="col-sm-6 text-sm-start"><img
                                    src="{{ asset('assets/img/icons/spot-illustrations/proapps.png') }}" alt="invoice"
                                    width="150" /></div>
                            <div class="col text-sm-end mt-3 mt-sm-0">
                                <h2 class="mb-3">Invoice</h2>
                                <h5>Indoland Manajamen Properti Terpadu</h5>
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
                                <h5>{{ $cr->User->nama_user }}</h5>
                                @if ($cr->User->Tenant)
                                    <p class="fs--1">
                                        @if ($cr->ElectricUSS)
                                            {{ Auth::user()->Site->nama_site }},
                                            {{ $cr->ElectricUSS->Unit->Tower->nama_tower }}
                                            {{ $cr->ElectricUSS->Unit->nama_unit }}<br />
                                            {{ Auth::user()->Site->provinsi }}, {{ Auth::user()->Site->kode_pos }}
                                        @endif
                                    </p>
                                    <p class="fs--1"><a href="mailto:example@gmail.com">
                                            {{ $cr->User->login_user }}</a><br />
                                        <a href="tel:444466667777">{{ $cr->User->Tenant->no_telp_tenant }}</a>
                                    </p>
                                @endif
                            </div>
                            <div class="col-sm-auto ms-auto">
                                <div class="table-responsive">
                                    <table class="table table-sm table-borderless fs--1">
                                        <tbody>
                                            <tr>
                                                <th class="text-sm-end">Invoice Date:</th>
                                                <td>{{ HumanDate($cr->created_at) }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-sm-end">Payment Status:</th>
                                                <td>
                                                    @if ($cr->transaction_status == 'PAID')
                                                        <span class="badge bg-success">Payed</span>
                                                    @else
                                                        <span class="badge bg-warning">Pending</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="alert alert-success fw-bold">
                                                <th class="text-sm-end">Amount Due:</th>
                                                <td>{{ rupiah($cr->gross_amount) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive scrollbar mt-4 fs--1">
                            <table class="table table-striped border-bottom">
                                <thead data-bs-theme="light">
                                    <tr class="bg-primary text-white dark__bg-1000">
                                        <th class="border-0">Products</th>
                                        <th class="border-0 text-center">Quantity</th>
                                        <th class="border-0 text-end">Rate</th>
                                        <th class="border-0 text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="align-middle">
                                            <h6 class="mb-0 text-nowrap">Tagihan Listrik</h6>
                                            <p class="mb-0">Tagihan listrik bulan {{ $cr->ElectricUSS->periode_bulan }}
                                            </p>
                                        </td>
                                        <td class="align-middle text-center"></td>
                                        <td class="align-middle text-end"></td>
                                        <td class="align-middle text-end">{{ rupiah($cr->sub_total) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle">
                                            <h6 class="mb-0 text-nowrap">Biaya admin</h6>
                                        </td>
                                        <td class="align-middle text-center"></td>
                                        <td class="align-middle text-end"></td>
                                        <td class="align-middle text-end">{{ rupiah($cr->admin_fee) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-auto">
                                <table class="table table-sm table-borderless fs--1 text-end">
                                    <tr>
                                        <th class="text-900">Subtotal:</th>
                                        <td class="fw-semi-bold">{{ rupiah($cr->gross_amount) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-900">Tax 11%:</th>
                                        <td class="fw-semi-bold">{{ rupiah($cr->gross_amount * 0.11) }}</td>
                                    </tr>
                                    <tr class="border-top">
                                        <th class="text-900">Total:</th>
                                        <td class="fw-semi-bold">
                                            {{ rupiah($cr->gross_amount * 0.11 + $cr->gross_amount) }}</td>
                                    </tr>
                                    <tr class="border-top border-top-2 fw-bolder text-900">
                                        <th>Amount Due:</th>
                                        <td>{{ rupiah($cr->gross_amount * 0.11 + $cr->gross_amount) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="footer">
                    <div class="row g-0 justify-content-between fs--1 mt-4 mb-3">
                        <div class="col-12 col-sm-auto text-center">
                            <p class="mb-0 text-600">
                                &copy; Copyright 2023, Indoland Group
                            </p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </main>
@endsection
