@extends('layouts.master')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}">
@endsection


@section('content')
<div class="row g-0 my-4">
<div class="container">
    <div class="card mb-3 p-3">
        <div class="card-body px-xxl-0 pt-4">
            <div class="frame-537">
                <div class="frame-193">
                    <div class="request-volume-performance">Building Information</div>
                    <svg class="icon" width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_563_37579)">
                            <path d="M12 0.875C5.58014 0.875 0.375 6.08202 0.375 12.5C0.375 18.9217 5.58014 24.125 12 24.125C18.4199 24.125 23.625 18.9217 23.625 12.5C23.625 6.08202 18.4199 0.875 12 0.875ZM12 6.03125C13.0873 6.03125 13.9688 6.91269 13.9688 8C13.9688 9.08731 13.0873 9.96875 12 9.96875C10.9127 9.96875 10.0312 9.08731 10.0312 8C10.0312 6.91269 10.9127 6.03125 12 6.03125ZM14.625 17.9375C14.625 18.2481 14.3731 18.5 14.0625 18.5H9.9375C9.62686 18.5 9.375 18.2481 9.375 17.9375V16.8125C9.375 16.5019 9.62686 16.25 9.9375 16.25H10.5V13.25H9.9375C9.62686 13.25 9.375 12.9981 9.375 12.6875V11.5625C9.375 11.2519 9.62686 11 9.9375 11H12.9375C13.2481 11 13.5 11.2519 13.5 11.5625V16.25H14.0625C14.3731 16.25 14.625 16.5019 14.625 16.8125V17.9375Z" fill="#3F4045" />
                        </g>
                        <defs>
                            <clipPath id="clip0_542_36712">
                                <rect width="24" height="24" fill="white" transform="translate(0 0.5)" />
                            </clipPath>
                        </defs>
                    </svg>
                </div>
                <div class="col-md-auto p-3">
                    <form class="row align-items-center g-3">
                        <div class="col-auto">
                            <h6 class="text-700 mb-0">Showing Data For: </h6>
                        </div>
                        <div class="col-md-auto position-relative"><input class="form-control form-control-sm datetimepicker ps-4" id="CRMDateRange" type="text" placeholder="Choose Date"> <span class="fas fa-calendar-alt text-primary position-absolute top-50 translate-middle-y ms-2"> </span></div>
                    </form>
                </div>
            </div>
            <div class="row g-0">
                <div class="col-xxl-3 col-md-6 px-3 text-center border-end-md border-bottom border-bottom-xxl-0 pb-3 p-xxl-0 ps-md-0">
                    <div class="card-body">
                        <div class="col d-lg-block flex-between-center text-start">
                            <h6 class="mb-2 text-900">Tenant</h6>
                            <h4 class="fs-3 fw-normal text-700 mb-0">
                                <span class="text-primary">{{ $tenant }}</span>
                                <div class="icon-background float-end"> <i class=" icon-background float-end fas fa-calendar-alt float-end"></i></div>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6 px-3 text-center border-end-xxl border-bottom border-bottom-xxl-0 pb-3 pt-4 pt-md-0 pe-md-0 p-xxl-0">
                    <div class="card-body">
                        <div class="col d-lg-block flex-between-center text-start">
                            <h6 class="mb-2 text-900">Unit</h6>
                            <h4 class="fs-3 fw-normal text-700 mb-0">
                                <span>{{ $unit }}</span>
                                <div class="icon-background-2 float-end"> <i class="fas fa-home float-end"></i></div>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6 px-3 text-center border-end-md border-bottom border-bottom-md-0 pb-3 pt-4 p-xxl-0 pb-md-0 ps-md-0">
                    <div class="card-body">
                        <div class="col d-lg-block flex-between-center text-start">
                            <h6 class="mb-2 text-900">Employee</h6>
                            <h4 class="fs-3 fw-normal text-700 mb-0">
                                <span>{{ $karyawan }}</span>
                                <div class="icon-background-2 float-end"> <i class="fas fa-user float-end"></i></div>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6 px-3 text-center pt-4 p-xxl-0 pb-0 pe-md-0">
                    <div class="card-body">
                        <div class="col d-lg-block flex-between-center text-start">
                            <h6 class="mb-2 text-900">Tower</h6>
                            <h4 class="fs-3 fw-normal text-700 mb-0">
                                <span class="text-primary">{{ $tower }}</span>
                                <div class="icon-background float-end"> <i class="fas fa-building float-end"></i></div>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3 p-3">
        <div class="frame-537">
            <div class="frame-193">
                <div class="request-volume-performance">Request Quality Performance</div>
                <svg class="icon" width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_485_36291)">
                        <path d="M0 12.5C0 9.3174 1.26428 6.26516 3.51472 4.01472C5.76516 1.76428 8.8174 0.5 12 0.5C15.1826 0.5 18.2348 1.76428 20.4853 4.01472C22.7357 6.26516 24 9.3174 24 12.5C24 15.6826 22.7357 18.7348 20.4853 20.9853C18.2348 23.2357 15.1826 24.5 12 24.5C8.8174 24.5 5.76516 23.2357 3.51472 20.9853C1.26428 18.7348 0 15.6826 0 12.5ZM13.5 5C13.5 4.60218 13.342 4.22064 13.0607 3.93934C12.7794 3.65804 12.3978 3.5 12 3.5C11.6022 3.5 11.2206 3.65804 10.9393 3.93934C10.658 4.22064 10.5 4.60218 10.5 5C10.5 5.39782 10.658 5.77936 10.9393 6.06066C11.2206 6.34196 11.6022 6.5 12 6.5C12.3978 6.5 12.7794 6.34196 13.0607 6.06066C13.342 5.77936 13.5 5.39782 13.5 5ZM12 20C13.6547 20 15 18.6547 15 17C15 16.1844 14.6766 15.4484 14.1516 14.9094L17.1562 8.07969C17.4047 7.5125 17.1469 6.84688 16.5797 6.59844C16.0125 6.35 15.3469 6.60781 15.0984 7.175L12.0891 14C12.0609 14 12.0281 14 12 14C10.3453 14 9 15.3453 9 17C9 18.6547 10.3453 20 12 20ZM8.25 7.25C8.25 6.85218 8.09196 6.47064 7.81066 6.18934C7.52936 5.90804 7.14782 5.75 6.75 5.75C6.35218 5.75 5.97064 5.90804 5.68934 6.18934C5.40804 6.47064 5.25 6.85218 5.25 7.25C5.25 7.64782 5.40804 8.02936 5.68934 8.31066C5.97064 8.59196 6.35218 8.75 6.75 8.75C7.14782 8.75 7.52936 8.59196 7.81066 8.31066C8.09196 8.02936 8.25 7.64782 8.25 7.25ZM4.5 14C4.89782 14 5.27936 13.842 5.56066 13.5607C5.84196 13.2794 6 12.8978 6 12.5C6 12.1022 5.84196 11.7206 5.56066 11.4393C5.27936 11.158 4.89782 11 4.5 11C4.10218 11 3.72064 11.158 3.43934 11.4393C3.15804 11.7206 3 12.1022 3 12.5C3 12.8978 3.15804 13.2794 3.43934 13.5607C3.72064 13.842 4.10218 14 4.5 14ZM21 12.5C21 12.1022 20.842 11.7206 20.5607 11.4393C20.2794 11.158 19.8978 11 19.5 11C19.1022 11 18.7206 11.158 18.4393 11.4393C18.158 11.7206 18 12.1022 18 12.5C18 12.8978 18.158 13.2794 18.4393 13.5607C18.7206 13.842 19.1022 14 19.5 14C19.8978 14 20.2794 13.842 20.5607 13.5607C20.842 13.2794 21 12.8978 21 12.5Z" fill="#3F4045" />
                    </g>
                    <defs>
                        <clipPath id="clip0_542_36712">
                            <rect width="24" height="24" fill="white" transform="translate(0 0.5)" />
                        </clipPath>
                    </defs>
                </svg>
            </div>
            <div class="col-md-auto p-3">
                <form class="row align-items-center g-3">
                    <div class="col-auto">
                        <h6 class="text-primary mb-0">Showing Data For :</h6>
                    </div>
                    <div class="col-md-auto position-relative"><input class="form-control form-control-sm datetimepicker ps-4" id="CRMDateRange" type="text" placeholder="Choose date" /><span class="fas fa-calendar-alt text-primary position-absolute top-50 translate-middle-y ms-2"> </span></div>
                </form>
            </div>
        </div>
        <div class="row" data-bs-theme="light">
            <div class="col-3 col-lg-3 mb-4">
                <div class="card text-white ">
                    <div class="card-body" style="background-color: #E9F7F5;">
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
                                <img height="45" src="{{ asset('assets/img/icons/ticket_complete.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 col-lg-3 mb-4">
                <div class="card text-white ">
                    <div class="card-body" style="background-color: #BEE8E1;">
                        <div class="row flex-between-center g-0">
                            <div class="col-6 d-lg-block flex-between-center">
                                <h6 class="mb-2 text-900">Ticket on Progress</h6>
                                <h4 class="fs-3 fw-normal text-700 mb-0">
                                    <span>{{ $progress_ticket }}</span>
                                    <span>/</span>
                                    <span>{{ $entry_ticket }}</span>
                                </h4>
                            </div>
                            <div class="col-auto h-100">
                                <img height="45" src="{{ asset('assets/img/icons/ticket_on_progress.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 col-lg-3 mb-4">
                <div class="card text-white ">
                    <div class="card-body" style="background-color: #E9F7F5;">
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
                                <img height="45" src="{{ asset('assets/img/icons/ticket_hold.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 col-lg-3 mb-4">
                <div class="card text-white ">
                    <div class="card-body" style="background-color: #BEE8E1;">
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
                                <img height="45" src="{{ asset('assets/img/icons/ticket_cancel.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card mb-3">
        <div class="row" data-bs-theme="light">
            <div class="frame-283">
                <div class="frame-537">
                    <div class="frame-193">
                        <div class="request-volume-performance">Request Volume Performance</div>
                        <svg class="icon" width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_542_36712)">
                                <path d="M5.33333 8.5H18.6667V16.5H5.33333V8.5ZM22 12.5C22 13.6046 22.8954 14.5 24 14.5V18.5C24 19.6046 23.1046 20.5 22 20.5H2C0.895417 20.5 0 19.6046 0 18.5V14.5C1.10458 14.5 2 13.6046 2 12.5C2 11.3954 1.10458 10.5 0 10.5V6.5C0 5.39542 0.895417 4.5 2 4.5H22C23.1046 4.5 24 5.39542 24 6.5V10.5C22.8954 10.5 22 11.3954 22 12.5ZM20 8.16667C20 7.61437 19.5523 7.16667 19 7.16667H5C4.44771 7.16667 4 7.61437 4 8.16667V16.8333C4 17.3856 4.44771 17.8333 5 17.8333H19C19.5523 17.8333 20 17.3856 20 16.8333V8.16667Z" fill="#3F4045" />
                            </g>
                            <defs>
                                <clipPath id="clip0_542_36712">
                                    <rect width="24" height="24" fill="white" transform="translate(0 0.5)" />
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <div class="col-md-auto p-3">
                        <form class="row align-items-center g-3">
                            <div class="col-auto">
                                <h6 class="text-primary mb-0">Showing Data For :</h6>
                            </div>
                            <div class="col-md-auto position-relative"><input class="form-control form-control-sm datetimepicker ps-4" id="CRMDateRange" type="text" placeholder="Choose date" /><span class="fas fa-calendar-alt text-primary position-absolute top-50 translate-middle-y ms-2"> </span></div>
                        </form>
                    </div>
                </div>
                <div class="frame-536">
                    <div class="frame-281">
                        <div class="frame-278">
                            <div class="entry-request">Entry Request</div>
                            <div class="_100">{{ $entry_ticket }}</div>
                        </div>
                        <div class="frame-279">
                            <div class="work-request">Work Request</div>
                            <div class="_100">{{ $wr }}</div>
                        </div>
                        <div class="frame-280">
                            <div class="work-order">Work Order</div>
                            <div class="_100">{{ $wo }}</div>
                        </div>
                    </div>
                    <div class="frame-282">
                        <div class="frame-2782">
                            <div class="bapp">BAPP</div>
                            <div class="_100">{{ $bapp }}</div>
                        </div>
                        <div class="frame-2792">
                            <div class="good-in-good-out">Good in Good Out</div>
                            <div class="_100">{{ $gigo }}</div>
                        </div>
                        <div class="frame-2802">
                            <div class="reservation">Reservation</div>
                            <div class="_100">100</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="card mb-3">
        <!-- <div class="row" data-bs-theme="light">
            <div class="frame-193">
                <div class="request-volume-performance">Statistik Invoice</div>
                <svg class="icon" width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.6 15.5H17.4C17.7 15.5 18 15.2 18 14.9V8.6C18 8.3 17.7 8 17.4 8H15.6C15.3 8 15 8.3 15 8.6V14.9C15 15.2 15.3 15.5 15.6 15.5ZM20.1 15.5H21.9C22.2 15.5 22.5 15.2 22.5 14.9V4.1C22.5 3.8 22.2 3.5 21.9 3.5H20.1C19.8 3.5 19.5 3.8 19.5 4.1V14.9C19.5 15.2 19.8 15.5 20.1 15.5ZM6.6 15.5H8.4C8.7 15.5 9 15.2 9 14.9V11.6C9 11.3 8.7 11 8.4 11H6.6C6.3 11 6 11.3 6 11.6V14.9C6 15.2 6.3 15.5 6.6 15.5ZM11.1 15.5H12.9C13.2 15.5 13.5 15.2 13.5 14.9V5.6C13.5 5.3 13.2 5 12.9 5H11.1C10.8 5 10.5 5.3 10.5 5.6V14.9C10.5 15.2 10.8 15.5 11.1 15.5ZM23.25 18.5H3V4.25C3 3.83562 2.66438 3.5 2.25 3.5H0.75C0.335625 3.5 0 3.83562 0 4.25V20C0 20.8283 0.671719 21.5 1.5 21.5H23.25C23.6644 21.5 24 21.1644 24 20.75V19.25C24 18.8356 23.6644 18.5 23.25 18.5Z" fill="black" />
                    <defs>
                        <clipPath id="clip0_542_36712">
                            <rect width="24" height="24" fill="white" transform="translate(0 0.5)" />
                        </clipPath>
                    </defs>
                </svg>
            </div>
                <div class="col-md-auto p-3">
                    <form class="row align-items-center g-3">
                        <div class="col-auto">
                            <h6 class="text-primary mb-0">Showing Data For :</h6>
                        </div>
                        <div class="col-md-auto position-relative"><input class="form-control form-control-sm datetimepicker ps-4" id="CRMDateRange" type="text" placeholder="Choose date" /><span class="fas fa-calendar-alt text-primary position-absolute top-50 translate-middle-y ms-2"> </span></div>
                    </form>
                </div>
        </div> -->
        <div class="card-body h-100 pe-0">
            <div class="echart-line-total-sales h-100" data-echart-responsive="true"></div>
        </div>
    </div>


    <!-- <div class="card mb-3 p-3">
        <div class="frame-537">
            <div class="frame-193">
                <div class="request-volume-performance">Invoice In Rupiah</div>
                <svg class="icon" width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_485_36291)">
                        <path d="M0 12.5C0 9.3174 1.26428 6.26516 3.51472 4.01472C5.76516 1.76428 8.8174 0.5 12 0.5C15.1826 0.5 18.2348 1.76428 20.4853 4.01472C22.7357 6.26516 24 9.3174 24 12.5C24 15.6826 22.7357 18.7348 20.4853 20.9853C18.2348 23.2357 15.1826 24.5 12 24.5C8.8174 24.5 5.76516 23.2357 3.51472 20.9853C1.26428 18.7348 0 15.6826 0 12.5ZM13.5 5C13.5 4.60218 13.342 4.22064 13.0607 3.93934C12.7794 3.65804 12.3978 3.5 12 3.5C11.6022 3.5 11.2206 3.65804 10.9393 3.93934C10.658 4.22064 10.5 4.60218 10.5 5C10.5 5.39782 10.658 5.77936 10.9393 6.06066C11.2206 6.34196 11.6022 6.5 12 6.5C12.3978 6.5 12.7794 6.34196 13.0607 6.06066C13.342 5.77936 13.5 5.39782 13.5 5ZM12 20C13.6547 20 15 18.6547 15 17C15 16.1844 14.6766 15.4484 14.1516 14.9094L17.1562 8.07969C17.4047 7.5125 17.1469 6.84688 16.5797 6.59844C16.0125 6.35 15.3469 6.60781 15.0984 7.175L12.0891 14C12.0609 14 12.0281 14 12 14C10.3453 14 9 15.3453 9 17C9 18.6547 10.3453 20 12 20ZM8.25 7.25C8.25 6.85218 8.09196 6.47064 7.81066 6.18934C7.52936 5.90804 7.14782 5.75 6.75 5.75C6.35218 5.75 5.97064 5.90804 5.68934 6.18934C5.40804 6.47064 5.25 6.85218 5.25 7.25C5.25 7.64782 5.40804 8.02936 5.68934 8.31066C5.97064 8.59196 6.35218 8.75 6.75 8.75C7.14782 8.75 7.52936 8.59196 7.81066 8.31066C8.09196 8.02936 8.25 7.64782 8.25 7.25ZM4.5 14C4.89782 14 5.27936 13.842 5.56066 13.5607C5.84196 13.2794 6 12.8978 6 12.5C6 12.1022 5.84196 11.7206 5.56066 11.4393C5.27936 11.158 4.89782 11 4.5 11C4.10218 11 3.72064 11.158 3.43934 11.4393C3.15804 11.7206 3 12.1022 3 12.5C3 12.8978 3.15804 13.2794 3.43934 13.5607C3.72064 13.842 4.10218 14 4.5 14ZM21 12.5C21 12.1022 20.842 11.7206 20.5607 11.4393C20.2794 11.158 19.8978 11 19.5 11C19.1022 11 18.7206 11.158 18.4393 11.4393C18.158 11.7206 18 12.1022 18 12.5C18 12.8978 18.158 13.2794 18.4393 13.5607C18.7206 13.842 19.1022 14 19.5 14C19.8978 14 20.2794 13.842 20.5607 13.5607C20.842 13.2794 21 12.8978 21 12.5Z" fill="#3F4045" />
                    </g>
                    <defs>
                        <clipPath id="clip0_542_36712">
                            <rect width="24" height="24" fill="white" transform="translate(0 0.5)" />
                        </clipPath>
                    </defs>
                </svg>
            </div>
            <div class="col-md-auto p-3">
                <form class="row align-items-center g-3">
                    <div class="col-auto">
                        <h6 class="text-primary mb-0">Showing Data For :</h6>
                    </div>
                    <div class="col-md-auto position-relative"><input class="form-control form-control-sm datetimepicker ps-4" id="CRMDateRange" type="text" placeholder="Choose date" /><span class="fas fa-calendar-alt text-primary position-absolute top-50 translate-middle-y ms-2"> </span></div>
                </form>
            </div>
        </div>
        <div class="row" data-bs-theme="light">
            <div class="col-3 col-lg-3 mb-4">
                <div class="card text-white ">
                    <div class="card-body" style="background-color: #E9F7F5;">
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
                                <img height="45" src="{{ asset('assets/img/icons/ticket_complete.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 col-lg-3 mb-4">
                <div class="card text-white ">
                    <div class="card-body" style="background-color: #BEE8E1;">
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
                                <img height="45" src="{{ asset('assets/img/icons/ticket_cancel.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


    </div>



</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/echarts@5.0.1/dist/echarts.min.js"></script>

@endsection
