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
    <link rel="apple-touch-icon" sizes="180x180" href="https://demo.pro-apps.xyz/assets/img/favicons/apple-touch-icon.png">
    {{-- <link rel="manifest" href="https://demo.pro-apps.xyz/assets/img/favicons/manifest.json"> --}}
    <meta name="msapplication-TileImage" content="https://demo.pro-apps.xyz/assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="https://demo.pro-apps.xyz/assets/css/theme.min.css" rel="stylesheet" id="user-style-default">
</head>

<body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container" data-layout="container">                                              
            <div class="card mb-3">
                <div class="mb-5">
                    <span class="font-sans-serif fw-bolder fs-5 d-inline-block text-primary p-2">Room {{ $room->nama_room }}</span>
                </div>
                <div class="card-body p-4 p-sm-5">                            
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Tower</label>
                                <input class="form-control" value="{{ $room->Tower->nama_tower }}" type="text"
                                    readonly />
                            </div>
                            <div class="col-6">
                            <label class="form-label">Floor</label>
                                <input class="form-control" value="{{ $room->Floor->nama_lantai }}" type="text"
                                    readonly />
                            </div>
                        </div>
                    </div>                                                          
                </div>
            </div>                
            
            <div class="card">
                <div class="mb-5">
                    <span class="font-sans-serif fw-bolder fs-2 d-inline-block text-primary p-2">Inspection Engineering</span>
                </div>
                <div class="card-body p-sm-5">                            
                    <table class="table-striped table-responsive">
                        <thead>
                            <tr>
                                <th class="sort" data-sort="">No</th>
                                <th class="sort" data-sort="nama_room">Equipment</th>
                                <th class="sort" data-sort="nama_room">Schedule</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($room->InspectionEng as $key => $inspection)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{ $inspection->Equipment->equiqment }}</td>
                                    <td>{{ HumanDate($inspection->schedule) }}</td>
                                    <td class="text-center">
                                        <a href="" class="btn btn-sm btn-warning">
                                            <span class="fas fa-pencil-alt fs--2 me-1"></span>
                                        </a>                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>                                                       
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
