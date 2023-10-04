@extends('layouts.master')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}">
@endsection


@section('content')

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
                <div class="frame-285">
                    <div class="col-md-auto p-3">
                        <form class="row align-items-center g-3">
                            <div class="col-auto">
                                <h6 class="text-primary mb-0">Showing Data For :</h6>
                            </div>
                            <div class="col-md-auto position-relative"><input class="form-control form-control-sm datetimepicker ps-4" id="CRMDateRange" type="text" placeholder="Choose date" /><span class="fas fa-calendar-alt text-primary position-absolute top-50 translate-middle-y ms-2"> </span></div>
                        </form>
                    </div>
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

    <!-- <div class="container bg-white mb-3 p-3">
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col">
                        <div class="request-quality-performance">Request Quality Performance</div>
                    </div>
                    <div class="col">
                        <svg class="icon" width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_485_36291)">
                                <path d="M0 12.5C0 9.3174 1.26428 6.26516 3.51472 4.01472C5.76516 1.76428 8.8174 0.5 12 0.5C15.1826 0.5 18.2348 1.76428 20.4853 4.01472C22.7357 6.26516 24 9.3174 24 12.5C24 15.6826 22.7357 18.7348 20.4853 20.9853C18.2348 23.2357 15.1826 24.5 12 24.5C8.8174 24.5 5.76516 23.2357 3.51472 20.9853C1.26428 18.7348 0 15.6826 0 12.5ZM13.5 5C13.5 4.60218 13.342 4.22064 13.0607 3.93934C12.7794 3.65804 12.3978 3.5 12 3.5C11.6022 3.5 11.2206 3.65804 10.9393 3.93934C10.658 4.22064 10.5 4.60218 10.5 5C10.5 5.39782 10.658 5.77936 10.9393 6.06066C11.2206 6.34196 11.6022 6.5 12 6.5C12.3978 6.5 12.7794 6.34196 13.0607 6.06066C13.342 5.77936 13.5 5.39782 13.5 5ZM12 20C13.6547 20 15 18.6547 15 17C15 16.1844 14.6766 15.4484 14.1516 14.9094L17.1562 8.07969C17.4047 7.5125 17.1469 6.84688 16.5797 6.59844C16.0125 6.35 15.3469 6.60781 15.0984 7.175L12.0891 14C12.0609 14 12.0281 14 12 14C10.3453 14 9 15.3453 9 17C9 18.6547 10.3453 20 12 20ZM8.25 7.25C8.25 6.85218 8.09196 6.47064 7.81066 6.18934C7.52936 5.90804 7.14782 5.75 6.75 5.75C6.35218 5.75 5.97064 5.90804 5.68934 6.18934C5.40804 6.47064 5.25 6.85218 5.25 7.25C5.25 7.64782 5.40804 8.02936 5.68934 8.31066C5.97064 8.59196 6.35218 8.75 6.75 8.75C7.14782 8.75 7.52936 8.59196 7.81066 8.31066C8.09196 8.02936 8.25 7.64782 8.25 7.25ZM4.5 14C4.89782 14 5.27936 13.842 5.56066 13.5607C5.84196 13.2794 6 12.8978 6 12.5C6 12.1022 5.84196 11.7206 5.56066 11.4393C5.27936 11.158 4.89782 11 4.5 11C4.10218 11 3.72064 11.158 3.43934 11.4393C3.15804 11.7206 3 12.1022 3 12.5C3 12.8978 3.15804 13.2794 3.43934 13.5607C3.72064 13.842 4.10218 14 4.5 14ZM21 12.5C21 12.1022 20.842 11.7206 20.5607 11.4393C20.2794 11.158 19.8978 11 19.5 11C19.1022 11 18.7206 11.158 18.4393 11.4393C18.158 11.7206 18 12.1022 18 12.5C18 12.8978 18.158 13.2794 18.4393 13.5607C18.7206 13.842 19.1022 14 19.5 14C19.8978 14 20.2794 13.842 20.5607 13.5607C20.842 13.2794 21 12.8978 21 12.5Z" fill="#3F4045" />
                            </g>
                            <defs>
                                <clipPath id="clip0_485_36291">
                                    <rect width="24" height="24" fill="white" transform="translate(0 0.5)" />
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-md-auto p-3">
                        <form class="row align-items-center g-3">
                            <div class="col-auto">
                                <h6 class="text-primary mb-0">Showing Data For :</h6>
                            </div>
                            <div class="col-md-auto position-relative"><input class="form-control form-control-sm datetimepicker ps-4" id="CRMDateRange" type="text" data-options="{&quot;mode&quot;:&quot;range&quot;,&quot;dateFormat&quot;:&quot;M d&quot;,&quot;disableMobile&quot;:true , &quot;defaultDate&quot;: [&quot;Feb 16&quot;, &quot;Feb 23&quot;] }" /><span class="fas fa-calendar-alt text-primary position-absolute top-50 translate-middle-y ms-2"> </span></div>
                        </form>
                    </div>
                </div>


            </div>
        </div>

        <div class="frame-285">

        </div>
    </div> -->
    <div class="frame-283 mb-3">
        <div class="frame-537">
            <div class="frame-193">
                <div class="request-volume-performance">Request Volume Performance</div>
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
            <div class="frame-285">
                <div class="col-md-auto p-3">
                    <form class="row align-items-center g-3">
                        <div class="col-auto">
                            <h6 class="text-primary mb-0">Showing Data For :</h6>
                        </div>
                        <div class="col-md-auto position-relative"><input class="form-control form-control-sm datetimepicker ps-4" id="CRMDateRange" type="text" placeholder="Choose date" /><span class="fas fa-calendar-alt text-primary position-absolute top-50 translate-middle-y ms-2"> </span></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="frame-536">
            <div class="frame-341">
                <div class="_1">
                    <div class="frame-340">
                        <div class="frame-539">
                            <svg class="check" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.15146 20.5971L0.351457 12.7971C-0.117152 12.3285 -0.117152 11.5687 0.351457 11.1L2.04847 9.40294C2.51708 8.93428 3.27693 8.93428 3.74553 9.40294L8.99999 14.6573L20.2544 3.40294C20.7231 2.93433 21.4829 2.93433 21.9515 3.40294L23.6485 5.1C24.1171 5.56861 24.1171 6.32841 23.6485 6.79706L9.84852 20.5971C9.37986 21.0657 8.62007 21.0657 8.15146 20.5971Z" fill="white" />
                            </svg>
                        </div>
                        <div class="frame-364">
                            <div class="frame-538">
                                <div class="frame-342">
                                    <div class="_150">150</div>
                                    <div class="_100">/100</div>
                                </div>
                                <div class="request-complete">Request Complete</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="_11">
                    <div class="frame-3402">
                        <div class="frame-5392">
                            <svg class="list-check-solid-1" width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.28703 3.26998C8.71238 3.65236 8.74676 4.30113 8.36437 4.72647L5.27092 8.16364C5.08188 8.37417 4.8155 8.49876 4.53193 8.50306C4.24837 8.50736 3.97769 8.39994 3.77576 8.20231L2.05288 6.48373C1.65331 6.07986 1.65331 5.4268 2.05288 5.02293C2.45245 4.61906 3.10981 4.61906 3.50938 5.02293L4.45889 5.97245L6.82624 3.34302C7.20862 2.91767 7.85739 2.88329 8.28274 3.26568L8.28703 3.26998ZM8.28703 10.1443C8.71238 10.5267 8.74676 11.1755 8.36437 11.6008L5.27092 15.038C5.08188 15.2485 4.8155 15.3731 4.53193 15.3774C4.24837 15.3817 3.97769 15.2743 3.77576 15.0766L2.05288 13.3581C1.64901 12.9542 1.64901 12.3011 2.05288 11.9016C2.45674 11.502 3.10981 11.4977 3.50938 11.9016L4.45889 12.8511L6.82624 10.2216C7.20862 9.79629 7.85739 9.76192 8.28274 10.1443H8.28703ZM11.3762 5.75333C11.3762 4.99285 11.9906 4.37846 12.7511 4.37846H22.3751C23.1356 4.37846 23.75 4.99285 23.75 5.75333C23.75 6.5138 23.1356 7.12819 22.3751 7.12819H12.7511C11.9906 7.12819 11.3762 6.5138 11.3762 5.75333ZM11.3762 12.6277C11.3762 11.8672 11.9906 11.2528 12.7511 11.2528H22.3751C23.1356 11.2528 23.75 11.8672 23.75 12.6277C23.75 13.3881 23.1356 14.0025 22.3751 14.0025H12.7511C11.9906 14.0025 11.3762 13.3881 11.3762 12.6277ZM8.62645 19.502C8.62645 18.7415 9.24085 18.1271 10.0013 18.1271H22.3751C23.1356 18.1271 23.75 18.7415 23.75 19.502C23.75 20.2625 23.1356 20.8769 22.3751 20.8769H10.0013C9.24085 20.8769 8.62645 20.2625 8.62645 19.502ZM3.81442 17.4397C4.36138 17.4397 4.88593 17.657 5.27269 18.0437C5.65945 18.4305 5.87672 18.955 5.87672 19.502C5.87672 20.0489 5.65945 20.5735 5.27269 20.9603C4.88593 21.347 4.36138 21.5643 3.81442 21.5643C3.26747 21.5643 2.74291 21.347 2.35616 20.9603C1.9694 20.5735 1.75213 20.0489 1.75213 19.502C1.75213 18.955 1.9694 18.4305 2.35616 18.0437C2.74291 17.657 3.26747 17.4397 3.81442 17.4397Z" fill="white" />
                            </svg>
                        </div>
                        <div class="frame-364">
                            <div class="frame-538">
                                <div class="frame-342">
                                    <div class="_1502">150</div>
                                    <div class="_1002">/100</div>
                                </div>
                                <div class="ticket-on-progress">Ticket On Progress</div>
                            </div>
                        </div>
                    </div>
                    <div class="frame-3412">
                        <div class="frame-5392">
                            <svg class="list-check-solid-12" width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.28703 3.26998C8.71238 3.65236 8.74676 4.30113 8.36437 4.72647L5.27092 8.16364C5.08188 8.37417 4.8155 8.49876 4.53193 8.50306C4.24837 8.50736 3.97769 8.39994 3.77576 8.20231L2.05288 6.48373C1.65331 6.07986 1.65331 5.4268 2.05288 5.02293C2.45245 4.61906 3.10981 4.61906 3.50938 5.02293L4.45889 5.97245L6.82624 3.34302C7.20862 2.91767 7.85739 2.88329 8.28274 3.26568L8.28703 3.26998ZM8.28703 10.1443C8.71238 10.5267 8.74676 11.1755 8.36437 11.6008L5.27092 15.038C5.08188 15.2485 4.8155 15.3731 4.53193 15.3774C4.24837 15.3817 3.97769 15.2743 3.77576 15.0766L2.05288 13.3581C1.64901 12.9542 1.64901 12.3011 2.05288 11.9016C2.45674 11.502 3.10981 11.4977 3.50938 11.9016L4.45889 12.8511L6.82624 10.2216C7.20862 9.79629 7.85739 9.76192 8.28274 10.1443H8.28703ZM11.3762 5.75333C11.3762 4.99285 11.9906 4.37846 12.7511 4.37846H22.3751C23.1356 4.37846 23.75 4.99285 23.75 5.75333C23.75 6.5138 23.1356 7.12819 22.3751 7.12819H12.7511C11.9906 7.12819 11.3762 6.5138 11.3762 5.75333ZM11.3762 12.6277C11.3762 11.8672 11.9906 11.2528 12.7511 11.2528H22.3751C23.1356 11.2528 23.75 11.8672 23.75 12.6277C23.75 13.3881 23.1356 14.0025 22.3751 14.0025H12.7511C11.9906 14.0025 11.3762 13.3881 11.3762 12.6277ZM8.62645 19.502C8.62645 18.7415 9.24085 18.1271 10.0013 18.1271H22.3751C23.1356 18.1271 23.75 18.7415 23.75 19.502C23.75 20.2625 23.1356 20.8769 22.3751 20.8769H10.0013C9.24085 20.8769 8.62645 20.2625 8.62645 19.502ZM3.81442 17.4397C4.36138 17.4397 4.88593 17.657 5.27269 18.0437C5.65945 18.4305 5.87672 18.955 5.87672 19.502C5.87672 20.0489 5.65945 20.5735 5.27269 20.9603C4.88593 21.347 4.36138 21.5643 3.81442 21.5643C3.26747 21.5643 2.74291 21.347 2.35616 20.9603C1.9694 20.5735 1.75213 20.0489 1.75213 19.502C1.75213 18.955 1.9694 18.4305 2.35616 18.0437C2.74291 17.657 3.26747 17.4397 3.81442 17.4397Z" fill="white" />
                            </svg>
                        </div>
                        <div class="frame-364">
                            <div class="frame-538">
                                <div class="frame-342">
                                    <div class="_1503">150</div>
                                    <div class="_1003">/100</div>
                                </div>
                                <div class="request-on-progress">Request On Progress</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="_12">
                    <div class="frame-3403">
                        <div class="frame-539">
                            <svg class="frame" width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.5 6.75C15.3011 6.75 15.1103 6.82902 14.9697 6.96967C14.829 7.11032 14.75 7.30109 14.75 7.5V18C14.75 18.1989 14.829 18.3897 14.9697 18.5303C15.1103 18.671 15.3011 18.75 15.5 18.75H16.25C16.4489 18.75 16.6397 18.671 16.7803 18.5303C16.921 18.3897 17 18.1989 17 18V7.5C17 7.30109 16.921 7.11032 16.7803 6.96967C16.6397 6.82902 16.4489 6.75 16.25 6.75H15.5ZM20.75 6.75C20.5511 6.75 20.3603 6.82902 20.2197 6.96967C20.079 7.11032 20 7.30109 20 7.5V18C20 18.414 20.336 18.75 20.75 18.75H21.5C21.6989 18.75 21.8897 18.671 22.0303 18.5303C22.171 18.3897 22.25 18.1989 22.25 18V7.5C22.25 7.30109 22.171 7.11032 22.0303 6.96967C21.8897 6.82902 21.6989 6.75 21.5 6.75H20.75ZM5.555 7.06C4.305 6.347 2.75 7.25 2.75 8.69V16.812C2.75 18.252 4.305 19.155 5.555 18.44L12.663 14.379C13.923 13.659 13.923 11.843 12.663 11.123L5.555 7.06Z" fill="white" />
                            </svg>
                        </div>
                        <div class="frame-364">
                            <div class="frame-538">
                                <div class="frame-342">
                                    <div class="_150">150</div>
                                    <div class="_100">/100</div>
                                </div>
                                <div class="request-hold">Request Hold</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="_14">
                    <div class="frame-3404">
                        <div class="frame-5392">
                            <svg class="list-check-solid-13" width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.78703 3.26998C8.21238 3.65236 8.24675 4.30113 7.86436 4.72647L4.77091 8.16364C4.58187 8.37417 4.31549 8.49876 4.03192 8.50306C3.74836 8.50736 3.47768 8.39994 3.27575 8.20231L1.55287 6.48373C1.1533 6.07986 1.1533 5.4268 1.55287 5.02293C1.95244 4.61906 2.6098 4.61906 3.00937 5.02293L3.95888 5.97245L6.32623 3.34302C6.70862 2.91767 7.35738 2.88329 7.78273 3.26568L7.78703 3.26998ZM7.78703 10.1443C8.21238 10.5267 8.24675 11.1755 7.86436 11.6008L4.77091 15.038C4.58187 15.2485 4.31549 15.3731 4.03192 15.3774C3.74836 15.3817 3.47768 15.2743 3.27575 15.0766L1.55287 13.3581C1.149 12.9542 1.149 12.3011 1.55287 11.9016C1.95674 11.502 2.6098 11.4977 3.00937 11.9016L3.95888 12.8511L6.32623 10.2216C6.70862 9.79629 7.35738 9.76192 7.78273 10.1443H7.78703ZM10.8762 5.75333C10.8762 4.99285 11.4906 4.37846 12.251 4.37846H21.8751C22.6356 4.37846 23.25 4.99285 23.25 5.75333C23.25 6.5138 22.6356 7.12819 21.8751 7.12819H12.251C11.4906 7.12819 10.8762 6.5138 10.8762 5.75333ZM10.8762 12.6277C10.8762 11.8672 11.4906 11.2528 12.251 11.2528H21.8751C22.6356 11.2528 23.25 11.8672 23.25 12.6277C23.25 13.3881 22.6356 14.0025 21.8751 14.0025H12.251C11.4906 14.0025 10.8762 13.3881 10.8762 12.6277ZM8.12645 19.502C8.12645 18.7415 8.74084 18.1271 9.50131 18.1271H21.8751C22.6356 18.1271 23.25 18.7415 23.25 19.502C23.25 20.2625 22.6356 20.8769 21.8751 20.8769H9.50131C8.74084 20.8769 8.12645 20.2625 8.12645 19.502ZM3.31442 17.4397C3.86137 17.4397 4.38593 17.657 4.77268 18.0437C5.15944 18.4305 5.37671 18.955 5.37671 19.502C5.37671 20.0489 5.15944 20.5735 4.77268 20.9603C4.38593 21.347 3.86137 21.5643 3.31442 21.5643C2.76746 21.5643 2.24291 21.347 1.85615 20.9603C1.46939 20.5735 1.25212 20.0489 1.25212 19.502C1.25212 18.955 1.46939 18.4305 1.85615 18.0437C2.24291 17.657 2.76746 17.4397 3.31442 17.4397Z" fill="white" />
                            </svg>
                        </div>
                        <div class="frame-364">
                            <div class="frame-538">
                                <div class="frame-342">
                                    <div class="_1502">150</div>
                                    <div class="_1002">/100</div>
                                </div>
                                <div class="ticket-on-progress">Ticket On Progress</div>
                            </div>
                        </div>
                    </div>
                    <div class="frame-3413">
                        <div class="frame-5392">
                            <svg class="times" width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.3775 12L20.0683 7.30922C20.6439 6.73359 20.6439 5.80031 20.0683 5.22422L19.0258 4.18172C18.4502 3.60609 17.5169 3.60609 16.9408 4.18172L12.25 8.8725L7.55922 4.18172C6.98359 3.60609 6.05031 3.60609 5.47422 4.18172L4.43172 5.22422C3.85609 5.79984 3.85609 6.73312 4.43172 7.30922L9.1225 12L4.43172 16.6908C3.85609 17.2664 3.85609 18.1997 4.43172 18.7758L5.47422 19.8183C6.04984 20.3939 6.98359 20.3939 7.55922 19.8183L12.25 15.1275L16.9408 19.8183C17.5164 20.3939 18.4502 20.3939 19.0258 19.8183L20.0683 18.7758C20.6439 18.2002 20.6439 17.2669 20.0683 16.6908L15.3775 12Z" fill="white" />
                            </svg>
                        </div>
                        <div class="frame-364">
                            <div class="frame-538">
                                <div class="frame-342">
                                    <div class="_1503">150</div>
                                    <div class="_1003">/100</div>
                                </div>
                                <div class="request-cancel">Request Cancel</div>
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
                    <div class="frame-285">
                        <div class="col-md-auto p-3">
                            <form class="row align-items-center g-3">
                                <div class="col-auto">
                                    <h6 class="text-primary mb-0">Showing Data For :</h6>
                                </div>
                                <div class="col-md-auto position-relative"><input class="form-control form-control-sm datetimepicker ps-4" id="CRMDateRange" type="text" placeholder="Choose date" /><span class="fas fa-calendar-alt text-primary position-absolute top-50 translate-middle-y ms-2"> </span></div>
                            </form>
                        </div>
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

    <div class="card h-lg-100 mb-3">
        <div class="frame-537">
            <div class="frame-193">
                <div class="request-volume-performance">Request Volume Performance</div>
                <svg class="icon" width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.6 15.5H17.4C17.7 15.5 18 15.2 18 14.9V8.6C18 8.3 17.7 8 17.4 8H15.6C15.3 8 15 8.3 15 8.6V14.9C15 15.2 15.3 15.5 15.6 15.5ZM20.1 15.5H21.9C22.2 15.5 22.5 15.2 22.5 14.9V4.1C22.5 3.8 22.2 3.5 21.9 3.5H20.1C19.8 3.5 19.5 3.8 19.5 4.1V14.9C19.5 15.2 19.8 15.5 20.1 15.5ZM6.6 15.5H8.4C8.7 15.5 9 15.2 9 14.9V11.6C9 11.3 8.7 11 8.4 11H6.6C6.3 11 6 11.3 6 11.6V14.9C6 15.2 6.3 15.5 6.6 15.5ZM11.1 15.5H12.9C13.2 15.5 13.5 15.2 13.5 14.9V5.6C13.5 5.3 13.2 5 12.9 5H11.1C10.8 5 10.5 5.3 10.5 5.6V14.9C10.5 15.2 10.8 15.5 11.1 15.5ZM23.25 18.5H3V4.25C3 3.83562 2.66438 3.5 2.25 3.5H0.75C0.335625 3.5 0 3.83562 0 4.25V20C0 20.8283 0.671719 21.5 1.5 21.5H23.25C23.6644 21.5 24 21.1644 24 20.75V19.25C24 18.8356 23.6644 18.5 23.25 18.5Z" fill="black" />
                    <defs>
                        <clipPath id="clip0_542_36712">
                            <rect width="24" height="24" fill="white" transform="translate(0 0.5)" />
                        </clipPath>
                    </defs>
                </svg>
            </div>
            <div class="frame-285">
                <div class="col-md-auto p-3">
                    <form class="row align-items-center g-3">
                        <div class="col-auto">
                            <h6 class="text-primary mb-0">Showing Data For :</h6>
                        </div>
                        <div class="col-md-auto position-relative"><input class="form-control form-control-sm datetimepicker ps-4" id="CRMDateRange" type="text" placeholder="Choose date" /><span class="fas fa-calendar-alt text-primary position-absolute top-50 translate-middle-y ms-2"> </span></div>
                    </form>
                </div>
            </div>
        </div>
        <!-- <div class="col-auto">
                      <h6 class="mb-0">Statistik Invoice</h6>
                    </div> -->
        <div class="col-auto d-flex">
            <div class="dropdown font-sans-serif btn-reveal-trigger">
            </div>
        </div>
        <div class="card-body h-100 pe-0">
            <!-- Find the JS file for the following chart at: src\js\charts\echarts\total-sales.js-->
            <!-- If you are not using gulp based workflow, you can find the transpiled code at: public\assets\js\theme.js-->
            <div class="echart-line-total-sales h-100" data-echart-responsive="true"></div>
        </div>
    </div>


    <div class="frame-283 mb-3">
        <div class="frame-537">
            <div class="frame-193">
                <div class="request-volume-performance">Invoice in Rupiah</div>
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
            <div class="frame-285">
                <div class="col-md-auto p-3">
                    <form class="row align-items-center g-3">
                        <div class="col-auto">
                            <h6 class="text-primary mb-0">Showing Data For :</h6>
                        </div>
                        <div class="col-md-auto position-relative"><input class="form-control form-control-sm datetimepicker ps-4" id="CRMDateRange" type="text" placeholder="Choose date" /><span class="fas fa-calendar-alt text-primary position-absolute top-50 translate-middle-y ms-2"> </span></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="frame-536">
            <div class="frame-341">
                <div class="_1">
                    <div class="frame-340">
                        <div class="frame-539">
                            <svg class="check" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.15146 20.5971L0.351457 12.7971C-0.117152 12.3285 -0.117152 11.5687 0.351457 11.1L2.04847 9.40294C2.51708 8.93428 3.27693 8.93428 3.74553 9.40294L8.99999 14.6573L20.2544 3.40294C20.7231 2.93433 21.4829 2.93433 21.9515 3.40294L23.6485 5.1C24.1171 5.56861 24.1171 6.32841 23.6485 6.79706L9.84852 20.5971C9.37986 21.0657 8.62007 21.0657 8.15146 20.5971Z" fill="white" />
                            </svg>
                        </div>
                        <div class="frame-364">
                            <div class="frame-538">
                                <div class="frame-342">
                                    <div class="_150">150</div>
                                    <div class="_100">/100</div>
                                </div>
                                <div class="request-complete">Request Complete</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="_11">
                    <div class="frame-3402">
                        <div class="frame-5392">
                            <svg class="list-check-solid-1" width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.28703 3.26998C8.71238 3.65236 8.74676 4.30113 8.36437 4.72647L5.27092 8.16364C5.08188 8.37417 4.8155 8.49876 4.53193 8.50306C4.24837 8.50736 3.97769 8.39994 3.77576 8.20231L2.05288 6.48373C1.65331 6.07986 1.65331 5.4268 2.05288 5.02293C2.45245 4.61906 3.10981 4.61906 3.50938 5.02293L4.45889 5.97245L6.82624 3.34302C7.20862 2.91767 7.85739 2.88329 8.28274 3.26568L8.28703 3.26998ZM8.28703 10.1443C8.71238 10.5267 8.74676 11.1755 8.36437 11.6008L5.27092 15.038C5.08188 15.2485 4.8155 15.3731 4.53193 15.3774C4.24837 15.3817 3.97769 15.2743 3.77576 15.0766L2.05288 13.3581C1.64901 12.9542 1.64901 12.3011 2.05288 11.9016C2.45674 11.502 3.10981 11.4977 3.50938 11.9016L4.45889 12.8511L6.82624 10.2216C7.20862 9.79629 7.85739 9.76192 8.28274 10.1443H8.28703ZM11.3762 5.75333C11.3762 4.99285 11.9906 4.37846 12.7511 4.37846H22.3751C23.1356 4.37846 23.75 4.99285 23.75 5.75333C23.75 6.5138 23.1356 7.12819 22.3751 7.12819H12.7511C11.9906 7.12819 11.3762 6.5138 11.3762 5.75333ZM11.3762 12.6277C11.3762 11.8672 11.9906 11.2528 12.7511 11.2528H22.3751C23.1356 11.2528 23.75 11.8672 23.75 12.6277C23.75 13.3881 23.1356 14.0025 22.3751 14.0025H12.7511C11.9906 14.0025 11.3762 13.3881 11.3762 12.6277ZM8.62645 19.502C8.62645 18.7415 9.24085 18.1271 10.0013 18.1271H22.3751C23.1356 18.1271 23.75 18.7415 23.75 19.502C23.75 20.2625 23.1356 20.8769 22.3751 20.8769H10.0013C9.24085 20.8769 8.62645 20.2625 8.62645 19.502ZM3.81442 17.4397C4.36138 17.4397 4.88593 17.657 5.27269 18.0437C5.65945 18.4305 5.87672 18.955 5.87672 19.502C5.87672 20.0489 5.65945 20.5735 5.27269 20.9603C4.88593 21.347 4.36138 21.5643 3.81442 21.5643C3.26747 21.5643 2.74291 21.347 2.35616 20.9603C1.9694 20.5735 1.75213 20.0489 1.75213 19.502C1.75213 18.955 1.9694 18.4305 2.35616 18.0437C2.74291 17.657 3.26747 17.4397 3.81442 17.4397Z" fill="white" />
                            </svg>
                        </div>
                        <div class="frame-364">
                            <div class="frame-538">
                                <div class="frame-342">
                                    <div class="_1502">150</div>
                                    <div class="_1002">/100</div>
                                </div>
                                <div class="ticket-on-progress">Ticket On Progress</div>
                            </div>
                        </div>
                    </div>
                    <div class="frame-3412">
                        <div class="frame-5392">
                            <svg class="list-check-solid-12" width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.28703 3.26998C8.71238 3.65236 8.74676 4.30113 8.36437 4.72647L5.27092 8.16364C5.08188 8.37417 4.8155 8.49876 4.53193 8.50306C4.24837 8.50736 3.97769 8.39994 3.77576 8.20231L2.05288 6.48373C1.65331 6.07986 1.65331 5.4268 2.05288 5.02293C2.45245 4.61906 3.10981 4.61906 3.50938 5.02293L4.45889 5.97245L6.82624 3.34302C7.20862 2.91767 7.85739 2.88329 8.28274 3.26568L8.28703 3.26998ZM8.28703 10.1443C8.71238 10.5267 8.74676 11.1755 8.36437 11.6008L5.27092 15.038C5.08188 15.2485 4.8155 15.3731 4.53193 15.3774C4.24837 15.3817 3.97769 15.2743 3.77576 15.0766L2.05288 13.3581C1.64901 12.9542 1.64901 12.3011 2.05288 11.9016C2.45674 11.502 3.10981 11.4977 3.50938 11.9016L4.45889 12.8511L6.82624 10.2216C7.20862 9.79629 7.85739 9.76192 8.28274 10.1443H8.28703ZM11.3762 5.75333C11.3762 4.99285 11.9906 4.37846 12.7511 4.37846H22.3751C23.1356 4.37846 23.75 4.99285 23.75 5.75333C23.75 6.5138 23.1356 7.12819 22.3751 7.12819H12.7511C11.9906 7.12819 11.3762 6.5138 11.3762 5.75333ZM11.3762 12.6277C11.3762 11.8672 11.9906 11.2528 12.7511 11.2528H22.3751C23.1356 11.2528 23.75 11.8672 23.75 12.6277C23.75 13.3881 23.1356 14.0025 22.3751 14.0025H12.7511C11.9906 14.0025 11.3762 13.3881 11.3762 12.6277ZM8.62645 19.502C8.62645 18.7415 9.24085 18.1271 10.0013 18.1271H22.3751C23.1356 18.1271 23.75 18.7415 23.75 19.502C23.75 20.2625 23.1356 20.8769 22.3751 20.8769H10.0013C9.24085 20.8769 8.62645 20.2625 8.62645 19.502ZM3.81442 17.4397C4.36138 17.4397 4.88593 17.657 5.27269 18.0437C5.65945 18.4305 5.87672 18.955 5.87672 19.502C5.87672 20.0489 5.65945 20.5735 5.27269 20.9603C4.88593 21.347 4.36138 21.5643 3.81442 21.5643C3.26747 21.5643 2.74291 21.347 2.35616 20.9603C1.9694 20.5735 1.75213 20.0489 1.75213 19.502C1.75213 18.955 1.9694 18.4305 2.35616 18.0437C2.74291 17.657 3.26747 17.4397 3.81442 17.4397Z" fill="white" />
                            </svg>
                        </div>
                        <div class="frame-364">
                            <div class="frame-538">
                                <div class="frame-342">
                                    <div class="_1503">150</div>
                                    <div class="_1003">/100</div>
                                </div>
                                <div class="request-on-progress">Request On Progress</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
@endsection


<!-- @extends('layouts.master')

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
                    <div class="echart-bar-top-products h-100" data-echart-responsive="true"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script></script>
@endsection -->