@extends('layouts.master')

@section('css')
    <link href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
@endsection

@section('content')
    <div class="card">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a href="{{ route('open-tickets.index') }}" class="btn btn-falcon-default btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <div class="ml-3">Create Open Request</div>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('open-tickets.store') }}" enctype="multipart/form-data"
                id="create-open-request">
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <label class="form-label">Jenis Request</label>
                        <select name="id_jenis_request" class="form-control" id="id_jenis_request">
                            @foreach ($jenis_requests as $jr)
                                <option value="{{ $jr->id_jenis_request }}">{{ $jr->jenis_request }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Judul Request</label>
                        <input id="judul_request" type="text" maxlength="50" value="{{ old('judul_request') }}"
                            name="judul_request" class="form-control">
                    </div>
                    <div class="col-6">
                        <label class="form-label">No HP</label>
                        <input type="text" value="{{ old('no_hp') }}" maxlength="13" id="no_hp" name="no_hp"
                            class="form-control">
                    </div>
                    @if ($user->user_category == 2)
                        <div class="col-6">
                            <label class="form-label">Tenant</label>
                            <select class="form-control" id="id_tenant">
                                <option disabled selected>-- Pilih Tenant ---</option>
                                @foreach ($tenants as $tenant)
                                    <option value="{{ $tenant->id_tenant }}">{{ $tenant->nama_tenant }} -
                                        {{ $tenant->email_tenant }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <div class="col-6">
                            <label class="form-label">Unit</label>
                            <select name="id_unit" class="form-control" id="id_unit">
                                @if ($user->user_category != 2)
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->unit->id_unit }}">{{ $unit->unit->nama_unit }} -
                                            {{ $unit->unit->Tower->nama_tower }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @endif
                </div>
                <div class="mb-3">
                    @if ($user->user_category == 2)
                        <div class="col-6">
                            <label class="form-label">Unit</label>
                            <select name="id_unit" class="form-control" id="id_unit">
                                @if ($user->user_category != 2)
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->unit->id_unit }}">{{ $unit->unit->nama_unit }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @endif
                </div>
                <div class="mb-3" id="div_deskripsi_request">
                    <label class="form-label">Deskripsi Request</label>
                    <textarea class="form-control" name="deskripsi_request" id="deskripsi_request" cols="30" rows="10"></textarea>
                </div>
                <div class="mb-3" id="upload_image">
                    <label class="form-label">Upload Foto</label>
                    <input class="form-control" type="file" name="upload_image" />
                </div>

                {{-- =============== Reservation Form ================ --}}
                @include('AdminSite.OpenTicket.reservation-form')
                {{-- =============== End Reservation Form ================ --}}


                {{-- ================= Gigo Form =============== --}}
                @include('AdminSite.OpenTicket.form-gigo')
                {{-- ================= End Gigo Form =============== --}}


                <div class="mt-5 modal-footer">
                    <button type="button" onclick="onSubmit()" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.tiny.cloud/1/mugoo4p5wbijt8fzvzj0042pz1zw9brcq34tenfqnw6wsro6/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        var lastID = 0;
        var goods = [];
        var idGood = 0;

        tinymce.init({
            selector: 'textarea#deskripsi_request', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'code table lists',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
        });
        tinymce.init({
            selector: 'textarea#keterangan_reservation', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'code table lists',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
        });

        $('#id_jenis_request').on('change', function() {
            var id_jenis_request = $(this).val();

            if (id_jenis_request == 4) {
                $('#reservation_form').css({
                    'display': 'block'
                });
                $('#gigo_form').css({
                    'display': 'none'
                });
                $('#div_deskripsi_request').css({
                    'display': 'none'
                });
                $('#upload_image').css({
                    'display': 'none'
                });
            } else if (id_jenis_request == 5) {
                $('#gigo_form').css({
                    'display': 'block'
                });
                $('#reservation_form').css({
                    'display': 'none'
                });
                $('#div_deskripsi_request').css({
                    'display': 'none'
                });
                $('#upload_image').css({
                    'display': 'none'
                });
            } else {
                $('#div_deskripsi_request').css({
                    'display': 'block'
                });
                $('#upload_image').css({
                    'display': 'block'
                });
                $('#gigo_form').css({
                    'display': 'none'
                });
                $('#reservation_form').css({
                    'display': 'none'
                });
            }
        })

        function onSubmit() {
            tinyMCE.triggerSave();

            var judul_request = $('#judul_request').val();
            var no_hp = $('#no_hp').val();
            var deskripsi_request = $('#deskripsi_request').val();
            var id_jenis_request = $('#id_jenis_request').val();
            var id_unit = $('#id_unit').val();

            if (id_jenis_request == 4) {
                value = reservationValue();
                if (!value) {
                    Swal.fire(
                        'Failed!',
                        'Please fill all field',
                        'error'
                    )
                } else {
                    $.ajax({
                        url: '/admin/request-reservations',
                        type: 'POST',
                        data: {
                            value,
                            judul_request: judul_request,
                            no_hp: no_hp,
                            deskripsi_request: deskripsi_request,
                            id_jenis_request: id_jenis_request,
                            id_unit: id_unit,
                        },
                        success: function(resp) {
                            if (resp.status === 'ok') {
                                window.location.href('/admin/open-tickets');
                            }
                        }
                    })
                    console.log(value);
                }
            }
        }

        $('#id_tenant').on('change', function() {
            $('#id_unit').html('');
            var id_tenant = $(this).val();
            $.ajax({
                url: '/admin/units-by-tenant/' + id_tenant,
                type: 'GET',
                success: function(resp) {
                    resp.data.map((item, i) => {
                        $('#id_unit').append(
                            `
                                <option value="${item.unit.id_unit}">${item.unit.nama_unit}</option>
                            `
                        )
                    })
                }
            })
        })
    </script>
@endsection
