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
                                    <h6 class="mb-0 text-light">All Units</h6>
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

                                    <div class="font-sans-serif ms-2">
                                        <a href="{{ route('units.create') }}"
                                            class="btn btn-falcon-default text-600 btn-sm dropdown-toggle dropdown-caret-none"
                                            type="button">
                                            Tambah Unit
                                        </a>
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
                            <div id="all-units">

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
                                            <option value="{{ $tower->id_tower }}"> {{ $tower->nama_tower }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 mt-n2">
                                    <label class="mb-1">Lantai</label>
                                    <select class="form-select form-select-sm" name="id_floor" id="id_floor" required>
                                        @foreach ($floors as $floor)
                                            <option {{ $floor->id_lantai == '006' ? 'selected' : '' }}
                                                value="{{ $floor->id_lantai }}"> {{ $floor->nama_lantai }}</option>
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
    </div>
@endsection

@section('script')
    <script>
        $('document').ready(function() {
            var id_tower = $('#id_tower').val()
            var id_floor = $('#id_floor').val()

            $('#id_tower').on('change', function() {
                var id_tower = $('#id_tower').val()
                var id_floor = $('#id_floor').val()

                getUnits(id_tower, id_floor)
            })

            $('#id_floor').on('change', function() {
                var id_tower = $('#id_tower').val()
                var id_floor = $('#id_floor').val()

                getUnits(id_tower, id_floor)
            })

            getUnits(id_tower, id_floor)
        })

        function getUnits(id_tower, id_floor) {
            $.ajax({
                url: '/admin/units-by-filter',
                type: 'GET',
                data: {
                    id_tower,
                    id_floor
                },
                success: function(data) {
                    console.log(data.html)
                    $('#all-units').html(data.html)
                }
            })
        }
    </script>
@endsection
