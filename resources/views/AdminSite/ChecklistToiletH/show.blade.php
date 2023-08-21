@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="my-3 text-light">Check List Toilet</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('checklisttoilets.store') }}">
                @csrf
                <div class="row">
                    <body>
                        <table>
                            <tr>
                                <th><b>Barcode Room </b></th>
                                <td>: {{$checklisttoilet->barcode_room}}</td>
                                <th><b>Nomer Inspection Toilet </b></th>
                              <td>: {{$checklisttoilet->no_checklist_toilet}}</td>
                            </tr>
                            <tr>
                                <th><b>Tanggal & Time Inspection </b></th>
                                <td>: {{\Carbon\Carbon::parse($checklisttoilet->tgl_checklist)->format(' d M Y') }} - {{\Carbon\Carbon::createFromFormat('H:i:s',$checklisttoilet->time_checklist)->format('h:i')}}</td>
                                <th><b>Room </b></th>
                                <td>: {{ $checklisttoilet->room->nama_room }}</td>
                            </tr>
                            <tr>
                                <th><b>Equiqment </b></th>
                                <td>: {{$checklisttoilet->equiqment->equiqment}}</td>
                              <th><b>PIC </b></th>
                                <td>: {{ $checklisttoilet->role->nama_role}}</td>
                            </tr>
                        </table>
                      </body>
                <div class="mt-3" id="biaya">
                    <h6><b>DETAIL CHECKLIS TOILET</b></h6>
                    <hr>
                 <div class="row mb-3">

                    <div id="tableExample2" data-list='{"valueNames":["no_checklist_ahu","in_out","check_point","keterangan"],"page":5,"pagination":true}'>
                        <div class="table-responsive scrollbar">
                          <table class="table table-bordered table-striped fs--1 mb-0">
                            <thead class="bg-200 text-900">
                              <tr>
                                <th class="sort" data-sort="no_checklist_toilet">Nomer Inspection Toilet</th>
                                <th class="sort" data-sort="id_checklist_equiqment_parameter">Inspection</th>
                                <th class="sort" data-sort="keterangan">Keterangan</th>
                              </tr>
                            </thead>
                            <tbody class="list">
                              <tr>
                                <td class="no_checklist_toilet">{{ $toiletdetail->no_checklist_toilet }}</td>
                                @foreach ($parameters as $item)
                                <td class="row" value="{{ $toiletdetail->id_equiqment}}">{{ $item->checklisttoilet }}</td>
                                @endforeach
                                <td class="keterangan">{{ $toiletdetail->keterangan }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                       
                      </div>
                <div class="mt-5">
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('checklisttoilets.index')}}">Back</a></button>
                </div>
                 </div>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection
