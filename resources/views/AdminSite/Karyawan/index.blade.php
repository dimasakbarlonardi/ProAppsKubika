@extends('layouts.master')

@section('content')
    <div class="content">
        <div class="card" id="ticketsTable"
            data-list='{"valueNames":["client","subject","status","priority","agent"],"page":7,"pagination":true,"fallback":"tickets-card-fallback"}'>
            <div class="card-header border-bottom border-200 px-0">
                <div class="d-lg-flex justify-content-between">
                    <div class="row flex-between-center gy-2 px-x1 text-light">
                        <div class="col-auto pe-0">
                            <h6 class="mb-0 text-light">All Karyawan</h6>
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
                            <a class="btn btn-falcon-default text-600 btn-sm" href="{{ route('karyawans.create') }}">Tambah Karyawan</a>
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
                        @foreach ($karyawans as $karyawan)
                            <div class="col-3">
                                <div
                                    class="bg-white dark__bg-1100 d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                                    <div class="d-flex align-items-start align-items-sm-center">
                                        <a class="d-none d-sm-block" href="">
                                            <div class="avatar avatar-xl avatar-3xl">
                                                <img src="{{ $karyawan->profile_picture ? '/' . $karyawan->profile_picture : '/assets/img/team/3-thumb.png' }}" alt="{{ $karyawan->profile_picture }}"
                                                    class="avatar-image" />
                                            </div>
                                        </a>
                                        <div class="ms-2 ms-sm-4">
                                            <p class="fw-semi-bold mb-3 mb-sm-2">
                                                <a class="text-primary" >
                                                    Karyawan
                                                </a>
                                            </p>
                                            <p class="fw-semi-bold mb-3 ">
                                                <a class="text-black" href="{{ route('karyawans.show', $karyawan->id_karyawan) }}">
                                                    {{ $karyawan->nama_karyawan }}
                                                </a>
                                            </p>
                                            <div class="row">
                                            <hr>
                                                <button class="btn btn-outline-success text-success mb-2" type="button"><a class="text-success" href="{{ route('karyawans.show', $karyawan->id_karyawan) }}"> Detail</a></button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

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


