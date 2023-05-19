<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Falcon | Dashboard &amp; Web App Template</title>
    <link href="{{ asset('assets/css/theme.min.css') }}" rel="stylesheet" id="style-default">
</head>

<body>
    <main class="main" id="top">
        <div class="container-fluid">
            <div class="row min-vh-100 flex-center g-0">
                <div class="col-lg-8 col-xxl-5 py-3 position-relative">
                    <img class="bg-auth-circle-shape"
                        src="{{ asset('assets/img/icons/spot-illustrations/bg-shape.png') }}" alt=""
                        width="250">
                    <img class="bg-auth-circle-shape-2"
                        src="{{ asset('assets/img/icons/spot-illustrations/shape-1.png') }}" alt=""
                        width="150">
                    <div class="card overflow-hidden z-index-1">
                        <div class="card-body p-0">
                            <div class="row g-0 h-100">
                                <div class="col-md-5 text-center">
                                    <img src="{{ asset('/assets/img/login_image.png') }}" alt="logo_image"
                                        width="105%" height="100%">
                                </div>
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('sweetalert::alert')

</body>

</html>
