                  
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

                        {{-- <div class="fs--1" style="max-width: 33rem;" >
                            <a class="notification">
                              <div class="notification-avatar">
                                <div class="avatar me-3 fas fa-user">
                                </div>
                              </div>
                              <div class="notification-body" >
                                <p class="mb-1"><strong>Unit  </strong></p>
                                 <select class="form-control" name="id_unit" id="id_unit" @readonly(true) readonly>
                                    <option value="{{ $kepemilikans->id_unit }}">{{ $kepemilikans->unit->nama_unit }}</option>
                            </select>
                              </div>
                            </a>
                          </div> --}}

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
                </div>
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
                        {{-- <a href="{{ route('kepemilikans.edit', $kepemilikans->id_pemilik) }}" class="btn btn-sm btn-warnin g">Edit</a> --}}
                        {{-- <a class="btn btn-sm btn-warning" href="{{ route('perubahanunits.index',)}}">Back</a> --}}
                        <div class="mb-3">
                            <div class=" my-3">
                        <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#error-modal">Pindah Kepemilikan Unit</button>
                        <div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
                            <div class="modal-content position-relative">
                              <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                  <form action="{{ route('deleteKepemilikanUnit', $kepemilikans->id_pemilik) }}" method="post"
                                    class="d-inline">
                                    @csrf
                                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-0">
                                <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                  <h4 class="mb-1" id="modalExampleDemoLabel">Alasan Pindah Kepemilikan Unit</h4>
                                </div>
                                <div class="p-4 pb-0">
                                    <form method="post" action="{{ route('offkepemilkanunits.store') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="col-form-label" for="message-text">Tanggal Keluar :</label>
                                        <input type="date" class="form-control" name="tgl_keluar" id="message-text">
                                    </div>
                                    <div class="mb-3">
                                        <label class="col-form-label" for="message-text">Keterangan :</label>
                                        <textarea class="form-control" name="keterangan" id="message-text"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                        </form>
                            </div>
                          </div>
                        </div>
                            </div>
                        </div>
                        {{-- <a class="btn btn-sm btn-warning" href="{{ route('editkepemilikanunit', $kepemilikans->id_pemilik)}}">Pindah Kepemilikan</a> --}}
                        {{-- <form class="d-inline" action="{{ route('kepemilikans.destroy', $kepemilikans->id_pemilik) }}" method="post">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('are you sure?')"><span class="fas fa-trash-alt fs--2 me-1"></span>OffBoarding</button>
                        </form> --}}

                        {{-- <div class="mb-3">
                            <div class=" my-3">
                        <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#error-modal">OffBoarding</button>
                        <div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
                            <div class="modal-content position-relative">
                              <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                <form class="d-inline" action="{{ route('kepemilikans.destroy', $kepemilikans->id_pemilik) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-0">
                                <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                  <h4 class="mb-1" id="modalExampleDemoLabel">Alasan Off Kepemilikan Unit</h4>
                                </div>
                                <div class="p-4 pb-0">
                                    <form method="post" action="{{ route('offtenantunits.store') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="col-form-label" for="message-text">Keterangan :</label>
                                        <textarea class="form-control" name="keterangan" id="message-text"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                        </form>
                            </div>
                          </div>
                        </div>
                            </div>
                        </div> --}}

        </div>
    </div>
@endsection

@section('script')
    <script>
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
