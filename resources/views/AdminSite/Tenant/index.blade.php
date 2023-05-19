@extends('layouts.master')

@section('content')
    {{-- <div class="card">
    <div class="card-header bg-light py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Tenant</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-primary" href="{{ route('tenants.create') }}">Tambah Tenant</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_tenant">ID Tenant</th>
                    <th class="sort" data-sort="id_site">ID Site</th>
                    <th class="sort" data-sort="id_user">ID User</th>
                    <th class="sort" data-sort="id_pemilik">ID Pemilik</th>
                    <th class="sort" data-sort="id_card_type">ID Card Type</th>
                    <th class="sort" data-sort="nik_tenant">Nik Tenant</th>
                    <th class="sort" data-sort="nama_tenant">Nama Tenant</th>
                    <th class="sort" data-sort="id_statushunian_tenant">ID Status Hunian Tenant</th>
                    <th class="sort" data-sort="kewarganegaraan">Kewarganegaraan</th>
                    <th class="sort" data-sort="masa_berlaku_id">Masa Berlaku ID</th>
                    <th class="sort" data-sort="alamat_ktp_tenant">Alamat KTP Tenant</th>
                    <th class="sort" data-sort="provinsi">Provinsi</th>
                    <th class="sort" data-sort="kode_pos">Kode Pos</th>
                    <th class="sort" data-sort="alamat_tinggal_tenant">Alamat Tinggal Tenant</th>
                    <th class="sort" data-sort="no_telp_tenant">No Telpon Tenant</th>
                    <th class="sort" data-sort="nik_pasangan_penjamin">NIK Pasangan Penjamin</th>
                    <th class="sort" data-sort="nama_pasangan_penjamin">Nama Pasangan Penjamin</th>
                    <th class="sort" data-sort="alamat_ktp_pasangan_penjamin">Alamat KTP Pasangan Penjamin</th>
                    <th class="sort" data-sort="alamat_tinggal_pasangan_penjamin">Alamat Tinggal Pasangan Penjamin</th>
                    <th class="sort" data-sort="hubungan_penjamin">Hubungan Penjamin</th>
                    <th class="sort" data-sort="no_telp_penjamin">No Telpon Penjamin</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tenants as $key => $tenant)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $tenant->id_tenant }}</td>
                        <td>{{ $tenant->id_site }}</td>
                        <td>{{ $tenant->id_user }}</td>
                        <td>{{ $tenant->id_pemilik }}</td>
                        <td>{{ $tenant->id_card_type }}</td>
                        <td>{{ $tenant->nik_tenant }}</td>
                        <td>{{ $tenant->nama_tenant  }}</td>
                        <td>{{ $tenant->id_statushunian_tenant }}</td>
                        <td>{{ $tenant->kewarganegaraan }}</td>
                        <td>{{ $tenant->masa_berlaku_id }}</td>
                        <td>{{ $tenant->alamat_ktp_tenant }}</td>
                        <td>{{ $tenant->provinsi }}</td>
                        <td>{{ $tenant->kode_pos }}</td>
                        <td>{{ $tenant->alamat_tinggal_tenant }}</td>
                        <td>{{ $tenant->no_telp_tenant }}</td>
                        <td>{{ $tenant->nik_pasangan_penjamin }}</td>
                        <td>{{ $tenant->nama_pasangan_penjamin }}</td>
                        <td>{{ $tenant->alamat_ktp_pasangan_penjamin }}</td>
                        <td>{{ $tenant->alamat_tinggal_pasangan_penjamin }}</td>
                        <td>{{ $tenant->hubungan_penjamin }}</td>
                        <td>{{ $tenant->no_telp_penjamin }}</td>
                        <td>
                            <a href="{{ route('getTenantUnit', $tenant->id_tenant) }}" class="btn btn-sm btn-primary">Tenant Unit</a>
                            <a href="{{ route('tenants.edit', $tenant->id_tenant) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('tenants.destroy', $tenant->id_tenant) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('are you sure?')">Hapus</button>
                            </form>
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
                            <h6 class="mb-0 text-light">All Tenants</h6>
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
                            <a class="btn btn-falcon-default text-600 btn-sm" href="{{ route('tenants.create') }}">Tambah Tenant</a>
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
                        @foreach ($tenants as $tenant)
                            <div class="col-3">
                                <div
                                    class="bg-white dark__bg-1100 d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                                    <div class="d-flex align-items-start align-items-sm-center">
                                        <a class="d-none d-sm-block" href="../../app/support-desk/contact-details.html">
                                            {{-- {{ dd($tenant->profile_picture) }} --}}
                                            <div class="avatar avatar-xl avatar-3xl">
                                                <img src="/{{ $tenant->profile_picture }}" alt="akmal"
                                                    class="avatar-image" />
                                            </div>
                                        </a>
                                        <div class="ms-1 ms-sm-3">
                                            <p class="fw-semi-bold mb-3 mb-sm-2">
                                                <a class="text-primary" href="../../app/support-desk/tickets-preview.html">
                                                    Astuti
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
                                            <a href="{{ route('getTenantUnit', $tenant->id_tenant) }}"
                                                class="btn btn-primary btn-sm">Tenant Unit</a>
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
