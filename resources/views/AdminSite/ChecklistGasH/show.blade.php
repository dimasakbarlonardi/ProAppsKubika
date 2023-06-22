@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="my-3 text-light">Check List Gas</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('checklistgases.store') }}">
                @csrf
                <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label"><b>Barcode Room </b> : {{$checklistgas->barcode_room}}</label>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label"><b>Nomer Checklist Gas </b> : {{$checklistgas->no_checklist_gas}}</label>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label"><b>Room </b> : {{ $checklistgas->room->nama_room }}</label>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label"><b>Tanggal Checklist </b> : {{$checklistgas->tgl_checklist}}</label>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label"><b>Time Checklist </b> : {{$checklistgas->time_checklist}}</label>
                </div>
                <div class=" col-6 mb-3">
                    @foreach ($idusers as $iduser)
                    <label class="form-label"><b>User </b> : {{ $iduser->name}}</label>
                    @endforeach
                </div>

                <div class="mt-3" id="biaya">
                    <h6><b>DETAIL CHECKLIS Gas</b></h6>
                    <hr>
                 <div class="row mb-3">

                    <div id="tableExample2" data-list='{"valueNames":["no_checklist_ahu","in_out","check_point","keterangan"],"page":5,"pagination":true}'>
                        <div class="table-responsive scrollbar">
                          <table class="table table-bordered table-striped fs--1 mb-0">
                            <thead class="bg-200 text-900">
                              <tr>
                                <th class="sort" data-sort="no_checklist_gas">Nomer Checklist Gas</th>
                                <th class="sort" data-sort="data1">Data 1</th>
                                <th class="sort" data-sort="data2">Data 2</th>
                                <th class="sort" data-sort="data3">Data 3</th>
                                <th class="sort" data-sort="data4">Data 4</th>
                                <th class="sort" data-sort="total1">Total 1</th>
                                <th class="sort" data-sort="total2">Total 2</th>
                                <th class="sort" data-sort="keterangan">Keterangan</th>
                              </tr>
                            </thead>
                            <tbody class="list">
                              <tr>
                                <td class="no_checklist_gas">{{ $gasdetail->no_checklist_gas }}</td>
                                <td class="data1">{{ $gasdetail->data1}}</td>
                                <td class="data2">{{ $gasdetail->data2 }}</td>
                                <td class="data3">{{ $gasdetail->data3}}</td>
                                <td class="data4">{{ $gasdetail->data4 }}</td>
                                <td class="total1">{{ $gasdetail->total1}}</td>
                                <td class="total2">{{ $gasdetail->total2 }}</td>
                                <td class="keterangan">{{ $gasdetail->keterangan }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                       
                      </div>
                <div class="mt-5">
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('checklistgases.index')}}">Back</a></button>
                </div>
                 </div>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection
