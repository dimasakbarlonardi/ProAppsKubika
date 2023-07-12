@extends('layouts.master')

@section('content')
<div class="row g-0 my-4">
    <div class="col-lg-12 ps-lg-2 mb-3">
        <div class="card h-lg-100">
            <div class="card-header">
                <div class="row flex-between-center">
                    <div class="col-auto">
                        <h5 class="mb-0 text-light">Building Information</h5>
                    </div>
                </div>
            </div>
            <div class="card-body h-100 pe-0 p-4">
                <div class="col">
                    <div class="row g-3">
                        <div class="col-3 col-xxl-12">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="row flex-between-center g-0">
                                        <div class="col-auto h-100">
                                            <img height="45"
                                                src="{{ asset('assets/img/icons/tower_icon.png') }}"
                                                alt="">
                                        </div>
                                        <div class="col-6 d-lg-block flex-between-center">
                                            <h6 class="mb-2 text-900">Tower</h6>
                                            <h4 class="fs-3 fw-normal text-700 mb-0">
                                                <span>{{ $tower }}</span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 col-xxl-12">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="row flex-between-center g-0">
                                        <div class="col-auto h-100">
                                            <img height="45"
                                                src="{{ asset('assets/img/icons/karyawan_icon.png') }}"
                                                alt="">
                                        </div>
                                        <div class="col-6 d-lg-block flex-between-center">
                                            <h6 class="mb-2 text-900">Employee</h6>
                                            <h4 class="fs-3 fw-normal text-700 mb-0">
                                                <span>{{ $karyawan }}</span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 col-xxl-12">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="row flex-between-center g-0">
                                        <div class="col-auto h-100">
                                            <img height="45"
                                                src="{{ asset('assets/img/icons/unit_icon.png') }}"
                                                alt="">
                                        </div>
                                        <div class="col-6 d-lg-block flex-between-center">
                                            <h6 class="mb-2 text-900">Unit</h6>
                                            <h4 class="fs-3 fw-normal text-700 mb-0">
                                                <span>{{ $unit }}</span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 col-xxl-12">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="row flex-between-center g-0">
                                        <div class="col-auto h-100">
                                            <img height="45"
                                                src="{{ asset('assets/img/icons/owner.png') }}"
                                                alt="">
                                        </div>
                                        <div class="col-6 d-lg-block flex-between-center">
                                            <h6 class="mb-2 text-900">Owner</h6>
                                            <h4 class="fs-3 fw-normal text-700 mb-0">
                                                <span>{{ $tower }}</span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 col-xxl-12">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="row flex-between-center g-0">
                                        <div class="col-auto h-100">
                                            <img height="45"
                                                src="{{ asset('assets/img/icons/tenant_icon.png') }}"
                                                alt="">
                                        </div>
                                        <div class="col-6 d-lg-block flex-between-center">
                                            <h6 class="mb-2 text-900">Tenant</h6>
                                            <h4 class="fs-3 fw-normal text-700 mb-0">
                                                <span>{{ $tenant }}</span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="row g-0">
        <div class="col-lg-12 ps-lg-2 mb-3">
            <div class="card h-lg-100">
                <div class="card-header">
                    <div class="row flex-between-center">
                        <div class="col-auto">
                            <h5 class="mb-0 text-light">Ticket Peformance (Volume)</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body h-100 pe-0">
                    <div class="row g-3 mb-3">
                        <div class="col-xxl-9">
                            <div class="row g-3 mb-3">
                                <div class="col-sm-6 col-md-4">
                                    <div class="card overflow-hidden" style="min-width: 12rem">
                                        <div class="bg-holder bg-card"
                                            style="background-image:url(../assets/img/icons/spot-illustrations/corner-1.png);">
                                        </div>
                                        <!--/.bg-holder-->
                                        <div class="card-body position-relative">
                                            <h6>Entry Ticket</h6>
                                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning">
                                                {{ $entry_ticket }}</div>
                                            <a class="fw-semi-bold fs--1 text-nowrap"
                                                href="../app/e-commerce/customers.html">See all
                                                <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="card overflow-hidden" style="min-width: 12rem">
                                        <div class="bg-holder bg-card"
                                            style="background-image:url(../assets/img/icons/spot-illustrations/corner-2.png);">
                                        </div>
                                        <!--/.bg-holder-->
                                        <div class="card-body position-relative">
                                            <h6>Work Request</h6>
                                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info">
                                                {{ $wr }}</div>
                                            <a class="fw-semi-bold fs--1 text-nowrap"
                                                href="../app/e-commerce/customers.html">See all
                                                <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card overflow-hidden" style="min-width: 12rem">
                                        <div class="bg-holder bg-card"
                                            style="background-image:url(../assets/img/icons/spot-illustrations/corner-3.png);">
                                        </div>
                                        <!--/.bg-holder-->
                                        <div class="card-body position-relative">
                                            <h6>Work Order</h6>
                                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif">{{ $wo }}
                                            </div>
                                            <a class="fw-semi-bold fs--1 text-nowrap"
                                                href="../app/e-commerce/customers.html">See all
                                                <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-xxl-9">
                            <div class="row g-3 mb-3">
                                <div class="col-sm-6 col-md-4">
                                    <div class="card overflow-hidden" style="min-width: 12rem">
                                        <div class="bg-holder bg-card"
                                            style="background-image:url(../assets/img/icons/spot-illustrations/corner-2.png);">
                                        </div>
                                        <!--/.bg-holder-->
                                        <div class="card-body position-relative">
                                            <h6>BAPP</h6>
                                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning">
                                                {{ $bapp }}</div>
                                            <a class="fw-semi-bold fs--1 text-nowrap"
                                                href="../app/e-commerce/customers.html">See all
                                                <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="card overflow-hidden" style="min-width: 12rem">
                                        <div class="bg-holder bg-card"
                                            style="background-image:url(../assets/img/icons/spot-illustrations/corner-3.png);">
                                        </div>
                                        <!--/.bg-holder-->
                                        <div class="card-body position-relative">
                                            <h6>GIGO</h6>
                                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info">
                                                {{ $gigo }}</div>
                                            <a class="fw-semi-bold fs--1 text-nowrap"
                                                href="../app/e-commerce/customers.html">See all
                                                <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card overflow-hidden" style="min-width: 12rem">
                                        <div class="bg-holder bg-card"
                                            style="background-image:url(../assets/img/icons/spot-illustrations/corner-1.png);">
                                        </div>
                                        <!--/.bg-holder-->
                                        <div class="card-body position-relative">
                                            <h6>Reservation</h6>
                                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif">{{ $rsv }}
                                            </div>
                                            <a class="fw-semi-bold fs--1 text-nowrap"
                                                href="../app/e-commerce/customers.html">See all
                                                <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-0 my-4">
        <div class="col-lg-12 ps-lg-2 mb-3">
            <div class="card h-lg-100">
                <div class="card-header">
                    <div class="row flex-between-center">
                        <div class="col-auto">
                            <h5 class="mb-0 text-light">Ticket Peformance (Quality)</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body h-100 pe-0 p-4">
                    <div class="col">
                        <div class="row g-3">
                            <div class="col-md-3 col-xxl-12">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row flex-between-center g-0">
                                            <div class="col-6 d-lg-block flex-between-center">
                                                <h6 class="mb-2 text-900">Ticket Complete</h6>
                                                <h4 class="fs-3 fw-normal text-700 mb-0">
                                                    <span>{{ $complete_ticket }}</span>
                                                    <span>/</span>
                                                    <span>{{ $entry_ticket }}</span>
                                                </h4>
                                            </div>
                                            <div class="col-auto h-100">
                                                <img height="45"
                                                    src="{{ asset('assets/img/icons/ticket_complete.png') }}"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-xxl-12">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row flex-between-center g-0">
                                            <div class="col-7 d-lg-block flex-between-center">
                                                <h6 class="mb-2 text-900">Ticket on Progress</h6>
                                                <h4 class="fs-3 fw-normal text-700 mb-0">
                                                    <span>{{ $progress_ticket }}</span>
                                                    <span>/</span>
                                                    <span>{{ $entry_ticket }}</span>
                                                </h4>
                                            </div>
                                            <div class="col-auto h-100">
                                                <img height="45"
                                                    src="{{ asset('assets/img/icons/ticket_on_progress.png') }}"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-xxl-12">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row flex-between-center g-0">
                                            <div class="col-6 d-lg-block flex-between-center">
                                                <h6 class="mb-2 text-900">Ticket Hold</h6>
                                                <h4 class="fs-3 fw-normal text-700 mb-0">
                                                    <span>0</span>
                                                    <span>/</span>
                                                    <span>{{ $entry_ticket }}</span>
                                                </h4>
                                            </div>
                                            <div class="col-auto h-100">
                                                <img height="45" src="{{ asset('assets/img/icons/ticket_hold.png') }}"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-xxl-12">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row flex-between-center g-0">
                                            <div class="col-6 d-lg-block flex-between-center">
                                                <h6 class="mb-2 text-900">Ticket Cancel</h6>
                                                <h4 class="fs-3 fw-normal text-700 mb-0">
                                                    <span>0</span>
                                                    <span>/</span>
                                                    <span>{{ $entry_ticket }}</span>
                                                </h4>
                                            </div>
                                            <div class="col-auto h-100">
                                                <img height="45"
                                                    src="{{ asset('assets/img/icons/ticket_cancel.png') }}"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-0">
        <div class="col-lg-12 ps-lg-2 mb-3">
            <div class="card h-lg-100">
                <div class="card-header">
                    <div class="row flex-between-center">
                        <div class="col-auto">
                            <h5 class="mb-0 text-light">Ticket Peformance (Volume)</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body h-100 pe-0">
                    <div class="row g-3 mb-3">
                        <div class="col-xxl-9">
                            <div class="row g-3 mb-3">
                                <div class="col-sm-6 col-md-4">
                                    <div class="card overflow-hidden" style="min-width: 12rem">
                                        <div class="bg-holder bg-card"
                                            style="background-image:url(../assets/img/icons/spot-illustrations/corner-1.png);">
                                        </div>
                                        <!--/.bg-holder-->
                                        <div class="card-body position-relative">
                                            <h6>Entry Ticket</h6>
                                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning">
                                                {{ $entry_ticket }}</div>
                                            <a class="fw-semi-bold fs--1 text-nowrap"
                                                href="../app/e-commerce/customers.html">See all
                                                <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="card overflow-hidden" style="min-width: 12rem">
                                        <div class="bg-holder bg-card"
                                            style="background-image:url(../assets/img/icons/spot-illustrations/corner-2.png);">
                                        </div>
                                        <!--/.bg-holder-->
                                        <div class="card-body position-relative">
                                            <h6>Work Request</h6>
                                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info">
                                                {{ $wr }}</div>
                                            <a class="fw-semi-bold fs--1 text-nowrap"
                                                href="../app/e-commerce/customers.html">See all
                                                <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card overflow-hidden" style="min-width: 12rem">
                                        <div class="bg-holder bg-card"
                                            style="background-image:url(../assets/img/icons/spot-illustrations/corner-3.png);">
                                        </div>
                                        <!--/.bg-holder-->
                                        <div class="card-body position-relative">
                                            <h6>Work Order</h6>
                                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif">{{ $wo }}
                                            </div>
                                            <a class="fw-semi-bold fs--1 text-nowrap"
                                                href="../app/e-commerce/customers.html">See all
                                                <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-xxl-9">
                            <div class="row g-3 mb-3">
                                <div class="col-sm-6 col-md-4">
                                    <div class="card overflow-hidden" style="min-width: 12rem">
                                        <div class="bg-holder bg-card"
                                            style="background-image:url(../assets/img/icons/spot-illustrations/corner-2.png);">
                                        </div>
                                        <!--/.bg-holder-->
                                        <div class="card-body position-relative">
                                            <h6>BAPP</h6>
                                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning">
                                                {{ $bapp }}</div>
                                            <a class="fw-semi-bold fs--1 text-nowrap"
                                                href="../app/e-commerce/customers.html">See all
                                                <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="card overflow-hidden" style="min-width: 12rem">
                                        <div class="bg-holder bg-card"
                                            style="background-image:url(../assets/img/icons/spot-illustrations/corner-3.png);">
                                        </div>
                                        <!--/.bg-holder-->
                                        <div class="card-body position-relative">
                                            <h6>GIGO</h6>
                                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info">
                                                {{ $gigo }}</div>
                                            <a class="fw-semi-bold fs--1 text-nowrap"
                                                href="../app/e-commerce/customers.html">See all
                                                <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card overflow-hidden" style="min-width: 12rem">
                                        <div class="bg-holder bg-card"
                                            style="background-image:url(../assets/img/icons/spot-illustrations/corner-1.png);">
                                        </div>
                                        <!--/.bg-holder-->
                                        <div class="card-body position-relative">
                                            <h6>Reservation</h6>
                                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif">{{ $rsv }}
                                            </div>
                                            <a class="fw-semi-bold fs--1 text-nowrap"
                                                href="../app/e-commerce/customers.html">See all
                                                <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-0 my-4">
        <div class="col-lg-12 ps-lg-2 mb-3">
            <div class="card h-lg-100">
                <div class="card-header">
                    <div class="row flex-between-center">
                        <div class="col-auto">
                            <h5 class="mb-0 text-light">Ticket Peformance (Quality)</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body h-100 pe-0 p-4">
                    <div class="col">
                        <div class="row g-3">
                            <div class="col-md-3 col-xxl-12">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row flex-between-center g-0">
                                            <div class="col-6 d-lg-block flex-between-center">
                                                <h6 class="mb-2 text-900">Ticket Complete</h6>
                                                <h4 class="fs-3 fw-normal text-700 mb-0">
                                                    <span>{{ $complete_ticket }}</span>
                                                    <span>/</span>
                                                    <span>{{ $entry_ticket }}</span>
                                                </h4>
                                            </div>
                                            <div class="col-auto h-100">
                                                <img height="45"
                                                    src="{{ asset('assets/img/icons/ticket_complete.png') }}"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-xxl-12">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row flex-between-center g-0">
                                            <div class="col-7 d-lg-block flex-between-center">
                                                <h6 class="mb-2 text-900">Ticket on Progress</h6>
                                                <h4 class="fs-3 fw-normal text-700 mb-0">
                                                    <span>{{ $progress_ticket }}</span>
                                                    <span>/</span>
                                                    <span>{{ $entry_ticket }}</span>
                                                </h4>
                                            </div>
                                            <div class="col-auto h-100">
                                                <img height="45"
                                                    src="{{ asset('assets/img/icons/ticket_on_progress.png') }}"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-xxl-12">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row flex-between-center g-0">
                                            <div class="col-6 d-lg-block flex-between-center">
                                                <h6 class="mb-2 text-900">Ticket Hold</h6>
                                                <h4 class="fs-3 fw-normal text-700 mb-0">
                                                    <span>0</span>
                                                    <span>/</span>
                                                    <span>{{ $entry_ticket }}</span>
                                                </h4>
                                            </div>
                                            <div class="col-auto h-100">
                                                <img height="45" src="{{ asset('assets/img/icons/ticket_hold.png') }}"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-xxl-12">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row flex-between-center g-0">
                                            <div class="col-6 d-lg-block flex-between-center">
                                                <h6 class="mb-2 text-900">Ticket Cancel</h6>
                                                <h4 class="fs-3 fw-normal text-700 mb-0">
                                                    <span>0</span>
                                                    <span>/</span>
                                                    <span>{{ $entry_ticket }}</span>
                                                </h4>
                                            </div>
                                            <div class="col-auto h-100">
                                                <img height="45"
                                                    src="{{ asset('assets/img/icons/ticket_cancel.png') }}"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-0">
        <div class="col-lg-12 ps-lg-2 mb-3">
            <div class="card h-lg-100">
                <div class="card-header">
                    <div class="row flex-between-center">
                        <div class="col-auto">
                            <h6 class="mb-0 text-light">Total Sales</h6>
                        </div>
                        <div class="col-auto d-flex"><select class="form-select form-select-sm select-month me-2">
                                <option value="0">January</option>
                                <option value="1">February</option>
                                <option value="2">March</option>
                                <option value="3">April</option>
                                <option value="4">May</option>
                                <option value="5">Jun</option>
                                <option value="6">July</option>
                                <option value="7">August</option>
                                <option value="8">September</option>
                                <option value="9">October</option>
                                <option value="10">November</option>
                                <option value="11">December</option>
                            </select>
                            <div class="dropdown font-sans-serif btn-reveal-trigger">
                                <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal"
                                    type="button" id="dropdown-total-sales" data-bs-toggle="dropdown"
                                    data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span
                                        class="fas fa-ellipsis-h fs--2 text-light"></span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end border py-2"
                                    aria-labelledby="dropdown-total-sales"><a class="dropdown-item"
                                        href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-danger"
                                        href="#!">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body h-100 pe-0">
                    <!-- Find the JS file for the following chart at: src\js\charts\echarts\total-sales.js-->
                    <!-- If you are not using gulp based workflow, you can find the transpiled code at: public\assets\js\theme.js-->
                    <div class="echart-line-total-sales h-100" data-echart-responsive="true"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-0">
        <div class="col-xxl-6 px-xxl-2">
            <div class="card h-100">
                <div class="card-header py-2">
                    <div class="row flex-between-center">
                        <div class="col-auto">
                            <h6 class="mb-0">Top Products</h6>
                        </div>
                        <div class="col-auto d-flex"><a class="btn btn-link btn-sm me-2" href="#!">View Details</a>
                            <div class="dropdown font-sans-serif btn-reveal-trigger"><button
                                    class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal"
                                    type="button" id="dropdown-top-products" data-bs-toggle="dropdown"
                                    data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span
                                        class="fas fa-ellipsis-h fs--2"></span></button>
                                <div class="dropdown-menu dropdown-menu-end border py-2"
                                    aria-labelledby="dropdown-top-products"><a class="dropdown-item"
                                        href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-danger"
                                        href="#!">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body h-100">
                    <!-- Find the JS file for the following chart at: src/js/charts/echarts/top-products.js-->
                    <!-- If you are not using gulp based workflow, you can find the transpiled code at: public/assets/js/theme.js-->
                    <div class="echart-bar-top-products h-100" data-echart-responsive="true"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script></script>
@endsection
