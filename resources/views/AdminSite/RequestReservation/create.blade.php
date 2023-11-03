@extends('layouts.master')

@section('css')
    <link href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <form action="{{ route('submit-reservation') }}" method="post" id="submit-reservation-form">
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
                                    <input class="form-control" id="startDateReservation" type="text"
                                        data-options='{"enableTime":true,"dateFormat":"Y-m-d H:i","disableMobile":true}'
                                        readonly />
                                </div>
                                <div class="col-6">
                                    <label class="mb-1">Durasi Acara</label>
                                    <div class="input-group">
                                        <input class="form-control" id="durasi_acara" type="text" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label class="mb-1">Waktu mulai acara</label>
                                    <input class="form-control" id="timeStartEvent" type="text" readonly />
                                </div>
                                <div class="col-6">
                                    <label class="mb-1">Waktu acara berakhir</label>
                                    <input class="form-control" readonly type="text" id="timeEndEvent" />
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label class="mb-1">Ruang reservasi</label>
                                    <input class="form-control" id="ruang_reservasi" readonly type="text">
                                </div>
                                <div class="col-6">
                                    <label class="mb-1">Jenis acara</label>
                                    <input class="form-control" id="jenis_acara" readonly type="text">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1">Keterangan</label>
                            <textarea class="form-control" id="keterangan_reservation"></textarea>
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
                                    <label class="mb-1">Jumlah pembayaran</label>
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
                                    <option {{ isset($id_tiket) ? ($id_tiket == $ticket->id ? 'selected' : '') : '' }}
                                        value="{{ $ticket->id }}">{{ $ticket->no_tiket }}</option>
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
        tinyMCE.init({
            selector: 'textarea#keterangan_reservation',
            readonly: true,
            height: "280"
        });

        var id = '{{ isset($id_tiket) }}';
        if (id) {
            id = '{{ $id_tiket }}'
            showTicket(id)
        }

        function showTicket(id) {
            $.ajax({
                url: '/admin/open-tickets/' + id,
                data: {
                    'data_type': 'json'
                },
                type: 'GET',
                success: function(data) {
                    $('#ticket_detail').css('display', 'block')
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
        }

        // $.ajax({
        //     url: '/admin/reservation/get/booked-date',
        //     type: 'GET',
        //     data: {
        //         startdate: `${selectdate}`,
        //         startdatetime: `${selectdate} ${startTime}`,
        //         enddatetime: `${selectdate} ${endTime}`
        //     },
        //     success: function(resp) {
        //         var data = resp.data;
        //         if (data.length > 0) {
        //             $('#event-lists').html("");
        //             data.map((event, i) => {
        //                 $('#event-lists').append(`
    //                                 <p>Event start ${formatDate(event.waktu_mulai)}, event end ${formatDate(event.waktu_akhir)}</p>
    //                             `)
        //             })
        //             $('#modalInfo').modal('show');
        //         } else {
        //             $("#submit-reservation-form").submit();
        //         }
        //     }
        // })

        function onSubmit() {
            var isDeposit = $('#is_deposit').val();
            var jumlahDeposit = $('#jumlah_deposit').val();

            if (isDeposit == 1 && !jumlahDeposit) {
                Swal.fire(
                    'Failed!',
                    'Please fill all field',
                    'error'
                )
            } else {
                $("#submit-reservation-form").submit();
            }
        }

        function formatDate(date) {
            var date = new Date(date);

            return `${date.getDate()}-${date.getMonth() + 1}-${date.getFullYear()} ${date.getHours()}:${date.getMinutes()}`;
        }

        $('#select_ticket').on('change', function() {
            var id = $(this).val()
            showTicket(id);
        })

        function showTicket(id) {
            $.ajax({
                url: '/admin/open-ticket-rsv/' + id,
                data: {
                    'data_type': 'json'
                },
                type: 'GET',
                success: function(data) {
                    var descRsv = data.data.request_reservation.keterangan

                    $('#startDateReservation').val(data.data.request_reservation.tgl_request_reservation);
                    $('#durasi_acara').val(data.data.request_reservation.durasi_acara);
                    $('#timeStartEvent').val(data.data.request_reservation.waktu_mulai);
                    $('#timeEndEvent').val(data.data.request_reservation.waktu_akhir);
                    $('#ruang_reservasi').val(data.data.request_reservation.ruang_reservation
                        .ruang_reservation);
                    $('#jenis_acara').val(data.data.request_reservation.jenis_acara.jenis_acara);

                    tinyMCE.get('keterangan_reservation').setContent(data.data.request_reservation
                        .keterangan);

                    $('#ticket_detail').css('display', 'block')
                    $('#reservation_detail').css('display', 'block')

                    if (descRsv) {
                        $('#ticket_detail_desc').html(descRsv);
                    } else {
                        $('#ticket_detail_desc').html(data.data.deskripsi_request);
                    }

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
        }

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
