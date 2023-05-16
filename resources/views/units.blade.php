@extends('layouts.master')

@section('content')
    <div class="content">

        <div class="row gx-3">
            <div class="col-xxl-10 col-xl-9">
                <div class="card" id="ticketsTable"
                    data-list='{"valueNames":["client","subject","status","priority","agent"],"page":7,"pagination":true,"fallback":"tickets-card-fallback"}'>
                    <div class="card-header border-bottom border-200 px-0">
                        <div class="d-lg-flex justify-content-between">
                            <div class="row flex-between-center gy-2 px-x1">
                                <div class="col-auto pe-0">
                                    <h6 class="mb-0">All tickets</h6>
                                </div>
                                <div class="col-auto">
                                    <form>
                                        <div class="input-group input-search-width">
                                            <input class="form-control form-control-sm shadow-none search"
                                                type="search" placeholder="Search  by name"
                                                aria-label="search" /><button
                                                class="btn btn-sm btn-outline-secondary border-300 hover-border-secondary">
                                                <span class="fa fa-search fs--1"></span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="border-bottom border-200 my-3"></div>
                            <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
                                <button class="btn btn-sm btn-falcon-default d-xl-none" type="button"
                                    data-bs-toggle="offcanvas" data-bs-target="#ticketOffcanvas"
                                    aria-controls="ticketOffcanvas">
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

                                    <div class="dropdown font-sans-serif ms-2">
                                        <button
                                            class="btn btn-falcon-default text-600 btn-sm dropdown-toggle dropdown-caret-none"
                                            type="button" id="preview-dropdown" data-bs-toggle="dropdown"
                                            data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                                            Tower
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end border py-2"
                                            aria-labelledby="preview-dropdown">
                                            <a class="dropdown-item" href="#!">Tambah Tower</a>
                                            <a class="dropdown-item"
                                                href="#!">List Tower</a>
                                        </div>
                                    </div>

                                    <div class="dropdown font-sans-serif ms-2">
                                        <button
                                            class="btn btn-falcon-default text-600 btn-sm dropdown-toggle dropdown-caret-none"
                                            type="button" id="preview-dropdown" data-bs-toggle="dropdown"
                                            data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                                            Lantai
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end border py-2"
                                            aria-labelledby="preview-dropdown">
                                            <a class="dropdown-item" href="#!">View</a><a class="dropdown-item"
                                                href="#!">Export</a>
                                        </div>
                                    </div>
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
                                <div class="col-4">
                                    <div
                                        class="bg-white dark__bg-1100 d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                                        <div class="d-flex align-items-start align-items-sm-center">
                                            <a class="d-none d-sm-block" href="../../app/support-desk/contact-details.html">
                                                <div class="avatar avatar-xl avatar-3xl">
                                                    <div class="avatar-name rounded-circle">
                                                        <span>PG</span>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="ms-1 ms-sm-3">
                                                <p class="fw-semi-bold mb-3 mb-sm-2">
                                                    <a href="../../app/support-desk/tickets-preview.html">I need your help
                                                        #2256</a>
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
                                                    <div class="col-auto lh-1 me-3">
                                                        <small class="badge rounded badge-soft-info false">Responded</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div
                                        class="bg-white dark__bg-1100 d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                                        <div class="d-flex align-items-start align-items-sm-center">
                                            <a class="d-none d-sm-block" href="../../app/support-desk/contact-details.html">
                                                <div class="avatar avatar-xl avatar-3xl">
                                                    <div class="avatar-name rounded-circle">
                                                        <span>PG</span>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="ms-1 ms-sm-3">
                                                <p class="fw-semi-bold mb-3 mb-sm-2">
                                                    <a href="../../app/support-desk/tickets-preview.html">I need your help
                                                        #2256</a>
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
                                                    <div class="col-auto lh-1 me-3">
                                                        <small class="badge rounded badge-soft-info false">Responded</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div
                                        class="bg-white dark__bg-1100 d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                                        <div class="d-flex align-items-start align-items-sm-center">
                                            <a class="d-none d-sm-block" href="../../app/support-desk/contact-details.html">
                                                <div class="avatar avatar-xl avatar-3xl">
                                                    <div class="avatar-name rounded-circle">
                                                        <span>PG</span>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="ms-1 ms-sm-3">
                                                <p class="fw-semi-bold mb-3 mb-sm-2">
                                                    <a href="../../app/support-desk/tickets-preview.html">I need your help
                                                        #2256</a>
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
                                                    <div class="col-auto lh-1 me-3">
                                                        <small class="badge rounded badge-soft-info false">Responded</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <div
                                        class="bg-white dark__bg-1100 d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                                        <div class="d-flex align-items-start align-items-sm-center">
                                            <a class="d-none d-sm-block" href="../../app/support-desk/contact-details.html">
                                                <div class="avatar avatar-xl avatar-3xl">
                                                    <div class="avatar-name rounded-circle">
                                                        <span>PG</span>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="ms-1 ms-sm-3">
                                                <p class="fw-semi-bold mb-3 mb-sm-2">
                                                    <a href="../../app/support-desk/tickets-preview.html">I need your help
                                                        #2256</a>
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
                                                    <div class="col-auto lh-1 me-3">
                                                        <small class="badge rounded badge-soft-info false">Responded</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div
                                        class="bg-white dark__bg-1100 d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                                        <div class="d-flex align-items-start align-items-sm-center">
                                            <a class="d-none d-sm-block" href="../../app/support-desk/contact-details.html">
                                                <div class="avatar avatar-xl avatar-3xl">
                                                    <div class="avatar-name rounded-circle">
                                                        <span>PG</span>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="ms-1 ms-sm-3">
                                                <p class="fw-semi-bold mb-3 mb-sm-2">
                                                    <a href="../../app/support-desk/tickets-preview.html">I need your help
                                                        #2256</a>
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
                                                    <div class="col-auto lh-1 me-3">
                                                        <small class="badge rounded badge-soft-info false">Responded</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div
                                        class="bg-white dark__bg-1100 d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                                        <div class="d-flex align-items-start align-items-sm-center">
                                            <a class="d-none d-sm-block" href="../../app/support-desk/contact-details.html">
                                                <div class="avatar avatar-xl avatar-3xl">
                                                    <div class="avatar-name rounded-circle">
                                                        <span>PG</span>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="ms-1 ms-sm-3">
                                                <p class="fw-semi-bold mb-3 mb-sm-2">
                                                    <a href="../../app/support-desk/tickets-preview.html">I need your help
                                                        #2256</a>
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
                                                    <div class="col-auto lh-1 me-3">
                                                        <small class="badge rounded badge-soft-info false">Responded</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <div
                                        class="bg-white dark__bg-1100 d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                                        <div class="d-flex align-items-start align-items-sm-center">
                                            <a class="d-none d-sm-block" href="../../app/support-desk/contact-details.html">
                                                <div class="avatar avatar-xl avatar-3xl">
                                                    <div class="avatar-name rounded-circle">
                                                        <span>PG</span>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="ms-1 ms-sm-3">
                                                <p class="fw-semi-bold mb-3 mb-sm-2">
                                                    <a href="../../app/support-desk/tickets-preview.html">I need your help
                                                        #2256</a>
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
                                                    <div class="col-auto lh-1 me-3">
                                                        <small class="badge rounded badge-soft-info false">Responded</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div
                                        class="bg-white dark__bg-1100 d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                                        <div class="d-flex align-items-start align-items-sm-center">
                                            <a class="d-none d-sm-block" href="../../app/support-desk/contact-details.html">
                                                <div class="avatar avatar-xl avatar-3xl">
                                                    <div class="avatar-name rounded-circle">
                                                        <span>PG</span>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="ms-1 ms-sm-3">
                                                <p class="fw-semi-bold mb-3 mb-sm-2">
                                                    <a href="../../app/support-desk/tickets-preview.html">I need your help
                                                        #2256</a>
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
                                                    <div class="col-auto lh-1 me-3">
                                                        <small class="badge rounded badge-soft-info false">Responded</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div
                                        class="bg-white dark__bg-1100 d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                                        <div class="d-flex align-items-start align-items-sm-center">
                                            <a class="d-none d-sm-block" href="../../app/support-desk/contact-details.html">
                                                <div class="avatar avatar-xl avatar-3xl">
                                                    <div class="avatar-name rounded-circle">
                                                        <span>PG</span>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="ms-1 ms-sm-3">
                                                <p class="fw-semi-bold mb-3 mb-sm-2">
                                                    <a href="../../app/support-desk/tickets-preview.html">I need your help
                                                        #2256</a>
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
                                                    <div class="col-auto lh-1 me-3">
                                                        <small class="badge rounded badge-soft-info false">Responded</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
            <div class="col-xxl-2 col-xl-3">
                <div class="offcanvas offcanvas-end offcanvas-filter-sidebar border-0 dark__bg-card-dark h-auto rounded-xl-3"
                    tabindex="-1" id="ticketOffcanvas" aria-labelledby="ticketOffcanvasLabelCard">
                    <div class="offcanvas-header d-flex flex-between-center d-xl-none bg-light">
                        <h6 class="fs-0 mb-0 fw-semi-bold">Filter</h6>
                        <button class="btn-close text-reset d-xl-none shadow-none" id="ticketOffcanvasLabelCard"
                            type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="card scrollbar shadow-none shadow-show-xl">
                        <div class="card-header bg-light d-none d-xl-block">
                            <h6 class="mb-0">Filter</h6>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="mb-3 mt-n2">
                                    <label class="mb-1">Tower</label><select class="form-select form-select-sm">
                                        <option>None</option>
                                        <option>Urgent</option>
                                        <option>High</option>
                                        <option>Medium</option>
                                        <option>Low</option>
                                    </select>
                                </div>
                                <div class="mb-3 mt-n2">
                                    <label class="mb-1">Lantai</label><select class="form-select form-select-sm">
                                        <option>None</option>
                                        <option>Urgent</option>
                                        <option>High</option>
                                        <option>Medium</option>
                                        <option>Low</option>
                                    </select>
                                </div>


                            </form>
                        </div>
                        <div class="card-footer border-top border-200 py-x1">
                            <button class="btn btn-primary w-100">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="row g-0 justify-content-between fs--1 mt-4 mb-3">
                <div class="col-12 col-sm-auto text-center">
                    <p class="mb-0 text-600">
                        Thank you for creating with Falcon
                        <span class="d-none d-sm-inline-block">| </span><br class="d-sm-none" />
                        2022 &copy; <a href="https://themewagon.com">Themewagon</a>
                    </p>
                </div>
                <div class="col-12 col-sm-auto text-center">
                    <p class="mb-0 text-600">v3.14.0</p>
                </div>
            </div>
        </footer>
    </div>
    <div class="modal fade" id="authentication-modal" tabindex="-1" role="dialog"
        aria-labelledby="authentication-modal-label" aria-hidden="true">
        <div class="modal-dialog mt-6" role="document">
            <div class="modal-content border-0">
                <div class="modal-header px-5 position-relative modal-shape-header bg-shape">
                    <div class="position-relative z-index-1 light">
                        <h4 class="mb-0 text-white" id="authentication-modal-label">
                            Register
                        </h4>
                        <p class="fs--1 mb-0 text-white">
                            Please create your free Falcon account
                        </p>
                    </div>
                    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4 px-5">
                    <form>
                        <div class="mb-3">
                            <label class="form-label" for="modal-auth-name">Name</label><input class="form-control"
                                type="text" autocomplete="on" id="modal-auth-name" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="modal-auth-email">Email address</label><input
                                class="form-control" type="email" autocomplete="on" id="modal-auth-email" />
                        </div>
                        <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                                <label class="form-label" for="modal-auth-password">Password</label><input
                                    class="form-control" type="password" autocomplete="on"
                                    id="modal-auth-password" />
                            </div>
                            <div class="mb-3 col-sm-6">
                                <label class="form-label" for="modal-auth-confirm-password">Confirm
                                    Password</label><input class="form-control" type="password" autocomplete="on"
                                    id="modal-auth-confirm-password" />
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="modal-auth-register-checkbox" /><label
                                class="form-label" for="modal-auth-register-checkbox">I accept the <a
                                    href="#!">terms </a>and
                                <a href="#!">privacy policy</a></label>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">
                                Register
                            </button>
                        </div>
                    </form>
                    <div class="position-relative mt-5">
                        <hr />
                        <div class="divider-content-center">or register with</div>
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col-sm-6">
                            <a class="btn btn-outline-google-plus btn-sm d-block w-100" href="#"><span
                                    class="fab fa-google-plus-g me-2" data-fa-transform="grow-8"></span>
                                google</a>
                        </div>
                        <div class="col-sm-6">
                            <a class="btn btn-outline-facebook btn-sm d-block w-100" href="#"><span
                                    class="fab fa-facebook-square me-2" data-fa-transform="grow-8"></span>
                                facebook</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
