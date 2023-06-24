@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="my-3 text-light">Check List Temperatur</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('checklisttemperaturs.store') }}">
                @csrf
                <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label"><b>Barcode Room </b> : {{$checklisttemperatur->barcode_room}}</label>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label"><b>Nomer Checklist Temperatur </b> : {{$checklisttemperatur->no_checklist_temperatur}}</label>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label"><b>Room </b> : {{ $checklisttemperatur->room->nama_room }}</label>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label"><b>Tanggal Checklist </b> : {{$checklisttemperatur->tgl_checklist}}</label>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label"><b>Time Checklist </b> : {{$checklisttemperatur->time_checklist}}</label>
                </div>
                <div class=" col-6 mb-3">
                    @foreach ($idusers as $iduser)
                    <label class="form-label"><b>User </b> : {{ $iduser->name}}</label>
                    @endforeach
                </div>

                <div class="mt-3" id="biaya">
                    <h6><b>DETAIL CHECKLIS Temperatur</b></h6>
                    <hr>
                 <div class="row mb-3">

                    <div id="tableExample2" data-list='{"valueNames":["no_checklist_ahu","in_out","check_point","keterangan"],"page":5,"pagination":true}'>
                        <div class="table-responsive scrollbar">
                          <table class="table table-bordered table-striped fs--1 mb-0">
                            <thead class="bg-200 text-900">
                              <tr>
                                <th class="sort" data-sort="no_checklist_temperatur">Nomer Checklist Temperatur</th>
                                <th class="sort" data-sort="id_lantai">Lantai</th>
                                <th class="sort" data-sort="checkpoint1">CheckPoint 1</th>
                                <th class="sort" data-sort="checkpoint2">CheckPoint 2</th>
                                <th class="sort" data-sort="checkpoint3">CheckPoint 3</th>
                                <th class="sort" data-sort="checkpoint4">CheckPoint 4</th>
                                <th class="sort" data-sort="checkpoint5">CheckPoint 5</th>
                                <th class="sort" data-sort="checkpoint6">CheckPoint 6</th>
                                <th class="sort" data-sort="jam">Jam</th>
                                <th class="sort" data-sort="keterangan">Keterangan</th>
                              </tr>
                            </thead>
                            <tbody class="list">
                              <tr>
                                <td class="no_checklist_temperatur">{{ $temperaturdetail->no_checklist_temperatur }}</td>
                                <td class="id_lantai">{{ $temperaturdetail->id_lantai}}</td>
                                <td class="check_point1">{{ $temperaturdetail->check_point1}}</td>
                                <td class="check_point2">{{ $temperaturdetail->check_point2 }}</td>
                                <td class="check_point3">{{ $temperaturdetail->check_point3}}</td>
                                <td class="check_point4">{{ $temperaturdetail->check_point4 }}</td>
                                <td class="checkpoint5">{{ $temperaturdetail->checkpoint5}}</td>
                                <td class="checkpoint6">{{ $temperaturdetail->checkpoint6 }}</td>
                                <td class="jam">{{ $temperaturdetail->jam}}</td>
                                <td class="keterangan">{{ $temperaturdetail->keterangan }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                       
                      </div>
                <div class="mt-5">
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('checklisttemperaturs.index')}}">Back</a></button>
                </div>
                 </div>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection
