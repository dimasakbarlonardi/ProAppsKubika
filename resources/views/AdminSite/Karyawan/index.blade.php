{{-- @extends('layouts.master')

@section('content')
    {{-- <div class="card">
    <div class="card-header py-3">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Karyawan</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('karyawans.create') }}">Tambah Karyawan</a>
            </div>
        </div>
    </div>
    <div class="p-5 table-responsive scrollbar">
        <table class="table table-striped table-bordered">
            <thead class="table-success bg-200 text-900">
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_karyawan">ID Karyawan</th>
                    <th class="sort" data-sort="nama_karyawan">Nama Karyawan</th>
                    <th class="sort" data-sort="alamat_ktp_karyawan">Alamat KTP Karyawan</th> --}}
{{-- 
                    <th class="sort" data-sort="id_site">ID Site</th>
                    <th class="sort" data-sort="id_card_type">ID Card Type</th>
                    <th class="sort" data-sort="nik_karyawan">Nik Karyawan</th>
                    <th class="sort" data-sort="id_status_karyawan">ID Status Karyawan</th>
                    <th class="sort" data-sort="id_status_kawin_karyawan">ID Status Kawin Karyawan</th>
                    <th class="sort" data-sort="id_status_aktif_karyawan">ID Status Aktif Karyawan</th>
                    <th class="sort" data-sort="kewarganegaraan">Kewarganegaraan</th>
                    <th class="sort" data-sort="masa_berlaku_id">Masa Berlaku ID</th>
                    <th class="sort" data-sort="no_telp_karyawan">No Telpon Karyawan</th>
                    <th class="sort" data-sort="nik_pasangan_penjamin">NIK Pasangan Penjamin</th>
                    <th class="sort" data-sort="nama_pasangan_penjamin">Nama Pasangan Penjamin</th>
                    <th class="sort" data-sort="alamat_ktp_pasangan_penjamin">Alamat KTP Pasangan Penjamin</th>
                    <th class="sort" data-sort="alamat_tinggal_pasangan_penjamin">Alamat Tinggal Pemilik</th>
                    <th class="sort" data-sort="hubungan_penjamin">Hubungan Penjamin</th>
                    <th class="sort" data-sort="no_telp_penjamin">No Telpon Penjamin</th>
                    <th class="sort" data-sort="tgl_masuk">Tanggal Masuk</th>
                    <th class="sort" data-sort="tgl_keluar">Tanggal Keluar</th>
                    --}}
                    {{-- <th class="sort" data-sort="id_jabatan">Jabatan</th>
                    <th class="sort" data-sort="id_divisi">Divisi</th>
                    <th class="sort" data-sort="id_departemen">Departement</th> --}}
                    {{-- <th class="sort" data-sort="id_penempatan">Penempatan</th>
                    <th class="sort" data-sort="tempat_lahir">Tempat Lahir</th>
                    <th class="sort" data-sort="tgl_lahir">ID Jenis Kelamin</th>
                    <th class="sort" data-sort="id_agama">ID Agama</th>
                    <th class="sort" data-sort="id_jenis_kelamin">ID Status Kawin</th>  --}}
                    {{-- <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($karyawans as $key => $karyawan)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $karyawan->id_karyawan }}</td>
                        <td class="nama_karyawan">
                            <span> <b> Nama : </b> <br> {{ $karyawan->nama_karyawan  }}</span> <br>
                            <span> <b> Nik : </b> <br> {{ $karyawan->nik_karyawan }} </span> <br>
                            <span> <b> Kewarganegaraan : </b> <br> {{ $karyawan->kewarganegaraan }} </span> <br>
                            <span> <b> No Telp : </b> <br> {{ $karyawan->no_telp_karyawan }} </span> <br>
                        </td>
                        <td class="alamat_tinggal_pemilik">
                            <span> <b> Alamat : </b> <br> {{ $karyawan->alamat_ktp_karyawan }} </span> <br>
                            <span> <b> Kode Pos : </b> <br> {{ $karyawan->kode_pos }} </span> <br>
                            <span> <b> Provinsi : </b> <br> {{ $karyawan->provinsi }} </span> <br>
                        </td> --}}
                        {{-- <td>{{ $karyawan->id_site}}</td>
                        <td>{{ $karyawan->IdCard->card_id_name}}</td> --}}
                        {{-- <td>{{ $karyawan->nik_karyawan }}</td> --}}
                        {{-- <td>{{ $karyawan->nama_karyawan }}</td> --}}
                        {{-- <td>{{ $karyawan->id_status_karyawan}}</td>
                        <td>{{ $karyawan->id_status_kawin_karyawan }}</td>
                        <td>{{ $karyawan->id_status_aktif_karyawan }}</td> --}}
                        {{-- <td>{{ $karyawan->kewarganegaraan }}</td> --}}
                        {{-- <td>{{ $karyawan->masa_berlaku_id }}</td> --}}
                        {{-- <td>{{ $karyawan->alamat_ktp_karyawan }}</td> --}}
                        {{-- <td>{{ $karyawan->no_telp_karyawan }}</td> --}}
                        {{-- <td>{{ $karyawan->nik_pasangan_penjamin }}</td>
                        <td>{{ $karyawan->nama_pasangan_penjamin }}</td>
                        <td>{{ $karyawan->alamat_ktp_pasangan_penjamin }}</td>
                        <td>{{ $karyawan->alamat_tinggal_pasangan_penjamin }}</td>
                        <td>{{ $karyawan->hubungan_penjamin }}</td>
                        <td>{{ $karyawan->no_telp_penjamin }}</td>
                        <td>{{ $karyawan->tgl_masuk }}</td>
                        <td>{{ $karyawan->tgl_keluar }}</td> --}}
{{-- 
                        <td>{{ $karyawan->Jabatan->nama_jabatan }}</td>
                        <td>{{ $karyawan->Divisi->nama_divisi }}</td>
                        <td>{{ $karyawan->Departemen->nama_departemen }}</td>  --}}

                        {{-- <td>{{ $karyawan->id_penempatan }}</td>
                        <td>{{ $karyawan->tempat_lahir }}</td>
                        <td>{{ $karyawan->tgl_lahir }}</td>
                        <td>{{ $karyawan->agama->nama_agama }}</td>
                        <td>{{ $karyawan->jeniskelamin->jenis_kelamin }}</td>
                        <td>{{ $karyawan->statuskawin->status_kawin }}</td>  --}}
                        {{-- <td>
                            <a href="{{ route('karyawans.show', $karyawan->id_karyawan) }}" class="btn btn-sm btn-warning">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div> --}}
    <div class="content">
        <div class="card" id="ticketsTable"
            data-list='{"valueNames":["client","subject","status","priority","agent"],"page":7,"pagination":true,"fallback":"tickets-card-fallback"}'>
            <div class="card-header border-bottom border-200 px-0">
                <div class="d-lg-flex justify-content-between">
                    <div class="row flex-between-center gy-2 px-x1 text-light">
                        <div class="col-auto pe-0">
                            <h6 class="mb-0 text-light">Karyawan</h6>
                        </div>
                        <div class="col-auto pe-0">
                            <span class="nav-link-icon">
                                <span class="fas fa-users"></span>
                            </span>
                        </div>
                    </div>

                    <div class="px-x1">
                            <a class="btn btn-falcon-default text-600 btn-sm" href="{{ route('karyawans.create') }}">Tambah
                                Karyawan</a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">

                <div class="list bg-light p-x1 d-flex flex-column gap-3" id="card-ticket-body">
                    <div class="row">
                        @foreach ($karyawans as $karyawan)
                            <div class="col-3">
                                <div
                                    class="bg-white dark__bg-1100 d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                                    <div class="d-flex align-items-start align-items-sm-center">
                                        <a class="d-none d-sm-block" href="../../app/support-desk/contact-details.html">
                                            <div class="avatar avatar-xl avatar-3xl">
                                                <img src="/{{ $karyawan->profile_picture }}" alt="akmal"
                                                    class="avatar-image" />
                                            </div>
                                        </a>
                                        <div class="ms-1 ms-sm-3">
                                            <p class="fw-semi-bold mb-3 mb-sm-2">
                                                <a class="text-primary"
                                                    href="{{ route('karyawans.show', $karyawan->id) }}">
                                                    {{ $karyawan->nama_karyawan }}
                                                </a>
                                            </p>
                                            <div class="row align-items-center gx-0 gy-2">
                                                <div class="col-auto me-2">
                                                    <h6 class="client mb-0">
                                                        <a class="text-800 d-flex align-items-center gap-1"
                                                            href="../../app/support-desk/contact-details.html"><span
                                                                class="fas fa-user"
                                                                data-fa-transform="shrink-3 up-1"></span><span>Peter
                                                                Gill</span></a>
                                                    </h6>
                                                </div>

                                            </div>
                                            <hr>
                                            <a href="{{ route('karyawans.show', $karyawan->id) }}"
                                                class="btn btn-primary btn-sm">Detail Karyawan</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="text-center d-none" id="tickets-card-fallback">
                    <p class="fw-bold fs-1 mt-3">No ticket found</p>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-center">
                    <button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous"
                        data-list-pagination="prev">
                        <span class="fas fa-chevron-left"></span>
                    </button>
                    <ul class="pagination mb-0"></ul>
                    <button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next"
                        data-list-pagination="next">
                        <span class="fas fa-chevron-right"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.master') --}}

@extends('layouts.master')

@section('content')
    <div class="content">
        <div class="card" id="ticketsTable"
            data-list='{"valueNames":["client","subject","status","priority","agent"],"page":7,"pagination":true,"fallback":"tickets-card-fallback"}'>
            <div class="card-header border-bottom border-200 px-0">
                <div class="d-lg-flex justify-content-between">
                    <div class="row flex-between-center gy-2 px-x1 text-light">
                        <div class="col-auto pe-0">
                            <h6 class="mb-0 text-light">All Karyawan</h6>
                        </div>
                        <div class="col-auto pe-0">
                            <span class="nav-link-icon">
                                <span class="fas fa-users"></span>
                            </span>
                        </div>
                    </div>
                    <div class="border-bottom border-200 my-3"></div>
                    <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
                        <button class="btn btn-sm btn-falcon-default d-xl-none" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#ticketOffcanvas" aria-controls="ticketOffcanvas">
                            <span class="fas fa-filter" data-fa-transform="shrink-4 down-1"></span><span
                                class="ms-1 d-none d-sm-inline-block">Filter</span>
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
                            <a class="btn btn-falcon-default text-600 btn-sm" href="{{ route('karyawans.create') }}">Tambah Karyawan</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="form-check d-none">
                    <input class="form-check-input" id="checkbox-bulk-card-tickets-select" type="checkbox"
                        data-bulk-select='{"body":"card-ticket-body","actions":"table-ticket-actions","replacedElement":"table-ticket-replace-element"}' />
                </div>
                <div class="list bg-light p-x1 d-flex flex-column gap-3" id="card-ticket-body">

                    <div class="row">
                        @foreach ($karyawans as $karyawan)
                            <div class="col-3">
                                <div
                                    class="bg-white dark__bg-1100 d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                                    <div class="d-flex align-items-start align-items-sm-center">
                                        <a class="d-none d-sm-block" href="../../app/support-desk/contact-details.html">
                                            {{-- {{ dd($tenant->profile_picture) }} --}}
                                            <div class=" row avatar avatar-xl avatar-3xl">
                                                <img src="/{{ $karyawan->profile_picture }}" alt="akmal"
                                                    class="avatar-image" />
                                            </div>
                                        </a>
                                        <div class="ms-2 ms-sm-4">
                                            <p class="fw-semi-bold mb-3 mb-sm-2">
                                                <a class="text-primary" >
                                                    Karyawan
                                                </a>
                                            </p>
                                            <p class="fw-semi-bold mb-3 ">
                                                <a class="text-black" href="{{ route('karyawans.show', $karyawan->id_karyawan) }}">
                                                    {{ $karyawan->nama_karyawan }}
                                                </a>
                                            </p>
                                            <div class="row align-items-center gx-0 gy-2">
                                                <div class="col-auto me-2">
                                                    <h6 class="client mb-0">
                                                        <a class="text-800 d-flex align-items-center gap-1"
                                                            href="../../app/support-desk/contact-details.html"><span
                                                                class="fas fa-user"
                                                                data-fa-transform="shrink-3 up-1"></span><span>Peter
                                                                Gill</span></a>
                                                    </h6>
                                                </div>

                                            </div>
                                            <div class="row">
                                            <hr>
                                                <button class="btn btn-outline-success text-success mb-2" type="button"><a class="text-success" href="{{ route('karyawans.show', $karyawan->id_karyawan) }} {{ $karyawan->nama_karyawan }}"> Detail</a></button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="text-center d-none" id="tickets-card-fallback">
                    <p class="fw-bold fs-1 mt-3">No ticket found</p>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-center">
                    <button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous"
                        data-list-pagination="prev">
                        <span class="fas fa-chevron-left"></span>
                    </button>
                    <ul class="pagination mb-0"></ul>
                    <button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next"
                        data-list-pagination="next">
                        <span class="fas fa-chevron-right"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection


