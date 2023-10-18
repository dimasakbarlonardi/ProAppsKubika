<!DOCTYPE html>
<html data-bs-theme="light" lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Proapps | Utility Usage Recording - Water</title>

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="https://dev.pro-apps.xyz/assets/img/favicons/apple-touch-icon.png">
    {{-- <link rel="manifest" href="https://dev.pro-apps.xyz/assets/img/favicons/manifest.json"> --}}
    <meta name="msapplication-TileImage" content="https://dev.pro-apps.xyz/assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="https://dev.pro-apps.xyz/assets/css/theme.min.css" rel="stylesheet" id="user-style-default">
</head>

<body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <div class="row flex-center min-vh-100 py-6">
                <div class="col-sm-12 col-md-10 col-lg-8 col-xl-10 col-xxl-4 mb-5">
                    <div class="mb-5">
                        <span class="font-sans-serif fw-bolder fs-5 d-inline-block text-primary">Utility Usage Recording
                            - Water</span>
                    </div>
                    <div class="card">
                        <div class="card-body p-4 p-sm-5">

                            <form action="">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Unit</label>
                                            <input class="form-control" value="" type="text"
                                                readonly />
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Period</label>
                                            <select class="form-control" name="periode_bulan">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Previous</label>
                                            <input class="form-control" name="previous" type="number"
                                                value="" />
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Current</label>
                                            <input class="form-control"
                                                min=""
                                                name="current" type="number" placeholder="111" />
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 mt-5">
                                    <button class="btn btn-primary d-block w-100 mt-3" type="submit">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main><!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="{{ url('assets/vendors/popper/popper.min.js') }}"></script>
    <script src="{{ url('assets/vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ url('assets/vendors/is/is.min.js') }}"></script>
    <script src="{{ url('assets/vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ url('assets/vendors/lodash/lodash.min.js') }}"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    @include('sweetalert::alert')
    <script></script>
</body>

</html>
