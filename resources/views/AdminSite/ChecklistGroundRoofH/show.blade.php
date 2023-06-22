@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="my-3 text-light">Check List GroundRoof</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('checklistgroundroofs.store') }}">
                @csrf
                <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label"><b>Barcode Room </b> : {{$checklistgroundroof->barcode_room}}</label>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label"><b>Nomer Checklist GroundRoof </b> : {{$checklistgroundroof->no_checklist_tank}}</label>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label"><b>Room </b> : {{ $checklistgroundroof->room->nama_room }}</label>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label"><b>Tanggal Checklist </b> : {{$checklistgroundroof->tgl_checklist}}</label>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label"><b>Time Checklist </b> : {{$checklistgroundroof->time_checklist}}</label>
                </div>
                <div class=" col-6 mb-3">
                    @foreach ($idusers as $iduser)
                    <label class="form-label"><b>User </b> : {{ $iduser->name}}</label>
                    @endforeach
                </div>

                <div class="mt-3" id="biaya">
                    <h6><b>DETAIL CHECKLIS GroundRoof</b></h6>
                    <hr>
                 <div class="row mb-3">

                    <div id="tableExample2" data-list='{"valueNames":["no_checklist_ahu","in_out","check_point","keterangan"],"page":5,"pagination":true}'>
                        <div class="table-responsive scrollbar">
                          <table class="table table-bordered table-striped fs--1 mb-0">
                            <thead class="bg-200 text-900">
                              <tr>
                                <th class="sort" data-sort="no_checklist_tank">Nomer Checklist GroundRoof</th>
                                <th class="sort" data-sort="check_point1">Checkpoint 1</th>
                                <th class="sort" data-sort="check_point2">Checkpoint 2</th>
                                <th class="sort" data-sort="check_point3">Checkpoint 3</th>
                                <th class="sort" data-sort="keterangan">Keterangan</th>
                              </tr>
                            </thead>
                            <tbody class="list">
                              <tr>
                                <td class="no_checklist_ahu">{{ $groundroofdetail->no_checklist_tank }}</td>
                                <td class="check_point1">{{ $groundroofdetail->check_point1}}</td>
                                <td class="check_point2">{{ $groundroofdetail->check_point2 }}</td>
                                <td class="check_point3">{{ $groundroofdetail->check_point3 }}</td>
                                <td class="keterangan">{{ $groundroofdetail->keterangan }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                       
                      </div>

                <div class="mt-5">
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('checklistgroundroofs.index')}}">Back</a></button>
                </div>
                 </div>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection
