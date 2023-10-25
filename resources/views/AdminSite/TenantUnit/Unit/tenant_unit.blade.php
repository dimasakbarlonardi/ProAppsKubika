<div class="list bg-light p-x1 d-flex flex-column gap-3" id="card-ticket-body">
    <div class="mb-3">
        <div class="text-end my-3">
            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#tambah-unit">Create
                Unit</button>
        </div>
    </div>
    <div class="row">
        @foreach ($tenant_units as $key => $tu)
            <div class="col-3">
                <div
                    class="bg-white dark__bg-1100 d-md-flex d-xl-inline-block d-xxl-flex align-items-center p-x1 rounded-3 shadow-sm card-view-height">
                    <div class="d-flex align-items-start align-items-sm-center">
                        <a class="d-none d-sm-block" href="../../app/support-desk/contact-details.html">
                            <div class="avatar avatar-xl avatar-3xl">
                                <img src="{{ $tenant->profile_picture ? url($tenant->profile_picture) : '/assets/img/team/3-thumb.png' }}"
                                    alt="akmal" class="avatar-image" />
                            </div>
                        </a>
                        <div class="ms-1 ms-sm-3">
                            <p class="fw-semi-bold mb-3 mb-sm-2">
                                <a class="text-primary">
                                    Tenant Unit
                                </a>
                            </p>
                            <p class="fw-semi-bold mb-3 mb-sm-2">
                                <a class="text-black" href="{{ route('tenantunits.show', $tu->id_tenant_unit) }}">
                                    {{ $tu->unit->nama_unit }}
                                </a>
                            </p>
                            <div class="row align-items-center gx-0 gy-2">
                                <div class="col-auto me-2">
                                    <h6 class="client mb-0">
                                        <span class="badge  bg-info">{{ $tu->is_owner == 1 ? 'Owner' : 'Rent' }}</span>
                                    </h6>
                                </div>
                            </div>
                            <hr>
                            {{-- <a href="{{ route('getTenantUnit', $tenant->id_tenant) }}"
                                class="btn btn-primary btn-sm">Tenant Unit</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="modal fade" id="tambah-unit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 800px">
        <div class="modal-content position-relative">
            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                    <h4 class="mb-1" id="modalExampleDemoLabel">Add Unit</h4>
                </div>
                <div class="p-4 pb-0">
                    <form action="{{ route('storeTenantUnit') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <div class="col-6">
                                        <label class="col-form-label">Is Owner:</label>
                                        <select class="form-control" name="is_owner" id="is_owner" required>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label">Unit :</label>
                                    <select class="form-control" name="id_unit" id="select_unit" required>
                                        <option selected disabled>-- Select Unit --</option>
                                        {{-- @foreach ($getCreateUnits as $unit)
                                            <option value="{{ $unit->id_unit }}">{{ $unit->nama_unit }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="col-form-label">Periode
                                        Sewa:</label>
                                    <div class="input-group">
                                        <select class="form-control" name="id_periode_sewa" id="periode" required>
                                            @foreach ($periodeSewa as $periode)
                                                <option value="{{ $periode->id_periode_sewa }}">
                                                    {{ $periode->periode_sewa }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="input-group-text">Bulan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label class="col-form-label">Tanggal
                                        masuk:</label>
                                    <input class="form-control" type="date" name="tgl_masuk" id="tgl_masuk" required>
                                </div>
                                <div class="col-6">
                                    <label class="col-form-label">Tanggal
                                        keluar:</label>
                                    <input class="form-control" type="date" name="tgl_keluar" id="tgl_keluar"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label class="col-form-label">Tanggal
                                        jatuh tempo IPL:</label>
                                    <input class="form-control" type="date" name="tgl_jatuh_tempo_ipl" id=""
                                        required>
                                </div>
                                <div class="col-6">
                                    <label class="col-form-label">Tanggal
                                        jatuh tempo utility:</label>
                                    <input class="form-control" type="date" name="tgl_jatuh_tempo_util" required>
                                </div>
                            </div>
                        </div> --}}
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit">Simpan
                            </button>
                        </div>
                        <input type="hidden" name="id_tenant" id="id_tenant" value="{{ $tenant->id_tenant }}">
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="edit-unit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 800px">
        <div class="modal-content position-relative">
            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>

            <div class="modal-body-unit-edit p-0">

            </div>
        </div>
    </div>
</div>

@section('script')
    <script>
        $('document').ready(function() {
            var is_owner = $('#is_owner').val();
            getUnitForCreate(is_owner);
        })

        $('#is_owner').on('change', function() {
            var is_owner = $(this).val();
            getUnitForCreate(is_owner);
        })

        function getUnitForCreate(is_owner)
        {
            var id_tenant = $('#id_tenant').val();
            if (is_owner == 1) {
                console.log("yes")
                $('#periode').attr("disabled", true);
                $('#tgl_keluar').attr("disabled", true);
            } else {
                $('#periode').attr("disabled", false);
                $('#tgl_keluar').attr("disabled", false);
            }

            $('#select_unit').html("");
            $.ajax({
                url: '/admin/tenant-unit/unit',
                type: 'POST',
                data: {
                    'is_owner': is_owner,
                    'id_tenant': id_tenant,
                },
                success: function(resp) {
                    var data = resp.data;

                    data.map((item, i) => {
                        $('#select_unit').append(`
                            <option value="${item.id_unit}">${item.nama_unit}</option>
                        `)
                    })
                }
            })
        }

        function editUnitModal(id) {
            $.ajax({
                url: '/admin/get/tenantunits-edit/' + id,
                type: 'GET',
                success: function(data) {
                    $(".modal-body-unit-edit").html(data);
                }
            })
        }
        $(document).ready(function() {
            $("#edit-unit").on("hide.bs.modal", function(e) {
                $(".modal-body-unit-edit").html();
            });
        });

        function editMemberModal(id) {
            $.ajax({
                url: '/admin/get/tenantmember-edit/' + id,
                type: 'GET',
                success: function(data) {
                    $(".modal-body-member-edit").html(data);
                }
            })
        }
        $(document).ready(function() {
            $("#edit-unit").on("hide.bs.modal", function(e) {
                $(".modal-body-member-edit").html();
            });
        });

        function editKendaraanModal(id) {
            $.ajax({
                url: '/admin/get/tenantkendaraan-edit/' + id,
                type: 'GET',
                success: function(data) {
                    $(".modal-body-kendaraan-edit").html(data);
                }
            })
        }
        $(document).ready(function() {
            $("#edit-kendaraan").on("hide.bs.modal", function(e) {
                $(".modal-body-kendaraan-edit").html();
            });
        });
    </script>

    <script>
        function calcDate() {
            var periode = $('#periode').find(':selected').text()
            var selectedDate = $('#tgl_masuk').val();
            var date = new Date(selectedDate);
            var addMonth = date.setMonth(date.getMonth() + parseInt(periode));
            var parseDate = new Date(addMonth);
            var newDate = parseDate.toISOString().split('T')[0]

            return newDate;
        }

        $('#tgl_masuk').on('change', function() {
            var date = calcDate();
            $('#tgl_keluar').val(date)
        })

        $('#periode').on('change', function() {
            var date = calcDate();
            $('#tgl_keluar').val(date)
        })
    </script>
@endsection
