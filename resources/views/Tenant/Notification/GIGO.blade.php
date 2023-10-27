@extends('layouts.master')

@section('css')
<link href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md d-flex">
                <div class="avatar avatar-2xl">
                    <img class="rounded-circle" src="../../assets/img/team/1.jpg" alt="" />
                </div>
                <div class="flex-1 ms-2">
                    <h5 class="mb-0 text-light">Women work wonders… on your marketing skills</h5><a class="text-800 fs--1" href="#!"><span class="fw-semi-bold text-light">Emma
                            Watson</span>
                        <span class="ms-1 text-light">&lt;emma@watson.com&gt;</span>
                    </a>
                </div>
            </div>
            <div class="col-md-auto ms-auto d-flex align-items-center ps-6 ps-md-3">
                <small class="text-light">8:40 AM (9 hours
                    ago)</small><span class="fas fa-star text-warning fs--1 ms-2"></span>
            </div>
        </div>
    </div>
    <div class="card-body bg-light">
        <form action="{{ route('gigo.update', $gigo->id) }}" method="post" class="d-inline" id="form-update-gigo">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-8">
                    <div class="card" id="permit_detail">
                        <div class="card-header">
                            <h6 class="mb-0">Detail GIGO</h6>
                        </div>
                        <div class="px-5">
                            <div class="my-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label">No Tiket</label>
                                        <input {{ $gigo->gigo_type ? 'disabled' : '' }} type="text" class="form-control" value="{{ $gigo->Ticket->no_tiket }}" disabled>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">No Request GIGO</label>
                                        <input {{ $gigo->gigo_type ? 'disabled' : '' }} type="text" class="form-control" value="{{ $gigo->no_request_gigo }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="mb-1">Nama pembawa</label>
                                        <input {{ $gigo->gigo_type ? 'disabled' : '' }} type="text" required value="{{ $gigo->nama_pembawa ? $gigo->nama_pembawa : '' }}" name="nama_pembawa" class="form-control" id="nama_pembawa" />
                                    </div>
                                    <div class="col-6">
                                        <label class="mb-1">No Polisi Pembawa</label>
                                        <input {{ $gigo->gigo_type ? 'disabled' : '' }} type="text" required value="{{ $gigo->no_pol_pembawa ? $gigo->no_pol_pembawa : '' }}" name="no_pol_pembawa" class="form-control" id="no_pol_pembawa" />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="mb-1">Tanggal & Jam bawa barang</label>
                                        <input {{ $gigo->gigo_type ? 'disabled' : '' }} class="form-control datetimepicker" required value="{{ $gigo->date_request_gigo ? $gigo->date_request_gigo : '' }}" name="date_request_gigo" id="date_request_gigo" type="text" placeholder="d/m/y H:i" data-options='{"enableTime":true,"dateFormat":"Y-m-d H:i","disableMobile":true}' />
                                    </div>
                                    <div class="col-6">
                                        <label class="mb-1">GIGO Type</label>
                                        <select name="gigo_type" class="form-control" required {{ $gigo->gigo_type ? 'disabled' : '' }} id="gigo_type">
                                            <option value="In">In</option>
                                            <option value="Out">Out</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="ticket_permit" class="mt-3">
                        <div class="card mt-2">
                            <div class="card-body">
                                <div class="card-body p-0">
                                    <div class="row gx-card mx-0 bg-200 text-900 fs--1 fw-semi-bold">
                                        <div class="col-9 col-md-8 py-2">List Barang</div>
                                    </div>
                                    <div id="detailGoods">

                                    </div>
                                    @foreach ($gigo->DetailGIGO as $good)
                                    <div class='row gx-card mx-0 align-items-center border-bottom border-200' id="good{{ $good->id }}">
                                        <div class='col-8 py-3'>
                                            <div class='d-flex align-items-center'>
                                                <div class='flex-1'>
                                                    <table>
                                                        <tr>
                                                            <td><b>Nama barang</b></td>
                                                            <td class="mr-5">&ensp;:&ensp;</td>
                                                            <td>{{ $good->nama_barang }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Jumlah barang</b></td>
                                                            <td class="mr-5">&ensp;:&ensp;</td>
                                                            <td>{{ $good->jumlah_barang }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Keterangan barang</b></td>
                                                            <td class="mr-5">&ensp;:&ensp;</td>
                                                            <td>{{ $good->keterangan }}</td>
                                                        </tr>
                                                    </table>
                                                    @if (!$gigo->sign_approval_1 && !$gigo->gigo_type)
                                                    <div class='fs--2 fs-md--1'>
                                                        <a class='text-danger' onclick='onRemoveGood({{ $good->id }})'>Remove</a>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @if (!$gigo->sign_approval_1 && !$gigo->gigo_type)
                                    <div class="row gx-card mx-0">
                                        <div class="col-8 py-3">
                                            <label class="mb-1">Nama barang</label>
                                            <input class="form-control" type="text" id="nama_barang">
                                        </div>
                                        <div class="col-4 mt-3">
                                            <label class="mb-1">Jumlah barang</label>
                                            <input class="form-control" type="number" id="jumlah_barang">
                                        </div>
                                        <div class="col-12 gx-card mx-0 mb-3">
                                            <label class="mb-1">Keterangan</label>
                                            <input class="form-control" type="text" id="keterangan">
                                        </div>
                                    </div>
                                    <div class="text-end mr-5">
                                        <button type="button" class="btn btn-primary mt-3" onclick="onAddBarang({{ $gigo->id }})">Tambah</button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Status</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-4 mt-n2">
                                <label class="mb-1">Status</label>
                                <input type="text" class="form-control" disabled value="{{ $gigo->status_request ? $gigo->status_request : 'PROSES' }}">
                            </div>
                        </div>
                        @if (!$gigo->sign_approval_1 && !$gigo->gigo_type)
                        <div class="card-footer border-top border-200 py-x1" id="gigoSubmit" style="display: none">
                            <button type="button" onclick="onSubmit({{ $gigo->id }})" class="btn btn-primary w-100">Submit</button>
                        </div>
                        @endif
                        @if (
                        !$gigo->sign_approval_1 &&
                        $gigo->gigo_type &&
                        $sysApprove->approval_1 == Request::session()->get('work_relation_id'))
                        <div class="card-footer border-top border-200 py-x1">
                            <button type="button" id="btnApprove1" class="btn btn-primary w-100" onclick="approve1({{ $gigo->id }})">Approve</button>
                        </div>
                        @endif
                        @if ($gigo->sign_approval_1 && !$gigo->sign_approval_2 && $user->RoleH->work_relation_id == $sysApprove->approval_2)
                        <div class="card-footer border-top border-200 py-x1">
                            <button type="button" id="btnApprove2" class="btn btn-primary w-100" onclick="approve2({{ $gigo->id }})">Approve</button>
                        </div>
                        @endif
                        @if (!$gigo->sign_approval_3 && $gigo->status_request == 'DONE' && $user->id_user == $sysApprove->approval_3)
                        <div class="card-footer border-top border-200 py-x1">
                            <button type="button" id="gigoComplete" class="btn btn-primary w-100" onclick="actionGigoComplete({{ $gigo->id }})">COMPLETE</button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>

<script>
    flatpickr("#date_request_gigo", {
        dateFormat: "Y-m-d H:i",
        minDate: "today",
        enableTime: true,
        altInput: true,
        altFormat: "F j, Y - H:i"
    });

    var goods = [];
    var idGood = 0;
    var getGoods = '{{ count($gigo->DetailGIGO) }}'

    $('document').ready(function() {
        if (getGoods > 0) {
            $('#gigoSubmit').css('display', 'block');
        }
    })

    function onSubmit(id) {
        var nama_pembawa = $('#nama_pembawa').val();
        var no_pol_pembawa = $('#no_pol_pembawa').val();
        var date_request_gigo = $('#date_request_gigo').val();
        var gigo_type = $('#gigo_type').val();

        if (!nama_pembawa || !no_pol_pembawa || !date_request_gigo || !gigo_type) {
            Swal.fire(
                'Failed!',
                'Please fill all field',
                'error'
            )
        } else {
            $.ajax({
                url: '/admin/gigo/' + id,
                type: 'PATCH',
                data: {
                    "nama_pembawa": nama_pembawa,
                    "no_pol_pembawa": no_pol_pembawa,
                    "date_request_gigo": date_request_gigo,
                    "gigo_type": gigo_type,
                },
                success: function(resp) {
                    if (resp.status == 'ok') {
                        Swal.fire(
                            'Success!',
                            'Success submit request',
                            'success'
                        ).then(() => {
                            window.location.reload();
                        });
                    }
                }
            })
        }
    }

    function onAddBarang(gigo_id) {
        var lastID = 0;
        var namaBarang = $('#nama_barang').val();
        var jumlahBarang = parseInt($('#jumlah_barang').val());
        var keterangan = $('#keterangan').val();

        if (!namaBarang || !jumlahBarang) {
            Swal.fire(
                'Failed!',
                'Please fill all field',
                'error'
            )
        } else {
            lastID += 1;

            if (namaBarang !== '' && jumlahBarang !== null) {
                $('#nama_barang').val('');
                $('#jumlah_barang').val('');
                $('#keterangan').val('');

                $.ajax({
                    url: '/admin/gigo/add-good',
                    type: 'post',
                    data: {
                        'id_request_gigo': gigo_id,
                        'nama_barang': namaBarang,
                        'jumlah_barang': jumlahBarang,
                        'keterangan': keterangan,
                    },
                    success: function(resp) {
                        let good = {
                            'id': resp.data.id,
                            'id_request_gigo': resp.data.id_request_gigo,
                            'nama_barang': resp.data.nama_barang,
                            'jumlah_barang': resp.data.jumlah_barang,
                            'keterangan': resp.data.keterangan,
                        }
                        $('#gigoSubmit').css('display', 'block');
                        goods.push(good);
                        detailGoods();
                    }
                })
            }
        }
    }

    function detailGoods() {
        $('#detailGoods').html('');
        console.log(goods);
        goods.map((item, i) => {
            $('#detailGoods').append(
                `<div class='row gx-card mx-0 align-items-center border-bottom border-200'>
                        <div class='col-8 py-3'>
                            <div class='d-flex align-items-center'>
                                <div class='flex-1'>
                                    <table>
                                        <tr>
                                            <td><b>Nama barang</b></td>
                                            <td class="mr-5">&ensp;:&ensp;</td>
                                            <td>${item.nama_barang}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Jumlah barang</b></td>
                                            <td class="mr-5">&ensp;:&ensp;</td>
                                            <td>${item.jumlah_barang}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Keterangan barang</b></td>
                                            <td class="mr-5">&ensp;:&ensp;</td>
                                            <td>${item.keterangan}</td>
                                        </tr>
                                    </table>
                                    <div class='fs--2 fs-md--1'>
                                        <a class='text-danger' onclick='onRemoveGood(${item.id})'>Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`
            )
        })
    }

    function onRemoveGood(id) {
        idGood -= 1;
        $.ajax({
            url: '/admin/gigo/remove-good',
            type: 'post',
            data: {
                'id': id
            },
            success: function(resp) {
                if (resp.status === 'ok') {
                    $(`#good${id}`).html('');
                    window.location.reload()
                }
            }
        })
    }

    function approve1(id) {
        $.ajax({
            url: `/admin/gigo/approve1/${id}`,
            type: 'POST',
            success: function(data) {
                if (data.status === 'ok') {
                    Swal.fire(
                        'Success!',
                        'Success approve GIGO!',
                        'success'
                    ).then(() => window.location.reload())
                }
            }
        })
    }

    function approve2(id) {
        $.ajax({
            url: `/admin/gigo/approve2/${id}`,
            type: 'POST',
            success: function(data) {
                if (data.status === 'ok') {
                    Swal.fire(
                        'Success!',
                        'Success approve GIGO!',
                        'success'
                    ).then(() => window.location.reload())
                }
            }
        })
    }

    function actionGigoComplete(id) {
        $.ajax({
            url: `/admin/gigo/complete/${id}`,
            type: 'POST',
            success: function(data) {
                if (data.status === 'ok') {
                    Swal.fire(
                        'Success!',
                        'Success approve GIGO!',
                        'success'
                    ).then(() => window.location.reload())
                }
            }
        })
    }
</script>
@endsection
