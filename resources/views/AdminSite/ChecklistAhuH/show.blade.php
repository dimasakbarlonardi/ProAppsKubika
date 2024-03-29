{{-- @extends('layouts.master')

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
                              <td>: {{$equiqmentdetail->no_checklist}}</td>
                            </tr>
                            <tr> 
                                <th><b>Tanggal & Time Inspection </b></th>
                                <td>: {{\Carbon\Carbon::parse($equiqmentdetail->tgl_checklist)->format(' d M Y') }} - {{\Carbon\Carbon::createFromFormat('H:i:s',$equiqmentdetail->time_checklist)->format('h:i')}}</td>
                                <th><b>Room </b></th>
                                <td>: {{ $checklistahu->room->nama_room }}</td>
                            </tr>
                            <tr>
                                <th><b>Equiqment </b></th>
                                <td>: {{$checklistahu->equiqment}}</td>
                              <th><b>PIC </b></th>
                                <td>: {{ $checklistahu->role->nama_role}}</td>
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
                                <th class="sort" data-sort="no_checklist">Nomer Inspection AHU</th>
                                <th class="sort" data-sort="usage_return">Usage/Return</th>
                                <th class="sort" data-sort="id_checklist_equiqment_parameter">Inspection</th>
                                <th class="sort" data-sort="keterangan">Keterangan</th>
                              </tr>
                            </thead>
                            <tbody class="list">
                              <tr value="{{$equiqmentdetail->id_equiqment}}">
                                <td class="no_checklist_ahu">{{ $equiqmentdetail->no_checklist }}</td>
                                <td class="usage_return">{{\Carbon\Carbon::parse($equiqmentdetail->usage_return)->format(' d M Y') }}</td>
                                @foreach ($parameters as $parameter)
                                <td  class="row"> {{ $parameter->id_equiqment}}</td>
                                @endforeach
                                <td class="keterangan">{{ $equiqmentdetail->keterangan }}</td>
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
@endsection --}}
