@extends('layouts.master')

@section('css')
    <link href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="card">
      
        <div class="card-body bg-light">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-9">
                    <div class="card" id="permit_detail">
                        <div class="card-header">
                            <h6 class="mb-0">Detail GIGO</h6>
                        </div>
                        <div class="px-5">
                            <div class="my-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label">No Request</label>
                                        <input type="text" class="form-control" value="{{ $gigo->Ticket->no_tiket }}"
                                            disabled>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">No Request Gigo</label>
                                        <input type="text" class="form-control" value="{{ $gigo->no_request_gigo }}"
                                            disabled>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Driver</label>
                                        <input type="text" class="form-control" value="{{ $gigo->nama_pembawa }}"
                                            disabled>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">No Car Plate</label>
                                        <input ßtype="text" class="form-control" value="{{ $gigo->no_pol_pembawa }}"
                                            disabled>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Gigo Time</label>
                                        <input type="text" class="form-control" value="{{ $gigo->date_request_gigo }}"
                                            disabled>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Gigo Type</label>
                                        <input type="text" class="form-control" value="{{ $gigo->gigo_type }}" disabled>
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
                                        <div class="col-9 col-md-8 py-2">List Items</div>
                                    </div>
                                    @foreach ($gigo->DetailGIGO as $good)
                                        <hr>
                                        <div class="row gx-card mx-0">
                                            <div class="col-8 py-3">
                                                <label class="mb-1">Name of Goods</label>
                                                <input value="{{ $good->nama_barang }}" class="form-control" type="text"
                                                    id="nama_barang" disabled>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Qty</label>
                                                <input value="{{ $good->jumlah_barang }}" type="text"
                                                    class="form-control" value="{{ $gigo->no_pol_pembawa }}" disabled>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Description</label>
                                                <input value="{{ $good->keterangan }}" type="text" class="form-control"
                                                    value="{{ $gigo->no_pol_pembawa }}" disabled>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div id="detailGoods">
                                    </div>
                                    @if (
                                        (!$gigo->sign_approval_1 && !$gigo->gigo_type) ||
                                            ($gigo->status_request == 'APPROVED' &&
                                                $gigo->sign_approval_2 &&
                                                $approve->approval_2 == Request::session()->get('work_relation_id')))
                                        <hr>
                                        <div class="row gx-card mx-0">
                                            <div class="col-8 py-3">
                                                <label class="mb-1">Nama barang</label>
                                                <input class="form-control" type="text" id="input_nama_barang">
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
                                            <button type="button" class="btn btn-primary mt-3"
                                                onclick="onAddBarang({{ $gigo->id }})">Tambah</button>
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
                                <input type="text" class="form-control" disabled
                                    value="{{ $gigo->status_request ? $gigo->status_request : 'PROSES' }}">
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            @if (
                                !$gigo->sign_approval_1 &&                                    
                                    $approve->approval_1 == $user->RoleH->WorkRelation->id_work_relation
                                )
                                <form action="{{ route('gigoApprove1', $gigo->id) }}" class="d-inline" method="post">
                                    @csrf
                                    <button class="btn btn-lg btn-block btn-success" onclick="approveGigo1({{ $gigo->id }})" type="button">Approve</button>
                                </form>
                            @endif
                            @if (
                                $gigo->sign_approval_1 &&
                                    !$gigo->sign_approval_2 &&
                                    $approve->approval_2 == $user->RoleH->WorkRelation->id_work_relation &&
                                    $user->Karyawan->is_can_approve)
                                <form action="{{ route('gigoApprove2', $gigo->id) }}" class="d-inline" method="post">
                                    @csrf
                                    <button class="btn btn-lg btn-block btn-success" type="submit">Approve</button>
                                </form>
                            @endif
                            @if (
                                $gigo->sign_approval_2 &&
                                    $gigo->status_request != 'DONE' &&
                                    $approve->approval_2 == $user->RoleH->WorkRelation->id_work_relation &&
                                    $user->Karyawan->is_can_approve)
                                <button class="btn btn-success btn-lg btn-block" type="button" onclick="actionGigoDone({{ $gigo->id }})">Done</button>
                            @endif
                            @if ($gigo->status_request == 'DONE' && $approve->approval_3 == $user->id_user)
                                <form action="{{ route('gigoComplete', $gigo->id) }}" class="d-inline" method="post">
                                    @csrf
                                    <button class="btn btn-lg btn-block btn-success" type="submit">Complete</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>

    <script>
        var goods = [];
        var idGood = 0;
        var getGoods = '{{ count($gigo->DetailGIGO) }}'

        $('document').ready(function() {
            if (getGoods > 0) {
                $('#gigoSubmit').css('display', 'block');
            }
        })

        function onAddBarang(gigo_id) {
            var lastID = 0;
            var namaBarang = $('#input_nama_barang').val();
            var jumlahBarang = parseInt($('#jumlah_barang').val());
            var keterangan = $('#keterangan').val();

            lastID += 1;

            if (namaBarang !== '' && jumlahBarang !== null) {
                $('#input_nama_barang').val('');
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

        function detailGoods() {
            $('#detailGoods').html('');
            goods.map((item, i) => {
                $('#detailGoods').append(
                    `
                    <hr>
                    <div class='row gx-card mx-0 align-items-center border-bottom border-200'>
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

        function approveGigo1(id) {
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

        function actionGigoDone(id) {
            $.ajax({
                url: `/admin/gigo/done/${id}`,
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
