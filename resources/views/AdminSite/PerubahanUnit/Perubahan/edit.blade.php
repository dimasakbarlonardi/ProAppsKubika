@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item active text-white" aria-current="page">Perubahan Unit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form action="{{ route('updatePerubahanUnit', $tenantunit->id_tenant_unit) }}" method="post">
                @method('POST')
                @csrf
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Unit</label>
                            <select class="form-control" name="id_unit" id="id_unit" required>
                                <option selected disabled>-- Pilih Unit --</option>
                                @foreach ($tenant_unit as $unit)
                                    <option value="{{ $unit->id_unit }}">
                                        {{ $unit->Unit->nama_unit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 mb-3" id="detail_tenantunit">
                            <label class="form-label">Pemilik</label>
                            <select class="form-control" name="id_pemilik" id="id_pemilik" required>
                                <option selected disabled>-- Pilih Pemilik --</option>
                                @foreach ($owners as $owner)
                                    <option value="{{ $owner->id_pemilik }}">{{ $owner->nama_pemilik }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="col-form-label">Periode
                                    Sewa:</label>
                                <div class="input-group">
                                    <select class="form-control" name="id_periode_sewa" id="periode_edit">
                                        @foreach ($periodeSewa as $periode)
                                            <option value="{{ $periode->id_periode_sewa }}">
                                                {{ $periode->periode_sewa }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-text">Bulan</span>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-6 mb-3">
                        <label class="form-label">Sewa Ke</label>
                        <input type="text" class="form-control" readonly>
                    </div> --}}
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="col-form-label">Tanggal
                                    masuk:</label>
                                <input class="form-control" type="date" name="tgl_masuk" id="tgl_masuk_edit">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="col-form-label">Tanggal
                                    keluar:</label>
                                <input class="form-control" type="date" name="tgl_keluar" id="tgl_keluar_edit" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="col-form-label">Tanggal
                                    jatuh tempo IPL:</label>
                                <input class="form-control" type="date" name="tgl_jatuh_tempo_ipl" id=""
                                    required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="col-form-label">Tanggal
                                    jatuh tempo utility:</label>
                                <input class="form-control" type="date" name="tgl_jatuh_tempo_util" required>
                            </div>
                            <div class="col-6 mb-5">
                                <label class="form-label">Keterangan</label>
                                <input type="text" name="keterangan" class="form-control" required>
                            </div>
                        </div>
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
                                        <input type="text" maxlength="3" id="luas_unit" name="luas_unit"
                                            class="form-control" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col">Barcode unit</th>
                                    <td scope="col">
                                        <input type="text" id="barcode_unit" name="barcode_unit" class="form-control"
                                            readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col">Barcode meter air</th>
                                    <td scope="col">
                                        <input type="text" id="barcode_meter_air" name="barcode_meter_air"
                                            class="form-control" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col">Barcode meter listrik</th>
                                    <td scope="col">
                                        <input type="text" id="barcode_meter_listrik" name="barcode_meter_listrik"
                                            class="form-control" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col">Barcode meter gas</th>
                                    <td scope="col">
                                        <input type="text" id="barcode_meter_gas" name="barcode_meter_gas"
                                            class="form-control" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="col">
                                        <label class="form-label">No meter air</label>
                                        <input type="text" id="no_meter_air" name="no_meter_air" class="form-control"
                                            readonly>
                                    </td>
                                    <td scope="col">
                                        <label class="form-label">No air awal</label>
                                        <input type="text" id="meter_air_awal" name="meter_air_awal"
                                            class="form-control" readonly>
                                    </td>
                                    <td scope="col">
                                        <label class="form-label">No air akhir</label>
                                        <input type="text" id="meter_air_akhir" name="meter_air_akhir"
                                            class="form-control" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="col">
                                        <label class="form-label">No meter listrik</label>
                                        <input type="text" id="no_meter_listrik" name="no_meter_listrik"
                                            class="form-control" readonly>
                                    </td>
                                    <td scope="col">
                                        <label class="form-label">No listrik awal</label>
                                        <input type="text" id="meter_listrik_awal" name="meter_listrik_awal"
                                            class="form-control" readonly>
                                    </td>
                                    <td scope="col">
                                        <label class="form-label">No listrik akhir</label>
                                        <input type="text" id="meter_listrik_akhir" name="meter_listrik_akhir"
                                            class="form-control" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="col">
                                        <label class="form-label">No meter gas</label>
                                        <input type="text" id="no_meter_gas" name="no_meter_gas" class="form-control"
                                            readonly>
                                    </td>
                                    <td scope="col">
                                        <label class="form-label">No gas awal</label>
                                        <input type="text" id="meter_gas_awal" name="meter_gas_awal"
                                            class="form-control" readonly>
                                    </td>
                                    <td scope="col">
                                        <label class="form-label">No gas akhir</label>
                                        <input type="text" id="meter_gas_akhir" name="meter_gas_akhir"
                                            class="form-control" readonly>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        {{-- <a href="{{ route('tenantunit.edit', $tenantunit->id_tenant_unit) }}" class="btn btn-sm btn-primary">Edit</a> --}}
                        {{-- <form action="{{ route('deleteTenantUnit', $tenantunit->id_tenant_unit) }}" method="post"
                    class="d-inline">
                    @csrf
                    <button class="btn btn-link p-0 ms-2" type="submit" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Delete"
                        onClick="return confirm('Are you absolutely sure you want to delete?')"><span
                            class="text-500 fas fa-trash-alt"></span>
                    </button>
                </form> --}}
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Simpan
                        </button>
                    </div>
                </div>
        </div>


        </form>
    </div>
    </div>
@endsection

@section('script')
    <script>
        $('document').ready(function() {

            $('#id_unit').on('change', function() {
                var id_unit = $(this).val();

                $('#detail_unit').css('display', 'inline');
                $.ajax({
                    url: '/admin/unit-by-id/' + id_unit,
                    type: 'GET',
                    success: function(data) {
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
        })
    </script>


    <script>
        $('document').ready(function() {
            $('#id_unit').on('change', function() {
                var id_unit = $(this).val();

                $('#detail_tenantunit').css('display', 'inline');
                $.ajax({
                    url: '/admin/perubahannunit-by-id/' + id_unit,
                    type: 'GET',
                    success: function(data) {
                        $('#id_pemilik').val(data.unit.id_pemilik)
                    }
                })
            })
        })
    </script>

    <script>
        function calcDate() {
            var periode = $('#periode_edit').find(':selected').text()
            var selectedDate = $('#tgl_masuk_edit').val();
            var date = new Date(selectedDate);
            var addMonth = date.setMonth(date.getMonth() + parseInt(periode));
            var parseDate = new Date(addMonth);
            var newDate = parseDate.toISOString().split('T')[0]

            return newDate;
        }

        $('#tgl_masuk_edit').on('change', function() {
            var date = calcDate();
            $('#tgl_keluar_edit').val(date)
        })

        $('#periode_edit').on('change', function() {
            var date = calcDate();
            $('#tgl_keluar_edit').val(date)
        })
    </script>
@endsection
{{--
<div class="modal-footer">
    <button class="btn btn-primary" type="submit">Simpan
    </button>
</div> --}}
