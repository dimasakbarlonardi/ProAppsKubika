@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="my-3 col-auto">
                <h6 class="mb-0">List Parameter Shift Security</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('Parameter-Shift-Security.create') }}"><span class="fas fa-plus fs--2 me-1"></span>Create Parameter</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <div id="tableExample3" data-list='{"valueNames":["shift"],"page":10,"pagination":true}'>
            <div class="row justify-content-end g-0">
                <div class="col-auto col-sm-5 mb-3">
                    <form>
                        <div class="input-group"><input class="form-control form-control-sm shadow-none search" type="search" placeholder="Search..." aria-label="search" />
                            <div class="input-group-text bg-transparent"><span class="fa fa-search fs--1 text-600"></span></div>
                        </div>
                    </form>
                </div>
                </di>
                <div class="table-responsive scrollbar">
                    <table class="table table-bordered table-striped fs--1 mb-0">
                        <thead>
                            <tr>
                                <th class="sort" data-sort="">No</th>
                                <th class="sort" data-sort="shift">Shift</th>
                                <th class="sort" data-sort="start_time">Start Time</th>
                                <th class="sort" data-sort="end_time">End Time</th>
                                <th class="sort">Action</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($ParameterShiftSecurity as $key => $security)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td class="shift">{{ $security->shift }}</td>
                                <td class="start_time">{{ HumanTime($security->start_time) }}</td>
                                <td class="end_time">{{ HumanTime($security->end_time) }}</td>
                                <td>
                                    <a href="{{ route('Parameter-Shift-Security.edit', $security->id) }}" class="btn btn-sm btn-warning"><span class="fas fa-pencil-alt fs--2 me-1"></span>Edit</a>
                                  
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3"><button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                    <ul class="pagination mb-0"></ul><button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"> </span></button>
                </div>
            </div>
        </div>
    </div>
    @endsection