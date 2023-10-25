@extends('layouts.master')

@section('content')
<div class="row mt-5 mt-lg-0 mt-xl-5 mt-xxl-0">
    <div class="col">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a href="{{ route('tenants.index') }}" class="btn btn-falcon-default btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <div class="ml-3">Tenant Unit</div>
                </div>
            </div>
        </div>
        <div class="d-flex mb-4"><span class="fa-stack me-2 ms-n1"><i class="fas fa-circle fa-stack-2x text-300"></i><i class="fa-inverse fa-stack-1x text-primary fas fa-tasks"></i></span>
            <div class="col">
                <h5 class="mb-0 text-primary">
                    <span class="bg-200 dark__bg-1100 pe-3">Tenant #{{ $tenant->id_tenant }}</span>
                </h5>
                <h3 class="mb-0 text-primary">
                    <span class="bg-200 dark__bg-1100 pe-3">{{ $tenant->nama_tenant }}</span>
                </h3>
            </div>
        </div>

        <ul class="nav nav-pills justify-content-around bg-white p-3 rounded" id="pill-myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link
                        {{ Session::get('active') == 'unit' || Session::get('active') == null ? 'active' : '' }}" data-bs-toggle="pill" data-bs-target="#pill-tab-home" type="button" role="tab">
                    <span class="fas fa-home me-2"></span>
                    <span class="fs--1">Tenant Unit</span>
                </button>
            </li>


            <li class="nav-item" role="presentation">
                <button class="nav-link btn-primary {{ Session::get('active') == 'member' ? 'active' : '' }}" data-bs-toggle="pill" data-bs-target="#pill-tab-profile" type="button" role="tab"><span class="fas fa-users me-2"></span><span class="d-none d-md-inline-block fs--1">Member</span></button>
            </li>


            <li class="nav-item" role="presentation"><button class="nav-link {{ Session::get('active') == 'vehicle' ? 'active' : '' }}" data-bs-toggle="pill" data-bs-target="#pill-tab-kendaraan" type="button" role="tab"><span class="fas fa-car me-2"></span><span class="d-none d-md-inline-block fs--1">Kendaraan
                        Member</span></button></li>
        </ul>

        <div class="container bg-white rounded">
            <div class="tab-content p-3 mt-3 " id="pill-myTabContent">
                <div class="tab-pane fade {{ Session::get('active') == 'unit' || Session::get('active') == null ? 'show active' : '' }}" id="pill-tab-home" role="tabpanel" aria-labelledby="home-tab">
                    @include('AdminSite.TenantUnit.Unit.tenant_unit')
                </div>
                <div class="tab-pane fade {{ Session::get('active') == 'member' ? 'show active' : '' }}" id="pill-tab-profile" role="tabpanel" aria-labelledby="profile-tab">
                    @include('AdminSite.TenantUnit.Member.member')
                </div>
                <div class="tab-pane fade {{ Session::get('active') == 'vehicle' ? 'show active' : '' }}" id="pill-tab-kendaraan" role="tabpanel" aria-labelledby="contact-tab">
                    @include('AdminSite.TenantUnit.Kendaraan.kendaraan')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection