@extends('layouts.master')

@section('content')
<div class="content">
    <div class="card" id="ticketsTable" data-list='{"valueNames":["client","subject","status","priority","agent"],"page":7,"pagination":true,"fallback":"tickets-card-fallback"}'>
        <div class="card-header border-bottom border-200 px-0">
            <div class="d-lg-flex justify-content-between">
                <div class="row flex-between-center gy-2 px-x1 text-light">
                    <div class="col-auto pe-0">
                        <h6 class="mb-0 text-light">All Employee</h6>
                    </div>
                    <div class="col-auto pe-0">
                        <span class="nav-link-icon">
                            <span class="fas fa-users"></span>
                        </span>
                    </div>
                </div>
                <div class="border-bottom border-200 my-3"></div>
                <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
                    <button class="btn btn-sm btn-falcon-default d-xl-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#ticketOffcanvas" aria-controls="ticketOffcanvas">
                        <span class="fas fa-filter" data-fa-transform="shrink-4 down-1"></span><span class="ms-1 d-none d-sm-inline-block">Filter</span>
                    </button>
                    <div class="bg-300 mx-3 d-none d-lg-block d-xl-none" style="width: 1px; height: 29px">
                    </div>
                    <div class="d-none" id="table-ticket-actions">
                        <div class="d-flex">
                            <select class="form-select form-select-sm" aria-label="Bulk actions">
                                <option selected="">Bulk actions</option>
                                <option value="Refund">Refund</option>
                                <option value="Delete">Delete</option>
                                <option value="Archive">Archive</option>
                            </select><button class="btn btn-falcon-default btn-sm ms-2" type="button">
                                Apply
                            </button>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" id="table-ticket-replace-element">
                        <a class="btn btn-falcon-default text-600 btn-sm" href="{{ route('karyawans.create') }}">Tambah
                            Karyawan</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body pt-4">
            <table class="table table-striped alternating-rows" id="table-engineeringhistory">
                <thead>
                    <tr>
                        <th class="sort" data-sort="">No</th>
                        <th></th>
                        <th class="sort" data-sort="equipment">Karyawan</th>
                        <th class="sort" data-sort="room">Role</th>
                        <th class="sort" data-sort="inspection">Address</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="checklist_body">
                    @foreach ($karyawans as $key => $karyawan)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>
                            <img src="{{ $karyawan->User ? asset($karyawan->User->profile_picture) : asset('/assets/img/team/3-thumb.png') }}" class="rounded-circle" style="max-width: 50px; height: 50px">
                        </td>
                        <td>
                            {{ $karyawan->nama_karyawan }} <br>
                            <small>{{ $karyawan->email_karyawan }}</small>
                        </td>
                        <td class="align-middle">
                            {{ $karyawan->User ? $karyawan->User->RoleH->nama_role : 'doesnt have role ' }}
                        </td>
                        <td>
                            {{ $karyawan->alamat_ktp_karyawan }}
                        </td>
                        <td class="text-center">
                            <button class="btn btn-outline-info btn-sm mb-2" type="button">
                                Detail
                            </button>
                            <a href="{{ route('workSchedules', $karyawan->id) }}" class="btn btn-outline-success btn-sm mb-2" type="button">
                                Work Schedule
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
