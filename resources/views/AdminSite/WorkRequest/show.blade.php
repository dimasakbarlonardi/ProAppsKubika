@extends('layouts.master')

@section('css')
    <script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
@endsection

@section('content')
    <form action="{{ route('work-requests.update', $wr->id) }}" method="post" id="form-show-wr">
        @method('PUT')
        @csrf
        <div class="row g-3">
            <div class="col-9">
                <div class="card">
                    <div class="card">
                        <div class="card-header d-flex flex-between-center">
                            <h6 class="mb-0">Deskripsi Request</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control" name="deskripsi_wr" id="deskripsi_wr_tenant" disabled>
                            {!! $wr->Ticket->deskripsi_request !!}
                        </textarea>
                    </div>
                </div>
                @if ($wr->status_request != 'PENDING')
                    <div class="card mt-2" id="deskripsi_wr_section">
                        <div class="card">
                            <div class="card-header d-flex flex-between-center">
                                <h6 class="mb-0">Deskripsi Work Request</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <textarea class="form-control" name="deskripsi_wr" id="deskripsi_wr" cols="30" rows="10" required>
                                {!! $wr->deskripsi_wr !!}
                            </textarea>
                        </div>
                    </div>
                @endif
                <div class="card mt-2" style="display: none" id="detail_work_order">
                    <div class="card-body">
                        <div class="card-body p-0">
                            <div class="row gx-card mx-0 bg-200 text-900 fs--1 fw-semi-bold">
                                <div class="col-9 col-md-8 py-2">Detail Pekerjaan</div>
                                <div class="col-3 col-md-4 py-2 text-end">Detail Biaya Alat</div>
                            </div>
                            <div id="detailWOService">

                            </div>

                            @if ($wr->status_request != 'WORK ORDER')
                                <div class="row gx-card mx-0 border-bottom border-200">
                                    <div class="col-9 py-3">
                                        <input class="form-control" type="text" id="input_detil_pekerjaan">
                                    </div>
                                    <div class="col-3 py-3 text-end">
                                        <div class="input-group flex-nowrap">
                                            <span class="input-group-text" id="addon-wrapping">Rp</span>
                                            <input class="form-control" type="text" id="input_biaya_alat" />
                                        </div>
                                        <button type="button" class="btn btn-primary mt-3" id="btnAddService"
                                            onclick="onAddService()">Tambah</button>
                                    </div>
                                </div>
                            @endif

                            <div class="row fw-bold gx-card mx-0">
                                <div class="col-12 col-md-4 py-2 text-end text-900">Total</div>
                                <div class="col px-0">
                                    <div class="row gx-card mx-0">
                                        <div class="col-md-8 py-2 d-none d-md-block text-center" id="totalServiceItems">
                                        </div>
                                        <div class="col-12 col-md-4 text-end py-2" id="totalServicePrice"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($user->id_role_hdr != 8)
                <div class="col-3">
                    <div class="card">
                        <div class="card-header d-flex flex-between-center py-3">
                            <h6 class="mb-0">Contact Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-0 border-bottom pb-x1 mb-x1 align-items-sm-center align-items-xl-start">
                                <div class="col-3">
                                    <div class="avatar avatar-3xl">
                                        <img class="rounded-circle"
                                            src="{{ $wr->Ticket->Tenant->profile_picture ? url($wr->Ticket->Tenant->profile_picture) : '' }}"
                                            alt="" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <p class="fw-semi-bold text-800 mb-0">{{ $wr->Ticket->Tenant->nama_tenant }}</p>
                                    <a class="btn btn-link btn-sm p-0 fe-medium fs--1" href="#">View more
                                        details
                                    </a>
                                </div>
                            </div>
                            <div class="row g-0 justify-content-lg-between">
                                <div class="col-auto col-md-6 col-lg-auto">
                                    <div class="row">
                                        <div class="col-md-auto mb-4 mb-md-0 mb-xl-4">
                                            <h6 class="mb-1">Email</h6>
                                            <a class="fs--1"
                                                href="mailto:{{ $wr->Ticket->Tenant->email_tenant }}">{{ $wr->Ticket->Tenant->email_tenant }}
                                            </a>
                                        </div>
                                        <div class="col-md-auto mb-4 mb-md-0 mb-xl-4">
                                            <h6 class="mb-1">Phone Number</h6>
                                            <a class="fs--1"
                                                href="tel:+{{ $wr->Ticket->Tenant->no_telp_tenant }}">{{ $wr->Ticket->Tenant->no_telp_tenant }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-auto mb-4 mb-md-0 mb-xl-4">
                                            <h6 class="mb-1">Unit</h6>
                                            <a class="fs--1" href="mailto:mattrogers@gmail.com">Lantai :
                                                {{ $wr->Ticket->Unit->floor->nama_lantai }},
                                                {{ $wr->Ticket->Unit->nama_unit }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto col-md-6 col-lg-auto ps-md-5 ps-xl-0">
                                    <div class="border-start position-absolute start-50 d-none d-md-block d-xl-none"
                                        style="height: 72px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-header">
                            <h6 class="mb-0">Properties</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-4 mt-n2"><label class="mb-1">Work Relation</label>
                                <select name="id_work_relation" class="form-select form-select-sm" disabled>
                                    <option disabled selected>--Pilih Work Relation ---</option>
                                    @foreach ($work_relations as $work_relation)
                                        <option
                                            {{ $work_relation->id_work_relation == $wr->id_work_relation ? 'selected' : '' }}
                                            value="{{ $work_relation->id_work_relation }}">
                                            {{ $work_relation->work_relation }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2 mt-n2"><label class="mb-1">Schedule</label>
                                <input type="text" value="{{ HumanDateTime($wr->schedule) }}" class="form-control"
                                    disabled>
                            </div>
                            @if ($wr->status_request != 'PENDING')
                                <div class="mb-4 mt-3"><label class="mb-1">Status</label>
                                    <select name="status_request" class="form-select form-select-sm" id="select_status">
                                        <option {{ $wr->status_request == 'ON WORK' ? 'selected' : '' }} value="ON WORK">
                                            ON WORK</option>
                                        <option {{ $wr->status_request == 'WORK ORDER' ? 'selected' : '' }}
                                            value="WORK ORDER">Ajukan Work Order</option>
                                    </select>
                                </div>
                                <div class="mb-4 mt-n2" id="select_id_bayarnon" style="display: none">
                                    <label class="mb-1">Status Berbayar WO</label>
                                    <select name="id_bayarnon" class="form-select form-select-sm" id="id_bayarnon">
                                        <option value="1">Berbayar</option>
                                        <option value="0">Non Berbayar</option>
                                    </select>
                                </div>
                                <div class="mb-4 mt-n2" id="select_estimasi_pengerjaan" style="display: none">
                                    <label class="mb-1">Estimasi Pengerjaan</label>
                                    <div class="input-group">
                                        <input class="form-control"
                                            value="{{ $wr->WorkOrder ? $wr->WorkOrder->estimasi_pengerjaan : '' }}"
                                            type="text" name="estimasi_pengerjaan" id="estimasi_pengerjaan" /><span
                                            class="input-group-text">Jam</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer border-top border-200 py-x1">
                        @if ($wr->status_request == 'PENDING')
                            <button type="button" onclick="onSubmit('ON WORK')"
                                class="btn btn-primary w-100">Kerjakan</button>
                        @elseif ($wr->status_request == 'ON WORK')
                            <button type="button" onclick="onSubmit('WORK DONE')" class="btn btn-primary w-100"
                                id="btn_pekerjaan_selesai">Pekerjaan Selesai</button>
                        @endif
                        @if ($wr->status_request != 'WORK ORDER')
                            <button type="button" class="btn btn-primary w-100" id="btn_request_wo">Ajukan Work
                                Order</button>
                        @endif
                    </div>
                </div>
            @endif
        </div>
        <input type="hidden" name="status_request" id="status_request">
    </form>
@endsection

@section('script')
    <script src="https://cdn.tiny.cloud/1/zqt3b05uqsuxthyk5xvi13srgf4ru0l5gcvuxltlpgm6rcki/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinyMCE.init({
            selector: 'textarea#deskripsi_wr_tenant',
            menubar: false,
            toolbar: false,
            height: "180",
            readonly: true
        });
        tinyMCE.init({
            selector: 'textarea#deskripsi_wr',
            menubar: false,
            toolbar: false,
            height: "180",
            readonly: false
        });
    </script>
    <script>
        var services = [];
        var idDetail = 0;
        var noWO = '{{ $wr->workOrder ? $wr->workOrder->no_work_order : '' }}';
        var status = '';
        var id_bayar = 0;

        $('document').ready(function() {
            var status = $('#select_status').val();
            showDetailWO(status);
            getWoByID(noWO);
            detailServiceWO();
        })

        function onSubmit(status) {
            $('#status_request').val(status);

            if (status != 'ON WORK') {
                tinyMCE.triggerSave();
                var deskripsi_wr = $('#deskripsi_wr').val();
                if (!deskripsi_wr) {
                    Swal.fire(
                        'Failed!',
                        'Please insert the description',
                        'error'
                    )
                } else {
                    $("#form-show-wr").submit();
                }
            } else {
                $("#form-show-wr").submit();
            }
        }

        $('#select_status').on('change', function() {
            status = $(this).val()
            id_bayar = $('#id_bayarnon').val()

            showDetailWO(status);
        })

        $('#id_bayarnon').on('change', function() {
            id_bayar = $(this).val()
            status = $('#select_status').val()

            showDetailWO(status, id_bayar);
        })

        $('#btn_request_wo').on('click', function() {
            tinyMCE.triggerSave();
            var id_bayar = $('#id_bayarnon').val();
            var deskripsi_wr = $('textarea#deskripsi_wr').val();
            var estimasi_pengerjaan = $('#estimasi_pengerjaan').val();

            if (!deskripsi_wr || !estimasi_pengerjaan) {
                Swal.fire(
                    'Failed!',
                    'Please insert all field',
                    'error'
                )
            } else {
                if (id_bayar == 1 && services.length <= 0) {
                    Swal.fire(
                        'Failed!',
                        'Please insert detail work',
                        'error'
                    )
                } else {
                    $.ajax({
                        url: '/admin/work-orders',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'no_tiket': '{{ $wr->no_tiket }}',
                            'no_work_request': '{{ $wr->no_work_request }}',
                            'services': services,
                            'id_bayarnon': parseInt(id_bayar),
                            'deskripsi_wr': deskripsi_wr,
                            'estimasi_pengerjaan': estimasi_pengerjaan
                        },
                        type: 'POST',
                        success: function(data) {
                            noWO = data;
                            getWoByID(noWO);
                            Swal.fire(
                                'Berhasil!',
                                'Berhasil mengajukan Work Order!',
                                'success'
                            ).then(() => window.location.reload());
                        }
                    })
                }
            }

        })

        function getWoByID(noWO) {
            $.ajax({
                url: `/admin/work-order/no-wo`,
                type: 'GET',
                data: {
                    'noWO': noWO
                },
                success: function(data) {
                    services = data;
                    detailServiceWO();
                }
            })
        }

        function showDetailWO(status) {
            var id_bayar = $('#id_bayarnon').val()

            if (status === 'WORK ORDER') {
                $('#detail_work_order').css('display', 'block');
                $('#btn_update').css('display', 'none');
                $('#deskripsi_wr_section').css('display', 'block');
                $('#select_id_bayarnon').css('display', 'block');
                $('#btn_pekerjaan_selesai').css('display', 'none');
                $('#select_estimasi_pengerjaan').css('display', 'block');
                $('#btn_request_wo').css('display', 'block');
            } else {
                $('#detail_work_order').css('display', 'none');
                $('#btn_update').css('display', 'block')
                $('#btn_request_wo').css('display', 'none')
                $('#select_id_bayarnon').css('display', 'none');
                $('#btn_pekerjaan_selesai').css('display', 'block');
                $('#select_estimasi_pengerjaan').css('display', 'none');
            }
        }

        $('#id_bayarnon').on('change', function() {
            value = $(this).val();

            if (value == 0) {
                $('#input_biaya_alat').attr("disabled", true);
            } else {
                $('#input_biaya_alat').attr("disabled", false);

            }
        })


        function onAddService() {
            var lastID = 0;
            var detilPekerjaan = $('#input_detil_pekerjaan').val();
            var detilBiayaAlat = $('#input_biaya_alat').val();

            if (noWO && services.length > 0) {
                lastID = services[services.length - 1]['id'];
            }

            lastID += 1;

            let service = {
                'id': lastID,
                detil_pekerjaan: detilPekerjaan,
                detil_biaya_alat: detilBiayaAlat ? detilBiayaAlat : 0,
            }
            console.log(id_bayar);
            if (detilPekerjaan !== '' && detilBiayaAlat !== '' && id_bayar == 1) {
                services.push(service);

                var detilPekerjaan = $('#input_detil_pekerjaan').val('');
                var detilBiayaAlat = $('#input_biaya_alat').val('');
                detailServiceWO();
            } else if (detilPekerjaan !== '' && id_bayar == 0) {
                services.push(service);

                var detilPekerjaan = $('#input_detil_pekerjaan').val('');
                var detilBiayaAlat = $('#input_biaya_alat').val('');
                detailServiceWO();
            }
        }

        function onRemoveService(id) {
            idDetail -= 1;

            services.splice(id, 1)
            detailServiceWO()
        }

        function detailServiceWO() {
            $('#detailWOService').html('');
            services.map((item, i) => {
                $('#detailWOService').append(
                    `<div class='row gx-card mx-0 align-items-center border-bottom border-200'>
                        <div class='col-8 py-3'>
                            <div class='d-flex align-items-center'>
                                <div class='flex-1'><h5 class='fs-0'>
                                    <h5 class='fs-0'>
                                        <span class='text-900' href=''>
                                            ${item.detil_pekerjaan}
                                        </span>
                                    </h5>
                                    <div class='fs--2 fs-md--1'>
                                        <a class='text-danger' onclick='onRemoveService(${i})'>Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='col-4 py-3 text-end text-600'>
                            Rp ${formatRupiah(item.detil_biaya_alat.toString())}
                        </div>
                    </div>`
                )
            })

            const sum = services.reduce((accumulator, object) => {
                return parseInt(accumulator) + parseInt(object.detil_biaya_alat)
            }, 0);

            $('#totalServiceItems').html(`${services.length} (${services.length > 1 ? 'items' : 'item'})`)
            $('#totalServicePrice').html(`Rp ${formatRupiah(sum.toString())}`)
        }
    </script>
@endsection
