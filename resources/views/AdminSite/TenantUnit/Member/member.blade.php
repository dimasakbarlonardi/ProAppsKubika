<div class="mb-3">
    <div class="text-end my-3">
        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#tambah-member">Tambah
            Member</button>
    </div>
</div>
<div class="table-responsive scrollbar">
    <table class="table">
        <thead>
            <tr>
                <th scope="col" rowspan="2">ID Unit</th>
                <th scope="col">Nama Member</th>
                <th scope="col">Hubungan Tenant</th>
                <th scope="col">No Telp Member</th>
                <th scope="col">ID Status Tinggal</th>
                <th scope="col">ID Tenant</th>
                <th class="text-end" scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tenant_members as $key => $tm)
                <tr>
                    <td>{{ $tm->id_unit }}</td>
                    <td>{{ $tm->nama_tenant_member }}</td>
                    <td>{{ $tm->hubungan_tenant }}</td>
                    <td>{{ $tm->no_telp_member }}</td>
                    <td>{{ $tm->status->status_tinggal}}</td>
                    <td>{{ $tm->tenant->nama_tenant }}</td>
                    <td class="text-end">
                        <div>
                            <button class="btn btn-link p-0" type="button" data-bs-toggle="modal"
                                data-bs-target="#edit-member" title="Edit"
                                data-target-id="{{ $tm->id_tenant_member }}"
                                onclick="editMemberModal('{{ $tm->id_tenant_member }}')">
                                <span class="text-500 fas fa-edit"></span>
                            </button>
                            <form action="{{ route('deleteTenantMember', $tm->id_tenant_member) }}" method="post" class="d-inline">
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
                                            <option value="{{ $unit->id_unit }}">{{ $unit->nama_unit }}</option>
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

                                <div class="col-5">
                                    <label class="form-label">ID Status Tinggal</label>
                                    <select class="form-control" name="id_status_tinggal" required>
                                        <option selected disabled>-- Pilih Status Tinggal --</option>
                                        @foreach ($statustinggals as $statustinggal)
                                        <option value="{{ $statustinggal->id_status_tinggal }}">{{ $statustinggal->status_tinggal }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit">Tambah</button>
                        </div>
                        <input type="hidden" name="id_tenant" value="{{ $tenant->id_tenant }}">
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
