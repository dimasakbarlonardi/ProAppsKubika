@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a href="javascript:history.back();" class="btn btn-falcon-default btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <div class="ml-3">Detail Unit</div>
        </div>
    </div>

    <div class="p-4">
        <div class="mb-3">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Unit</label>
                    <select class="form-control" name="id_unit" id="id_unit" readonly>
                        <option value="{{ $tenantunits->id_unit }}">{{ $tenantunits->unit->nama_unit }}</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tanggal Masuk - Tanggal Keluar</label>
                    <input type="text" value="{{ \Carbon\Carbon::parse($tenantunits->tgl_masuk)->format('d-M-Y') }} - {{ \Carbon\Carbon::parse($tenantunits->tgl_keluar)->format('d-M-Y') }}" class="form-control" readonly>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jatuh Tempo IPL</label>
                    <input type="text" value="{{ \Carbon\Carbon::parse($tenantunits->tgl_jatuh_tempo_ipl)->format('d-M-Y') }}" class="form-control" readonly>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jatuh Tempo UTIL</label>
                    <input type="text" value="{{ \Carbon\Carbon::parse($tenantunits->tgl_jatuh_tempo_util)->format('d-M-Y') }}" class="form-control" readonly>
                </div>
            </div>

            <div class="mb-3" id="detail_unit">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th scope="col"><b>Information Tenant Unit</b></th>
                        </tr>
                        <tr>
                            <td scope="col">
                                <label class="form-label">Luas Unit</label>
                                <input type="text" maxlength="3" id="luas_unit" value="{{ $unit->luas_unit }}" name="luas_unit" class="form-control" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td scope="col">
                                <label class="form-label">No meter air</label>
                                <input type="text" id="no_meter_air" value="{{ $unit->no_meter_air }}" name="no_meter_air" class="form-control" readonly>
                            </td>
                            <td scope="col">
                                <label class="form-label">No air awal</label>
                                <input type="text" id="meter_air_awal" value="{{ $unit->meter_air_awal }}" name="meter_air_awal" class="form-control" readonly>
                            </td>
                            <td scope="col">
                                <label class="form-label">No air akhir</label>
                                <input type="text" id="meter_air_akhir" value="{{ $unit->meter_air_akhir }}" name="meter_air_akhir" class="form-control" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td scope="col">
                                <label class="form-label">No meter listrik</label>
                                <input type="text" id="no_meter_listrik" value="{{ $unit->no_meter_listrik }}" name="no_meter_listrik" class="form-control" readonly>
                            </td>
                            <td scope="col">
                                <label class="form-label">No listrik awal</label>
                                <input type="text" id="meter_listrik_awal" value="{{ $unit->meter_listrik_awal }}" name="meter_listrik_awal" class="form-control" readonly>
                            </td>
                            <td scope="col">
                                <label class="form-label">No listrik akhir</label>
                                <input type="text" id="meter_listrik_akhir" value="{{ $unit->meter_listrik_akhir }}" name="meter_listrik_akhir" class="form-control" readonly>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td scope="col">
                                <label class="form-label">No meter gas</label>
                                <input type="text" id="no_meter_gas" value="{{ $unit->no_meter_gas }}" name="no_meter_gas" class="form-control" readonly>
                            </td>
                            <td scope="col">
                                <label class="form-label">No gas awal</label>
                                <input type="text" id="meter_gas_awal" name="meter_gas_awal" class="form-control" readonly>
                            </td>
                            <td scope="col">
                                <label class="form-label">No gas akhir</label>
                                <input type="text" id="meter_gas_akhir" name="meter_gas_akhir" class="form-control" readonly>
                            </td>
                        </tr> -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection