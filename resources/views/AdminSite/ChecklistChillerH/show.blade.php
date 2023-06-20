@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="my-3 text-light">Check List Chiller</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('checklistchillers.store') }}">
                @csrf
                <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label"><b>Barcode Room </b> : {{$checklistchiller->barcode_room}}</label>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label"><b>Nomer Checklist Chiller </b> : {{$checklistchiller->no_checklist_chiller}}</label>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label"><b>Room </b> : {{ $checklistchiller->room->nama_room }}</label>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label"><b>Tanggal Checklist </b> : {{$checklistchiller->tgl_checklist}}</label>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label"><b>Time Checklist </b> : {{$checklistchiller->time_checklist}}</label>
                </div>
                <div class=" col-6 mb-3">
                    @foreach ($idusers as $iduser)
                    <label class="form-label"><b>User </b> : {{ $iduser->name}}</label>
                    @endforeach
                </div>

                <div class="mt-3" id="biaya">
                    <h6><b>DETAIL CHECKLIS Chiller</b></h6>
                    <hr>
                 <div class="row mb-3">

                    <div id="tableExample2" data-list='{"valueNames":["no_checklist_ahu","in_out","check_point","keterangan"],"page":5,"pagination":true}'>
                        <div class="table-responsive scrollbar">
                          <table class="table table-bordered table-striped fs--1 mb-0">
                            <thead class="bg-200 text-900">
                              <tr>
                                <th class="sort" data-sort="no_checklist_ahu">Nomer Checklist AHU</th>
                                <th class="sort" data-sort="in_out">In / Out</th>
                                <th class="sort" data-sort="check_point">Checkpoint</th>
                                <th class="sort" data-sort="keterangan">Keterangan</th>
                              </tr>
                            </thead>
                            <tbody class="list">
                              <tr>
                                <td class="no_checklist_ahu">{{ $chillerdetail->no_checklist_chiller }}</td>
                                <td class="in_out">{{ $chillerdetail->in_out}}</td>
                                <td class="check_point">{{ $chillerdetail->check_point }}</td>
                                <td class="keterangan">{{ $chillerdetail->keterangan }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                       
                      </div>

                    {{-- <div class="col-6">
                        <label class="form-label">Nomer Checklist AHU</label>
                        <input type="text"  value=" " class="form-control" required>
                    </div>
                    <div class=" col-6">
                        <label class="form-label">IN / OUT</label>
                        <input type="text"  value="{{ $ahudetail->in_out}}" class="form-control" required>
                    </div>
                    <div class=" col-6">
                        <label class="form-label">Check Point</label>
                        <input type="text"  value="{{ $ahudetail->check_point }}" class="form-control" required>
                    </div>
                    <div class=" col-6">
                        <label class="form-label">Keterangan</label>
                        <input type="text"  value="{{ $ahudetail->keterangan }}" class="form-control" required>
                    </div> --}}
                <div class="mt-5">
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('checklistchillers.index')}}">Back</a></button>
                </div>
                 </div>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection