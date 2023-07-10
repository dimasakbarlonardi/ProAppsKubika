@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Detail Tenant Unit</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <div class="mb-3">
                <div class="row">
                    {{-- <div class="col-6 mb-3">
                        <label class="form-label">Unit</label>
                        <input type="text" value="{{ $tenantunits->unit->nama_unit}}" class="form-control" readonly>
                    </div> --}}
                    <div class="col-4 mb-3">
                        <label class="form-label">Unit</label>
                        <select class="form-control" name="id_unit" id="id_unit" @readonly(true) readonly>
                                <option value="{{ $tenantunits->id_unit }}">{{ $tenantunits->unit->nama_unit }}</option>
                        </select>
                    </div>
                    <div class="col-4 mb-3">
                        <label class="form-label">Owner</label>
                        <input type="text" value="{{ $tenantunits->Owner->nama_pemilik}}" class="form-control" readonly>
                    </div>
                    <div class="col-4 mb-3">
                        <label class="form-label">Tanggal Masuk - Tanggal Keluar</label>
                        <input type="text" value="{{\Carbon\Carbon::parse($tenantunits->tgl_masuk)->format('d-M-Y')}} - {{\Carbon\Carbon::parse($tenantunits->tgl_keluar)->format('d-M-Y')}} " class="form-control" readonly>
                    </div>
                    <div class="col-4 mb-3">
                        <label class="form-label">Jatuh Tempo IPL</label>
                        <input type="text" value="{{\Carbon\Carbon::parse($tenantunits->tgl_jatuh_tempo_ipl)->format('d-M-Y')}}" class="form-control" readonly>
                    </div>
                    <div class="col-4 mb-3">
                        <label class="form-label">Jatuh Tempo UTIL</label>
                        <input type="text" value="{{\Carbon\Carbon::parse($tenantunits->tgl_jatuh_tempo_util)->format('d-M-Y')}}" class="form-control" readonly>
                    </div>

            <div class="mb-3" id="detail_unit" style="">
                <div class="table-responsive scrollbar">
                    <table class="table">
                        <tr>
                            <th scope="col"><b> Information Tenant Unit </b></th>
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
                {{-- <a href="{{ route('tenantunits.edit', $tenantunits->id_tenant_unit) }}" class="btn btn-sm btn-primary">Edit</a> --}}
                <a class="btn btn-sm btn-warning" href="{{ route('getTenantUnit', $tenantunits->id_tenant)}}">Back</a>
                {{-- <form action="{{ route('deleteTenantUnit', $tenantunits->id_tenant_unit) }}" method="post"
                    class="d-inline">
                    @csrf
                    <button class="btn btn-link p-0 ms-2" type="submit" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Delete"
                        onClick="return confirm('Are you absolutely sure you want to delete?')"><span
                            class="text-500 fas fa-trash-alt"></span>
                    </button>
                </form> --}}
            </div>
         </div> 
    </div>
           

        </div>
    </div>
@endsection

@section('script')
    <script>
        $('document').ready(function() {
            $('#id_pemilik').on('change', function() {
                var id_pemilik = $(this).val()
                $.ajax({
                    url: '/admin/tenant-unit/' + id_pemilik,
                    type: 'GET',
                    success: function(data) {
                        console.log(data.units)
                        $.each(data.units, function(key, value) {
                            console.log(key, value.id_unit)
                            $("#id_unit").append(value.id_unit +
                                 + value.nama_unit );

                                value="{{ $tenantunits->id_unit }}"
                        });
                    }
                }) 

            })
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
