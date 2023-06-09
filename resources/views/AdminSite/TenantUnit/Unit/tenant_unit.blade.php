<div class="mb-3">
    <div class="text-end my-3">
        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#tambah-unit">Tambah
            Unit</button>
    </div>
</div>
<div class="table-responsive scrollbar">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Unit</th>
                <th scope="col">Pemilik</th>
                <th scope="col">Periode Sewa</th>
                <th scope="col">Jatuh Tempo IPL</th>
                <th scope="col">Jatuh Tempo UTIL</th>
                <th class="text-end" scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tenant_units as $key => $tu)
                <tr>
                    <td>{{ $tu->unit->nama_unit }}</td>
                    <td>{{ $tu->pemilik->nama_pemilik }}</td>
                    <td>
                        {{-- <b>{{ $tu->id_periode_sewa }}</b> <br> --}}
                        {{ $tu->tgl_masuk }} - {{ $tu->tgl_keluar }}
                    </td>
                    <td>    
                        {{ $tu->tgl_jatuh_tempo_ipl }}
                    </td>
                    <td>
                        {{ $tu->tgl_jatuh_tempo_util }}
                    </td>
                    <td class="text-end">
                        <div>
                            <button class="btn btn-link p-0" type="button" data-bs-toggle="modal"
                                data-bs-target="#edit-unit" title="Edit" data-target-id="{{ $tu->id_tenant_unit }}"
                                onclick="editUnitModal('{{ $tu->id_tenant_unit }}')"><span
                                    class="text-500 fas fa-edit"></span>
                            </button>
                            <form action="{{ route('deleteTenantUnit', $tu->id_tenant_unit) }}" method="post"
                                class="d-inline">
                                @csrf
                                <button class="btn btn-link p-0 ms-2" type="submit" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Delete"
                                    onClick="return confirm('Are you absolutely sure you want to delete?')"><span
                                        class="text-500 fas fa-trash-alt"></span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
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
                    <h4 class="mb-1" id="modalExampleDemoLabel">Tambah Unit</h4>
                </div>
                <div class="p-4 pb-0">
                    <form action="{{ route('storeTenantUnit') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label class="col-form-label">Unit:</label>
                                    <select class="form-control" name="id_unit" required>
                                        @foreach ($getCreateUnits as $unit)
                                            <option value="{{ $unit->id_unit }}">
                                                {{ $unit->nama_unit }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="col-form-label">Owner :</label>
                                    <select class="form-control" name="id_pemilik" required>
                                        @foreach ($owners as $owner)
                                            <option value="{{ $owner->id_pemilik }}">
                                                {{ $owner->nama_pemilik }}</option>
                                        @endforeach
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
                        <div class="mb-3">
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
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit">Simpan
                            </button>
                        </div>
                        <input type="hidden" name="id_tenant" value="{{ $tenant->id_tenant }}">
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
