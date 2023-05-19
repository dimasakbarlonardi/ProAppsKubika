@extends('layouts.master')

@section('content')
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
        <div class="col-lg-8 pe-lg-2 mb-3">
            <div class="card h-lg-100 overflow-hidden">
                <div class="card-header bg-light">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-0">Running Projects</h6>
                        </div>
                        <div class="col-auto text-center pe-x1"><select class="form-select form-select-sm">
                                <option>Working Time</option>
                                <option>Estimated Time</option>
                                <option>Billable Time</option>
                            </select></div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="row g-0 align-items-center py-2 position-relative border-bottom border-200">
                        <div class="col ps-x1 py-1 position-static">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xl me-3">
                                    <div class="avatar-name rounded-circle bg-primary-subtle text-dark">
                                        <span class="fs-0 text-primary">F</span>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-0 d-flex align-items-center"><a class="text-800 stretched-link"
                                            href="#!">Falcon</a><span
                                            class="badge rounded-pill ms-2 bg-200 text-primary">38%</span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col py-1">
                            <div class="row flex-end-center g-0">
                                <div class="col-auto pe-2">
                                    <div class="fs--1 fw-semi-bold">12:50:00</div>
                                </div>
                                <div class="col-5 pe-x1 ps-2">
                                    <div class="progress bg-200 me-2" style="height: 5px;" role="progressbar"
                                        aria-valuenow="38" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar rounded-pill" style="width: 38%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-0 align-items-center py-2 position-relative border-bottom border-200">
                        <div class="col ps-x1 py-1 position-static">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xl me-3">
                                    <div class="avatar-name rounded-circle bg-success-subtle text-dark">
                                        <span class="fs-0 text-success">R</span>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-0 d-flex align-items-center"><a class="text-800 stretched-link"
                                            href="#!">Reign</a><span
                                            class="badge rounded-pill ms-2 bg-200 text-primary">79%</span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col py-1">
                            <div class="row flex-end-center g-0">
                                <div class="col-auto pe-2">
                                    <div class="fs--1 fw-semi-bold">25:20:00</div>
                                </div>
                                <div class="col-5 pe-x1 ps-2">
                                    <div class="progress bg-200 me-2" style="height: 5px;" role="progressbar"
                                        aria-valuenow="79" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar rounded-pill" style="width: 79%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-0 align-items-center py-2 position-relative border-bottom border-200">
                        <div class="col ps-x1 py-1 position-static">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xl me-3">
                                    <div class="avatar-name rounded-circle bg-info-subtle text-dark"><span
                                            class="fs-0 text-info">B</span></div>
                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-0 d-flex align-items-center"><a class="text-800 stretched-link"
                                            href="#!">Boots4</a><span
                                            class="badge rounded-pill ms-2 bg-200 text-primary">90%</span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col py-1">
                            <div class="row flex-end-center g-0">
                                <div class="col-auto pe-2">
                                    <div class="fs--1 fw-semi-bold">58:20:00</div>
                                </div>
                                <div class="col-5 pe-x1 ps-2">
                                    <div class="progress bg-200 me-2" style="height: 5px;" role="progressbar"
                                        aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar rounded-pill" style="width: 90%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-0 align-items-center py-2 position-relative border-bottom border-200">
                        <div class="col ps-x1 py-1 position-static">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xl me-3">
                                    <div class="avatar-name rounded-circle bg-warning-subtle text-dark">
                                        <span class="fs-0 text-warning">R</span>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-0 d-flex align-items-center"><a class="text-800 stretched-link"
                                            href="#!">Raven</a><span
                                            class="badge rounded-pill ms-2 bg-200 text-primary">40%</span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col py-1">
                            <div class="row flex-end-center g-0">
                                <div class="col-auto pe-2">
                                    <div class="fs--1 fw-semi-bold">21:20:00</div>
                                </div>
                                <div class="col-5 pe-x1 ps-2">
                                    <div class="progress bg-200 me-2" style="height: 5px;" role="progressbar"
                                        aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar rounded-pill" style="width: 40%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-0 align-items-center py-2 position-relative">
                        <div class="col ps-x1 py-1 position-static">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xl me-3">
                                    <div class="avatar-name rounded-circle bg-danger-subtle text-dark">
                                        <span class="fs-0 text-danger">S</span>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-0 d-flex align-items-center"><a class="text-800 stretched-link"
                                            href="#!">Slick</a><span
                                            class="badge rounded-pill ms-2 bg-200 text-primary">70%</span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col py-1">
                            <div class="row flex-end-center g-0">
                                <div class="col-auto pe-2">
                                    <div class="fs--1 fw-semi-bold">31:20:00</div>
                                </div>
                                <div class="col-5 pe-x1 ps-2">
                                    <div class="progress bg-200 me-2" style="height: 5px;" role="progressbar"
                                        aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar rounded-pill" style="width: 70%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light p-0"><a class="btn btn-sm btn-link d-block w-100 py-2"
                        href="#!">Show all projects<span class="fas fa-chevron-right ms-1 fs--2"></span></a></div>
            </div>
        </div>
        <div class="col-lg-5 col-xl-4 ps-lg-2 mb-3">
            <div class="card">
                <div class="card-header d-flex flex-between-center bg-light py-2">
                    <h6 class="mb-0">Shared Files</h6>
                    {{-- <a class="py-1 fs--1 font-sans-serif" href="#!">View All</a> --}}
                    <a class="btn btn-link btn-sm me-2" href="#!">View Details</a>
                </div>
                <div class="card-body pb-0">
                    <div class="d-flex mb-3 hover-actions-trigger align-items-center">
                        <div class="file-thumbnail"><img class="border h-100 w-100 object-fit-cover rounded-2"
                                src="/assets/img/products/5-thumb.png" alt="" /></div>
                        <div class="ms-3 flex-shrink-1 flex-grow-1">
                            <h6 class="mb-1"><a class="stretched-link text-900 fw-semi-bold"
                                    href="#!">apple-smart-watch.png</a></h6>
                            <div class="fs--1"><span class="fw-semi-bold">Antony</span><span
                                    class="fw-medium text-600 ms-2">Just Now</span></div>
                        </div>
                    </div>
                    <hr class="text-200" />
                    <div class="d-flex mb-3 hover-actions-trigger align-items-center">
                        <div class="file-thumbnail"><img class="border h-100 w-100 object-fit-cover rounded-2"
                                src="/assets/img/products/3-thumb.png" alt="" /></div>
                        <div class="ms-3 flex-shrink-1 flex-grow-1">
                            <h6 class="mb-1"><a class="stretched-link text-900 fw-semi-bold"
                                    href="#!">iphone.jpg</a></h6>
                            <div class="fs--1"><span class="fw-semi-bold">Antony</span><span
                                    class="fw-medium text-600 ms-2">Yesterday at 1:30 PM</span></div>
                        </div>
                    </div>

                    <hr class="text-200" />
                    <div class="d-flex mb-3 hover-actions-trigger align-items-center">
                        <div class="file-thumbnail"><img class="border h-100 w-100 object-fit-cover rounded-2"
                                src="/assets/img/products/2-thumb.png" alt="" /></div>
                        <div class="ms-3 flex-shrink-1 flex-grow-1">
                            <h6 class="mb-1"><a class="stretched-link text-900 fw-semi-bold"
                                    href="#!">iMac.jpg</a></h6>
                            <div class="fs--1"><span class="fw-semi-bold">Rowen</span><span
                                    class="fw-medium text-600 ms-2">23 Sep at 6:10 PM</span></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row g-0">
        <div class="col-xxl-6 px-xxl-2">
            <div class="card h-100">
                <div class="card-header bg-light py-2">
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
