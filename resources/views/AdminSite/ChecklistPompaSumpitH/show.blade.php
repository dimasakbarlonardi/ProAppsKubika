@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="my-3 text-light">Check List Pompa Sumpit</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('checklistpompasumpits.store') }}">
                @csrf
                <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label"><b>Barcode Room </b> : {{$checklistpompasumpit->barcode_room}}</label>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label"><b>Nomer Checklist Pompa Sumpit </b> : {{$checklistpompasumpit->no_checklist_pompa_sumpit}}</label>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label"><b>Room </b> : {{ $checklistpompasumpit->room->nama_room }}</label>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label"><b>Tanggal Checklist </b> : {{$checklistpompasumpit->tgl_checklist}}</label>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label"><b>Time Checklist </b> : {{$checklistpompasumpit->time_checklist}}</label>
                </div>
                <div class=" col-6 mb-3">
                    @foreach ($idusers as $iduser)
                    <label class="form-label"><b>User </b> : {{ $iduser->name}}</label>
                    @endforeach
                </div>

                <div class="mt-3" id="biaya">
                    <h6><b>DETAIL CHECKLIS Pompa Sumpit</b></h6>
                    <hr>
                 <div class="row mb-3">

                    <div id="tableExample2" data-list='{"valueNames":["no_checklist_pompa_sumpit","in_out","check_point","keterangan"],"page":5,"pagination":true}'>
                        <div class="table-responsive scrollbar">
                          <table class="table table-bordered table-striped fs--1 mb-0">
                            <thead class="bg-200 text-900">
                              <tr>
                                <th class="sort" data-sort="no_checklist_pompa_sumpit">Nomer Checklist Pompa Sumpit</th>
                                <th class="sort" data-sort="check_point1">Checkpoint 1</th>
                                <th class="sort" data-sort="check_point2">Checkpoint 2</th>
                                <th class="sort" data-sort="check_point3">Checkpoint 3</th>
                                <th class="sort" data-sort="check_point4">Checkpoint 4</th>
                                <th class="sort" data-sort="check_point5">Checkpoint 5</th>
                                <th class="sort" data-sort="check_point6">Checkpoint 6</th>
                                <th class="sort" data-sort="check_point7">Checkpoint 7</th>
                                <th class="sort" data-sort="keterangan">Keterangan</th>
                              </tr>
                            </thead>
                            <tbody class="list">
                              <tr>
                                <td class="no_checklist_pompa_sumpit">{{ $pompasumpitdetail->no_checklist_pompa_sumpit }}</td>
                                <td class="check_point1">{{ $pompasumpitdetail->check_point1 }}</td>
                                <td class="check_point2">{{ $pompasumpitdetail->check_point2 }}</td>
                                <td class="check_point3">{{ $pompasumpitdetail->check_point3 }}</td>
                                <td class="check_point4">{{ $pompasumpitdetail->check_point4 }}</td>
                                <td class="check_point5">{{ $pompasumpitdetail->check_point5 }}</td>
                                <td class="check_point6">{{ $pompasumpitdetail->check_point6 }}</td>
                                <td class="check_point7">{{ $pompasumpitdetail->check_point7 }}</td>
                                <td class="keterangan">{{ $pompasumpitdetail->keterangan }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                       
                      </div>
                <div class="mt-5">
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('checklistpompasumpits.index')}}">Back</a></button>
                </div>
                 </div>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection
