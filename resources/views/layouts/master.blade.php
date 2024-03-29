<!DOCTYPE html>
<html data-bs-theme="light" lang="en-US" dir="ltr">
<html data-bs-theme="light" lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('css')

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Pro Apps | Dashboard &amp; Web App Template</title>
    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Pro Apps | Dashboard &amp; Web App Template</title>

    <meta name="theme-color" content="#ffffff">
    <script src="{{ url('assets/js/config.js') }}"></script>
    <script src="{{ url('assets/vendors/simplebar/simplebar.min.js') }}"></script>

    <meta name="theme-color" content="#ffffff">
    <script src="{{ url('assets/js/config.js') }}"></script>
    <script src="{{ url('assets/vendors/simplebar/simplebar.min.js') }}"></script>

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ url('assets/vendors/simplebar/simplebar.min.css') }}" rel="stylesheet">

    <link href="{{ url('assets/css/theme.min.css') }}" rel="stylesheet" id="style-default">
</head>

<body id="body">
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

    <main class="main" id="top" style="visibility: hidden">
        <div class="container-fluid" data-layout="container">
            <nav class="navbar navbar-light navbar-vertical navbar-expand-xl navbar-card">
                <div class="d-flex align-items-center">
                    <div class="toggle-icon-wrapper">
                        <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle"
                            data-bs-toggle="tooltip" data-bs-placement="left" title="Toggle Navigation"><span
                                class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
                    </div>
                    <a class="navbar-brand" href="{{ route('dashboard') }}">
                        <div class="d-flex align-items-center py-4"><img class="me-2"
                                src="/assets/img/icons/spot-illustrations/proapps.png" alt="proapps" width="130" />
                        </div>
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
                    <div class="navbar-vertical-content scrollbar">
                        <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav" id="">
                            <div id="dynamicMenu"></div>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="content">
                <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand" style="display: none;">
                    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button"
                        data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse"
                        aria-controls="navbarVerticalCollapse" aria-expanded="false"
                        aria-label="Toggle   Navigation"><span class="navbar-toggle-icon"><span
                                class="toggle-line"></span></span></button>
                    <a class="navbar-brand me-1 me-sm-3" href="{{ route('dashboard') }}">
                        <div class="d-flex align-items-center"><img class="me-2"
                                src="/assets/img/icons/spot-illustrations/proapps.png" alt="" width="150" />
                        </div>
                    </a>
                    <ul class="navbar-nav align-items-center d-none d-lg-block">
                        <li class="nav-item">
                            <div class="search-box" data-list='{"valueNames":["title"]}'>
                                <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                                    <input class="form-control search-input fuzzy-search" type="search"
                                        placeholder="Search..." aria-label="Search" />
                                    <span class="fas fa-search search-box-icon"></span>
                                </form>
                                <div class="btn-close-falcon-container position-absolute end-0 top-50 translate-middle shadow-none"
                                    data-bs-dismiss="search"><button class="btn btn-link btn-close-falcon p-0"
                                        aria-label="Close"></button></div>
                                <div class="dropdown-menu border font-base start-0 mt-2 py-0 overflow-hidden w-100">
                                    <div class="scrollbar list py-3" style="max-height: 24rem;">
                                        <h6 class="dropdown-header fw-medium text-uppercase px-x1 fs--2 pt-0 pb-2">
                                            Recently Browsed</h6>
                                        <a class="dropdown-item fs--1 px-x1 py-1 hover-primary"
                                            href="app/events/event-detail.html">
                                            <div class="d-flex align-items-center">
                                                <span class="fas fa-circle me-2 text-300 fs--2"></span>
                                                <div class="fw-normal title">Pages <span
                                                        class="fas fa-chevron-right mx-1 text-500 fs--2"
                                                        data-fa-transform="shrink-2"></span> Events</div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item fs--1 px-x1 py-1 hover-primary"
                                            href="app/e-commerce/customers.html">
                                            <div class="d-flex align-items-center">
                                                <span class="fas fa-circle me-2 text-300 fs--2"></span>
                                                <div class="fw-normal title">E-commerce <span
                                                        class="fas fa-chevron-right mx-1 text-500 fs--2"
                                                        data-fa-transform="shrink-2"></span> Customers</div>
                                            </div>
                                        </a>
                                        <hr class="text-200 dark__text-900" />
                                    </div>
                                    <div class="text-center mt-n3">
                                        <p class="fallback fw-bold fs-1 d-none">No Result Found.</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
                        <li class="nav-item dropdown">
                            <a class="nav-link notification-indicator-danger px-0 fa-icon-wait"
                                id="navbarDropdownNotification" role="button" data-bs-toggle="dropdown">
                                <span class="fas fa-bell" data-fa-transform="shrink-6"
                                    style="font-size: 33px"></span>
                            </a>
                            <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end dropdown-menu-card dropdown-menu-notification dropdown-caret-bg"
                                aria-labelledby="navbarDropdownNotification">
                                <div class="card card-notification shadow-none">
                                    <div class="card-header">
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-auto">
                                                <h6 class="card-header-title mb-0">Notifications</h6>
                                            </div>
                                            <div class="col-auto ps-0 ps-sm-3">
                                                <a class="card-link text-light fw-normal" href="#">Mark all as
                                                    read</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="scrollbar-overlay" style="max-height: 19rem">
                                        <div class="list-group list-group-flush fw-normal fs--1">
                                            <div id="notification-lists">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center border-top">
                                        <a class="card-link d-block" href="{{ route('notifications') }}">View all</a>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link pe-0 ps-2" id="navbarDropdownUser" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="avatar avatar-xl">
                                    @php
                                        $user = Session::get('user');
                                    @endphp
                                    <img class="rounded-circle"
                                        src="{{ $user->profile_picture ? asset($user->profile_picture) : asset('/storage/img/proapps.png') }}">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end py-0"
                                aria-labelledby="navbarDropdownUser">
                                <div class="bg-white dark__bg-1000 rounded-2 py-2">
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <div class="user-info" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                @php
                                    $user = Session::get('user');
                                @endphp
                                <h5 class="btn btn-falcon-default rounded-pill me-1 mb-1 ml-3">{{ $user->nama_user }}
                                </h5>
                            </div>
                            <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
                                <div class="bg-white dark__bg-1000 rounded-2 py-2">
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </li>

                    </ul>
                </nav>
                <script>
                    var navbarTopVertical = document.querySelector('.content .navbar-top');
                    var navbarTop = document.querySelector('[data-layout] .navbar-top:not([data-double-top-nav');

                    navbarTopVertical.removeAttribute('style');
                </script>
                <div class="mt-4">
                    @yield('content')
                </div>
                <footer class="footer">
                    <div class="row g-0 justify-content-between fs--1 mt-4 mb-3">
                        <div class="col-12 col-sm-auto text-center">
                            <p class="mb-0 text-600">
                                <span class="d-none d-sm-inline-block"> </span><br class="d-sm-none" />
                                2022 &copy; <a href="https://indoland-group.co.id/">Indoland Property Management</a>
                            </p>
                        </div>
                        <div class="col-12 col-sm-auto text-center">
                            <p class="mb-0 text-600">v3.14.0</p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

    </main>

    <audio id="notifSound" allow="autoplay">
        <source src="{{ url('/assets/audio/notifsound2.mp3') }}" type="audio/mpeg">
    </audio>


    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="{{ url('assets/vendors/popper/popper.min.js') }}"></script>
    <script src="{{ url('assets/vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ url('assets/vendors/is/is.min.js') }}"></script>
    <script src="{{ url('assets/vendors/echarts/echarts.min.js') }}"></script>
    <script src="{{ url('assets/vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ url('assets/vendors/lodash/lodash.min.js') }}"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="{{ url('assets/vendors/list.js/list.min.js') }}"></script>
    <script src="{{ url('assets/js/theme.js') }}"></script>
    @include('sweetalert::alert')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var user_id = "{{ Session::get('user_id') }}"
        var division_relation = "{{ Session::get('work_relation_id') }}"

        $('document').ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var notifSound = document.getElementById("notifSound");

            getNotifications(user_id);

            $.ajax({
                url: '/check-role-id',
                method: 'GET',
                success: function(data) {
                    if (data === '') {
                        window.location.replace("/select-role");
                    } else {
                        $("#top").css("visibility", "visible");
                    }
                }
            })

            $.ajax({
                url: '/admin/get-nav/' + user_id,
                type: 'GET',
                success: function(data) {
                    $('#dynamicMenu').append(data.html)
                }
            }).then(function() {
                var url = $(location).attr('href');
                var id = url.split('/')[4];

                $('#' + id).addClass('active my-2')
            })
        });

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
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    {{-- <script src="//js.pusher.com/3.1/pusher.min.js"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <script>
        var pusherKey = '{{ env('PUSHER_APP_KEY') }}';

        var pusher = new Pusher(pusherKey, {
            encrypted: true,
            cluster: 'ap1'
        });
        $('document').ready(function() {
            var channelHello = pusher.subscribe('hello-channel');
            channelHello.bind('App\\Events\\HelloEvent', function(e) {
                var receiver = e.dataNotif.receiver
                var division_receiver = e.dataNotif.division_receiver
                var notif_id = e.dataNotif.id
                getNewNotifications(user_id, receiver, division_receiver, notif_id);
                sumCounter(e.dataNotif.models);
            });

            var channelChat = pusher.subscribe('chat-channel');
            channelChat.bind('App\\Events\\ChatEvent', function(e) {
                if (e.sound === true) {
                    notifSound.play();
                }
            });
        })

        function getNotifications(user_id) {
            $.ajax({
                url: `/admin/get-notifications/${user_id}`,
                type: 'GET',
                success: function(data) {
                    if (data.length > 0) {
                        var is_notif = 0;
                        data.map((item) => {
                            sumCounter(item.models);
                            if (item.is_read == 0) {
                                is_notif += 1;
                            }
                            var current = new Date();
                            $('#notification-lists').append(`
                                    <div class="list-group-item">
                                        <a class="notification notification-flush ${item.is_read == 1 ? 'notification' : 'notification-unread' }"
                                            href="/admin/notification/${item.id}">
                                            <div class="notification-avatar">
                                                <div class="avatar avatar-2xl me-3">
                                                    <img class="rounded-circle"
                                                        src="${item.sender ? item.sender.profile_picture : 'https://demo.pro-apps.xyz/assets/img/icons/spot-illustrations/proapps.png'}"
                                                        alt="" />
                                                </div>
                                            </div>
                                            <div class="notification-body">
                                                <p class="mb-1">
                                                    <strong>${item.sender ? item.sender.nama_user : ''}</strong> ${item.sender ? 'Mengirim anda' : 'System '}  :
                                                    ${item.notif_message} ${item.notif_title}
                                                </p>
                                                <span class="notification-time">
                                                    ${timeDifference(current, new Date(item.created_at))}
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                `)
                        })
                        if (is_notif > 0) {
                            $('#navbarDropdownNotification').addClass('notification-indicator')
                        }
                    } else {
                        $('#notification-lists').append(`
                            <div id="empty_notif">
                                <div class="list-group-item">
                                    <div class="notification-body my-3 text-center">
                                        <strong>Tidak ada Notifikasi</strong>
                                    </div>
                                </div>
                            </div>
                        `)
                    }
                }
            })
        }

        function getNewNotifications(user_id, receiver, division_receiver, notif_id) {
            $.ajax({
                url: `/admin/get-new-notifications/${notif_id}`,
                type: 'GET',
                success: function(resp) {
                    if (resp.division_receiver == division_relation || resp.receiver == user_id) {
                        notifSound.play();
                        var current = new Date();
                        $('#navbarDropdownNotification').addClass('notification-indicator')
                        $('#empty_notif').html("");
                        $('#notification-lists').prepend(`
                            <div class="list-group-item">
                                <a class="notification notification-flush ${resp.is_read == 1 ? 'notification' : 'notification-unread' }"
                                    href="/admin/notification/${resp.id}">
                                    <div class="notification-avatar">
                                        <div class="avatar avatar-2xl me-3">
                                            <img class="rounded-circle"
                                                src="${resp.sender ? resp.sender.profile_picture : 'https://demo.pro-apps.xyz/assets/img/icons/spot-illustrations/proapps.png'}"
                                                alt="" />
                                        </div>
                                    </div>
                                    <div class="notification-body">
                                        <p class="mb-1">
                                            <strong>${resp.sender ? resp.sender.nama_user : ''}</strong> ${resp.sender ? 'Mengirim anda' : 'System '} :
                                            ${resp.notif_message} ${resp.notif_title}
                                        </p>
                                        <span class="notification-time">
                                            ${timeDifference(current, new Date(resp.created_at))}
                                        </span>
                                    </div>
                                </a>
                            </div>
                        `)
                    }
                }
            })
        }

        function sumCounter(models) {
            switch (models) {
                case 'OpenTicket':
                    getNotDoneRequest();
                case 'WorkRequest':
                    getNotDoneWR();
                case 'MApproveWorkOrder':
                    getNotDoneWO();
                default:

            }
            // getNotDoneRP();
        }

        function getNotDoneRequest() {
            $.ajax({
                url: `/admin/not-done/request`,
                type: 'GET',
                success: function(resp) {
                    if (resp > 0) {
                        $('#menu26').css("display", "block");
                        $('#menu26').html(resp);
                    }
                }
            })
        }

        function getNotDoneWR() {
            $.ajax({
                url: `/admin/not-done/wr`,
                type: 'GET',
                success: function(resp) {
                    if (resp > 0) {
                        $('#menu27').css("display", "block");
                        $('#menu27').html(resp);
                    }
                }
            })
        }

        function getNotDoneWO() {
            $.ajax({
                url: `/admin/not-done/wo`,
                type: 'GET',
                success: function(resp) {
                    if (resp > 0) {
                        $('#menu28').css("display", "block");
                        $('#menu28').html(resp);
                    }
                }
            })
        }

        function getNotDoneWO() {
            $.ajax({
                url: `/admin/not-done/wo`,
                type: 'GET',
                success: function(resp) {
                    if (resp > 0) {
                        $('#menu28').css("display", "block");
                        $('#menu28').html(resp);
                    }
                }
            })
        }

        function timeDifference(current, previous) {
            var msPerMinute = 60 * 1000;
            var msPerHour = msPerMinute * 60;
            var msPerDay = msPerHour * 24;
            var msPerMonth = msPerDay * 30;
            var msPerYear = msPerDay * 365;

            var elapsed = current - previous;

            if (elapsed < msPerMinute) {
                return Math.round(elapsed / 1000) + ' seconds ago';
            } else if (elapsed < msPerHour) {
                return Math.round(elapsed / msPerMinute) + ' minutes ago';
            } else if (elapsed < msPerDay) {
                return Math.round(elapsed / msPerHour) + ' hours ago';
            } else if (elapsed < msPerMonth) {
                return Math.round(elapsed / msPerDay) + ' days ago';
            } else if (elapsed < msPerYear) {
                return Math.round(elapsed / msPerMonth) + ' months ago';
            } else {
                return Math.round(elapsed / msPerYear) + ' years ago';
            }
        }
    </script>

    @yield('script')
</body>

</html>
