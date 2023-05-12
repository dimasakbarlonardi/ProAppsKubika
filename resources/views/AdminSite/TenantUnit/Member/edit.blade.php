<div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
    <h4 class="mb-1" id="modalExampleDemoLabel">Edit Member</h4>
</div>
<div class="p-4 pb-0">
    <form method="post" action="{{ route('updateTenantMember', $tenantmember->id_tenant_member) }}">
        @csrf
        <div class="mb-3">
            <div class="row">
                <div class="col-6">
                    <label class="form-label">Unit</label>
                    <select class="form-control" name="id_unit" required>
                        <option selected disabled>-- Pilih Unit --</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id_unit }}"
                                {{ $tenantmember->id_unit == $unit->id_unit ? 'selected' : '' }}>
                                {{ $unit->nama_unit }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label">Nik Tenant Member </label>
                    <input type="text" name="nik_tenant_member" value="{{ $tenantmember->nik_tenant_member }}" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-6">
                    <label class="form-label">Nama Tenant Member </label>
                    <input type="text" name="nama_tenant_member" value="{{ $tenantmember->nama_tenant_member }}" class="form-control" required>
                </div>
                <div class="col-6">
                    <label class="form-label">Hubungan Tenant </label>
                    <input type="text" name="hubungan_tenant" value="{{ $tenantmember->hubungan_tenant }}" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-6">
                    <label class="form-label">No Telp Member </label>
                    <input type="text" name="no_telp_member" value="{{ $tenantmember->no_telp_member }}" class="form-control" required>
                </div>
                <div class="col-6">
                    <label class="form-label">ID Status Tinggal </label>
                    <input type="text" name="id_status_tinggal" value="{{ $tenantmember->id_status_tinggal }}" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit">Update</button>
        </div>
    </form>
</div>
