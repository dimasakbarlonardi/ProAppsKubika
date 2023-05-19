@extends('layouts.master')

@section('content')
    <div class="content">
        <div class="card" id="ticketsTable"
            data-list='{"valueNames":["client","subject","status","priority","agent"],"page":7,"pagination":true,"fallback":"tickets-card-fallback"}'>
            <div class="card-header border-bottom border-200 px-0">
                <div class="d-lg-flex justify-content-between">
                    <div class="row flex-between-center gy-2 px-x1 text-light">
                        <div class="col-auto pe-0">
                            <h6 class="mb-0 text-light">All Tenants</h6>
                        </div>
                        <div class="col-auto pe-0">
                            <span class="nav-link-icon">
                                <span class="fas fa-users"></span>
                            </span>
                        </div>
                    </div>
                    <div class="border-bottom border-200 my-3"></div>
                    <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
                        <button class="btn btn-sm btn-falcon-default d-xl-none" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#ticketOffcanvas" aria-controls="ticketOffcanvas">
                            <span class="fas fa-filter" data-fa-transform="shrink-4 down-1"></span><span
                                class="ms-1 d-none d-sm-inline-block">Filter</span>
                        </button>
                        <div class="bg-300 mx-3 d-none d-lg-block d-xl-none" style="width: 1px; height: 29px">
                        </div>
                        <div class="d-none" id="table-ticket-actions">
                            <div class="d-flex">
                                <select class="form-select form-select-sm" aria-label="Bulk actions">
                                    <option selected="">Bulk actions</option>
                                    <option value="Refund">Refund</option>
                                    <option value="Delete">Delete</option>
                                    <option value="Archive">Archive</option>
                                </select><button class="btn btn-falcon-default btn-sm ms-2" type="button">
                                    Apply
                                </button>
                            </div>
                        </div>
                        <div class="d-flex align-items-center" id="table-ticket-replace-element">
                            <a class="btn btn-falcon-default text-600 btn-sm" href="{{ route('tenants.create') }}">Tambah Tenant</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="form-check d-none">
                    <input class="form-check-input" id="checkbox-bulk-card-tickets-select" type="checkbox"
                        data-bulk-select='{"body":"card-ticket-body","actions":"table-ticket-actions","replacedElement":"table-ticket-replace-element"}' />
                </div>
                <div class="list bg-light p-x1 d-flex flex-column gap-3" id="card-ticket-body">

                    <div class="row">
                        @foreach ($tenants as $tenant)
                            <div class="col-3">
                                <div
                                    class="bg-white dark__bg-1100 d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                                    <div class="d-flex align-items-start align-items-sm-center">
                                        <a class="d-none d-sm-block" href="../../app/support-desk/contact-details.html">
                                            {{-- {{ dd($tenant->profile_picture) }} --}}
                                            <div class="avatar avatar-xl avatar-3xl">
                                                <img src="/{{ $tenant->profile_picture }}" alt="akmal"
                                                    class="avatar-image" />
                                            </div>
                                        </a>
                                        <div class="ms-1 ms-sm-3">
                                            <p class="fw-semi-bold mb-3 mb-sm-2">
                                                <a class="text-primary" href="{{ route('tenants.show', $tenant->id_tenant) }}">
                                                    {{ $tenant->nama_tenant }}
                                                </a>
                                            </p>
                                            <div class="row align-items-center gx-0 gy-2">
                                                <div class="col-auto me-2">
                                                    <h6 class="client mb-0">
                                                        <a class="text-800 d-flex align-items-center gap-1"
                                                            href="../../app/support-desk/contact-details.html"><span
                                                                class="fas fa-user"
                                                                data-fa-transform="shrink-3 up-1"></span><span>Peter
                                                                Gill</span></a>
                                                    </h6>
                                                </div>

                                            </div>
                                            <hr>
                                            <a href="{{ route('getTenantUnit', $tenant->id_tenant) }}"
                                                class="btn btn-primary btn-sm">Tenant Unit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="text-center d-none" id="tickets-card-fallback">
                    <p class="fw-bold fs-1 mt-3">No ticket found</p>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-center">
                    <button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous"
                        data-list-pagination="prev">
                        <span class="fas fa-chevron-left"></span>
                    </button>
                    <ul class="pagination mb-0"></ul>
                    <button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next"
                        data-list-pagination="next">
                        <span class="fas fa-chevron-right"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
