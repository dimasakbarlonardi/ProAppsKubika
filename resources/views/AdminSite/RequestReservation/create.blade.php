@extends('layouts.master')

@section('css')
    <script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <link href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <form action="{{ route('request-reservations.store') }}" method="post" id="create-reservation-form">
        @csrf
        <div class="row g-3">
            <div class="col-9">
                <div class="card">
                    <div class="card-header d-flex flex-between-center">
                        <button class="btn btn-falcon-default btn-sm" type="button">
                            <span class="fas fa-arrow-left"></span>
                        </button>
                    </div>
                </div>
                <div class="card mt-3" style="display: none" id="ticket_detail">
                    <div class="card-body">
                        <div class="request" id="ticket_head">

                        </div>
                        <div class="pt-4">
                            <h6 class="mb-3 fw-semi-bold text-1000" id="ticket_detail_heading"></h6>
                            <div id="ticket_detail_desc">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3" style="display: none" id="reservation_detail">
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label class="mb-1">Tanggal request reservasi</label>
                                    <input class="form-control datetimepicker" name="tgl_request_reservation"
                                        id="startDateReservation" type="text" placeholder="d/m/y"
                                        data-options='{"dateFormat":"Y-m-d","disableMobile":true}' />
                                </div>
                                <div class="col-6">
                                    <label class="mb-1">Durasi Acara</label>
                                    <div class="input-group">
                                        <input class="form-control" id="durasi_acara" name="durasi_acara" type="number">
                                        <select class="form-control" name="satuan_durasi_acara">
                                            <option value="Jam">
                                                <span class="input-group-text">Jam</span>
                                            </option>
                                            <option value="Hari">
                                                <span class="input-group-text">Hari</span>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label class="mb-1">Waktu mulai acara</label>
                                    <input class="form-control datetimepicker" name="waktu_mulai" id="timeStartEvent"
                                        type="text" placeholder="Hour : Minute"
                                        data-options='{"enableTime":true,"dateFormat":"Y-m-d H:i","disableMobile":true}' />
                                </div>
                                <div class="col-6">
                                    <label class="mb-1">Waktu acara berakhir</label>
                                    <input class="form-control datetimepicker" name="waktu_akhir" id="timeEndEvent"
                                        type="text" placeholder="Hour : Minute"
                                        data-options='{"enableTime":true,"dateFormat":"Y-m-d H:i","disableMobile":false}' />
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label class="mb-1">Ruang reservasi</label>
                                    <select class="form-control" name="id_ruang_reservation" id="id_ruang_reservation">
                                        <option selected disable>--- Ruang reservasi ---</option>
                                        @foreach ($ruangRsv as $ruang)
                                            <option value="{{ $ruang->id_ruang_reservation }}">
                                                {{ $ruang->ruang_reservation }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="mb-1">Jenis acara</label>
                                    <select class="form-control" name="id_jenis_acara" id="id_jenis_acara">
                                        <option selected disable>--- Pilih jenis acara ---</option>
                                        @foreach ($jenisAcara as $acara)
                                            <option value="{{ $acara->id_jenis_acara }}">{{ $acara->jenis_acara }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1">Keterangan</label>
                            <textarea class="form-control" name="keterangan" id="keterangan_reservation"></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label class="mb-1">Status Reservasi</label>
                                    <select name="is_deposit" class="form-control" id="is_deposit">
                                        <option value="1">Berbayar</option>
                                        <option value="">Tidak berbayar</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="mb-1">Jumlah deposit</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text" id="addon-wrapping">Rp</span>
                                        <input class="form-control" id="jumlah_deposit" type="number"
                                            name="jumlah_deposit" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Properties</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-4 mt-n2"><label class="mb-1">Request</label>
                            <select name="no_tiket" class="form-select form-select-sm" id="select_ticket">
                                <option disabled selected>-- Select request ---</option>
                                @foreach ($tickets as $ticket)
                                    <option value="{{ $ticket->id }}">{{ $ticket->no_tiket }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top border-200 py-x1">
                    <button type="button" onclick="onSubmit()" class="btn btn-primary w-100">Submit</button>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
            <div class="modal-content position-relative">
                <div class="modal-body p-0">
                    <div class="rounded-top-lg py-3 ps-4 pe-6">
                        <h4 class="mb-1" id="modalExampleDemoLabel">Sorry there's event on selected date</h4>
                    </div>
                    <div class="p-4 pb-0" id="event-lists">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
    <script>
        flatpickr("#startDateReservation", {
            dateFormat: "Y-m-d",
            minDate: "today",
            altInput: true,
            altFormat: "F j, Y"
        });

        flatpickr("#timeStartEvent", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
        });

        flatpickr("#timeEndEvent", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
        });


        tinyMCE.init({
            selector: 'textarea#keterangan_reservation',

            height: "280"
        });

        function onSubmit() {
            var selectdate = $('#startDateReservation').val();
            var durasiAcara = $('#durasi_acara').val();
            var ruangReservasi = $('#id_ruang_reservation').val();
            var jenisAcara = $('#id_jenis_acara').val();
            var isDeposit = $('#is_deposit').val();
            var jumlahDeposit = $('#jumlah_deposit').val();

            var startTime = $('#timeStartEvent').val();
            var endTime = $('#timeEndEvent').val();

            if (!selectdate || !durasiAcara || !jenisAcara || !ruangReservasi || !isDeposit || !jumlahDeposit || !
                startTime || !endTime) {
                Swal.fire(
                    'Failed!',
                    'Please fill all field',
                    'error'
                )
            } else {
                $.ajax({
                    url: '/admin/reservation/get/booked-date',
                    type: 'GET',
                    data: {
                        startdate: `${selectdate}`,
                        startdatetime: `${selectdate} ${startTime}`,
                        enddatetime: `${selectdate} ${endTime}`
                    },
                    success: function(resp) {
                        var data = resp.data;
                        if (data.length > 0) {
                            $('#event-lists').html("");
                            data.map((event, i) => {
                                $('#event-lists').append(`
                                    <p>Event start ${formatDate(event.waktu_mulai)}, event end ${formatDate(event.waktu_akhir)}</p>
                                `)
                            })
                            $('#modalInfo').modal('show');
                        } else {
                            $("#create-reservation-form").submit();
                        }
                    }
                })
            }
        }

        function formatDate(date) {
            var date = new Date(date);

            return `${date.getDate()}-${date.getMonth() + 1}-${date.getFullYear()} ${date.getHours()}:${date.getMinutes()}`;
        }

        $('#select_ticket').on('change', function() {
            var id = $(this).val()
            $.ajax({
                url: '/admin/open-tickets/' + id,
                data: {
                    'data_type': 'json'
                },
                type: 'GET',
                success: function(data) {
                    $('#ticket_detail').css('display', 'block')
                    $('#reservation_detail').css('display', 'block')
                    $('#ticket_detail_desc').html(data.data.deskripsi_request)
                    $('#ticket_detail_heading').html(data.data.judul_request)
                    $('#ticket_head').html(`
                            <div class="d-md-flex d-xl-inline-block d-xxl-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar avatar-2xl">
                                        <img class="rounded-circle" src="${data.data.tenant.profile_picture}" alt="${data.data.tenant.profile_picture}" />
                                    </div>
                                    <p class="mb-0"><a class="fw-semi-bold mb-0 text-800"
                                            href="#">${data.data.tenant.nama_tenant}</a>
                                        <a class="mb-0 fs--1 d-block text-500"
                                            href="mailto:${data.data.tenant.email_tenant}">${data.data.tenant.email_tenant}</a>
                                    </p>
                                </div>
                                <p class="mb-0 fs--2 fs-sm--1 fw-semi-bold mt-2 mt-md-0 mt-xl-2 mt-xxl-0 ms-5">
                                    ${new Date(data.data.created_at).toDateString()}
                                    <span class="mx-1">|</span><span class="fst-italic">${new Date(data.data.created_at).toLocaleTimeString()} (${timeDifference(new Date(), new Date(data.data.created_at))})</span></p>
                            </div>
                        `)
                }
            })
        })

        $('#is_deposit').on('change', function() {
            if ($(this).val() == 0) {
                $('#jumlah_deposit').attr("disabled", true);
            } else {
                $('#jumlah_deposit').attr("disabled", false);
            }
        })

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
@endsection
