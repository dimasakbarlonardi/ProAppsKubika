<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    @yield('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Proapps | Property Management System</title>
    <link href="{{ asset('assets/css/theme.min.css') }}" rel="stylesheet" id="style-default">
</head>

<body>
    <main class="main" id="top">
        <div class="container-fluid">
            <div class="row min-vh-100 flex-center g-0">
                <div class="col-lg-8 col-xxl-5 py-3 position-relative">
                    <div class="">
                        <div class="card-body p-0">
                            <div class="row g-0 h-100 reverse">
                            <div class="col-md-5 text-center">
                                <div class="image-container">
                                    <img src="{{ asset('/assets/img/Login.png') }}" alt="background_image" width="400px" height="500px">
                                </div>
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
    @yield('script')
</body>

</html>
