@extends('layouts.master')

@section('css')
    <link href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md d-flex">Nama pembawa
                    <div class="avatar avatar-2xl">
                        <img class="rounded-circle" src="../../assets/img/team/1.jpg" alt="" />
                    </div>
                    <div class="flex-1 ms-2">
                        <h5 class="mb-0 text-light">Women work wonders… on your marketing skills</h5><a
                            class="text-800 fs--1" href="#!"><span class="fw-semi-bold text-light">Emma
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
            <form action="{{ route('gigo.update', $gigo->id) }}" method="post" class="d-inline">
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
                                            <input type="text" class="form-control" value="{{ $gigo->Ticket->no_tiket }}"
                                                disabled>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">No Request Permit</label>
                                            <input type="text" class="form-control" value="{{ $gigo->no_request_gigo }}"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Nama pembawa</label>
                                            <input type="text" class="form-control" value="{{ $gigo->nama_pembawa }}"
                                                disabled>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">No Polisi Pembawa</label>
                                            <input type="text" class="form-control" value="{{ $gigo->no_pol_pembawa }}"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="col-6">
                                        <label class="form-label">Tanggal & Jam bawa barang</label>
                                        <input type="text" class="form-control" value="{{ $gigo->date_request_gigo }}"
                                            disabled>
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
                                        {{-- @foreach ($gigo->DetailGIGO as $good)
                                            <div class='row gx-card mx-0 align-items-center border-bottom border-200'
                                                id="good{{ $good->id }}">
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
                                                            <div class='fs--2 fs-md--1'>
                                                                <a class='text-danger'
                                                                    onclick='onRemoveGood({{ $good->id }})'>Remove</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach --}}
                                        <div id="detailGoods">
                                        </div>
                                        @foreach ($gigo->DetailGIGO as $good)
                                            <div class="row gx-card mx-0">
                                                <div class="col-8 py-3">
                                                    <label class="mb-1">Nama barang</label>
                                                    <input value="{{ $good->nama_barang }}" class="form-control" type="text" id="nama_barang" disabled>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">Jumlah barang</label>
                                                    <input value="{{ $good->jumlah_barang }}" type="text" class="form-control" value="{{ $gigo->no_pol_pembawa }}"
                                                        disabled>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">Keterangan</label>
                                                    <input value="{{ $good->keterangan }}" type="text" class="form-control" value="{{ $gigo->no_pol_pembawa }}"
                                                        disabled>
                                                </div>
                                            </div>
                                            {{-- <div class="text-end mr-5">
                                                <button type="button" class="btn btn-primary mt-3"
                                                    onclick="onAddBarang({{ $gigo->id }})">Tambah</button>
                                            </div> --}}
                                            @endforeach

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
                                        <h6 class="mb-0">Status</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-4 mt-n2">
                                            <label class="mb-1">Status</label>
                                            <input type="text" class="form-control" disabled
                                                value="{{ $gigo->status_request ? $gigo->status_request : 'PROSES' }}">
                                        </div>
                                    </div>
                                    {{-- @if (!$gigo->sign_approval_1)
                                        <div class="card-footer border-top border-200 py-x1" id="gigoSubmit"
                                            style="display: none">
                                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                                        </div>
                                    @endif --}}
                                </div>
                            </div>
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
            var namaBarang = $('#nama_barang').val();
            var jumlahBarang = parseInt($('#jumlah_barang').val());
            var keterangan = $('#keterangan').val();

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

        function detailGoods() {
            $('#detailGoods').html('');
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
    </script>
@endsection
