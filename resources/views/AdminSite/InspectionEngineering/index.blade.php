@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}">
@endsection

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="my-3 col-auto">
                <h6 class="mb-0 text-white">List Agama</h6>
                </div>
                    <div class="col-auto d-flex">
                      <a class="btn btn-falcon-default text-600 btn-sm" href="{{ route('inspectionStore') }}"><span class="fas fa-plus fs--2 me-1"></span>Create Inspection Engineering</a>
                    </div>
                    </div>
                    </div>
                    <div class="p-5">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th class="sort" data-sort="">No</th>
                                    <th class="sort" data-sort="inspection">Inspection</th>
                                    <th class="sort">Action</th>
                                </tr>
                            </thead>
                            <tbody id="checklist_body">
                                @foreach ($inspections as $key => $inspection)
                                    <tr>
                                        <th scope="row">{{ $key + 1 }}</th>
                                        <td>{{ $inspection->inspection_engineering }}</td>
                                        <td>
                                            <div class="dropdown font-sans-serif position-static"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal" type="button" id="order-dropdown-0" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                                <div class="dropdown-menu dropdown-menu-end border py-0" aria-labelledby="order-dropdown-0">
                                                  <div class="py-2"><a class="dropdown-item text" href="{{ route('front', $inspection->id_inspection_engineering) }}">List Inspection Equiqment</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text" href="{{ route('checklist', $inspection->id_inspection_engineering) }}">Inspection Parameter</a>
                                            </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- <div class="col-xxl-2 col-xl-3">
                <div class="offcanvas offcanvas-end offcanvas-filter-sidebar border-0 dark__bg-card-dark h-auto rounded-xl-3"
                    tabindex="-1" id="ticketOffcanvas" aria-labelledby="ticketOffcanvasLabelCard">
                    <div class="card scrollbar shadow-none shadow-show-xl">
                        <div class="card-header d-none d-xl-block">
                            <h6 class="mb-0 text-light">Filter</h6>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="mb-3 mt-n2">
                                    <label class="form-label" for="timepicker2">Tanggal Inspection AHU</label>
                                    <input id="tgl_checklist" class="form-control datetimepicker" id="timepicker2" type="text" placeholder="d/m/y to d/m/y" data-options='{"mode":"range","dateFormat":"Y-m-d","disableMobile":true}' />
                                </div>
                                <div class="mb-3 mt-n2">
                                    <label class="mb-1">Nomer Inspection AHU</label>
                                    <select class="form-select form-select-sm" name="no_checklist_ahu" required id="no_checklist_ahu">
                                        <option type="reset" value=""> All </option>
                                        @foreach ($checklistahus as $checklistahu)
                                            <option value="{{ $checklistahu->no_checklist_ahu }}"> {{ $checklistahu->no_checklist_ahu }} </option>
                                            @endforeach
                                    </select>
                                </div>     
                                <div class="mb-3 mt-n2">
                                    <label class="mb-1">User Inspection AHU</label>
                                    <select class="form-select form-select-sm" name="user" required id="user">
                                        @foreach ($idusers as $iduser)
                                            <option value="{{ $iduser->id }}"> {{ $iduser->name }}</option>
                                        @endforeach
                                    </select>
                                </div>   
                                <div class="card-footer border-top border-200 py-x1">
                                    <button type="reset" class="btn btn-primary w-100">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
    <script>
        $('document').ready(function() {

            $('#tgl_checklist').on('change', function() {
                var no_checklist_ahu = $('#no_checklist_ahu').val()
                var tgl_checklist = $('#tgl_checklist').val()
                var date_from = tgl_checklist.substr(0, 10)
                var date_to = tgl_checklist.substr(14, 23)

                console.log("date from : ", date_from)
                console.log("date to : ", date_to)

                index(no_checklist_ahu, date_from, date_to)
            })
            $('#no_checklist_ahu').on('change', function() {
                var no_checklist_ahu = $('#no_checklist_ahu').val()
                var tgl_checklist = $('#tgl_checklist').val()
                var date_from = tgl_checklist.substr(0, 10)
                var date_to = tgl_checklist.substr(14, 23)

                index(no_checklist_ahu, date_from, date_to)
            })
        })

        function index(no_checklist_ahu, date_from, date_to) {
            $.ajax({
                url: '/admin/checklist-filter-ahu',
                type: 'GET',
                data: {
                    no_checklist_ahu,
                    date_from,
                    date_to,
                },
                success: function(data) {
                    $('#checklist_body').html("")
                    data.checklists.map((item, i) => {
                        $('#checklist_body').append(`
                            <tr>
                                <th scope="row">${i + 1}</th>                           
                                <td>${item.tgl_checklist}</td>                            
                                <td>${item.no_checklist_ahu}</td>
                                <td>
                                    <div class="dropdown font-sans-serif position-static"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal" type="button" id="order-dropdown-0" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                        <div class="dropdown-menu dropdown-menu-end border py-0" aria-labelledby="order-dropdown-0">
                                            <a class="dropdown-item text" href="/admin/checklistahus/${item.no_checklist_ahu}">Detail ahu Inspection</a>
                                        </div>
                                    </div>                        
                                </td>
                            </tr>
                        `)
                    })
                    
                }
            })
        }
    </script>
@endsection