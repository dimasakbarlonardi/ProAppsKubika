@extends('layouts.master')

@section('content')


    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="my-3 text-light">Inspection AHU</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('checklistahus.store') }}">
                @csrf
                <div class="row">
                    <body>

                        <table>
                            <tr>
                                <th><b>Barcode Room </b></th>
                                <td>: {{$checklistahu->barcode_room}}</td>
                                <th><b>Nomer Inspection AHU </b></th>
                              <td>: {{$checklistahu->no_checklist_ahu}}</td>
                            </tr>
                            <tr>
                                <th><b>Tanggal Checklist </b></th>
                                <td>: {{$checklistahu->tgl_checklist}}</td>
                                <th><b>Room </b></th>
                                <td>: {{ $checklistahu->room->nama_room }}</td>
                            </tr>
                            <tr>
                                <th><b>Time Inspection </b></th>
                                <td>: {{$checklistahu->time_checklist}}</td>
                              <th><b>User </b></th>
                              @foreach ($idusers as $iduser)
                                <td>: {{ $iduser->name}}</td>
                                @endforeach
                            </tr>
                        </table>
                        
                        </body>


                <div class="mt-5" id="biaya" >
                    <h6><b>DETAIL Inspection AHU</b></h6>
                    <hr>
                 <div class="row mb-3">

                    <div id="tableExample2" data-list='{"valueNames":["no_checklist_ahu","in_out","check_point","keterangan"],"page":5,"pagination":true}'>
                        <div class="table-responsive scrollbar">
                          <table class="table table-bordered table-striped fs--1 mb-0">
                            <thead class="bg-200 text-900">
                              <tr>
                                <th class="sort" data-sort="no_checklist_ahu">Nomer Inspection AHU</th>
                                <th class="sort" data-sort="in_out">In / Out</th>
                                <th class="sort" data-sort="check_point">Checkpoint</th>
                                <th class="sort" data-sort="keterangan">Keterangan</th>
                              </tr>
                            </thead>
                            <tbody class="list">
                              <tr>
                                <td class="no_checklist_ahu">{{ $ahudetail->no_checklist_ahu }}</td>
                                <td class="in_out">{{ $ahudetail->in_out}}</td>
                                <td class="check_point">{{ $ahudetail->check_point }}</td>
                                <td class="keterangan">{{ $ahudetail->keterangan }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                       
                      </div>
                <div class="mt-5">
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('checklistahus.index')}}">Back</a></button>
                </div>
                 </div>
                </div>
            </form>
        </div>
    </div>
@endsection
