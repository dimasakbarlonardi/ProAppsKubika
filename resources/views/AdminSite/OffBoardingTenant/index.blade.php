@extends('layouts.master')

@section('css')
    <link href="{{ url('assets/vendors/choices/choices.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="mb-0 text-light">List OffBoarding Tenant</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <label for="organizerSingle">tenant</label><select class="form-select js-choice" id="id_tenant" size="1"
                name="organizerSingle" data-options='{"removeItemButton":true,"placeholder":true}'>
                <option selected disabled>-- Pilih Tenant --</option>
                @foreach ($tenants as $item)
                    <option value="{{ $item->id_tenant }}">{{ $item->nama_tenant }}</option>
                @endforeach
            </select>

            <div class="mb-3" id="detail_tenant" style="">
                <div class="table-responsive scrollbar">
                    <table class="table">
                        <tr>
                            <th scope="col"><b> Information Nama Kontak PIC </b></th>
                        </tr>
                        <tr>
                            <th scope="col">Nama PIC</th>
                            <td scope="col">
                                <input type="text" maxlength="3" id="nama_pasangan_penjamin"
                                    name="nama_pasangan_penjamin" class="form-control" readonly>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">NIK PIC</th>
                            <td scope="col">
                                <input type="text" maxlength="3" id="nik_pasangan_penjamin" name="nik_pasangan_penjamin"
                                    class="form-control" readonly>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">No. Telp PIC</th>
                            <td scope="col">
                                <input type="text" maxlength="3" id="no_telp_penjamin" name="no_telp_penjamin"
                                    class="form-control" readonly>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="mb-3" id="detail_tenant_unit" style="">
                <div class="table-responsive scrollbar">
                    <table class="table" id="unit-list">
                        <tr>
                            <th scope="col"><b> Information Tenant Unit </b></th>
                        </tr>
                    </table>
                </div>
                <div class="mb-3">
                    <div class=" my-3">
                        {{-- <button class="btn btn-danger" type="button" onclick="submitOffTenant()">Off Tenant
                        </button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="off-modal-form" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
            <div class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">

                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('offdeleteTenantUnit') }}">
                    <div class="modal-body p-0">
                        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                            <h4 class="mb-1" id="modalExampleDemoLabel">Alasan Off tenant</h4>
                        </div>
                        <div class="p-4 pb-0">
                            @csrf
                            <div class="mb-3">
                                <label class="col-form-label" for="message-text">Tanggal Keluar
                                    :</label>
                                <input type="date" class="form-control" name="tgl_keluar" id="message-text">
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label" for="message-text">Keterangan
                                    :</label>
                                <textarea class="form-control" name="keterangan" id="message-text"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <input type="hidden" name="id_tenant_modal" id="id_tenant_modal">
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalValidation" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md mt-6" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-1"><button
                        class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal"
                        aria-label="Close"></button></div>
                <div class="modal-body p-0">
                    <div class="bg-light rounded-top-3 py-3 ps-4 pe-6 text-center">
                        <img src="{{ asset('assets/img/icons/validation_error.png') }}" class="my-3" height="100">
                        <h4 class="mb-1" id="staticBackdropLabel">
                            Offboarding Failed!
                        </h4>
                    </div>
                    <div class="p-4">
                        <div id="modalListErrors">
                            <div class="row">
                                <div class="d-flex">
                                    <span class="fa-stack ms-n1">
                                        <img src="{{ asset('assets/img/icons/cross_red.png') }}" class=""
                                            height="25">
                                    </span>
                                    <div class="">
                                        <p class="text-break fs--1 mt-1">
                                            Tenant masih memiliki unit
                                        </p>
                                    </div>
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
        var units = 0;
        $('document').ready(function() {
            $('#id_tenant').on('change', function() {
                var id_tenant = $(this).val();
                $('#unit-list').html('')
                $('#detail_tenant').css('display', 'inline');
                $.ajax({
                    url: '/admin/penjamin-by-id/' + id_tenant,
                    type: 'GET',
                    success: function(data) {
                        console.log(data);
                        units = data.units.length
                        $('#nama_pasangan_penjamin').val(data.tenant.nama_pasangan_penjamin)
                        $('#nik_pasangan_penjamin').val(data.tenant.nik_pasangan_penjamin)
                        $('#no_telp_penjamin').val(data.tenant.no_telp_penjamin)
                        data.units.map((unit) => {
                            $('#unit-list').append(`
                            <tr>
                                <th scope="col">Unit</th>
                                <td scope="col">
                                    <input type="text" value="${unit.nama_unit}" name="id_unit" class="form-control"
                                        readonly>
                                </td>
                                <td scope="col">
                                    <button class="btn btn-danger text-dark" type="button" onclick="submitOffTenant('${id_tenant}', '${unit.id_unit}')">Off Tenant
                                    </button>
                                </td>
                            </tr>
                        `)
                        })
                    }
                })
            })
        })

        function submitOffTenant(id_tenant, id_unit) {
            Swal.fire({
                title: 'Are you sure?',
                icon: 'info',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                $.ajax({
                    url: `/admin/tenant-unit-by-tenant/${id_tenant}/${id_unit}`,
                    type: 'GET',
                    success: function(resp) {
                        window.location.reload();
                    }
                })
            })
        }
    </script>
@endsection
