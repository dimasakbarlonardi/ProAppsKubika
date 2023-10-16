<!DOCTYPE html>
<html data-bs-theme="light" lang="en-US" dir="ltr">
<html data-bs-theme="light" lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Work Permit</title>

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/apple-touch-icon.png">
    <meta name="msapplication-TileImage" content="assets/img/favicons/mstile-150x150.png">
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

<body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <div class="container">
        <div class="mt-5">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md">
                            <h5 class="mb-2 mb-md-0">Reservation #</h5>
                        </div>
                        <div class="col-auto">
                            <button id="create_pdf" class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0" type="button">
                                <span class="fas fa-arrow-down me-1"> </span>Download
                                (.pdf)</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3" id="form-print-out">
                <div class="card-body">
                    <div class="row align-items-center text-center mb-3">
                        <div class="col-sm-6 text-sm-start"><img src="/assets/img/icons/spot-illustrations/proapps.png"
                                alt="invoice" width="150" /></div>
                        <div class="col text-sm-end mt-3 mt-sm-0">
                            <h2 class="mb-3">Invoice</h2>
                            <h5>Proapps</h5>
                            <p class="fs--1 mb-0">
                                Harton Tower Citihub, 6th floor <br>
                                Jl. Boulevard Artha Gading Blok D No. 3, <br>
                                Kelapa Gading Barat
                                Jakarta Utara, 14240
                            </p>
                        </div>
                        <div class="col-12">
                            <hr />
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-500">Invoice to</h6>
                            <h5></h5>
                            <p class="fs--1">

                            </p>
                            <p class="fs--1"><a href="mailto:"></a><br /><a href="tel:444466667777"></a></p>
                        </div>
                        <div class="col-sm-auto ms-auto">
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless fs--1">
                                    <tbody>
                                        <tr>
                                            <th class="text-sm-end">Invoice Date:</th>
                                            <td>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive scrollbar mt-4 fs--1">
                        <table class="table border-bottom">
                            <thead data-bs-theme="light">
                                <tr class="bg-primary text-white dark__bg-1000">
                                    <th class="border-0">Products</th>
                                    <th class="border-0 text-center">Quantity</th>
                                    <th class="border-0 text-end">Rate</th>
                                    <th class="border-0 text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="alert alert-success my-3">
                                    <td class="align-middle">
                                        <h6 class="mb-0 text-nowrap">Reservation Deposit Bills</h6>
                                    </td>
                                    <td class="align-middle text-center">
                                    </td>
                                    <td class="align-middle text-end"></td>
                                    <td class="align-middle text-end"></td>
                                </tr>
                                <tr>
                                    <td class="align-middle">
                                        Room Reservation
                                    </td>
                                    <td>:</td>
                                    <td class="align-middle">
                                        <p class="mb-0">

                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">
                                        Kind Reservation
                                    </td>
                                    <td>:</td>
                                    <td class="align-middle">
                                        <p class="mb-0">

                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">
                                        Event Duration
                                    </td>
                                    <td>:</td>
                                    <td class="align-middle">
                                        <p class="mb-0">

                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">
                                        Deposit
                                    </td>
                                    <td>:</td>
                                    <td class="align-middle">
                                        <p class="mb-0">

                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="row g-0 justify-content-between fs--1 mt-4 mb-3">
                <div class="col-12 col-sm-auto text-center">
                    <p class="mb-0 text-600">Thank you for creating with Falcon <span class="d-none d-sm-inline-block">|
                        </span><br class="d-sm-none" /> 2022 &copy; <a href="https://themewagon.com">Themewagon</a>
                    </p>
                </div>
                <div class="col-12 col-sm-auto text-center">
                    <p class="mb-0 text-600">v3.14.0</p>
                </div>
            </div>
        </footer>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
    <script>
        var form = $('#form-print-out'),
            cache_width = form.width(),
            a4 = [595.28, 841.89]; // for a4 size paper width and height

        $('#create_pdf').on('click', function() {
            $('body').scrollTop(0);
            createPDF();
        });

        function createPDF() {
            getCanvas().then(function(canvas) {
                var
                    img = canvas.toDataURL("image/png"),
                    doc = new jsPDF({
                        unit: 'px',
                        format: 'a4'
                    });
                doc.addImage(img, 'JPEG', 20, 20);
                doc.save('work-permit-approval.pdf');
                form.width(cache_width);
            });
        }

        function getCanvas() {
            form.width((a4[0] * 1.33333) - 80).css('max-width', 'none');
            return html2canvas(form, {
                imageTimeout: 2000,
                removeContainer: true
            });
        }
    </script>
</body>

</html>
