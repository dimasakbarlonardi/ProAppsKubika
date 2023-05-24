{{-- @extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header bg-light py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Unit</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-primary" href="{{ route('units.create') }}">Tambah Unit</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_unit">Kode Unit</th>
                    <th class="sort" data-sort="nama_hunian">Nama Hunian</th>
                    <th class="sort" data-sort="nama_unit">Nama Unit</th>
                    <th class="sort" data-sort="luas_unit">Luas Unit</th>
                    <th class="sort" data-sort="barcode_meter_air">Barcode Meter Air</th>
                    <th class="sort" data-sort="barcode_meter_listrik">Barcode Meter Listrik</th>
                    <th class="sort" data-sort="barcode_meter_gas">Barcode Meter Gas</th>
                    <th class="sort" data-sort="no_meter_air">No Meter Air</th>
                    <th class="sort" data-sort="no_meter_listrik">No Meter Listrik</th>
                    <th class="sort" data-sort="no_meter_gas">No Meter Gas</th>
                    <th class="sort" data-sort="meter_air_awal">Meter Air Awal</th>
                    <th class="sort" data-sort="meter_air_akhir">Meter Air Akhir</th>
                    <th class="sort" data-sort="meter_listrik_awal">Meter Listrik Awal</th>
                    <th class="sort" data-sort="meter_listrik_akhir">Meter Listrik Akhir</th>
                    <th class="sort" data-sort="meter_gas_awal">Meter Gas Awal</th>
                    <th class="sort" data-sort="meter_gas_akhir">Meter Gas Akhir</th>
                    <th class="sort" data-sort="keterangan">Keterangan</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($units as $key => $unit)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $unit->id_unit }}</td>
                        <td>{{ $unit->hunian->nama_hunian }}</td>
                        <td>{{ $unit->nama_unit }}</td>
                        <td>{{ $unit->luas_unit }}</td>
                        <td>{{ $unit->barcode_meter_air }}</td>
                        <td>{{ $unit->barcode_meter_listrik }}</td>
                        <td>{{ $unit->barcode_meter_gas }}</td>
                        <td>{{ $unit->no_meter_air }}</td>
                        <td>{{ $unit->no_meter_listrik }}</td>
                        <td>{{ $unit->no_meter_gas }}</td>
                        <td>{{ $unit->meter_air_awal }}</td>
                        <td>{{ $unit->meter_air_akhir }}</td>
                        <td>{{ $unit->meter_listrik_awal }}</td>
                        <td>{{ $unit->meter_listrik_akhir }}</td>
                        <td>{{ $unit->meter_gas_awal }}</td>
                        <td>{{ $unit->meter_gas_akhir }}</td>
                        <td>{{ $unit->keterangan }}</td>
                        <td>
                            <a href="{{ route('units.edit', $unit->id_unit) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('units.destroy', $unit->id_unit) }}" method="post">
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
</div>
@endsection --}}

@extends('layouts.master')

@section('content')
    <div class="content">
        <div class="row gx-3">
            <div class="col-xxl-10 col-xl-9">
                <div class="card" id="ticketsTable"
                    data-list='{"valueNames":["client","subject","status","priority","agent"],"page":7,"pagination":true,"fallback":"tickets-card-fallback"}'>
                    <div class="card-header border-bottom border-200 px-0">
                        <div class="d-lg-flex justify-content-between">
                            <div class="row flex-between-center gy-2 px-x1 text-light">
                                <div class="col-auto pe-0">
                                    <h6 class="mb-0 text-light">All tickets</h6>
                                </div>
                                <div class="col-auto pe-0">
                                    <span class="nav-link-icon">
                                        <span class="fas fa-building"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="border-bottom border-200 my-3"></div>
                            <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
                                <button class="btn btn-sm btn-falcon-default d-xl-none" type="button"
                                    data-bs-toggle="offcanvas" data-bs-target="#ticketOffcanvas"
                                    aria-controls="ticketOffcanvas">
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

                                    <div class="dropdown font-sans-serif ms-2">
                                        <button
                                            class="btn btn-falcon-default text-600 btn-sm dropdown-toggle dropdown-caret-none"
                                            type="button" id="preview-dropdown" data-bs-toggle="dropdown"
                                            data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                                            Tower
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end border py-2"
                                            aria-labelledby="preview-dropdown">
                                            <a class="dropdown-item" href="{{ route('towers.create') }}">Tambah Tower</a>
                                            <a class="dropdown-item" href="{{ route('towers.index') }}">List Tower</a>
                                        </div>
                                    </div>

                                    <div class="dropdown font-sans-serif ms-2">
                                        <button
                                            class="btn btn-falcon-default text-600 btn-sm dropdown-toggle dropdown-caret-none"
                                            type="button" id="preview-dropdown" data-bs-toggle="dropdown"
                                            data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                                            Lantai
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end border py-2"
                                            aria-labelledby="preview-dropdown">
                                            <a class="dropdown-item" href="{{ route('floors.create') }}">Tambah Lantai</a>
                                            <a class="dropdown-item" href="{{ route('floors.index') }}">List Lantai</a>
                                        </div>
                                    </div>
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
                                <div class="col-4">
                                    <div
                                        class="bg-white dark__bg-1100 d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                                        <div class="d-flex align-items-start align-items-sm-center">
                                            <div class="ms-1 ms-sm-3">
                                                <p class="fw-semi-bold mb-3 mb-sm-2">
                                                    <a class="text-primary" href="../../app/support-desk/tickets-preview.html">I need your help
                                                        #2256</a>
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
                                                    <div class="col-auto lh-1 me-3">
                                                        <small
                                                            class="badge rounded badge-soft-info false">Responded</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div
                                        class="bg-white dark__bg-1100 d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                                        <div class="d-flex align-items-start align-items-sm-center">
                                            <div class="ms-1 ms-sm-3">
                                                <p class="fw-semi-bold mb-3 mb-sm-2">
                                                    <a class="text-primary" href="../../app/support-desk/tickets-preview.html">I need your help
                                                        #2256</a>
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
                                                    <div class="col-auto lh-1 me-3">
                                                        <small
                                                            class="badge rounded badge-soft-info false">Responded</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div
                                        class="bg-white dark__bg-1100 d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                                        <div class="d-flex align-items-start align-items-sm-center">
                                            <div class="ms-1 ms-sm-3">
                                                <p class="fw-semi-bold mb-3 mb-sm-2">
                                                    <a class="text-primary" href="../../app/support-desk/tickets-preview.html">I need your help
                                                        #2256</a>
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
                                                    <div class="col-auto lh-1 me-3">
                                                        <small
                                                            class="badge rounded badge-soft-info false">Responded</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
            <div class="col-xxl-2 col-xl-3">
                <div class="offcanvas offcanvas-end offcanvas-filter-sidebar border-0 dark__bg-card-dark h-auto rounded-xl-3"
                    tabindex="-1" id="ticketOffcanvas" aria-labelledby="ticketOffcanvasLabelCard">
                    <div class="card scrollbar shadow-none shadow-show-xl">
                        <div class="card-header d-none d-xl-block">
                            <h6 class="mb-0 text-light">Filter</h6>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="mb-3 mt-n2">
                                    <label class="mb-1">Tower</label>
                                    <select class="form-select form-select-sm" name="id_tower" required id="id_tower">
                                        @foreach ($towers as $tower)
                                        <option value="{{ $tower->id_tower}}"> {{ $tower->nama_tower}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 mt-n2">
                                    <label class="mb-1">Lantai</label>
                                    <select class="form-select form-select-sm" name="id_tower" required>
                                        @foreach ($floors as $floor)
                                        <option value="{{ $floor->id_lantai}}"> {{ $floor->nama_lantai}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </form>
                        </div>
                        <div class="card-footer border-top border-200 py-x1">
                            <button class="btn btn-primary w-100">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="row g-0 justify-content-between fs--1 mt-4 mb-3">
                <div class="col-12 col-sm-auto text-center">
                    <p class="mb-0 text-600">
                        Thank you for creating with Falcon
                        <span class="d-none d-sm-inline-block">| </span><br class="d-sm-none" />
                        2022 &copy; <a href="https://themewagon.com">Themewagon</a>
                    </p>
                </div>
                <div class="col-12 col-sm-auto text-center">
                    <p class="mb-0 text-600">v3.14.0</p>
                </div>
            </div>
        </footer>
    </div>
@endsection

{{-- @section('script')
    <script>
        $('document').ready(function() {
            var id_tower = $('#id_tower').val()
            console.log(id_tower)
        })

        
    </script>
@endsection --}}
