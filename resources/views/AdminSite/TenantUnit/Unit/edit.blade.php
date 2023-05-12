<div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
    <h4 class="mb-1">Edit Unit</h4>
</div>
<div class="p-4 pb-0">
    <form action="{{ route('updateTenantUnit', $tenantunit->id_tenant_unit) }}" method="post">
        @csrf
        <div class="mb-3">
            <div class="row">
                <div class="col-6">
                    <label class="col-form-label">Unit:</label>
                    <select class="form-control" name="id_unit">
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id_unit }}"
                                {{ $tenantunit->id_unit == $unit->id_unit ? 'selected' : '' }}>
                                {{ $unit->nama_unit }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label class="col-form-label">Periode
                        Sewa:</label>
                    <div class="input-group">
                        <select class="form-control" name="id_periode_sewa" id="periode_edit">
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
                    <input class="form-control" type="date" name="tgl_masuk" value="{{ $tenantunit->tgl_masuk }}"
                        id="tgl_masuk_edit">
                </div>
                <div class="col-6">
                    <label class="col-form-label">Tanggal
                        keluar:</label>
                    <input class="form-control" type="date" name="tgl_keluar" value="{{ $tenantunit->tgl_keluar }}"
                        id="tgl_keluar_edit" readonly>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-6">
                    <label class="col-form-label">Tanggal
                        jatuh tempo IPL:</label>
                    <input class="form-control" type="date" name="tgl_jatuh_tempo_ipl"
                        value="{{ $tenantunit->tgl_jatuh_tempo_ipl }}" id="">
                </div>
                <div class="col-6">
                    <label class="col-form-label">Tanggal
                        jatuh tempo utility:</label>
                    <input class="form-control" type="date" name="tgl_jatuh_tempo_util"
                        value="{{ $tenantunit->tgl_jatuh_tempo_util }}" id="">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit">Update</button>
        </div>
    </form>
</div>


<script>
    function calcDate() {
        var periode = $('#periode_edit').find(':selected').text()
        var selectedDate = $('#tgl_masuk_edit').val();
        var date = new Date(selectedDate);
        var addMonth = date.setMonth(date.getMonth() + parseInt(periode));
        var parseDate = new Date(addMonth);
        var newDate = parseDate.toISOString().split('T')[0]

        return newDate;
    }

    $('#tgl_masuk_edit').on('change', function() {
        var date = calcDate();
        $('#tgl_keluar_edit').val(date)
    })

    $('#periode_edit').on('change', function() {
        var date = calcDate();
        $('#tgl_keluar_edit').val(date)
    })
</script>
