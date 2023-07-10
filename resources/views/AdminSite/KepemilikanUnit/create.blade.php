@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Tambah Kepemilikan Unit</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
                <form method="post" action="/admin/kepemilikans">
                @csrf
                <div class="mb-5">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">ID Pemilik</label>
                            <select class="form-control" name="id_pemilik" id="id_pemilik" required>
                                <option selected disabled>-- Pilih ID Pemilik --</option>
                                @foreach ($owners as $owner)
                                    <option value="{{ $owner->id_pemilik }}">{{ $owner->nama_pemilik }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">ID Unit</label>
                            <select class="form-control" name="id_unit" id="id_unit" required>
                                <option selected disabled>-- Pilih ID Unit --</option>
                                {{-- @foreach ($units as $unit)
                                    <option value="{{ $unit->id_unit }}">{{ $unit->nama_unit }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">ID Status Hunian</label>
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
                            <input type="date" name="tgl_mulai" class="form-control">
                        </div>
                        <div class="col-6 mb-3 ">
                            <label class="form-label">No Bukti Milik</label>
                            <input type="text" name="no_bukti_milik" class="form-control" >
                        </div>
                        <div class="col-6 mb-3 ">
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" >
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
                    <a class="btn btn-sm btn-warning" href="{{ route('kepemilikans.index')}}">Back</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('document').ready(function() {
            $('#id_pemilik').on('change', function() {
                var id_pemilik = $(this).val()
                $.ajax({
                    url: '/admin/kepemilikan-unit/' + id_pemilik,
                    type: 'GET',
                    success: function(data) {
                        console.log(data.units)
                        $.each(data.units, function(key, value) {
                            console.log(key, value.id_unit)
                            $("#id_unit").append('<option value=' + value.id_unit +
                                '>' + value.nama_unit + '</option>');
                        });
                    }
                }) 

            })

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
@endsection
