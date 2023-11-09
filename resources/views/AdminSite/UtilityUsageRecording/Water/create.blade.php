<!DOCTYPE html>
<html data-bs-theme="light" lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Proapps | Utility Usage Recording - Water</title>

    <link rel="apple-touch-icon" sizes="180x180" href="https://dev.pro-apps.xyz/assets/img/favicons/apple-touch-icon.png">
    {{-- <link rel="manifest" href="https://dev.pro-apps.xyz/assets/img/favicons/manifest.json"> --}}
    <meta name="msapplication-TileImage" content="https://dev.pro-apps.xyz/assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">


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
                            @php
                                $months = [['value' => '01', 'name' => 'January', 'isDisabled' => false], ['value' => '02', 'name' => 'February', 'isDisabled' => false], ['value' => '03', 'name' => 'March', 'isDisabled' => false], ['value' => '04', 'name' => 'April', 'isDisabled' => false], ['value' => '05', 'name' => 'May', 'isDisabled' => false], ['value' => '06', 'name' => 'June', 'isDisabled' => false], ['value' => '07', 'name' => 'July', 'isDisabled' => false], ['value' => '08', 'name' => 'August', 'isDisabled' => false], ['value' => '09', 'name' => 'September', 'isDisabled' => false], ['value' => '10', 'name' => 'Oktober', 'isDisabled' => false], ['value' => '11', 'name' => 'November', 'isDisabled' => false], ['value' => '12', 'name' => 'December', 'isDisabled' => false]];
                                foreach ($unit->allWaterUUSbyYear as $uus) {
                                    foreach ($months as $key => $month) {
                                        if ($month['value'] == $uus->periode_bulan) {
                                            $months[$key]['isDisabled'] = true;
                                        }
                                    }
                                }
                            @endphp
                            <form action="{{ route('store-usr-water', [$unit->id_unit, $token]) }}"
                                enctype="multipart/form-data" method="post" id="water-usage-form">
                                @csrf
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Unit</label>
                                            <input class="form-control" value="{{ $unit->nama_unit }}" type="text"
                                                readonly />
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Period</label>
                                            <select class="form-control" name="periode_bulan" id="periode_bulan">
                                                @foreach ($months as $month)
                                                    <option id="pb-January" value="{{ $month['value'] }}"
                                                        {{ $month['value'] != \Carbon\Carbon::now()->format('m') ? 'disabled' : '' }}>
                                                        {{ $month['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Previous</label>
                                            <input class="form-control" name="previous" type="number"
                                                value="{{ count($unit->waterUUS) > 0 ? $unit->waterUUS[0]->nomor_air_akhir : 0 }}"
                                                {{ count($unit->waterUUS) > 0 ? 'readonly' : '' }} id="previous"/>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Current</label>
                                            <input class="form-control"
                                                min="{{ count($unit->waterUUS) > 0 ? $unit->waterUUS[0]->nomor_air_akhir : 0 }}"
                                                name="current" type="number" placeholder="111" id="value_current" />
                                        </div>
                                    </div>
                                </div>
                                <input type="file" id="imageInput" name="image" style="display: none;">
                                <input type="hidden" id="imageData" name="imageData">
                                <div class="d-flex justify-content-center mt-3">
                                    <video id="camera" autoplay style="display: none;" width="400"
                                        class="rounded"></video>
                                    <img id="capturedImage" style="display: none;" width="400" class="rounded">
                                </div>
                                <div class="d-flex justify-content-center mt-2">
                                    <button type="button" id="startButton" class="btn btn-info">Take Picture</button>
                                    <button type="button" id="retakeButton" style="display: none"
                                        class="btn btn-warning">Retake</button>
                                    <button type="button" id="captureButton" style="display: none"
                                        class="btn btn-success">Capture</button>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary d-block w-100 mt-3" type="button"
                                        onclick="onSubmit()">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function onSubmit() {
            const unitID = '{{ $unit->id_unit }}';
            const token = '{{ $token }}';
            var value_current = $('#value_current').val();
            var periode_bulan = $('#periode_bulan').val();
            var previous = $('#previous').val();
            var imageData = $('#imageData').val();

            Swal.fire({
                title: 'Are you sure?',
                icon: 'info',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (!imageData) {
                    Swal.fire({
                        title: 'Please take a picture',
                        icon: 'info',
                        confirmButtonText: 'Yes!'
                    })
                    return;
                }
                if (!value_current) {
                    Swal.fire({
                        title: 'Please insert current value',
                        icon: 'info',
                        confirmButtonText: 'Yes!'
                    })
                } else {
                    $.ajax({
                        url: `/api/v1/store/insert-water/${unitID}/${token}`,
                        type: 'post',
                        data: {
                            'periode_bulan': periode_bulan,
                            'previous': previous,
                            'current': value_current,
                            'imageData': imageData,
                        },
                        success: function(data) {
                            if (data.status === 'ok') {
                                Swal.fire(
                                    'Success!',
                                    'Success add record!',
                                    'success'
                                ).then(() => window.location.reload())
                            } else {
                                Swal.fire(
                                    'Sorry!',
                                    'Data is already exist for this month!',
                                    'info'
                                ).then(() => window.location.reload())
                            }
                        }
                    })

                }
            })
        }
    </script>

    <script>
        const videoElement = document.getElementById("camera");
        const startButton = document.getElementById("startButton");
        const captureButton = document.getElementById("captureButton");
        const imageInput = document.getElementById("imageInput");
        const imageDataInput = document.getElementById("imageData");
        const imageForm = document.getElementById("water-usage-form");
        const capturedImage = document.getElementById("capturedImage");
        const retakeButton = document.getElementById("retakeButton");

        startButton.addEventListener("click", () => {
            videoElement.style.display = "block";
            capturedImage.style.display = "none";
            startButton.style.display = "none";
            captureButton.style.display = "block";

            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then((stream) => {
                    videoElement.srcObject = stream;
                })
                .catch((error) => {
                    console.error("Error accessing the camera:", error);
                });
        });

        retakeButton.addEventListener("click", () => {
            videoElement.style.display = "block";
            capturedImage.style.display = "none";
            startButton.style.display = "none";
            retakeButton.style.display = "none";
            captureButton.style.display = "block";

            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then((stream) => {
                    videoElement.srcObject = stream;
                })
                .catch((error) => {
                    console.error("Error accessing the camera:", error);
                });
        });

        captureButton.addEventListener("click", () => {
            const canvas = document.createElement("canvas");
            canvas.width = videoElement.videoWidth;
            canvas.height = videoElement.videoHeight;
            canvas.getContext("2d").drawImage(videoElement, 0, 0, canvas.width, canvas.height);

            const dataURL = canvas.toDataURL("image/png");

            imageDataInput.value = dataURL;

            videoElement.style.display = "none";
            capturedImage.style.display = "block";
            retakeButton.style.display = "block";
            captureButton.style.display = "none";

            canvas.width = videoElement.videoWidth;
            canvas.height = videoElement.videoHeight;
            canvas.getContext("2d").drawImage(videoElement, 0, 0, canvas.width, canvas.height);

            capturedImage.src = canvas.toDataURL("image/png");
        });
    </script>
</body>

</html>
