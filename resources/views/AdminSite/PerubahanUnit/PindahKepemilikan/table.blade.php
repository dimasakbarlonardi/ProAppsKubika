                  
@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-white">Detail Kepemilikan Unit</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-4 mb-3" id="id_pemilik" >
                            <label class="form-label">Owner</label>
                            <input type="text" name="id_pemilik" id="id_pemilik" value="{{ $kepemilikans->Pemilik->nama_pemilik }}" class="form-control" readonly>
                        </div>
                        <div class="col-4 mb-3">
                            <label class="form-label">Unit</label>
                            <select class="form-control" name="id_unit" id="id_unit" @readonly(true) readonly>
                                    <option value="{{ $kepemilikans->id_unit }}">{{ $kepemilikans->unit->nama_unit }}</option>
                            </select>
                        </div>

                        <div class="col-4 mb-3">
                            <label class="form-label">Status Hunian</label>
                            <input type="text" value="{{$kepemilikans->StatusHunianTenant->status_hunian_tenant}}" class="form-control" readonly>
                        </div>
                        <div class="col-4 mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="text" value="{{ $kepemilikans->tgl_mulai }}" class="form-control" readonly>
                        </div>
                        <div class="col-4 mb-3">
                            <label class="form-label">No Bukti Milik</label>
                            <input type="text" value="{{ $kepemilikans->no_bukti_milik }}" class="form-control" readonly>
                        </div>
                        <div class="col-4 mb-3">
                            <label class="form-label">keterangan</label>
                            <input type="text" value="{{$kepemilikans->keterangan}}" class="form-control" readonly>
                        </div>

                <div class="mb-3" id="detail_unit" style="">
                    <div class="table-responsive scrollbar">
                        <table class="table">
                            <tr>
                                <th scope="col"><b> Information Kepemilikan Unit     </b></th>
                            </tr>
                            <tr>
                                <th scope="col">Luas Unit</th>
                                <td scope="col">
                                    <input type="text" maxlength="3" id="luas_unit" name="luas_unit" class="form-control" readonly>
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">Barcode unit</th>
                                <td scope="col">
                                    <input type="text" id="barcode_unit" name="barcode_unit" class="form-control" readonly>
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">Barcode meter air</th>
                                <td scope="col">
                                    <input type="text" id="barcode_meter_air" name="barcode_meter_air" class="form-control" readonly>
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">Barcode meter listrik</th>
                                <td scope="col">
                                    <input type="text" id="barcode_meter_listrik" name="barcode_meter_listrik" class="form-control" readonly>
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">Barcode meter gas</th>
                                <td scope="col">
                                    <input type="text" id="barcode_meter_gas" name="barcode_meter_gas" class="form-control" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td scope="col">
                                    <label class="form-label">No meter air</label>
                                    <input type="text" id="no_meter_air" name="no_meter_air" class="form-control" readonly>
                                </td>
                                <td scope="col">
                                    <label class="form-label">No air awal</label>
                                    <input type="text" id="meter_air_awal" name="meter_air_awal" class="form-control" readonly>
                                </td>
                                <td scope="col">
                                    <label class="form-label">No air akhir</label>
                                    <input type="text" id="meter_air_akhir" name="meter_air_akhir" class="form-control" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td scope="col">
                                    <label class="form-label">No meter listrik</label>
                                    <input type="text" id="no_meter_listrik" name="no_meter_listrik" class="form-control" readonly>
                                </td>
                                <td scope="col">
                                    <label class="form-label">No listrik awal</label>
                                    <input type="text" id="meter_listrik_awal" name="meter_listrik_awal" class="form-control" readonly>
                                </td>
                                <td scope="col">
                                    <label class="form-label">No listrik akhir</label>
                                    <input type="text" id="meter_listrik_akhir" name="meter_listrik_akhir" class="form-control" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td scope="col">
                                    <label class="form-label">No meter gas</label>
                                    <input type="text" id="no_meter_gas" name="no_meter_gas" class="form-control" readonly>
                                </td>
                                <td scope="col">
                                    <label class="form-label">No gas awal</label>
                                    <input type="text" id="meter_gas_awal" name="meter_gas_awal" class="form-control" readonly>
                                </td>
                                <td scope="col">
                                    <label class="form-label">No gas akhir</label>
                                    <input type="text" id="meter_gas_akhir" name="meter_gas_akhir" class="form-control"
                                        readonly>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
               <div class="text-end">
                <button type="button" data-toggle="modal" data-target="#modalValidation"
                class="btn btn-sm btn-warning" id="btnPerpanjangSewa">Pindah Kepemilikan Unit</button>
               </div>

               <div class="modal fade" id="modalValidation" data-bs-keyboard="false" data-bs-backdrop="static"
               tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
               <div class="modal-dialog modal-md mt-6" role="document">
                   <div class="modal-content border-0">
                       <div class="position-absolute top-0 end-0 mt-3 me-3 z-1"><button
                               class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                               data-bs-dismiss="modal" aria-label="Close"></button></div>
                       <div class="modal-body p-0">
                           <div class="bg-light rounded-top-3 py-3 ps-4 pe-6 text-center">
                               <img src="{{ asset('assets/img/icons/validation_error.png') }}"
                                   class="my-3" height="100">
                               <h4 class="mb-1" id="staticBackdropLabel">
                                   Offboarding Failed!
                               </h4>
                               <p class="fs--2 mb-0">
                                   Still a process or payment that has not been completed or paid
                               </p>
                           </div>
                           <div class="p-4">
                               <div id="modalListErrors">
                                   <div class="row">
                                       <div class="d-flex">
                                           <span class="fa-stack ms-n1">
                                               <img src="{{ asset('assets/img/icons/cross_red.png') }}"
                                                   class="" height="25">
                                           </span>
                                           <div class="">
                                               <p class="text-break fs--1 mt-1">The illustration must match to
                                                   the
                                                   contrast of the theme. </p>
                                           </div>
                                       </div>
                                   </div>
                               </div>
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
    <script>
$('#btnPerpanjangSewa').on('click', function() {
            var id_pemilik = '{{ $kepemilikans->Owner->User->id_user }}';
            var id_unit = '{{ $kepemilikans->id_unit }}';
            var id_tenant_unit = '{{ $kepemilikans->id_pemilik }}';

            $('#modalListErrors').html('');
            $.ajax({
                url: `/admin/validation/perubahan`,
                type: 'GET',
                data: {
                    'id_user': id_pemilik,
                    'id_unit':id_unit
                },
                success: function(resp) {
                    console.log(resp.errors)
                    if (resp.errors.length > 0) {
                        resp.errors.map((item) => { 
                            $('#modalListErrors').append(`
                                 <div class="row">
                                    <div class="d-flex">
                                        <span class="fa-stack ms-n1">
                                            <img src="{{ asset('assets/img/icons/cross_red.png') }}"
                                                class="" height="25">
                                        </span>
                                        <div class="">
                                            <p class="text-break fs--1 mt-1">${item.type} - ${item.error_header} masih berstatus ${item.error_status}</p>
                                        </div>
                                    </div>
                                </div>
                                `);
                                $('#modalValidation').modal('show')
                        })
                    } else {
                        window.location.replace(`/admin/get/kepemilikanunits-edit/${id_pemilik}`)
                    }
                }
            })
        })

        $('document').ready(function() {
                var id_unit = $('#id_unit').val();
                $('#detail_unit').css('display', 'inline');
                $.ajax({
                    url: '/admin/unit-by-id/' + id_unit,
                    type: 'GET',
                    success: function(data) {
                        console.log(data.unit)
                        $('#luas_unit').val(data.unit.luas_unit)
                        $('#barcode_unit').val(data.unit.barcode_unit)
                        $('#barcode_meter_air').val(data.unit.barcode_meter_air)
                        $('#barcode_meter_listrik').val(data.unit.barcode_meter_listrik)
                        $('#barcode_meter_gas').val(data.unit.barcode_meter_gas)
                        $('#no_meter_air').val(data.unit.no_meter_air)
                        $('#meter_air_awal').val(data.unit.meter_air_awal)
                        $('#meter_air_akhir').val(data.unit.meter_air_akhir)
                        $('#no_meter_listrik').val(data.unit.no_meter_listrik)
                        $('#meter_listrik_awal').val(data.unit.meter_listrik_awal)
                        $('#meter_listrik_akhir').val(data.unit.meter_listrik_akhir)
                        $('#no_meter_gas').val(data.unit.no_meter_gas)
                        $('#meter_gas_awal').val(data.unit.meter_gas_awal)
                        $('#meter_gas_akhir').val(data.unit.meter_gas_akhir)
                        $('#id_unit_input').val(data.unit.id_unit)
                    }
                })
        })
    </script>
@endsection
