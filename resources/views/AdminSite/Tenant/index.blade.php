@extends('layouts.master')

@section('content')
<div class="content">
    <div class="card" id="ticketsTable" data-list='{"valueNames":["client","subject","status","priority","agent"],"page":7,"pagination":true,"fallback":"tickets-card-fallback"}'>
        <div class="card-header border-bottom border-200 px-0">
            <div class="d-lg-flex justify-content-between">
                <div class="row flex-between-center gy-2 px-x1 text-light">
                    <div class="col-auto pe-0">
                        <h6 class="mb-0 text-light">All Tenants</h6>
                    </div>
                    <div class="col-auto">
                        <form>
                            <div class="input-group input-search-width"><input class="form-control form-control-sm shadow-none search" type="search" placeholder="Search by name" aria-label="search" />
                            </div>
                        </form>
                    </div>
                </div>
                <div class="border-bottom border-200 my-3"></div>
                <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
                    <button class="btn btn-sm btn-falcon-default d-xl-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#ticketOffcanvas" aria-controls="ticketOffcanvas">
                        <span class="fas fa-filter" data-fa-transform="shrink-4 down-1"></span><span class="ms-1 d-none d-sm-inline-block">Filter</span>
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
                        <a class="btn btn-falcon-default text-600 btn-sm" href="{{ route('tenants.create') }}">Create Tenant</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="form-check d-none">
                <input class="form-check-input" id="checkbox-bulk-card-tickets-select" type="checkbox" data-bulk-select='{"body":"card-ticket-body","actions":"table-ticket-actions","replacedElement":"table-ticket-replace-element"}' />
            </div>
            <div class="row">
                @foreach ($tenants as $tenant)
                <div class="col-sm-6 col-lg-4 mb-4 mt-4">
                    <div class="card border h-100 border-success">
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center">
                                <div class="avatar avatar-xl avatar-3xl">
                                    <img src="{{ $tenant->profile_picture ? url($tenant->profile_picture) : '/assets/img/team/3-thumb.png' }}" class="avatar-image" />
                                </div>
                                <div class="ms-1 ms-sm-3">
                                    <p class="fw-semi-bold mb-3 mb-sm-2 mt-3">
                                        <a class="text-primary">
                                            Tenant
                                        </a>
                                    </p>
                                    <p class="client fw-semi-bold mb-3 mb-sm-2">
                                        <a class="client text-black" href="{{ route('tenants.show', $tenant->id_tenant) }}">
                                            {{ $tenant->nama_tenant }}
                                        </a>
                                    </p>
                                    <hr>
                                    <a href="{{ route('getTenantUnit', $tenant->id_tenant) }}" class="btn btn-primary btn-sm">Tenant Unit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>


            <div class="text-center d-none" id="tickets-card-fallback">
                <p class="fw-bold fs-1 mt-3">Data Tidak Ditemukan</p>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-center">
                <button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous" data-list-pagination="prev">
                    <span class="fas fa-chevron-left"></span>
                </button>
                <ul class="pagination mb-0"></ul>
                <button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next">
                    <span class="fas fa-chevron-right"></span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection