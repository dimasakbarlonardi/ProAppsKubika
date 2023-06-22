@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="my-3 text-light">Check List Pemadam</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('checklistpemadams.store') }}">
                @csrf
                <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label"><b>Barcode Room </b> : {{$checklistpemadam->barcode_room}}</label>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label"><b>Nomer Checklist Pemadam </b> : {{$checklistpemadam->no_checklist_pemadam}}</label>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label"><b>Room </b> : {{ $checklistpemadam->room->nama_room }}</label>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label"><b>Tanggal Checklist </b> : {{$checklistpemadam->tgl_checklist}}</label>
                </div>
                <div class=" col-6 mb-3">
                    <label class="form-label"><b>Time Checklist </b> : {{$checklistpemadam->time_checklist}}</label>
                </div>
                <div class=" col-6 mb-3">
                    @foreach ($idusers as $iduser)
                    <label class="form-label"><b>User </b> : {{ $iduser->name}}</label>
                    @endforeach
                </div>

                <div class="mt-3" id="biaya">
                    <h6><b>DETAIL CHECKLIS Pemadam</b></h6>
                    <hr>
                 <div class="row mb-3">

                    <div id="tableExample2" data-list='{"valueNames":["no_checklist_ahu","in_out","check_point","keterangan"],"page":5,"pagination":true}'>
                        <div class="table-responsive scrollbar">
                          <table class="table table-bordered table-striped fs--1 mb-0">
                            <thead class="bg-200 text-900">
                              <tr>
                                <th class="sort" data-sort="no_checklist_pemadam">Nomer Checklist Pemadam</th>
                                <th class="sort" data-sort="data1">CheckPoint 1</th>
                                <th class="sort" data-sort="data2">CheckPoint 2</th>
                                <th class="sort" data-sort="data3">CheckPoint 3</th>
                                <th class="sort" data-sort="data4">CheckPoint 4</th>
                                <th class="sort" data-sort="total1">CheckPoint 5</th>
                                <th class="sort" data-sort="total2">CheckPoint 6</th>
                                <th class="sort" data-sort="data1">CheckPoint 7</th>
                                <th class="sort" data-sort="data2">CheckPoint 8</th>
                                <th class="sort" data-sort="data3">CheckPoint 9</th>
                                <th class="sort" data-sort="data4">CheckPoint 10</th>
                                <th class="sort" data-sort="total1">CheckPoint 11</th>
                                <th class="sort" data-sort="total2">CheckPoint 12</th>
                                <th class="sort" data-sort="keterangan">Keterangan</th>
                              </tr>
                            </thead>
                            <tbody class="list">
                              <tr>
                                <td class="no_checklist_pemadam">{{ $pemadamdetail->no_checklist_pemadam }}</td>
                                <td class="check_point1">{{ $pemadamdetail->check_point1}}</td>
                                <td class="check_point2">{{ $pemadamdetail->check_point2 }}</td>
                                <td class="check_point3">{{ $pemadamdetail->check_point3}}</td>
                                <td class="check_point4">{{ $pemadamdetail->check_point4 }}</td>
                                <td class="check_point5">{{ $pemadamdetail->check_point5}}</td>
                                <td class="check_point6">{{ $pemadamdetail->check_point6 }}</td>
                                <td class="check_point7">{{ $pemadamdetail->check_point7}}</td>
                                <td class="check_point8">{{ $pemadamdetail->check_point8 }}</td>
                                <td class="check_point9">{{ $pemadamdetail->check_point9}}</td>
                                <td class="check_point10">{{ $pemadamdetail->check_point10 }}</td>
                                <td class="check_point11">{{ $pemadamdetail->check_point11}}</td>
                                <td class="check_point12">{{ $pemadamdetail->check_point12 }}</td>
                                <td class="keterangan">{{ $pemadamdetail->keterangan }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                       
                      </div>
                <div class="mt-5">
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('checklistpemadams.index')}}">Back</a></button>
                </div>
                 </div>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection
