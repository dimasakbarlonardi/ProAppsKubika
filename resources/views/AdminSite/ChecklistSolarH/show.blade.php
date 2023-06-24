@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="my-3 text-light">Check List Solar</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('checklistsolars.store') }}">
                @csrf
                <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label"><b>Barcode Room </b> : {{$checklistsolar->barcode_room}}</label>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label"><b>Nomer Checklist Solar </b> : {{$checklistsolar->no_checklist_solar}}</label>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label"><b>Room </b> : {{ $checklistsolar->room->nama_room }}</label>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label"><b>Tanggal Checklist </b> : {{$checklistsolar->tgl_checklist}}</label>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label"><b>Time Checklist </b> : {{$checklistsolar->time_checklist}}</label>
                </div>
                <div class=" col-6 mb-3">
                    @foreach ($idusers as $iduser)
                    <label class="form-label"><b>User </b> : {{ $iduser->name}}</label>
                    @endforeach
                </div>

                <div class="mt-3" id="biaya">
                    <h6><b>DETAIL CHECKLIS Solar</b></h6>
                    <hr>
                 <div class="row mb-3">

                    <div id="tableExample2" data-list='{"valueNames":["no_checklist_ahu","in_out","check_point","keterangan"],"page":5,"pagination":true}'>
                        <div class="table-responsive scrollbar">
                          <table class="table table-bordered table-striped fs--1 mb-0">
                            <thead class="bg-200 text-900">
                              <tr>
                                <th class="sort" data-sort="no_checklist_solar">Nomer Checklist Solar</th>
                                <th class="sort" data-sort="checkpoint1">CheckPoint 1</th>
                                <th class="sort" data-sort="checkpoint2">CheckPoint 2</th>
                                <th class="sort" data-sort="checkpoint3">CheckPoint 3</th>
                                <th class="sort" data-sort="checkpoint4">CheckPoint 4</th>
                                <th class="sort" data-sort="data1">Data 1</th>
                                <th class="sort" data-sort="data2">Data 2</th>
                                <th class="sort" data-sort="jam1">Jam 1</th>
                                <th class="sort" data-sort="jam2">Jam 2</th>

                                <th class="sort" data-sort="keterangan">Keterangan</th>
                              </tr>
                            </thead>
                            <tbody class="list">
                              <tr>
                                <td class="no_checklist_solar">{{ $solardetail->no_checklist_solar }}</td>
                                <td class="check_point1">{{ $solardetail->check_point1}}</td>
                                <td class="check_point2">{{ $solardetail->check_point2 }}</td>
                                <td class="check_point3">{{ $solardetail->check_point3}}</td>
                                <td class="check_point4">{{ $solardetail->check_point4 }}</td>
                                <td class="data1">{{ $solardetail->data1}}</td>
                                <td class="data2">{{ $solardetail->data2 }}</td>
                                <td class="jam1">{{ $solardetail->jam1}}</td>
                                <td class="jam2">{{ $solardetail->jam2 }}</td>
                                <td class="keterangan">{{ $solardetail->keterangan }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                       
                      </div>
                <div class="mt-5">
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('checklistsolars.index')}}">Back</a></button>
                </div>
                 </div>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection
