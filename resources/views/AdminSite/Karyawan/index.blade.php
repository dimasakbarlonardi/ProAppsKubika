@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0 text-light">All Employee</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-color text-600 btn-sm mr-3 text-white" href=""><span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>Import</a>
                <a class="btn btn-falcon-default text-600 btn-sm ml-3" href="{{ route('karyawans.create') }}">Create Employee</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <div id="tableExample3" data-list='{"valueNames":["nama_karyawan", "nama_role", "alamat_ktp_karyawan"],"page":10,"pagination":true}'>
            <div class="row justify-content-end g-0">
                <div class="col-auto col-sm-5 mb-3">
                    <form>
                        <div class="input-group"><input class="form-control form-control-sm shadow-none search" type="search" placeholder="Search..." aria-label="search" />
                            <div class="input-group-text bg-transparent"><span class="fa fa-search fs--1 text-600"></span></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive scrollbar">
                <table class="table table-bordered table-striped fs--1 mb-0">
                    <thead>
                        <tr>
                            <th class="sort" data-sort="">No</th>
                            <th></th>
                            <th>Karyawan</th>
                            <th>Role</th>
                            <th>Address</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @foreach ($karyawans as $key => $karyawan)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>
                                <img src="{{ $karyawan->User ? asset($karyawan->profile_picture) : asset('/assets/img/team/3-thumb.png') }}" class="rounded-circle" style="max-width: 50px; height: 50px">
                            </td>
                            <td class="nama_karyawan">
                                {{ $karyawan->nama_karyawan }} <br>
                                <small>{{ $karyawan->email_karyawan }}</small>
                            </td>
                            <td class="align-middle nama_role">
                                {{ $karyawan->User ? $karyawan->User->RoleH->nama_role : 'doesnt have role ' }}
                            </td>
                            <td class="alamat_ktp_karyawan">
                                {{ $karyawan->alamat_ktp_karyawan }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('karyawans.show', $karyawan->id) }}" class="btn btn-outline-info btn-sm mb-2" type="button">
                                    Detail
                                </a>
                                <a href="{{ route('workSchedules', $karyawan->id) }}" class="btn btn-outline-success btn-sm mb-2" type="button">
                                    Work Schedule
                                </a>
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