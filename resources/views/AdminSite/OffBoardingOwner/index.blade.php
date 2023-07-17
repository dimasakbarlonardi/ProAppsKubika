@extends('layouts.master')

@section('css')
    <link href="{{ url('assets/vendors/choices/choices.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="mb-0 text-light">List OffBoarding Owner</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <label for="organizerSingle">Nama Owner</label><select class="form-select js-choice" id="id_pemilik"
                size="1" name="organizerSingle" data-options='{"removeItemButton":true,"placeholder":true}'>
                <option selected disabled>-- Search Owner --</option>
                @foreach ($owners as $owner)
                    <option value="{{ $owner->id_pemilik }}">{{ $owner->nama_pemilik }}</option>
                @endforeach
            </select>

            <div class="mb-3" id="detail_owner" style="">
                <div class="table-responsive scrollbar">
                    <table class="table">
                        <tr>
                            <th scope="col"><b> Information Nama Kontak PIC </b></th>
                        </tr>
                        <tr>
                            <th scope="col">Nama PIC</th>
                            <td scope="col">
                                <input type="text" maxlength="3" id="nama_kontak_pic" name="nama_kontak_pic"
                                    class="form-control" readonly>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">NIK PIC</th>
                            <td scope="col">
                                <input type="text" maxlength="3" id="nik_kontak_pic" name="nik_kontak_pic"
                                    class="form-control" readonly>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">No. Telp PIC</th>
                            <td scope="col">
                                <input type="text" maxlength="3" id="no_telp_kontak_pic" name="no_telp_kontak_pic"
                                    class="form-control" readonly>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="mb-3" id="detail_ownerunit" style="">
                <div class="table-responsive scrollbar">
                    <table class="table" id="unit-lists">
                        <table class="table" id="unit-list">
                        <tr>
                            <th scope="col"><b>Information Kepemilikan Unit </b></th>
                        </tr>
                    </table>
                </div>
                <div class="mb-3">
                    <div class=" my-3">
                        <button class="btn btn-danger" type="button" data-bs-toggle="modal"
                            data-bs-target="#error-modal">Off Owner</button>
                        <div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
                                <div class="modal-content position-relative">
                                    <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                        <form action="{{ route('deleteTenantUnit', $owner->id_pemilik) }}" method="post"
                                            class="d-inline">
                                            @csrf
                                            <button
                                                class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-0">
                                        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                            <h4 class="mb-1" id="modalExampleDemoLabel">Alasan Off Owner</h4>
                                        </div>
                                        <div class="p-4 pb-0">
                                            <form method="post" action="{{ route('offtenantunits.store') }}">
                                                @csrf
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="message-text">Tanggal Keluar
                                                        :</label>
                                                    <input type="date" class="form-control" name="tgl_keluar"
                                                        id="message-text">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="message-text">Keterangan
                                                        :</label>
                                                    <textarea class="form-control" name="keterangan" id="message-text"></textarea>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                    </form>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('script')
    <script src="{{ url('assets/vendors/choices/choices.min.js') }}"></script>

    <script>
        $('document').ready(function() {
            $('#id_pemilik').on('change', function() {
                var id_pemilik = $(this).val();

                $('#detail_ownerunit').css('display', 'inline');
                $.ajax({
                    url: '/admin/ownerunit-by-id/' + id_pemilik,
                    type: 'GET',
                    success: function(data) {
                        console.log(data)
                        $('#nama_kontak_pic').val(data.owner.nama_kontak_pic)
                        $('#nik_kontak_pic').val(data.owner.nik_kontak_pic)
                        $('#no_telp_kontak_pic').val(data.owner.no_telp_kontak_pic)
                        data.nama_unit.map((unit) => {
                            $('#unit-lists').append(`
                            <tr>
                                <th scope="col">Unit</th>
                                <td scope="col">
                                    <input type="text" value="${unit}" name="id_unit" class="form-control"
                                        readonly>
                                </td>
                            </tr>
                        `)
                        })
                    }
                })
            })
        })
    </script>

    <script>
        // $('document').ready(function() {
        //     $('#id_pemilik').on('change', function() {
        //         var id_pemilik = $(this).val();

        //         $('#detail_owner').css('display', 'inline');
        //         $.ajax({
        //             url: '/admin/pic-by-id/' + id_pemilik,
        //             type: 'GET',
        //             success: function(data) {
        //                 console.log(data.unit)
        //                 $('#nama_kontak_pic').val(data.unit.nama_kontak_pic)
        //             }
        //         })
        //     })
        // })
    </script>
@endsection
