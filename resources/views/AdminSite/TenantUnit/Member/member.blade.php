<div class="mb-3">
    <div class="text-end my-3">
        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#tambah-member">Tambah
            Member</button>
    </div>
</div>

<div class="row p-3">
    @foreach ($units as $unit)
        <div class="col">
            <button class="btn btn-falcon-primary me-1 mb-1 btn-unit" type="button"
                onclick="btnUnitClick1('{{ $unit->id_unit }}')"
                id="btn-unit-{{ $unit->id_unit }}">{{ $unit->nama_unit }}</button>
        </div>
    @endforeach
</div>

<div id="member_tenant">
    @include('AdminSite.TenantUnit.Member.table')
</div>

<div class="modal fade" id="tambah-member" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 800px">
        <div class="modal-content position-relative">
            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                    <h4 class="mb-1" id="modalExampleDemoLabel">Tambah Member</h4>
                </div>
                <div class="p-4 pb-0">
                    <form method="post" action="{{ route('storeTenantMember') }}">
                        @csrf
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label">Unit</label>
                                    <select class="form-control" name="id_unit" required>
                                        <option selected disabled>-- Pilih Unit --</option>
                                        @foreach ($units as $unit)
                                            {{-- <option value="{{ $unit->id_unit }}">{{ $unit->nama_unit }}</option> --}}
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Nik Tenant Member </label>
                                    <input type="text" name="nik_tenant_member" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label">Nama Tenant Member </label>
                                    <input type="text" name="nama_tenant_member" class="form-control" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Hubungan Tenant </label>
                                    <input type="text" name="hubungan_tenant" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label">No Telp Member </label>
                                    <input type="text" name="no_telp_member" class="form-control" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">ID Status Tinggal </label>
                                    <input type="text" name="id_status_tinggal" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit">Tambah</button>
                        </div>
                        <input type="hidden" name="id_tenant" id="id_tenant" value="{{ $tenant->id_tenant }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-member" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 800px">
        <div class="modal-content position-relative">
            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>

            <div class="modal-body-member-edit p-0">

            </div>
        </div>
    </div>
</div>

<script>
    function btnUnitClick1(id) {
        var id_tenant = $('#id_tenant').val();
        console.log(id)
        $.ajax({
            url: '/admin/kepemilikan-member-unit/' + id,
            type: 'GET',
            data: {
                id_tenant
            },
            success: function(data) {
                $('#member_tenant').html(data.html)
            }
        })
    }
</script>
