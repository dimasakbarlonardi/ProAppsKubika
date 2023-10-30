@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="row mt-5 mt-lg-0 mt-xl-5 mt-xxl-0">
        <div class="col">

            <ul class="nav nav-pills justify-content-around bg-white p-3 rounded" id="pill-myTab" role="tablist">

                <li class="nav-item"  role="presentation">
                    <button class="nav-link {{ Session::get('active') == 'perpanjang' || Session::get('active') == null ? 'active' : '' }}" data-bs-toggle="pill" data-bs-target="#pill-tab-home" type="button" role="tab">
                        <span class=""></span>
                        <span class="fs--1">Perpanjang Sewa</span>
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link btn-primary {{ Session::get('active') == 'perubahan' ? 'active' : '' }}" data-bs-toggle="pill" data-bs-target="#pill-tab-perubahan"
                        type="button" role="tab"><span class=""></span><span
                            class="d-none d-md-inline-block fs--1">Perubahan Unit</span></button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ Session::get('active') == 'tidakperpanjang' ? 'active' : '' }}" data-bs-toggle="pill" data-bs-target="#pill-tab-profiles"
                        type="button" role="tab"><span class=""></span><span
                            class="d-none d-md-inline-block fs--1">Tidak Perpanjang Unit</span></button></li>
            </ul>

            <div class="container bg-white rounded">
                <div class="tab-content p-3 mt-3 " id="pill-myTabContent">
                    <div class="tab-pane fade {{ Session::get('active') == 'perpanjang' || Session::get('active') == null ? 'show active' : '' }}"
                        id="pill-tab-home" role="tabpanel" aria-labelledby="home-tab">
                        @include('AdminSite.PerubahanUnit.Perpanjang.perpanjangsewa')
                    </div>
                    <div class="tab-pane fade {{ Session::get('active') == 'perubahan' | Session::get('active') == null ? 'show active' : '' }}}}"
                        id="pill-tab-perubahan" role="tabpanel" aria-labelledby="perubahan-tab">
                        @include('AdminSite.PerubahanUnit.Perubahan.perubahan')
                    </div>
                    <div class="tab-pane fade {{ Session::get('active') == 'tidakperpanjang' | Session::get('active') == null ? 'show active' : '' }}}}"
                    id="pill-tab-profiles" role="tabpanel" aria-labelledby="profiles-tab">
                    @include('AdminSite.PerubahanUnit.TidakPerpanjangUnit.tidakperpanjang')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script>
    new DataTable('#table-perpanjang');
    new DataTable('#table-perubahan');
    new DataTable('#table-pindah');
    new DataTable('#table-tidakperpanjang');
</script>
@endsection
