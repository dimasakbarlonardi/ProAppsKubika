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
                            <h5 class="mb-2 mb-md-0">Work Permit #{{ $wp->no_work_permit }}</h5>
                        </div>
                        <div class="col-auto">
                            <button id="create_pdf" class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0"
                                type="button">
                                <span class="fas fa-arrow-down me-1"> </span>Download
                                (.pdf)</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3" id="form-print-out">
                <div class="card-body">
                    <div class="row align-items-center text-center mb-3">
                        <div class="col text-sm-start">
                            <img src="/assets/img/icons/spot-illustrations/proapps.png" alt="invoice" width="150" />
                        </div>
                        <div class="col text-center mt-3">
                            <h3 class="mb-3">SURAT IZIN KERJA</h3>
                            <h4>Park Royale</h4>
                            <h6>No. #{{ $wp->no_work_permit }}</h6>
                        </div>
                        <div class="col text-sm-end mt-3 mt-sm-0">
                            <img src="/assets/img/icons/spot-illustrations/proapps.png" alt="invoice" width="150" />
                        </div>
                    </div>
                    <div class="row align-items-center text-center p-3" style="font-size: 14px">
                        <div class="col-10">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>NAMA PENGHUNI / PEMILIK</td>
                                        <td>:</td>
                                        <td>{{ $wp->Ticket->Tenant->nama_tenant }}</td>
                                    </tr>
                                    <tr>
                                        <td>LOKASI / TOWER / UNIT</td>
                                        <td>:</td>
                                        <td>{{ $wp->Ticket->Unit->Tower->nama_tower }} /
                                            {{ $wp->Ticket->Unit->nama_unit }}</td>
                                    </tr>
                                    <tr>
                                        <td>PERIODE</td>
                                        <td>:</td>
                                        <td>{{ HumanDateTime($wp->RequestPermit->tgl_mulai) }} s/d
                                            {{ HumanDateTime($wp->RequestPermit->tgl_akhir) }}</td>
                                    </tr>
                                    <tr>
                                        <td>PERUSAHAAN / KONTRAKTOR</td>
                                        <td>:</td>
                                        <td>{{ $wp->RequestPermit->nama_kontraktor }} </td>
                                    </tr>
                                    <tr>
                                        <td>JUMLAH PERSONIL</td>
                                        <td>:</td>
                                        <td>
                                            @php
                                                $data = json_decode($wp->RequestPermit->RPDetail->data);
                                                $personels = json_decode($data);
                                            @endphp
                                            {{ count($personels->personels) }} Orang
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>JENIS PEKERJAAN / KEGIATAN</td>
                                        <td>:</td>
                                        <td>{{ $wp->RequestPermit->JenisPekerjaan->jenis_pekerjaan }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6">

                        </div>
                    </div>
                </div>
                <div class="row align-items-center text-center" style="margin-top: -2%">
                    <div class="col">

                    </div>
                    <div class="col">

                    </div>
                    <div class="col">
                        <h6>Jakarta, {{ HumanDate($wp->created_at) }}</h6>
                    </div>
                </div>
                <div class="p-3">
                    <table class="table table-bordered">
                        <thead>
                            <div class="row">
                                <div class="col-4" style="width: 10px">
                                    <th width="25%" class="text-center border">
                                        <span style="font-size: 12px">
                                            SECURITY
                                        </span>
                                    </th>
                                </div>
                                <div class="col-4">
                                    <th width="25%" class="text-center border">
                                        <span style="font-size: 12px">
                                            FIT OUT
                                        </span>
                                    </th>
                                </div>
                                <div width="25%" class="col-4">
                                    <th class="text-center border">
                                        <span style="font-size: 12px">
                                            ENGINEERING
                                        </span>
                                    </th>
                                </div>
                                <div width="25%" class="col-4">
                                    <th class="text-center border">
                                        <span style="font-size: 12px">
                                            BUILDING MANAGER
                                        </span>
                                    </th>
                                </div>
                            </div>
                        </thead>
                        <tbody>
                            <tr>
                                <th style="height: 80px" class="border"></th>
                                <td style="height: 80px" class="border"></td>
                                <td style="height: 80px" class="border"></td>
                                <td style="height: 80px" class="border"></td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="margin-left: 5%">
                        <span class="mb-2"><u><b>Kententuan : </b></u></span> <br>
                        <div class="ml-3" style="font-size: 12px;">
                            <span class="text-muted small">
                                - Ijin pekerjaan perbaikan ini harus dibawa oleh pekerja dan
                                ditempelkan di pintu utama, badan pengelola berhak menghentikan pekerjaan apabila tidak ada
                                ijin
                                kerja.
                            </span> <br>
                            <span class="text-muted small">
                                - Pintu utama unit hunian harus dalam keadaan tertutup selama
                                proses
                                pekerjaan perbaikan unit.
                            </span> <br>
                            <span class="text-muted small">
                                - Sampah dan puing pekerjaan perbaikan harus dibuang ke luar
                                spanngkungan
                                Gading Icon City Apartment dengan menggunakan kantong sampah.
                            </span> <br>
                            <span class="text-muted small">
                                - Dilarang membuang sampah pekerjaan perbaikan ke ruang sampah
                                unit
                                hunian.
                            </span> <br>
                            <span class="text-muted small">
                                - Harap memperpanjang masa ijin kerja kepada badan pengelola,
                                jika
                                pekerjaan melebihi tanggal masa ijin kerja yang diberikan.</span> <br>
                            <span class="text-muted small">
                                - Segera laporkan kepada badan pengelola jika pekerjaan telah
                                selesai
                                dilaksanakan.</span>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
    <script>
        var letterID = '{{ $wp->no_work_permit }}';
        var form = $('#form-print-out'),
            cache_width = form.width(),
            a4 = [841.89, 595.28]; // for a4 size paper width and height

        $('#create_pdf').on('click', function() {
            $('body').scrollTop(0);
            createPDF();
        });

        function createPDF() {
            getCanvas().then(function(canvas) {
                var
                    img = canvas.toDataURL("image/png"),
                    doc = new jsPDF({
                        orientation: 'l',
                        unit: 'px',
                        format: 'a4',
                    });
                doc.addImage(img, 'JPEG', 20, 20);
                doc.save(`SURAT IZIN KERJA - ${String(letterID)}.pdf`);
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
