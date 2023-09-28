@extends('layouts.master')

@section('css')
    <script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <link href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <form action="{{ route('request-reservations.store') }}" method="post" style="display: inline">
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
                                        id="datetimepicker" type="text" placeholder="d/m/y"
                                        data-options='{"dateFormat":"Y-m-d","disableMobile":true}' />
                                </div>
                                <div class="col-6">
                                    <label class="mb-1">Durasi Acara</label>
                                    <div class="input-group">
                                        <input class="form-control" name="durasi_acara" type="number">
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
                                    <input class="form-control datetimepicker" name="waktu_mulai" id="datetimepicker"
                                        type="text" placeholder="d/m/y H:i"
                                        data-options='{"enableTime":true,"dateFormat":"Y-m-d H:i","disableMobile":true}' />
                                </div>
                                <div class="col-6">
                                    <label class="mb-1">Waktu acara berakhir</label>
                                    <input class="form-control datetimepicker" name="waktu_akhir" id="datetimepicker"
                                        type="text" placeholder="d/m/y H:i"
                                        data-options='{"enableTime":true,"dateFormat":"Y-m-d H:i","disableMobile":true}' />
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                {{-- <div class="col-6">
                                    <label class="mb-1">Tipe reservasi</label>
                                    <select class="form-control" name="id_type_reservation">
                                        <option selected disable>--- Pilih tipe reservasi ---</option>
                                        @foreach ($typeRsv as $type)
                                            <option value="{{ $type->id_type_reservation }}">{{ $type->type_reservation }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="col-6">
                                    <label class="mb-1">Ruang reservasi</label>
                                    <select class="form-control" name="id_ruang_reservation">
                                        <option selected disable>--- Ruang reservasi ---</option>
                                        @foreach ($ruangRsv as $ruang)
                                            <option value="{{ $ruang->id_ruang_reservation }}">{{ $ruang->ruang_reservation }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="mb-1">Jenis acara</label>
                                    <select class="form-control" name="id_jenis_acara">
                                        <option selected disable>--- Pilih jenis acara ---</option>
                                        @foreach ($jenisAcara as $acara)
                                            <option value="{{ $acara->id_jenis_acara }}">{{ $acara->jenis_acara }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label class="mb-1">Jenis acara</label>
                                    <select class="form-control" name="id_jenis_acara">
                                        <option selected disable>--- Pilih jenis acara ---</option>
                                        @foreach ($jenisAcara as $acara)
                                            <option value="{{ $acara->id_jenis_acara }}">{{ $acara->jenis_acara }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div> --}}
                        <div class="mb-3">
                            <label class="mb-1">Keterangan</label>
                            <textarea class="form-control" name="keterangan" id="keterangan_reservation"></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label class="mb-1">Jumlah deposit</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text" id="addon-wrapping">Rp</span>
                                        <input class="form-control" type="number" name="jumlah_deposit" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="row g-3 position-sticky top-0">
                    <div class="col-md-6 col-xl-12 rounded-3">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Properties</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-4 mt-n2"><label class="mb-1">Tickets</label>
                                    <select name="no_tiket" class="form-select form-select-sm" id="select_ticket">
                                        <option disabled selected>--Pilih Ticket ---</option>
                                        @foreach ($tickets as $ticket)
                                            <option value="{{ $ticket->id }}">{{ $ticket->no_tiket }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-top border-200 py-x1">
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
    <script>
        tinyMCE.init({
            selector: 'textarea#keterangan_reservation',

            height: "280"
        });
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
