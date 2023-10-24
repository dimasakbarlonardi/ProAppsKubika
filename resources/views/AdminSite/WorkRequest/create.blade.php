@extends('layouts.master')

@section('css')
    <script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection

@section('content')
    <form action="{{ route('work-requests.store') }}" method="post" style="display: inline">
        @csrf
        <div class="row">
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
            </div>

            <div class="col-3">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Properties</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-4 mt-n2"><label class="mb-1">Requests</label>
                            <select name="no_tiket" class="form-select form-select-sm" id="select_ticket">
                                <option disabled selected>-- Select Request ---</option>
                                @foreach ($tickets as $ticket)
                                    <option {{ isset($id_tiket) ? ($id_tiket == $ticket->id ? 'selected' : '') : '' }} value="{{ $ticket->id }}">{{ $ticket->no_tiket }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4 mt-n2"><label class="mb-1">Work Relation</label>
                            <select name="id_work_relation" class="form-select form-select-sm">
                                <option disabled selected>--Pilih Work Relation ---</option>
                                @foreach ($work_relations as $work_relation)
                                    <option value="{{ $work_relation->id_work_relation }}">
                                        {{ $work_relation->work_relation }}</option>
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
    </form>
@endsection

@section('script')
    <script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <script>
        tinymce.init({
            selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'code table lists',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
        });
    </script>
    <script>
        $('document').ready(function() {
            $('#select_ticket').select2({
                theme: 'bootstrap-5'
            });
            var id = '{{ isset($id_tiket) }}';
            if (id) {
                id = '{{ $id_tiket }}'
                showTicket(id)
            }
        })
        $('#select_ticket').on('change', function() {
            var id = $(this).val();

            showTicket(id);
        })

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
