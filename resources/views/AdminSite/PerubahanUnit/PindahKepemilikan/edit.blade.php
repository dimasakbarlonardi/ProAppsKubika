@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Pindah Kepemilikan Unit</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('updateKU', $kepemilikans->id_pemilik)}}">
                @csrf
                <div class="mb-5">
                    <div class="row">
                        
                        {{-- <div class="col-4 mb-3">
                            <label class="form-label">Unit</label>
                            <select class="form-control" name="id_unit" id="id_unit" @readonly(true) readonly>
                                <option value="{{ $kepemilikans->id_unit }}">{{ $kepemilikans->unit->nama_unit }}</option>
                            </select>
                        </div> --}}
                        <div class="col-6 mb-3">
                            <label class="form-label">Pemilik</label>
                            <select class="form-control" name="id_pemilik" id="id_pemilik" required>
                                <option selected disabled>-- Pilih Pemilik --</option>
                                @foreach ($owners as $owner)
                                    <option value="{{ $owner->id_pemilik }}" {{ $owner->id_pemilik == $kepemilikans->id_pemilik ? 'selected':''}}>{{ $owner->nama_pemilik }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Unit</label>
                            <select class="form-control" name="id_unit" id="id_unit" required>
                                <option selected disabled>-- Pilih Unit --</option>
                                @foreach ($kepemilikanunits as $unit)
                                    <option value="{{ $unit->id_unit }}">
                                        {{ $unit->Unit->nama_unit }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3" id="detail_kepemilikan_unit" style="display: none">
                        <div class="table-responsive scrollbar">
                            <table class="table">
                                <tr>
                                    <th scope="col"><b> Information Kepemilikan Unit </b></th>
                                </tr>
                                <tr>
                                    <th scope="col">Status Hunian</th>
                                    <td scope="col">
                                        <input type="text" maxlength="3" id="id_status_hunian" name="id_status_hunian" class="form-control" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col">Tanggal Mulai</th>
                                    <td scope="col">
                                        <input type="text" id="tgl_mulai" name="tgl_mulai" class="form-control" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col">No Bukti Milik</th>
                                    <td scope="col">
                                        <input type="text" maxlength="3" id="no_bukti_milik" name="no_bukti_milik" class="form-control" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col">Keterangan</th>
                                    <td scope="col">
                                        <input type="text" id="keterangan" name="keterangan" class="form-control" readonly>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                        {{-- <div class="col-6 mb-3">
                            <label class="form-label">Status Hunian</label>
                            <select class="form-control" name="id_status_hunian" required>
                                <option selected disabled>-- Pilih Status Hunian --</option>
                                @foreach ($statushunians as $statushunian)
                                    <option value="{{ $statushunian->id_statushunian_tenant }}">
                                        {{ $statushunian->status_hunian_tenant }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 mb-3 ">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tgl_mulai" class="form-control" >
                        </div>
                        <div class="col-6 mb-3 ">
                            <label class="form-label">No Bukti Milik</label>
                            <input type="text" name="no_bukti_milik" class="form-control" >
                        </div>
                        <div class="col-6 mb-3 ">
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" required>
                        </div>
                    </div> --}}
                    <div class="row mt-3">
                        <th scope="col"><b> keterangan pindah kepemilikan </b></th>'
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3 mt-2 ">
                            <label class="form-label">Tanggal Perpindahan</label>
                            <input type="date" name="tgl_keluar" class="form-control" >
                        </div>
                        <div class="col-6 mb-3 mt-2 ">
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3" id="detail_unit" style="display: none">
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
                            <input type="hidden" name="id_unit" id="id_unit_input">
                        </table>
                    </div>
                </div>

                <div class="mt-5">
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('perubahanunits.index')}}">Back</a></button>
                    <button type="submit" class="btn btn-primary">Submit</button>
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
        })
    </script>

<script>
    $('document').ready(function() {
        $('#id_unit').on('change', function() {
            var id_unit = $(this).val();

            $('#detail_kepemilikan_unit').css('display', 'inline');
            $.ajax({
                url: '/admin/kepemilikanunit-by-id/' + id_unit,
                type: 'GET',
                success: function(data) {
                    console.log(data.unit)
                    $('#id_status_hunian').val(data.unit.id_status_hunian)
                    $('#tgl_mulai').val(data.unit.tgl_mulai)
                    $('#no_bukti_milik').val(data.unit.no_bukti_milik)
                    $('#keterangan').val(data.unit.keterangan)
                }
            })
        })
    })
</script>
@endsection
